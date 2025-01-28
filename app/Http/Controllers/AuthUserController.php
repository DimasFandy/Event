<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\WhatsappController;
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
        $request->validate([
            'phone' => 'required|digits_between:10,15',
            'password' => 'required|min:8',
        ]);

        $member = Member::where('phone', $request->phone)->first();

        if ($member) {
            if (Hash::check($request->password, $member->password)) {
                // Generate dan simpan OTP di session
                $otp = rand(100000, 999999);
                Session::put('otp', $otp);
                Session::put('member_id', $member->id);

                // Kirim OTP melalui WhatsApp
                app(WhatsappController::class)->sendWhatsappMessage($member->phone, $member->name, $otp);

                return redirect()->route('user.auth.verify_otp', ['member_id' => $member->id])
                    ->with('success', 'OTP berhasil dikirim. Silakan cek WhatsApp Anda.');
            }

            return back()->withErrors(['password' => 'Password salah'])
                ->with('error', 'Login gagal, password salah.');
        }

        return back()->withErrors(['phone' => 'Nomor HP tidak ditemukan'])
            ->with('error', 'Login gagal, nomor HP tidak ditemukan.');
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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => [
                'required',
                'digits_between:10,15',
                'unique:members,phone',
                'regex:/^(?!123456789|000000000|111111111|999999999).+$/'
            ],
            'password' => 'required|confirmed|min:8',
        ], [
            'phone.regex' => 'Nomor telepon tidak valid.',
        ]);

        try {
            $member = Member::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Generate dan simpan OTP di session
            $otp = rand(100000, 999999);
            Session::put('otp', $otp);
            Session::put('member_id', $member->id);

            // Kirim OTP melalui WhatsApp
            app(WhatsappController::class)->sendWhatsappMessage($member->phone, $member->name, $otp);

            return redirect()->route('user.auth.verify_otp', ['member_id' => $member->id])
                ->with('success', 'Registrasi berhasil! OTP telah dikirim melalui WhatsApp.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors(['duplicate' => 'Email atau nomor telepon sudah terdaftar.'])
                    ->with('error', 'Registrasi gagal, email atau nomor telepon sudah terdaftar.');
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi.'])
                ->with('error', 'Registrasi gagal, silakan coba lagi.');
        }
    }



    public function editProfile()
    {
        // Mengambil pengguna yang sedang login
        $member = Auth::guard('member')->user(); // Ganti 'member' dengan nama guard Anda jika berbeda

        // Pastikan $member ada
        if (!$member) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Mengirim data ke view
        return view('user.auth.editprofile', compact('member'));
    }

    public function updateProfile(Request $request)
    {
        $member = Auth::guard('member')->user();

        // Validasi input profil
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email,' . $member->id,
            'phone' => 'nullable|regex:/^[0-9]+$/|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika ada foto yang diupload, simpan foto dan update path-nya
        if ($request->hasFile('photo')) {
            if ($member->photo) {
                // Hapus foto lama jika ada
                Storage::delete('public/' . $member->photo);
            }
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Update profil pengguna
        $member->update($validated);

        return redirect()->route('user.editprofile')->with('success', 'Profil berhasil diperbarui!');
    }
    public function editPassword()
    {
        return view('user.auth.editpw');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('member')->user();

        // Validasi dan pembaruan password
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.editpassword')->with('success', 'Password berhasil diperbarui!');
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

    // Menampilkan form verifikasi OTP
    public function showVerifyOtpForm($member_id)
    {
        // Ambil data member berdasarkan member_id
        $member = Member::find($member_id);

        if (!$member) {
            return redirect()->route('home')->with('error', 'Member tidak ditemukan.');
        }

        // Kirimkan memberId ke view
        return view('user.auth.verify_otp', ['memberId' => $member->id]);
    }
    // Verifikasi OTP yang dimasukkan oleh user
    public function verifyOtp(Request $request, $member_id)
    {
        // Validasi input OTP
        $request->validate([
            'otp' => 'required|numeric|digits:6', // Validasi OTP
        ]);

        // Cek apakah OTP yang dimasukkan sama dengan yang disimpan di session
        if ($request->otp == Session::get('otp')) {
            // Hapus OTP dari session setelah berhasil diverifikasi
            Session::forget('otp');
            Session::forget('member_id');

            // Lakukan login member
            $member = Member::find($member_id);
            Auth::guard('member')->login($member);

            // Redirect ke halaman home dengan pesan sukses
            return redirect()->route('user.home')->with('success', 'Login berhasil! Selamat datang, ' . $member->name);
        }

        // OTP salah
        return back()->withErrors(['otp' => 'Kode OTP salah']);
    }

}
