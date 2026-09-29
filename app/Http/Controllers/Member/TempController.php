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

        // Validasi input buku ID
        $request->validate([
            'id' => 'required|integer|exists:buku,id',
        ]);

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

    public function dataKeranjang(?User $user = null)
    {
        if ($user && $user->id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $user = Auth::user();
        $temp = Temp::with('buku.kategori')->where('id_user', $user->id)->get();

        return view('member.keranjang', compact('temp', 'user'));
    }

    public function hapusKeranjang($buku, ?User $user = null)
    {
        if ($user && $user->id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $userId = Auth::id();
        $bookId = $buku instanceof Buku ? $buku->id : $buku;
        Temp::where(['id_buku' => $bookId, 'id_user' => $userId])->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari keranjang!');
    }

    public function simpanBooking(Request $request)
    {
        $userId = Auth::id();
        $cek_stok = Temp::with('buku')->where('id_user', $userId)->get();

        if ($cek_stok->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang buku Anda masih kosong.');
        }

        if ($cek_stok->count() > 3) {
            return redirect()->back()->with('error', 'Jumlah buku yang dibooking melebihi batas maksimal (3 buku).');
        }

        $bookIds = $cek_stok->pluck('id_buku')->toArray();

        DB::beginTransaction();
        try {
            $books = Buku::whereIn('id', $bookIds)->lockForUpdate()->get()->keyBy('id');

            foreach ($cek_stok as $item) {
                $book = $books->get($item->id_buku);
                if (! $book || $book->stok <= 0) {
                    DB::rollBack();

                    return redirect()->back()->with('error', 'Ada buku yang stoknya kosong, silakan hapus terlebih dahulu.');
                }
            }

            $today = Carbon::today()->format('ymd');
            $prefix = 'B'.$today;
            $maxSeq = 0;

            $existingBookings = DB::table('booking')
                ->where('id_booking', 'like', $prefix.'%')
                ->lockForUpdate()
                ->pluck('id_booking');

            foreach ($existingBookings as $ib) {
                $seq = intval(substr($ib, strlen($prefix)));
                if ($seq > $maxSeq) {
                    $maxSeq = $seq;
                }
            }

            $existingPinjams = DB::table('pinjam')
                ->where('id_booking', 'like', $prefix.'%')
                ->lockForUpdate()
                ->pluck('id_booking');

            foreach ($existingPinjams as $ib) {
                $seq = intval(substr($ib, strlen($prefix)));
                if ($seq > $maxSeq) {
                    $maxSeq = $seq;
                }
            }

            $newIdBooking = $prefix.str_pad($maxSeq + 1, 3, '0', STR_PAD_LEFT);

            $tgl_booking = Carbon::now();
            $batas_ambil = $tgl_booking->copy()->addDay();

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

                $affected = DB::table('buku')
                    ->where('id', $item->id_buku)
                    ->where('stok', '>', 0)
                    ->decrement('stok');

                if (! $affected) {
                    DB::rollBack();

                    return redirect()->back()->with('error', 'Stok buku tidak mencukupi untuk booking.');
                }

                DB::table('buku')->where('id', $item->id_buku)->increment('dibooking');
            }

            Temp::where('id_user', $userId)->delete();

            DB::commit();

            return redirect()->route('member.dataBooking', $userId)->with('success', 'Booking berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan booking.');
        }
    }
}
