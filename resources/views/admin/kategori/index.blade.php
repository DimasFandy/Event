@extends('admin.layouts.app')

@section('content')
    <!-- Google Fonts Link -->
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Potta+One&family=Rampart+One&family=Sansita:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <div class="container">
        <h1 class="mb-4" style="font-family: 'Poppins', sans-serif; color: #007bff;"><i class="bi bi-list-ul">Daftar
                Kategori</i></h1>

        @can('create_kategori')
            <a href="{{ route('kategoris.create') }}" class="btn btn-primary mb-3" style="font-family: 'Poppins', sans-serif;">
                <i class="bi bi-journal-plus"></i> Tambah Kategori
            </a>
        @endcan

        <!-- Filter Section (Select2) -->
        <h6 class="text-muted">Filter Kategori</h6>
        <form id="filterForm" class="mb-4">
            <label for="filterSelect" class="form-label">Pilih Kategori</label>
            <select id="filterSelect" class="form-select" multiple="multiple">
                <!-- Select2 Placeholder -->
            </select>
        </form>

        <table class="table mt-3" style="font-family: 'Merriweather Sans', sans-serif;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Bobot</th>
                    <th>Status</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>

            <tbody id="kategoriTableBody">
                @foreach ($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}</td>
                        <td>{{ $kategori->name }}</td>
                        <td>{{ $kategori->description }}</td>
                        <td>{{ $kategori->weight }}</td>
                        <td>{{ $kategori->status }}</td>
                        <td
                            style="white-space: nowrap; display: flex; gap: 5px; justify-content: center; align-items: center;">
                            @can('edit_kategori')
                                <a href="{{ route('kategoris.edit', $kategori) }}" class="btn btn-warning btn-sm"><i
                                        class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete_kategori')
                                @if ($kategori->status == 'inactive')
                                    <form action="{{ route('kategoris.reactivate', $kategori->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm"><i
                                                class="bi bi-arrow-counterclockwise"></i> Re-Activate</button>
                                    </form>
                                @else
                                    <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i>
                                            Hapus</button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <a href="{{ $kategoris->previousPageUrl() }}" class="page-link"
                style="font-family: 'Poppins', sans-serif;">Previous</a>
            @foreach ($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $kategoris->currentPage() ? 'active' : '' }}"
                    style="font-family: 'Poppins', sans-serif;">{{ $page }}</a>
            @endforeach
            <a href="{{ $kategoris->nextPageUrl() }}" class="page-link"
                style="font-family: 'Poppins', sans-serif;">Next</a>
        </div>

        <!-- Filtered Event Display -->
        <div class="mt-5">
            <h2>Daftar Event</h2>
            <div class="row">
                @foreach ($filteredData as $event)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header">{{ $event->name }}</div>
                            <div class="card-body">
                                <p>{{ $event->date }}</p>
                                <p>{{ $event->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk kategori dengan filter event
            $('#filterSelect').select2({
                placeholder: 'Pilih kategori',
                ajax: {
                    url: '{{ route('getDropdownData') }}', // Sesuaikan dengan route yang benar
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var selectedEventIds = $('#eventFilterSelect')
                    .val(); // Ambil event ID yang dipilih
                        return {
                            _token: '{{ csrf_token() }}',
                            search: params.term, // Kirimkan parameter pencarian jika ada
                            selectedEventIds: selectedEventIds // Kirimkan filter berdasarkan event
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

            // Event listener untuk perubahan pada filter kategori
            $('#filterSelect').on('change', function() {
                var selectedValues = $(this).val(); // Ambil kategori yang dipilih
                fetchFilteredData(selectedValues); // Ambil data yang difilter
            });

            // Fungsi untuk mengambil data yang sudah difilter berdasarkan kategori
            function fetchFilteredData(selectedValues) {
                $.ajax({
                    url: '{{ route('getFilteredData') }}',
                    type: 'POST',
                    data: {
                        values: selectedValues,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#kategoriTableBody').html(response
                        .html); // Update table body dengan data baru
                    }
                });
            }
        });
    </script>
@endsection
