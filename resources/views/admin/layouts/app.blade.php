<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Sidebar -->
    <div class="d-flex">
        <div class="sidebar" style="width: 250px; background-color: #343a40; color: white; padding: 15px;">
            <h4>Admin Dashboard</h4>
            <hr class="text-white">
            <a href="{{ route('admin.dashboard') }}" class="text-white">Home</a>

            <!-- Dropdown Menu for Events -->
            <div class="mt-3">
                <h6 class="text-white">Events</h6>
                <ul class="list-unstyled">
                    <li class="dropdown">
                        <a href="#" class="text-white text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">Events</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('kategoris.index') }}" class="dropdown-item text-black">Kategori</a>
                            </li>
                            <li><a href="{{ route('events.index') }}" class="dropdown-item text-black">List Event</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <a href="{{ route('members.index') }}" class="text-white mt-2">Members</a>

            <!-- Dropdown Menu for Roles, Permissions, and Users -->
            <div class="mt-3">
                <h6 class="text-white">Manage Admin</h6>
                <ul class="list-unstyled">
                    <li class="dropdown">
                        <a href="#" class="text-white text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">Manage Admin</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('roles.index') }}" class="dropdown-item text-black">Roles</a></li>
                            <li><a href="{{ route('permissions.index') }}"
                                    class="dropdown-item text-black">Permissions</a></li>
                            <li><a href="{{ route('users.index') }}" class="dropdown-item text-black">Users</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content" style="flex-grow: 1;"> <!-- Adjust to fill the remaining space -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.dashboard') }}">Home</a>
                            </li>
                            <!-- User Dropdown Menu -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Auth::check())
                                        {{ Auth::user()->name }} <!-- Display the logged-in user's name -->
                                    @else
                                        Guest <!-- Or show something else if no user is logged in -->
                                    @endif
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-black">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container mt-4">
                <!-- Filter Section Moved to Content Area -->
                {{-- <h6 class="text-muted">Filter Data</h6>
                <form id="filterForm" class="mb-4">
                    <label for="filterSelect" class="form-label">Pilih Kategori atau Event</label>
                    <select id="filterSelect" class="form-select" multiple="multiple">
                        <!-- Select2 Placeholder -->
                    </select>
                </form> --}}

                <div id="dataContainer">
                    <!-- Filtered Data Will Appear Here -->
                </div>

                @yield('content')
            </div>

            <footer>
                {{-- &copy; 2024 Admin Dashboard. All rights reserved. --}}
            </footer>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

    <script>
        // Setup CSRF Token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // Inisialisasi Select2
            $('#filterSelect').select2({
                placeholder: 'Pilih kategori atau event',
                ajax: {
                    url: '{{ route('getDropdownData') }}',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: '{{ csrf_token() }}',
                            search: params.term // Kirim parameter pencarian jika ada
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name
                            }))
                        };
                    },
                    cache: true
                }
            });

            // Event listener untuk perubahan nilai filter
            $('#filterSelect').on('change', function() {
                var selectedValues = $(this).val(); // Mendapatkan nilai yang dipilih
                fetchData(selectedValues); // Memanggil fungsi fetchData dengan nilai yang dipilih
            });

            // Event listener untuk menghapus pilihan (clear) dari Select2
            $('#filterSelect').on('select2:unselect', function(e) {
                var selectedValues = $(this).val(); // Mendapatkan nilai yang tersisa setelah memilih X
                fetchData(selectedValues); // Memanggil fungsi fetchData dengan nilai yang tersisa
            });

            // Fungsi untuk mengambil data berdasarkan filter yang dipilih
            function fetchData(selectedValues) {
                $.ajax({
                    url: '{{ route('getFilteredData') }}',
                    type: 'POST',
                    data: {
                        values: selectedValues,
                        _token: '{{ csrf_token() }}' // Sertakan CSRF token
                    },
                    success: function(response) {
                        $('#dataContainer').html(response); // Menampilkan data yang diterima ke dalam #dataContainer
                    },
                });
            }
        });
    </script>
</body>

</html>
