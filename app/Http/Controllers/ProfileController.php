<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $member = Auth::guard('member')->user(); // Pastikan menggunakan guard 'member'
        return view('user.auth.editprofile', compact('member'));
    }

    public function update(Request $request)
    {
        $member = Auth::guard('member')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'required|numeric|digits_between:10,15|unique:members,phone,' . $member->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan data yang diupdate
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;

        // Menghandle foto jika ada yang diupload
        if ($request->hasFile('photo')) {
            // Menghapus foto lama jika ada
            if ($member->photo) {
                // Hapus file yang ada di storage
                Storage::delete('public/' . $member->photo);
            }

            // Menyimpan foto baru di folder profile_photos di dalam storage/app/public
            $path = $request->file('photo')->store('public/profile_photos');

            // Menyimpan path relatifnya
            $member->photo = 'profile_photos/' . basename($path);
        }

        // Simpan perubahan ke database
        $member->save();

        return redirect()->route('home')->with('success', 'Profile updated successfully.');
    }
}
