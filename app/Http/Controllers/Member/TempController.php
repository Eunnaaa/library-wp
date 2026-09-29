<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Buku;
use App\Models\Temp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TempController extends Controller
{
    public function tambahKeranjang(Request $request)
    {
        $userId = Auth::id();

        // Cek apakah buku yang diklik booking dengan user yang sedang login sudah ada di tabel temp
        $cek_keranjang = Temp::where(['id_buku' => $request->id, 'id_user' => $userId])->count();
        $cek_pinjam = DB::table('pinjam as a')
            ->join('pinjam_detail as b', 'a.no_pinjam', '=', 'b.no_pinjam')
            ->where('a.id_user', $userId)
            ->where('b.id_buku', $request->id)
            ->where('b.status', 'Pinjam')
            ->count();

        // Jika buku yang diklik booking sudah ada di temp atau sedang dipinjam
        if ($cek_keranjang > 0 || $cek_pinjam > 0) {
            return redirect()->route('member.index')->with('error', 'Buku sudah ada di keranjang atau sedang dipinjam.');
        }

        // Cek apakah ada data buku yang belum diambil (masih booking)
        $cek_booking = Booking::where('id_user', $userId)->count();
        if ($cek_booking > 0) {
            return redirect()->route('member.index')->with('error', 'Masih ada buku yang belum diambil, silakan ambil buku atau menunggu pembatalan otomatis.');
        }

        // Cek jumlah buku dalam keranjang
        $cek_limit = Temp::where('id_user', $userId)->count();

        // Cek jumlah buku yang sedang dipinjam
        $total_pinjam = DB::table('pinjam as a')
            ->join('pinjam_detail as b', 'a.no_pinjam', '=', 'b.no_pinjam')
            ->where('a.id_user', $userId)
            ->where('b.status', 'Pinjam')
            ->count();

        // Jika jumlah keranjang + booking + pinjam sama dengan/lebih dari 3
        if (($total_pinjam + $cek_booking + $cek_limit) >= 3) {
            return redirect()->route('member.index')->with('error', 'Total buku di keranjang, booking dan sedang pinjam tidak boleh lebih dari 3.');
        }

        $buku = Buku::findOrFail($request->id);
        if ($buku->stok <= 0) {
            return redirect()->route('member.index')->with('error', 'Maaf, stok buku saat ini sedang kosong.');
        }

        Temp::create([
            'id_buku' => $request->id,
            'id_user' => $userId,
        ]);

        return redirect()->route('member.index')->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    public function dataKeranjang(User $user)
    {
        if (Auth::id() !== $user->id && Auth::user()->role_id !== 1) {
            abort(403, 'Akses ditolak! Anda tidak dapat melihat keranjang pengguna lain.');
        }

        $temp = Temp::with('buku.kategori')->where('id_user', $user->id)->get();
        return view('member.keranjang', compact('temp', 'user'));
    }

    public function hapusKeranjang($buku, $user)
    {
        if (Auth::id() != $user && Auth::user()->role_id !== 1) {
            abort(403, 'Akses ditolak! Anda tidak dapat menghapus keranjang pengguna lain.');
        }

        Temp::where(['id_buku' => $buku, 'id_user' => $user])->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus dari keranjang!');
    }

    public function simpanBooking(Request $request)
    {
        // Selalu gunakan ID user yang sedang terotentikasi untuk keamanan
        $userId = Auth::id();
        $cek_stok = Temp::with('buku')->where('id_user', $userId)->get();

        if ($cek_stok->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang buku Anda masih kosong.');
        }

        // Loop melalui setiap buku untuk memeriksa stok
        foreach ($cek_stok as $item) {
            if ($item->buku->stok <= 0) {
                return redirect()->back()->with('error', 'Ada buku yang stoknya kosong, silakan hapus terlebih dahulu.');
            }
        }

        // Generate id_booking
        $today = Carbon::today()->format('ymd');

        // Mendapatkan id_booking terbaru dari tabel booking
        $latestBooking = DB::table('booking')
            ->whereDate('tgl_booking', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $latestBookingId = $latestBooking ? intval(substr($latestBooking->id_booking, -3)) : 0;

        // Mendapatkan id_booking terbaru dari tabel pinjam
        $latestPinjam = DB::table('pinjam')
            ->whereDate('tgl_pinjam', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $latestPinjamId = $latestPinjam ? intval(substr($latestPinjam->id_booking, -3)) : 0;

        // Bandingkan id_booking dari kedua tabel
        $latestIdBooking = max($latestBookingId, $latestPinjamId);

        // Membuat id_booking baru format B<ymd><001>
        $newIdBooking = 'B' . $today . str_pad($latestIdBooking + 1, 3, '0', STR_PAD_LEFT);

        // Tanggal booking dan batas ambil (1 hari)
        $tgl_booking = Carbon::now();
        $batas_ambil = $tgl_booking->copy()->addDay();

        DB::beginTransaction();
        try {
            DB::table('booking')->insert([
                'id_booking' => $newIdBooking,
                'tgl_booking' => $tgl_booking,
                'batas_ambil' => $batas_ambil,
                'id_user' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($cek_stok as $item) {
                DB::table('booking_detail')->insert([
                    'id_booking' => $newIdBooking,
                    'id_buku' => $item->id_buku,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update stok buku dan kolom dibooking
                DB::table('buku')->where('id', $item->id_buku)->update([
                    'stok' => DB::raw('stok - 1'),
                    'dibooking' => DB::raw('dibooking + 1'),
                ]);
            }

            // Hapus data dari tabel temp
            Temp::where('id_user', $userId)->delete();

            DB::commit();

            return redirect()->route('member.dataBooking', $userId)->with('success', 'Booking berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan booking: ' . $e->getMessage());
        }
    }
}
