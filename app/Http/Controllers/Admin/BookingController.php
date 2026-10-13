<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pinjam;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $booking = Booking::with(['anggota', 'booking_detail.buku.kategori'])->latest()->get();

        return view('admin.booking.index', compact('booking'));
    }

    public function show(string $id)
    {
        $data_booking = Booking::with(['booking_detail.buku.kategori', 'anggota'])
            ->where(function ($q) use ($id) {
                $q->where('id', $id)->orWhere('id_booking', $id);
            })
            ->get();

        if ($data_booking->isEmpty()) {
            return redirect()->route('admin.transaksi.booking.index')->with('error', 'Data booking tidak ditemukan.');
        }

        return view('admin.booking.show', compact('data_booking'));
    }

    public function destroy(string $id)
    {
        $booking = Booking::with('booking_detail')
            ->where(function ($q) use ($id) {
                $q->where('id', $id)->orWhere('id_booking', $id);
            })
            ->first();

        if (! $booking) {
            return redirect()->route('admin.transaksi.booking.index')->with('error', 'Data booking tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            foreach ($booking->booking_detail as $detail) {
                DB::table('buku')->where('id', $detail->id_buku)->increment('stok');
                DB::table('buku')->where('id', $detail->id_buku)->where('dibooking', '>', 0)->decrement('dibooking');
            }

            $booking->booking_detail()->delete();
            $booking->delete();

            DB::commit();

            return redirect()->route('admin.transaksi.booking.index')->with('success', 'Data booking berhasil dibatalkan dan stok buku dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal membatalkan data booking.');
        }
    }

    public function verifikasiQr(Request $request)
    {
        $rawCode = trim($request->input('code', $request->input('id_booking', '')));

        if (empty($rawCode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode booking tidak boleh kosong.',
            ], 422);
        }

        // Ekstrak kode booking jika QR berisi URL atau teks lengkap (Format B + 9 digit angka)
        if (preg_match('/(B\d{9})/i', $rawCode, $matches)) {
            $code = strtoupper($matches[1]);
        } else {
            $code = strtoupper($rawCode);
        }

        $booking = Booking::with(['anggota', 'booking_detail.buku.kategori'])
            ->where('id_booking', $code)
            ->first();

        if (! $booking) {
            // Cek apakah booking ini sudah diproses ke peminjaman
            $pinjam = Pinjam::with(['anggota', 'pinjam_detail.buku'])
                ->where('id_booking', $code)
                ->first();

            if ($pinjam) {
                return response()->json([
                    'status' => 'already_processed',
                    'message' => "Kode booking {$code} sudah pernah diproses menjadi transaksi peminjaman aktif ({$pinjam->no_pinjam}).",
                    'no_pinjam' => $pinjam->no_pinjam,
                    'anggota' => [
                        'nama' => $pinjam->anggota?->nama ?? 'Anggota',
                        'email' => $pinjam->anggota?->email ?? '-',
                    ],
                ]);
            }

            return response()->json([
                'status' => 'not_found',
                'message' => "Data reservasi dengan kode '{$code}' tidak ditemukan atau telah dibatalkan.",
            ], 404);
        }

        $batasAmbil = Carbon::parse($booking->batas_ambil);
        $isExpired = $batasAmbil->isPast();

        $books = $booking->booking_detail->map(function ($detail) {
            return [
                'id_buku' => $detail->id_buku,
                'judul_buku' => $detail->buku?->judul_buku ?? 'Buku Tidak Tersedia',
                'pengarang' => $detail->buku?->pengarang ?? '-',
                'penerbit' => $detail->buku?->penerbit ?? '-',
                'kategori' => $detail->buku?->kategori?->nama_kategori ?? 'Umum',
                'isbn' => $detail->buku?->isbn ?? '-',
                'stok' => $detail->buku?->stok ?? 0,
                'cover_url' => asset('storage/'.($detail->buku?->image ?? 'cover-buku/book-default-cover.jpg')),
            ];
        });

        return response()->json([
            'status' => $isExpired ? 'expired' : 'valid',
            'code' => $code,
            'is_expired' => $isExpired,
            'message' => $isExpired
                ? 'Reservasi telah melewati batas waktu pengambilan 1x24 jam (Kedaluwarsa).'
                : 'Reservasi terverifikasi valid! Anggota berhak mengambil buku.',
            'booking' => [
                'id_booking' => $booking->id_booking,
                'tgl_booking' => date('d M Y, H:i', strtotime($booking->tgl_booking)),
                'batas_ambil' => date('d M Y, H:i', strtotime($booking->batas_ambil)),
                'batas_ambil_raw' => $booking->batas_ambil,
                'sisa_waktu' => $isExpired ? 'Kedaluwarsa' : Carbon::now()->diffForHumans($batasAmbil, ['parts' => 2, 'syntax' => CarbonInterface::DIFF_ABSOLUTE]),
            ],
            'anggota' => [
                'id' => $booking->anggota?->id,
                'nama' => $booking->anggota?->nama ?? 'Anggota',
                'email' => $booking->anggota?->email ?? '-',
                'alamat' => $booking->anggota?->alamat ?? '-',
                'image_url' => asset('storage/'.($booking->anggota?->image ?? 'profil-pic/default.jpg')),
            ],
            'buku' => $books,
            'total_buku' => $books->count(),
        ]);
    }
}
