@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Role</h1>

        <!-- Card Container -->
        <div class="card shadow-lg p-4 rounded">
            <form action="{{ route('roles.update', $role->id) }}" method="POST"
                style="max-height: 500px; overflow-y: auto; padding-bottom: 50px;">
                @csrf
                @method('PUT')

                <div class="form-group" style="position: sticky; top: 0; background-color: white; z-index: 1;">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}"
                        required>
                </div>

                <div class="form-group mt-3">
                    <label for="permissions">Permissions</label>
                    <div
                        style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
                        <div class="form-check">
                            @foreach ($permissions as $permission)
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="form-check-input" id="permission-{{ $permission->id }}"
                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                <label for="permission-{{ $permission->id }}"
                                    class="form-check-label">{{ $permission->name }}</label><br>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3"
                    style="position: sticky; bottom: 0; background-color: white; z-index: 1;">
                    <button type="submit" class="btn btn-success">Update Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
