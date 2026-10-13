<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function dataBooking(?User $user = null)
    {
        if ($user && $user->id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $userId = Auth::id();

        $data_booking = Booking::with(['booking_detail.buku.kategori', 'anggota'])
            ->where('id_user', $userId)
            ->get();

        if ($data_booking->isEmpty()) {
            return redirect()->route('member.index')->with('info', 'Tidak ada buku yang sedang dibooking.');
        }

        return view('member.data_booking', compact('data_booking'));
    }

    public function bookingPdf(?User $user = null)
    {
        if ($user && $user->id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $userId = Auth::id();

        $data_booking = Booking::with(['booking_detail.buku.kategori', 'anggota'])
            ->where('id_user', $userId)
            ->get();

        if ($data_booking->isEmpty()) {
            return redirect()->route('member.index')->with('error', 'Tidak ada data booking untuk dicetak.');
        }

        $user = Auth::user();
        $pdf = Pdf::loadView('member.booking_pdf', compact('data_booking'));
        $safeName = Str::slug($user->nama, '_');

        return $pdf->stream('bukti_booking_'.($safeName ?: 'member').'.pdf');
    }
}
