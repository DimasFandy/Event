    @extends('admin.layouts.app')


    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/kategori.css') }}">

    @section('content')
        <div class="container">
            <h1 class="mb-4" style="font-family: 'Poppins', sans-serif; color: #007bff;">
                 Daftar Kategori
            </h1>

            @can('create_kategori')
                <a href="{{ route('kategoris.create') }}" class="btn btn-primary mb-3"
                    style="font-family: 'Poppins', sans-serif;">
                    <i class="bi bi-journal-plus"></i> Tambah Kategori
                </a>
            @endcan

            <!-- Filter Section -->
            <div class="filter-section p-4 bg-light rounded shadow-sm">
                <h6 class="text-primary fw-bold mb-3">Filter Kategori</h6>
                <form id="filterForm" class="mb-4">
                    <label for="filterSelect" class="form-label text-secondary">Pilih Kategori</label>
                    <select id="filterSelect" class="form-select border-primary shadow-sm" multiple="multiple"
                        style="height: 150px;">

                    </select>

                </form>
            </div>


            <!-- Tempat untuk hasil filter -->
            <div id="filteredResults" class="row mt-4"></div>

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
                            <td class="d-flex gap-2 justify-content-center">
                                @can('read_kategori')
                                    <a href="{{ route('kategoris.show', $kategori) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i>Lihat
                                    </a>
                                @endcan
                                @can('edit_kategori')
                                    <a href="{{ route('kategoris.edit', $kategori) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>Edit
                                    </a>
                                @endcan
                                @can('delete_kategori')
                                    @if ($kategori->status == 'inactive')
                                        <form action="{{ route('kategoris.reactivate', $kategori->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-arrow-counterclockwise"></i>Re-Activate
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
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
                <a href="{{ $kategoris->previousPageUrl() }}" class="page-link">Previous</a>
                @foreach ($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                        class="page-link {{ $page == $kategoris->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endforeach
                <a href="{{ $kategoris->nextPageUrl() }}" class="page-link">Next</a>
            </div>
        </div>
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('#filterSelect').select2({
                placeholder: 'Pilih kategori',
                ajax: {
                    url: '{{ route('getDropdownData') }}',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: '{{ csrf_token() }}',
                            search: params.term
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

            // Fetch filtered data on change
            $('#filterSelect').on('change', function() {
                const selectedValues = $(this).val();
                console.log("Selected Values: ", selectedValues); // Debugging selected values

                // Check if any category is selected
                if (selectedValues && selectedValues.length > 0) {
                    fetchFilteredData(selectedValues);
                } else {
                    console.error('No categories selected');
                    $('#filteredResults').html(
                        '<p class="text-muted">No categories selected.</p>'
                    ); // Optional message to the user
                }
            });

            function fetchFilteredData(selectedValues) {
                $.ajax({
                    url: '{{ route('getFilteredData') }}',
                    type: 'POST',
                    data: {
                        values: selectedValues,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log("Response from server: ", response); // Debugging response
                        if (response.html) {
                            $('#filteredResults').html(response.html); // Render hasil filter
                        } else {
                            console.error('No HTML data in response.');
                            $('#filteredResults').html(
                                '<p class="text-danger">Error fetching data.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        console.error('Response:', xhr.responseText); // Display more error details
                        $('#filteredResults').html(
                            '<p class="text-danger">An error occurred while fetching data.</p>');
                    }
                });
            }
        });
    </script>
