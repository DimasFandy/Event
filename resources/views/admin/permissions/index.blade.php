@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Permissions</h1>

        <!-- Filter and Search Form (Aligned to the Right) -->
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('permissions.index') }}" method="GET" class="d-flex">
                <!-- Search input -->
                <div class="form-group mb-0 me-2">
                    <label for="search" class="d-none">Search Permission Name:</label>
                    <input type="text" name="search" id="search" class="form-control"
                        placeholder="Search Permission Name" value="{{ $search }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <!-- Create Permission Button -->
            @can('create_permission')
                <a href="{{ route('permissions.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill">
                        Tambah</i></a>
            @endcan
        </div>

        <!-- Permissions Table -->
        <form action="#" method="POST">
            @csrf
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>
                            {{-- <input type="checkbox" id="select_all" onclick="toggleSelectAll()"> --}}
                        </th>
                        <th>No</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>
                                <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}"
                                    class="permission-checkbox">
                            </td>
                            <td>{{ $permissions->firstItem() + $loop->iteration - 1 }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                @can('edit_permission')
                                    <a href="{{ route('permissions.edit', $permission->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                @endcan

                                @can('delete_permission')
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
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

            <button type="submit" class="btn btn-danger mt-3">Delete Selected</button>
        </form>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $permissions->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
        </div>
    </div>

    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('select_all');
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }
    </script>
    
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
