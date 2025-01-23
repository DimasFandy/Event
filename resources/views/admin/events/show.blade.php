@extends('admin.layouts.app')

@section('content')
<h1 class="mb-4 text-primary">Detail Event</h1>

<div class="d-flex justify-content-between mb-4">
    <a href="{{ route('events.members.create', ['event_id' => $event->id]) }}" class="btn btn-success">Tambah Peserta</a> <!-- Tombol tambah peserta -->
    <a href="{{ route('events.export_pdf', ['event_id' => $event->id]) }}" class="btn btn-primary">Export ke PDF</a> <!-- Tombol export ke PDF -->
</div>

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

<!-- Daftar Peserta dalam Tabel -->
<div class="mt-4">
    <h4 class="text-primary">Peserta yang Terdaftar:</h4>
    @if($members->isEmpty())
        <p>Tidak ada peserta terdaftar untuk event ini.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th> <!-- Kolom untuk tombol aksi -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $index => $member)
                        <tr>
                            <td>{{ ($members->currentPage() - 1) * $members->perPage() + $index + 1 }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->created_at->format('d M Y H:i') }}</td> <!-- Menampilkan tanggal daftar -->
                            <td>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('events.members.destroy', ['event_id' => $event->id, 'member_id' => $member->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Menampilkan Pagination -->
        {{ $members->links('pagination::simple-tailwind') }}
    @endif
</div>


<a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm mt-3">Kembali ke Daftar Event</a>
@endsection
