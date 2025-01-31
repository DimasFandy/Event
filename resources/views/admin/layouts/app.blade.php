<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Menambahkan favicon (ikon di tab) -->
    <link rel="icon" href="https://img.icons8.com/ios-filled/50/FFFFFF/gg.png" alt="gg">
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
            <h4><img width="48" height="48"
                    src="https://img.icons8.com/fluency/48/discord-hypesquad-events-badge.png"
                    alt="discord-hypesquad-events-badge" /> Admin Events</h4>
            <hr class="text-white">
            <a href="{{ route('admin.dashboard') }}"
                class="text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <img width="30" height="30" src="https://img.icons8.com/color/96/dashboard-layout.png"
                    alt="dashboard-layout" /> Dashboard
            </a>

            <!-- Dropdown Menu for Events -->
            <div class="mt-3">
                <ul class="list-unstyled">
                    <li>
                        <a href="#"
                            class="text-white text-decoration-none dropdown-toggle {{ request()->routeIs('kategoris.*') || request()->routeIs('events.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#eventDropdown"
                            aria-expanded="{{ request()->routeIs('kategoris.*') || request()->routeIs('events.*') ? 'true' : 'false' }}"
                            aria-controls="eventDropdown">
                            <img width="30" height="30"
                                src="https://img.icons8.com/fluency/48/event-accepted--v1.png" alt="event-accepted--v1"
                                class="me-2" />
                            Manage Events
                        </a>
                        <div class="collapse {{ request()->routeIs('kategoris.*') || request()->routeIs('events.*') ? 'show' : '' }}"
                            id="eventDropdown">
                            <a href="{{ route('kategoris.index') }}"
                                class="list-group-item {{ request()->routeIs('kategoris.*') ? 'active' : '' }} rounded-3 px-3 py-2 my-1">
                                Kategori
                            </a>
                            <a href="{{ route('events.index') }}"
                                class="list-group-item {{ request()->routeIs('events.*') ? 'active' : '' }} rounded-3 px-3 py-2 my-1">
                                List Event
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Custom Styles -->
            <style>

            </style>



            <!-- Menu di Bawah Dropdown -->
            <div class="mt-2">
                <a href="{{ route('members.index') }}"
                    class="text-white mt-2 {{ request()->routeIs('members.*') ? 'active' : '' }}">
                    <img width="30" height="30" src="https://img.icons8.com/fluency/48/conference-call.png"
                        alt="conference-call" /> Manage Members
                </a>
            </div>

            <!-- Dropdown Menu for Roles, Permissions, and Users -->
            <div class="mt-3">
                <ul class="list-unstyled">
                    <li>
                        <!-- Tombol utama dropdown -->
                        <a href="#"
                            class="text-white text-decoration-none dropdown-toggle
                            {{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') || request()->routeIs('users.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#adminDropdown">
                            <img width="30" height="30"
                                src="https://img.icons8.com/ios-filled/100/228BE6/admin-settings-male.png"
                                alt="admin-settings-male" /> Manage Admin
                        </a>

                        <!-- Dropdown menu -->
                        <div class="collapse {{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') || request()->routeIs('users.*') ? 'show' : '' }}"
                            id="adminDropdown">
                            <a href="{{ route('roles.index') }}"
                                class="list-group-item
                                        {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                                Roles
                            </a>
                            <a href="{{ route('permissions.index') }}"
                                class="list-group-item
                                        {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                                Permissions
                            </a>
                            <a href="{{ route('users.index') }}"
                                class="list-group-item
                                        {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                Users
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content" style="flex-grow: 1;">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                {{-- <a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a> --}}
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (Auth::check())
                                        {{ Auth::user()->name }}
                                    @else
                                        Guest
                                    @endif
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container mt-4">
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
            // Initialize Select2
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
                            search: params.term // Send search parameter if any
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

            // Event listener for filter value change
            $('#filterSelect').on('change', function() {
                var selectedValues = $(this).val();
                fetchData(selectedValues);
            });

            // Function to fetch data based on filter selection
            function fetchData(selectedValues) {
                $.ajax({
                    url: '{{ route('getFilteredData') }}',
                    type: 'POST',
                    data: {
                        values: selectedValues,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#dataContainer').html(response);
                    },
                });
            }
        });
    </script>
</body>

</html>
