@extends('admin.layouts.app')

@section('content')

<h1 class="mb-4 text-primary" style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #004085; text-align: center; margin-bottom: 20px;">Detail Event</h1>

<div class="d-flex justify-content-between mb-4">
    <!-- Tombol Kembali di kiri -->
    <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm mt-3" style="padding: 8px 16px; background-color: #6c757d; color: white; font-size: 1rem; border-radius: 50px;">
        Kembali ke Daftar Event
    </a>

    <!-- Tombol-tombol di sebelah kanan -->
    <div class="d-flex gap-2">
        <a href="{{ route('events.members.create', ['event_id' => $event->id]) }}" class="btn btn-primary" style="padding: 12px 20px; background-color: #007bff; color: white; font-size: 1rem; border-radius: 50px; transition: all 0.3s ease; display: inline-flex; align-items: center;">
            <img width="20" height="20" src="https://img.icons8.com/ultraviolet/50/add-user-group-woman-man.png" alt="add-user-group-woman-man" style="margin-right: 8px;"/> Tambah Peserta
        </a>
        <a href="{{ route('events.export_pdf', ['event_id' => $event->id]) }}" class="btn btn-success" style="padding: 12px 20px; background-color: #28a745; color: white; font-size: 1rem; border-radius: 50px; transition: all 0.3s ease; display: inline-flex; align-items: center;">
            <img width="20" height="20" src="https://img.icons8.com/arcade/64/ms-word.png" alt="ms-word" style="margin-right: 8px;"/> Export PDF
        </a>
    </div>
</div>
    

<div class="table-responsive mb-4" style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
    <table class="table table-bordered table-striped">
        <tr>
            <th style="font-weight: 600; color: #333;">Nama:</th>
            <td>{{ $event->name }}</td>
        </tr>
        <tr>
            <th style="font-weight: 600; color: #333;">Kategori:</th>
            <td>
                @foreach ($event->kategori as $kategori)
                    <span>{{ $kategori->name }}</span>
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th style="font-weight: 600; color: #333;">Deskripsi:</th>
            <td>{{ $event->description }}</td>
        </tr>
        <tr>
            <th style="font-weight: 600; color: #333;">Tanggal Mulai:</th>
            <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <th style="font-weight: 600; color: #333;">Tanggal Selesai:</th>
            <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <th style="font-weight: 600; color: #333;">Status:</th>
            <td>{{ ucfirst($event->status) }}</td>
        </tr>
        <tr>
            <th style="font-weight: 600; color: #333;">Jumlah Peserta:</th>
            <td>{{ $event->members_count ?? 0 }} peserta</td>
        </tr>
    </table>
</div>

<div class="mt-4">
    <h4 class="text-primary" style="font-weight: 700; color: #004085;">Peserta yang Terdaftar:</h4>
    @if ($members->isEmpty())
        <p class="text-muted" style="color: #6c757d;">Tidak ada peserta terdaftar untuk event ini.</p>
    @else
        <div class="table-responsive" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $index => $member)
                        <tr>
                            <td>{{ ($members->currentPage() - 1) * $members->perPage() + $index + 1 }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" style="padding: 6px 12px; background-color: #dc3545; color: white; border-radius: 5px; transition: all 0.3s ease;" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-member-id="{{ $member->id }}"
                                    data-member-name="{{ $member->name }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $members->links('pagination::simple-tailwind') }}
    @endif
</div>



<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-event-id="{{ $event->id }}">
    <div class="modal-dialog">
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="member_id" id="memberId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus peserta <strong id="memberName"></strong>?</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label" style="font-weight: 600; color: #333;">Alasan Penghapusan</label>
                        <textarea name="reason" id="reason" class="form-control" rows="3" style="border-radius: 8px; border: 1px solid #ccc;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Display success or error notification as pop-ups
        @if (session('success'))
            alert('Success: {{ session('success') }}');
        @elseif (session('error'))
            alert('Error: {{ session('error') }}');
        @endif

        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const memberId = button.getAttribute('data-member-id');
            const memberName = button.getAttribute('data-member-name');
            const eventId = deleteModal.getAttribute('data-event-id');

            // Set action URL for form
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', `/events/${eventId}/members/${memberId}`);

            // Set modal data
            document.getElementById('memberId').value = memberId;
            document.getElementById('memberName').textContent = memberName;
        });
    });
</script>
