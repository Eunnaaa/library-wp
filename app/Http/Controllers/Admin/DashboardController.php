<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Booking;
use App\Models\Kategori;
use App\Models\Pinjam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $total_anggota = User::where('role_id', 2)->count();
        $total_buku = Buku::sum('stok');
        $total_judul = Buku::count();
        $total_kategori = Kategori::count();
        $total_booking = Booking::count();
        $total_pinjam = Pinjam::count();

        // Recent bookings and books
        $recent_bookings = Booking::with('anggota')->latest()->take(5)->get();
        $recent_buku = Buku::with('kategori')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'total_anggota',
            'total_buku',
            'total_judul',
            'total_kategori',
            'total_booking',
            'total_pinjam',
            'recent_bookings',
            'recent_buku'
        ));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('admin.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'nama' => 'required|string|max:128',
            'alamat' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 1MB.',
        ]);

        $userData = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ];

        if ($request->hasFile('image')) {
            if ($user->image && $user->image !== 'profil-pic/default.jpg') {
                Storage::disk('public')->delete($user->image);
            }
            $userData['image'] = $request->file('image')->store('profil-pic', 'public');
        }

        $user->update($userData);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function tampilGantiPassword()
    {
        return view('admin.ganti-password');
    }

    public function updateGantiPassword(Request $request)
    {
        $request->validate([
            'password_sekarang' => 'required',
            'password_baru' => 'required|min:6|same:konfirmasi_password',
            'konfirmasi_password' => 'required|min:6',
        ], [
            'password_sekarang.required' => 'Password saat ini wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.same' => 'Konfirmasi password tidak cocok.',
            'konfirmasi_password.required' => 'Ulangi password baru wajib diisi.',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->password_sekarang, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini salah!');
        }

        if (Hash::check($request->password_baru, $user->password)) {
            return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan password lama!');
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
