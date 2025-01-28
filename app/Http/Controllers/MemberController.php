<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Reason;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_member'])->only(['create', 'store']);
        $this->middleware(['permission:edit_member'])->only(['edit', 'update']);
        $this->middleware(['permission:read_member'])->only(['read', 'show']);
        $this->middleware(['permission:delete_member'])->only(['destroy', 'delete']);
        $this->middleware(['permission:ganti_passwordmember'])->only(['editPassword', 'updatePassword']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $members = Member::select(['id', 'name', 'email', 'phone', 'photo']);

                return DataTables::of($members)
                    ->addIndexColumn()
                    ->addColumn('aksi', function ($row) {
                        $buttons = '';

                        // Show button with permission check
                        if (auth()->user()->can('read_member')) {
                            $buttons .= '<a href="/members/' . $row->id . '" class="btn btn-info btn-sm">Show</a>';
                        }

                        if (auth()->user()->can('edit_member')) {
                            $buttons .= '<a href="/members/' . $row->id . '/edit" class="btn btn-warning btn-sm mx-1">Edit</a>';
                        }

                        if (auth()->user()->can('ganti_passwordmember')) {
                            $buttons .= '<a href="' . route('members.editPassword', $row->id) . '" class="btn btn-primary btn-sm ">Change Password</a>';
                        }

                        if (auth()->user()->can('delete_member')) {
                            $buttons .= '
                            <form action="' . route('members.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm mx-1">Delete</button>
                            </form>';
                        }

                        return $buttons;
                    })
                    ->addColumn('image', function ($row) {
                        if ($row->photo) {
                            // If there is a photo, display the image
                            return '<img src="' . asset('storage/' . $row->profile_photos) . '" alt="Photo" width="50" height="50">';
                        } else {
                            // If no photo, display text or a placeholder
                            return '<span>No Image</span>';
                        }
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }


        return view('admin.members.index');
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email', // Pastikan email belum terdaftar
            'phone' => 'required|string|max:20|unique:members,phone', // Pastikan phone belum terdaftar
            'password' => 'nullable|string|min:8', // Tambahkan validasi untuk password
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto
        ]);

        // Simpan member baru jika validasi berhasil
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public'); // Menyimpan foto di folder public/photos
        }

        Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password ? bcrypt($request->password) : null, // Enkripsi jika password diberikan
            'photo' => $photoPath, // Simpan path foto di database
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil di tambahkan.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8', // Validasi untuk password
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto
        ]);

        // Cek jika ada foto baru yang diunggah
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($member->photo && Storage::exists('public/' . $member->photo)) {
                Storage::delete('public/' . $member->photo);
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')->store('photos', 'public');
            $member->photo = $photoPath;
        }

        // Update data member
        $member->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password ? bcrypt($request->password) : $member->password, // Update hanya jika password diberikan
            'photo' => $member->photo, // Simpan path foto jika ada perubahan
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil di perbarui.');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id); // Ambil data member berdasarkan ID
        return view('admin.members.show', compact('member'));
    }
    public function editPassword($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.members.editpassword', compact('member'));
    }

    public function updatePassword(Request $request, $id)
    {
        // Validasi input password
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        // Temukan member berdasarkan ID
        $member = Member::findOrFail($id);

        // Cek apakah password lama yang dimasukkan sesuai
        if (!Hash::check($request->current_password, $member->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        // Update password baru
        $member->password = bcrypt($request->new_password);
        $member->save();

        // Kembali ke halaman edit password dengan pesan sukses
        return redirect()->route('members.index')->with('success', 'Password berhasil diubah');
    }

    public function destroy(Request $request, Member $member)
    {
        // Simpan alasan penghapusan jika ada
        if ($request->has('reason')) {
            Reason::create([
                'member_id' => $member->id,
                'reason' => $request->input('reason'),
            ]);
        }

        // Hapus foto jika ada
        if ($member->photo && Storage::exists('public/' . $member->photo)) {
            Storage::delete('public/' . $member->photo);
        }

        // Hapus member dari database
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member berhasil di hapus.');
    }
}
