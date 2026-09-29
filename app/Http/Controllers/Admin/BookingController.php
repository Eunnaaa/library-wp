<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
        $data_booking = Booking::with(['booking_detail.buku.kategori', 'anggota'])->where('id', $id)->get();
        if ($data_booking->isEmpty()) {
            return redirect()->route('admin.transaksi.booking.index')->with('error', 'Data booking tidak ditemukan.');
        }

        return view('admin.booking.show', compact('data_booking'));
    }

    public function destroy(string $id)
    {
        $booking = Booking::with('booking_detail')->findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($booking->booking_detail as $detail) {
                DB::table('buku')->where('id', $detail->id_buku)->increment('stok');
                DB::table('buku')->where('id', $detail->id_buku)->decrement('dibooking');
            }

            $booking->booking_detail()->delete();
            $booking->delete();

            DB::commit();

            return redirect()->route('admin.transaksi.booking.index')->with('success', 'Data booking berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus data booking.');
        }
    }
}
