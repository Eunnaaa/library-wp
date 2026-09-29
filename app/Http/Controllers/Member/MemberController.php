<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Temp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul_buku', 'like', '%'.$request->keyword.'%')
                    ->orWhere('pengarang', 'like', '%'.$request->keyword.'%')
                    ->orWhere('penerbit', 'like', '%'.$request->keyword.'%');
            });
        }

        $buku = $query->latest()->paginate(12)->withQueryString();
        $kategori = Kategori::all();

        $count_keranjang = 0;
        if (Auth::check()) {
            $count_keranjang = Temp::where('id_user', Auth::id())->count();
        }

        return view('member.index', compact('buku', 'kategori', 'count_keranjang'));
    }

    public function detailBuku(Buku $buku)
    {
        $detailBuku = Buku::with('kategori')->find($buku->id);

        return response()->json($detailBuku);
    }

    public function tampilProfil()
    {
        $user = Auth::user();

        return view('member.profil', compact('user'));
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
            'image.max' => 'Ukuran gambar maksimal 1MB.',
        ]);

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ];

        if ($request->hasFile('image')) {
            if ($user->image && $user->image !== 'profil-pic/default.jpg') {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('profil-pic', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function tampilGantiPassword()
    {
        return view('member.ganti-password');
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
            'konfirmasi_password.required' => 'Konfirmasi password baru wajib diisi.',
        ]);

        $user = User::findOrFail(Auth::id());

        if (! Hash::check($request->password_sekarang, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini salah!');
        }

        if (Hash::check($request->password_baru, $user->password)) {
            return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan password lama!');
        }

        $user->update([
            'password' => $request->password_baru,
        ]);

        return redirect()->back()->with('success', 'Password Anda berhasil diubah!');
    }
}
