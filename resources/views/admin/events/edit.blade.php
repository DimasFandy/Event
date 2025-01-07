@extends('admin.layouts.app')

@section('content')
    <!-- Tambahkan CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <h1 class="mb-4 text-primary">Edit Event</h1>

    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori:</label>
            <select name="kategori_id[]" class="form-control select2" multiple="multiple" required>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}"
                        {{ in_array($item->id, old('kategori_id', $event->kategori->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi:</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Tanggal Mulai:</label>
            <input type="datetime-local" name="start_date" class="form-control"
                value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Tanggal Selesai:</label>
            <input type="datetime-local" name="end_date" class="form-control"
                value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ $event->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $event->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <div class="form-group mt-3 mb-3">
            <label for="image">Gambar:</label>
            <input type="file" name="image" class="form-control-file" accept="image/*">
            @if ($event->image_path)
                <div class="mt-2">
                    <p>Gambar Saat Ini:</p>
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="Gambar Event" class="img-fluid" style="max-width: 300px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
    </form>

    <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm mt-3">Kembali ke Daftar Event</a>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 with multiple selection
        $('.select2').select2({
            placeholder: 'Pilih Kategori',
            allowClear: true
        });
    });
</script>
