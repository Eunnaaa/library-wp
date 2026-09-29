<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (! $user->is_active) {
                return redirect()->back()->withInput()->with('error', 'Akun Anda belum aktif! Silakan hubungi admin.');
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();

                if (Auth::user()->role_id == 1) {
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, '.Auth::user()->nama);
                } else {
                    return redirect()->route('member.index')->with('success', 'Selamat datang, '.Auth::user()->nama);
                }
            }
        }

        return redirect()->back()->withInput()->with('error', 'Email atau password yang Anda masukkan salah!');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:128',
            'email' => 'required|string|email|max:128|unique:users',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => $request->password,
            'role_id' => 2, // Member
            'is_active' => 1,
            'image' => 'profil-pic/default.jpg',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
