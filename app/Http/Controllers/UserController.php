<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pinjam;
use App\Models\PinjamDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:128',
            'email' => 'required|string|email|max:128|unique:users',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6',
            'role_id' => 'required|in:1,2',
            'is_active' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'role_id.required' => 'Role wajib dipilih.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ]);

        $imagePath = 'profil-pic/default.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profil-pic', 'public');
        }

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => $request->password,
            'role_id' => $request->role_id,
            'is_active' => $request->is_active,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.master.user.index')->with('success', 'Data user berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:128',
            'email' => 'required|string|email|max:128|unique:users,email,'.$user->id,
            'alamat' => 'required|string',
            'role_id' => 'required|in:1,2',
            'is_active' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'password' => 'nullable|string|min:6',
        ]);

        if ($user->id === auth()->id()) {
            if ((int) $request->role_id !== 1) {
                return redirect()->back()->withInput()->with('error', 'Anda tidak dapat mengubah role akun administrator Anda sendiri.');
            }
            if ((int) $request->is_active !== 1) {
                return redirect()->back()->withInput()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
            }
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'role_id' => $request->role_id,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('image')) {
            if ($user->image && $user->image !== 'profil-pic/default.jpg') {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('profil-pic', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.master.user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.master.user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role_id == 1 && User::where('role_id', 1)->count() <= 1) {
            return redirect()->route('admin.master.user.index')->with('error', 'Tidak dapat menghapus administrator terakhir dalam sistem.');
        }

        $hasActiveBookings = Booking::where('id_user', $user->id)->count() > 0;
        $hasActiveLoans = PinjamDetail::whereIn(
            'no_pinjam',
            Pinjam::where('id_user', $user->id)->pluck('no_pinjam')
        )->where('status', 'Pinjam')->count() > 0;

        if ($hasActiveBookings || $hasActiveLoans) {
            return redirect()->route('admin.master.user.index')->with('error', 'User tidak dapat dihapus karena masih memiliki booking atau pinjaman aktif.');
        }

        if ($user->image && $user->image !== 'profil-pic/default.jpg') {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('admin.master.user.index')->with('success', 'Data user berhasil dihapus!');
    }
}
