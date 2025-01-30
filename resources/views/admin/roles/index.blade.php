@extends('admin.layouts.app')
@section('title', 'Daftar Roles')

@section('content')
    <div class="container">
        <h1>Roles</h1>

        <!-- Search Form and Create Button Aligned to the Right -->
        <div class="d-flex justify-content-between mb-3">
            <!-- Search Form -->
            <form method="GET" action="{{ route('roles.index') }}" class="d-flex">
                <div class="form-group mb-0 me-2">
                    <label for="search" class="d-none">Search by Role Name:</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Role Name"
                        value="{{ request()->get('search') }}">
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </form>

            <!-- Create Role Button -->
            @can('create_role')
                <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill">Tambah</i></a>
            @endcan
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @can('edit_role')
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @endcan
                            @can('read_role')
                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info btn-sm">View</a>
                            @endcan
                            @can('delete_role')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endcan
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-3">
            {{ $roles->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Display success alert when 'success' session variable is set
        @if (session('success'))
            Swal.fire({
                title: 'Sukses!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Oke'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
        @endif
    </script>
@endsection
