@extends('admin.layouts.app')

@section('content')
    <h1>Users</h1>

    <!-- Filter Form and Add User Button Aligned to the Right -->
    <div class="d-flex justify-content-between mb-3">
        <!-- Filter by Role and Search Form -->
        <form method="GET" action="{{ route('users.index') }}" class="d-flex">
            <!-- Search Input -->
            <div class="form-group mb-0 me-2">
                <label for="search" class="d-none">Search:</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="Search by Name or Email"
                    value="{{ request()->get('search') }}">
            </div>
            <!-- Filter Button -->
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
        </form>

        <!-- Add User Button -->
        @can('create_user')
            <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i></a>
        @endcan
    </div>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th> <!-- Kolom role -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->isNotEmpty() ? $user->getRoleNames()->implode(', ') : 'No Role' }}</td>
                    <!-- Menampilkan role -->

                    <td>
                        @can('edit_user')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i
                                    class="bi bi-pencil-square"></i> Edit</a>
                        @endcan

                        @can('read_user')
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary"><i
                                    class="bi bi-eye-fill"></i> Lihat</a>
                        @endcan

                        @can('delete_user')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-4') }} <!-- Pagination links with Bootstrap style -->
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
