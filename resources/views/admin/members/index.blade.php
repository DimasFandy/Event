@extends('admin.layouts.app')

@section('content')

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <div class="container mt-4">
        <h1 class="mb-4 text-center text-primary">Members List</h1>

        @can('create_member')
            <!-- Tombol Create -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('members.create') }}" class="btn btn-success">
                    <i class="bi bi-person-plus-fill"></i> Add New Member
                </a>
            </div>
        @endcan

        <!-- Table -->
        <div class="table-responsive">
            <table id="members-table" class="table table-striped table-bordered shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center" style="background-color: #353535; color: white;">No</th>
                        <th class="text-center" style="background-color: #353535; color: white;">Name</th>
                        <th class="text-center" style="background-color: #353535; color: white;">Email</th>
                        <th class="text-center" style="background-color: #353535; color: white;">Phone</th>
                        <th class="text-center" style="background-color: #353535; color: white;">Photo</th>
                        <th class="text-center" style="background-color: #353535; color: white;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data rows will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
    
    <script>
        var $j = jQuery.noConflict(); // Menghindari konflik

        $j(document).ready(function() {
            console.log("Versi jQuery:", $j.fn.jquery); // Debugging
            console.log("Apakah DataTables tersedia?", typeof $j.fn.dataTable); // Debugging

            // Inisialisasi DataTables
            $j('#members-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('members.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-center'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        className: 'text-center'
                    },
                    {
                        data: 'photo',  // Kolom Foto
                        name: 'photo',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (data) {
                                return '<img src="' + '{{ asset("storage/") }}' + '/' + data + '" alt="Photo" width="50" height="50">';
                            } else {
                                return '<span>No Image</span>';
                            }
                        }
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
        });
    </script>

@endsection
