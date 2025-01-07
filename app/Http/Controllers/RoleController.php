<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
{
    // examples:
    $this->middleware(['permission:create_role'])->only(['create','store']);
    $this->middleware(['permission:edit_role'])->only(['edit','show']);
    $this->middleware(['permission:read_role'])->only(['read','show']);
    $this->middleware(['permission:delete_role'])->only(['destroy','delete']);
}
    public function index(Request $request)
    {
        // Get the search term from the request, default to empty string if not provided
        $search = $request->get('search', '');

        // Start the query for roles
        $roles = Role::query();

        // If there's a search term, filter the roles by name
        if ($search) {
            $roles = $roles->where('name', 'like', "%$search%");
        }

        // Paginate the results, 10 roles per page
        $roles = $roles->paginate(10);

        // Return the view with paginated and filtered data
        return view('admin.roles.index', compact('roles', 'search'));
    }



    public function create()
{
    $permissions = Permission::all(); // Ambil semua permissions
    return view('admin.roles.create', compact('permissions'));
}


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles|max:255',
        'permissions' => 'required|array|exists:permissions,id', // Validasi ID permissions
    ]);

    // Buat role baru
    $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

    // Masukkan data ke tabel role_has_permissions
    foreach ($request->permissions as $permissionId) {
        DB::table('role_has_permissions')->insert([
            'role_id' => $role->id,
            'permission_id' => $permissionId,
        ]);
    }

    return redirect()->route('roles.index')->with('success', 'Role created and permissions assigned successfully.');
}

public function edit(Role $role)
{
    $permissions = Permission::all();
    return view('admin.roles.edit', compact('role', 'permissions'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'permissions' => 'nullable|array|exists:permissions,id', // Validasi ID permissions
    ]);

    $permissions = Permission::whereIn('id', $request->permissions)->get();
    // dd($permissions->toArray());
    // Ambil role berdasarkan ID
    $role = Role::findOrFail($id);

    $role->syncPermissions($permissions);

    // Hapus semua data lama di role_has_permissions untuk role ini
    // DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

    // // Masukkan data baru ke tabel role_has_permissions
    // foreach ($request->permissions as $permissionId) {
    //     DB::table('role_has_permissions')->insert([
    //         'role_id' => $role->id,
    //         'permission_id' => $permissionId,
    //     ]);
    // }

    return redirect()->route('roles.index')->with('success', 'Role updated and permissions reassigned successfully.');
}


public function show($id)
{
    // Ambil role berdasarkan ID
    $role = Role::findOrFail($id);

    // Ambil semua permission yang dimiliki oleh role ini
    $permissions = $role->permissions;

    // Return view untuk menampilkan detail role
    return view('admin.roles.show', compact('role', 'permissions'));
}
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
