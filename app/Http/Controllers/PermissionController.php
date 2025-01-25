<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
{
    // examples:
    $this->middleware(['permission:create_permission'])->only(['create','store']);
    $this->middleware(['permission:edit_permission'])->only(['edit','update']);
    $this->middleware(['permission:read_permission'])->only(['read','show']);
    $this->middleware(['permission:delete_permission'])->only(['destroy','delete']);
}
    public function index(Request $request)
    {
        // Get the search term from the request, default to empty string if not provided
        $search = $request->get('search', '');

        // Start the query for permissions
        $permissions = Permission::query();

        // If there's a search term, filter the permissions by name
        if ($search) {
            $permissions = $permissions->where('name', 'like', "%$search%");
        }

        // Paginate the results, 4 permissions per page
        $permissions = $permissions->paginate(4);

        // Return the view with paginated and filtered data
        return view('admin.permissions.index', compact('permissions', 'search'));
    }



    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions|max:255',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id . '|max:255',
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
