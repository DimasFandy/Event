@extends('admin.layouts.app')

@section('content')
<h1 class="mb-4 text-primary">Detail Event</h1>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tr>
            <th>Nama:</th>
            <td>{{ $event->name }}</td>
        </tr>
        <tr>
            <th>Kategori:</th>
            <td>
                @foreach ($event->kategori as $kategori)
                    <span>{{ $kategori->name }}</span>@if (!$loop->last), @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Deskripsi:</th>
            <td>{{ $event->description }}</td>
        </tr>
        <tr>
            <th>Tanggal Mulai:</th>
            <td>{{ $event->start_date }}</td>
        </tr>
        <tr>
            <th>Tanggal Selesai:</th>
            <td>{{ $event->end_date }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ $event->status }}</td>
        </tr>
        <tr>
            <th>Jumlah Peserta:</th>
            <td>{{ $event->members_count ?? 0 }} peserta</td> <!-- Menampilkan jumlah peserta -->
        </tr>
    </table>
</div>

<!-- Daftar Peserta -->
<div class="mt-4">
    <h4 class="text-primary">Peserta yang Terdaftar:</h4>
    @if($members->isEmpty())
        <p>Tidak ada peserta terdaftar untuk event ini.</p>
    @else
        <ul>
            @foreach($members as $index => $member)
                <li>{{ ($members->currentPage() - 1) * $members->perPage() + $index + 1 }}. {{ $member->name }}</li> <!-- Menampilkan nomor urut berkelanjutan -->
            @endforeach
        </ul>

        <!-- Menampilkan Pagination -->
        {{ $members->links('pagination::simple-tailwind') }}
    @endif
</div>

<a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm mt-3">Kembali ke Daftar Event</a>
@endsection
