<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function dataBooking(User $user)
    {
        if (Auth::id() !== $user->id && Auth::user()->role_id !== 1) {
            abort(403, 'Akses ditolak! Anda tidak dapat melihat data booking pengguna lain.');
        }

        $data_booking = Booking::with(['booking_detail.buku.kategori', 'anggota'])
            ->where('id_user', $user->id)
            ->get();

        if ($data_booking->isEmpty()) {
            return redirect()->route('member.index')->with('info', 'Tidak ada buku yang sedang dibooking.');
        }

        return view('member.data_booking', compact('data_booking'));
    }

    public function bookingPdf(User $user)
    {
        if (Auth::id() !== $user->id && Auth::user()->role_id !== 1) {
            abort(403, 'Akses ditolak! Anda tidak dapat mengunduh bukti booking pengguna lain.');
        }

        $data_booking = Booking::with(['booking_detail.buku.kategori', 'anggota'])
            ->where('id_user', $user->id)
            ->get();

        if ($data_booking->isEmpty()) {
            return redirect()->route('member.index')->with('error', 'Tidak ada data booking untuk dicetak.');
        }

        $pdf = Pdf::loadView('member.booking_pdf', compact('data_booking'));
        return $pdf->stream('bukti_booking_' . $user->nama . '.pdf');
    }
}
