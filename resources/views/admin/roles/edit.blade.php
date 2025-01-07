@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Role</h1>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="permissions">Permissions</label>
            <div class="form-check">
                @foreach ($permissions as $permission)
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input" id="permission-{{ $permission->id }}"
                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                    <label for="permission-{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label><br>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Role</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
