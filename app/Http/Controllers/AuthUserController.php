<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class AuthUserController extends Controller
{
    // Show the login form for users
    public function showLoginForm()
    {
        // Cek jika user sudah login dengan guard 'member', arahkan ke home
        if (Auth::guard('member')->check()) {
            return redirect()->route('user.home');
        }

        return view('user.auth.login_user'); // Tampilan form login
    }

    // Handle user login
    public function login(Request $request)
{
    // Validasi form login
    $request->validate([
        'phone' => 'required|digits_between:10,15', // Validasi nomor HP
        'password' => 'required|min:8', // Validasi password
    ]);

    // Cek apakah user ada di database berdasarkan nomor HP
    $member = Member::where('phone', $request->phone)->first();

    // Verifikasi jika user ada
    if ($member) {
        // Cek apakah password sesuai
        if (Hash::check($request->password, $member->password)) {
            // Log in the user manually
            Auth::guard('member')->login($member);

            // Redirect ke halaman home setelah berhasil login
            return redirect()->route('user.home');
        }

        // Password salah
        return back()->withErrors(['password' => 'Password salah'])->withInput();
    }

    // Nomor HP tidak valid
    return back()->withErrors(['phone' => 'Nomor HP tidak ditemukan'])->withInput();
}


    // Show the registration form for users
    public function showRegisterForm()
    {
        // Cek jika user sudah login dengan guard 'member', arahkan ke home
        if (Auth::guard('member')->check()) {
            return redirect()->route('user.home');
        }

        return view('user.auth.register_user'); // Tampilan form registrasi
    }

    // Handle user registration
    public function register(Request $request)
    {
        // Validasi form registrasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits_between:10,15|unique:members,phone', // Validasi nomor HP
            'password' => 'required|confirmed|min:8',
        ]);

        // Membuat data pengguna baru di tabel member
        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // Simpan nomor HP
            'password' => Hash::make($request->password), // Hash password sebelum disimpan
        ]);

        // Menyimpan data pengguna baru dan login
        Auth::guard('member')->login($member);

        // Redirect ke halaman setelah berhasil registrasi
        return redirect()->route('user.home');
    }

    // Handle user logout
    public function logout(Request $request)
    {
        // Logout dari guard 'member'
        Auth::guard('member')->logout();

        // Invalidate sesi
        $request->session()->invalidate();

        // Regenerasi token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman home setelah logout
        return redirect()->route('home');
    }
}
