@extends('admin.layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Potta+One&family=Rampart+One&family=Sansita:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/events.css') }}">


<h1 class="mb-4 text-primary">Daftar Event</h1>

@can('create_event')
    <a href="{{ route('events.create') }}" class="btn btn-success mb-3"><i class="bi bi-calendar2-plus-fill"></i> Tambah Event</a>
@endcan

<a href="{{ route('events.export') }}" class="btn btn-primary mb-3"><i class="bi bi-file-earmark-excel"></i> Export to Excel</a>

<!-- Filter Section (Select2) -->
<h6 class="text-muted">Filter Kategori</h6>
<form id="filterForm" method="GET" action="{{ route('events.index') }}" class="mb-4">
    <label for="filterSelect" class="form-label">Pilih Kategori</label>
    <select id="filterSelect" name="kategori_id[]" class="form-select" multiple="multiple">
        <!-- Options will be populated by the controller -->
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ in_array($category->id, request('kategori_id', [])) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary mt-3">Filter</button>
</form>

<!-- Only display filtered events if filter is applied -->
@if(request('kategori_id', []))
    <h6>Showing results for selected categories:</h6>
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover table-sm shadow-sm rounded">
        <table class="table table-striped">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center">Gambar</th> <!-- Kolom Gambar -->
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Peserta</th> <!-- Kolom jumlah peserta -->
                    <th class="text-center" style="width: 200px;">Aksi</th> <!-- Lebar tetap untuk kolom aksi -->
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr class="event-row">
                        <td>{{ $loop->iteration + $events->firstItem() - 1 }}</td>
                        <td>{{ $event->name }}</td>
                        <td>
                            @foreach ($event->kategori as $kategori)
                                <span>{{ $kategori->name }}</span>@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td style="max-width: 300px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $event->description }}
                        </td>
                        <td class="text-center">
                            @if ($event->image_path)
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="Gambar Event" style="max-width: 100px; height: auto;">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>{{ $event->start_date }} - {{ $event->end_date }}</td>
                        <td class="text-center">
                            <span class="badge
                                @if ($event->status == 'Aktif') bg-success
                                @elseif($event->status == 'Tidak Aktif') bg-danger
                                @else bg-warning @endif">
                                {{ $event->status }}
                            </span>
                        </td>
                        <td class="text-center">{{ $event->members_count ?? 0 }} jumlah</td> <!-- Menampilkan jumlah peserta -->
                        <td class="text-center" style="width: 200px;"> <!-- Lebar tetap -->
                            <div style="display: flex; justify-content: center; gap: 5px; flex-wrap: wrap;">
                                @can('read_event')
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm event-action-btn"><i class="bi bi-file-earmark"></i> Detail</a>
                                @endcan

                                @can('edit_event')
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm event-action-btn"><i class="bi bi-pencil-square"></i> Edit</a>
                                @endcan

                                @can('delete_event')
                                    @if ($event->status === 'inactive')
                                        <form action="{{ route('events.reactivate', $event->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm event-action-btn"><i class="bi bi-arrow-counterclockwise"></i> Reactive</button>
                                        </form>
                                    @else
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm event-action-btn"><i class="bi bi-trash-fill"></i> Hapus</button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </table>


    <!-- Pagination -->
    <div class="pagination">
        <a href="{{ $events->previousPageUrl() }}" class="page-link" style="font-family: 'Poppins', sans-serif;">Previous</a>
        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page == $events->currentPage() ? 'active' : '' }}"
                style="font-family: 'Poppins', sans-serif;">{{ $page }}</a>
        @endforeach
        <a href="{{ $events->nextPageUrl() }}" class="page-link" style="font-family: 'Poppins', sans-serif;">Next</a>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 with multiple selection and limit of 2
            $('#filterSelect').select2({
                theme: 'bootstrap4',
                placeholder: 'Select Categories',
                maximumSelectionLength: 2 // Limit the number of selections to 2
            });
        });
    </script>
@endsection
