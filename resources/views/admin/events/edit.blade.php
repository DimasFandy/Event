@extends('admin.layouts.app')

@section('content')
    <!-- Tambahkan CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Show success or error notifications -->
    @if (session('success'))
        <script>
            $(document).ready(function() {
                $('#successModal').modal('show');
            });
        </script>
    @elseif(session('error'))
        <script>
            $(document).ready(function() {
                $('#errorModal').modal('show');
            });
        </script>
    @endif

    <h1 class="mb-4 text-primary" style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #004085; text-align: center; margin-bottom: 30px;">
        Edit Event
    </h1>

    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
        style="background: linear-gradient(135deg, #f5f7fa, #c3cfe2); padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 0 auto;">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="name" style="font-size: 1rem; font-weight: 600; color: #333;">Nama:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required
                style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="kategori_id" style="font-size: 1rem; font-weight: 600; color: #333;">Kategori:</label>
            <select name="kategori_id[]" class="form-control select2" multiple="multiple" required
                style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}"
                        {{ in_array($item->id, old('kategori_id', $event->kategori->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="description" style="font-size: 1rem; font-weight: 600; color: #333;">Deskripsi:</label>
            <textarea name="description" class="form-control" rows="4"
                style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="start_date" style="font-size: 1rem; font-weight: 600; color: #333;">Tanggal Mulai:</label>
            <input type="datetime-local" name="start_date" class="form-control"
                value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}" required
                style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="end_date" style="font-size: 1rem; font-weight: 600; color: #333;">Tanggal Selesai:</label>
            <input type="datetime-local" name="end_date" class="form-control"
                value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i')) }}" required
                style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="status" style="font-size: 1rem; font-weight: 600; color: #333;">Status:</label>
            <select name="status" class="form-control" required
                style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
                <option value="active" {{ $event->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $event->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <div class="form-group mt-3 mb-3" style="margin-bottom: 20px;">
            <label for="image" style="font-size: 1rem; font-weight: 600; color: #333;">Gambar:</label>
            <input type="file" name="image" class="form-control-file" accept="image/*"
                style="padding: 10px; background-color: #f8f9fa; font-size: 1rem;">
            @if ($event->image_path)
                <div class="mt-2">
                    <p>Gambar Saat Ini:</p>
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="Gambar Event" class="img-fluid"
                        style="max-width: 300px;">
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-primary btn-lg"
                style="padding: 12px 30px; background: linear-gradient(135deg, #ff7e5f, #feb47b); color: white; font-size: 1.1rem; border: none; border-radius: 50px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
                Simpan Perubahan
            </button>
            <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm"
                style="padding: 8px 20px; background: linear-gradient(135deg, #6c757d, #343a40); color: white; font-size: 1rem; border-radius: 30px;">
                Kembali ke Daftar Event
            </a>
        </div>
    </form>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Password Updated Successfully</h5>
                </div>
                <div class="modal-body">
                    Data Event berhasil di update. <b>klik dimana saja untuk menutup. Terima Kasih</b>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('events.index') }}" class="btn btn-primary">kembali</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                </div>
                <div class="modal-body">
                    Terjadi kesalahan. <b>klik dimana saja untuk menutup. Terima Kasih</b>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('events.index') }}" class="btn btn-danger">kembali</a>
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 with multiple selection
        $('.select2').select2({
            placeholder: 'Pilih Kategori',
            allowClear: true
        });
    });
</script>
