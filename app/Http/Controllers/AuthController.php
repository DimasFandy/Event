<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        // Jika user sudah login, redirect ke halaman dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard'); // Arahkan ke dashboard
        }

        // Jika belum login, tampilkan halaman login
        return view('admin.auth.login');
    }

    // Menangani proses autentikasi
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect ke halaman dashboard setelah login berhasil
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil! Selamat datang.');
        }

        // Jika login gagal
        return back()->with('error', 'Email atau password salah');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
