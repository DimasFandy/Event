@extends('admin.layouts.app')
@section('title', 'Tambah Roles')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Create Role</h1>

        <!-- Card Container with Gradient Background -->
        <div class="card shadow-lg p-4 rounded">
            <form action="{{ route('roles.store') }}" method="POST"
                style="max-height: 500px; overflow-y: auto; padding-bottom: 50px;">
                @csrf
                <div class="form-group mb-3" style="position: sticky; top: 0; background-color: white; z-index: 1;">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter role name"
                        required>
                </div>

                <div class="form-group mb-4">
                    <label for="permissions" class="form-label">Permissions</label>
                    <div
                        style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
                        <div class="list-group">
                            @foreach ($permissions as $permission)
                                <div class="form-check list-group-item">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        class="form-check-input" id="permission-{{ $permission->id }}">
                                    <label class="form-check-label"
                                        for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Sticky Submit Button -->
                <div class="d-flex justify-content-center"
                    style="position: sticky; bottom: 0; background-color: white; z-index: 1; padding-top: 10px;">
                    <button type="submit" class="btn btn-primary btn-lg">Save Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection
