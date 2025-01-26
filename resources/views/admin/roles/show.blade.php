@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Role</h1>
        <p><strong>Nama Role:</strong> {{ $role->name }}</p>

        <h3>Permissions:</h3>
        <ul>
            @foreach ($permissions as $permission)
                <li>{{ $permission->name }}</li>
            @endforeach
        </ul>

        <div class="d-flex justify-content-start" style="position: sticky; bottom: 0; background-color: white; z-index: 1; padding-top: 10px;">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
