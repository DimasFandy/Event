@extends('admin.layouts.app')

@section('content')
    <h1 class="mb-4 text-primary">Detail Event</h1>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('events.members.create', ['event_id' => $event->id]) }}" class="btn btn-primary"><img width="20" height="20" src="https://img.icons8.com/ultraviolet/50/add-user-group-woman-man.png" alt="add-user-group-woman-man"/> Tambah Peserta</a>
        <a href="{{ route('events.export_pdf', ['event_id' => $event->id]) }}" class="btn btn-success"><img width="20" height="20" src="https://img.icons8.com/arcade/64/ms-word.png" alt="ms-word"/> Export ke PDF</a>
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
                        <span>{{ $kategori->name }}</span>
                        @if (!$loop->last)
                            ,
                        @endif
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
                <td>{{ $event->members_count ?? 0 }} peserta</td>
            </tr>
        </table>
    </div>

    <div class="mt-4">
        <h4 class="text-primary">Peserta yang Terdaftar:</h4>
        @if ($members->isEmpty())
            <p>Tidak ada peserta terdaftar untuk event ini.</p>
        @else
            <div class="table-responsive">
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
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
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

    <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm mt-3">Kembali ke Daftar Event</a>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true"
        data-event-id="{{ $event->id }}">
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
                            <label for="reason" class="form-label">Alasan Penghapusan</label>
                            <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
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

            // Set action URL untuk form
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.setAttribute('action', `/events/${eventId}/members/${memberId}`);

            // Set modal data
            document.getElementById('memberId').value = memberId;
            document.getElementById('memberName').textContent = memberName;
        });
    });
</script>
