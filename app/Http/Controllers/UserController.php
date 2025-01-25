<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function __construct()
    {
        // examples:
        $this->middleware(['permission:create_user'])->only(['create','store']);
        $this->middleware(['permission:edit_user'])->only(['edit','update']);
        $this->middleware(['permission:read_user'])->only(['read','show']);
        $this->middleware(['permission:delete_user'])->only(['destroy','delete']);

    }
    public function index(Request $request)
    {
        // Ambil data roles untuk dropdown filter
        $roles = Role::all();

        // Mulai query untuk pengguna
        $query = User::with('role');

        // Terapkan pencarian berdasarkan nama atau email jika ada input pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Ambil data pengguna dengan pagination
        $users = $query->paginate(10);

        // Kirim data pengguna, roles, dan search term ke view
        return view('admin.users.index', compact('users', 'roles'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all(); // Ambil data role
        return view('admin.users.create', compact('roles')); // Kirim data role ke view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id', // Memastikan role_id ada di tabel roles
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('password123'), // Set default password
        ]);

        // Menambahkan role ke user yang baru dibuat
        $role = Role::find($validated['role_id']);
        $user->assignRole($role);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Ambil data role
        return view('admin.users.edit', compact('user', 'roles')); // Kirim data role ke view
    }

    public function show(string $id)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Kembalikan view untuk melihat detail user
        return view('admin.users.show', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id', // Memastikan role_id ada di tabel roles
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,

        ]);

        // Sinkronkan role ke user yang terpilih
        $role = Role::find($request->role_id); // Memperbaiki cara mencari role berdasarkan ID
        $user->syncRoles($role); // Sinkronkan role dengan user

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User successfully deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
}
