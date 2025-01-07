<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:create_member'])->only(['create','store']);
        $this->middleware(['permission:edit_member'])->only(['edit','show']);
        $this->middleware(['permission:read_member'])->only(['read','show']);
        $this->middleware(['permission:delete_member'])->only(['destroy','delete']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $members = Member::select(['id', 'name', 'email', 'phone']);

                return DataTables::of($members)
                    ->addIndexColumn()
                    ->addColumn('aksi', function ($row) {
                        return '
                            <a href="/members/' . $row->id . '/edit" class="btn btn-warning btn-sm">Edit</a>
                            <button onclick="confirmDelete(' . $row->id . ')" class="btn btn-danger btn-sm">Delete</button>
                        ';
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            } catch (\Exception $e) {
                // Debugging pesan error
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
    ]);

    // Jika validasi berhasil, simpan member baru
    if ($validated) {
        Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('members.index')->with('success', 'Member added successfully');
    } else {
        // Jika email atau phone sudah terdaftar, arahkan kembali dengan pesan error
        return back()->with('error', 'Email or Phone number already in use.');
    }
}

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'required',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id); // Ambil data member berdasarkan ID
        return view('admin.members.show', compact('member'));
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully.');
    }
}
