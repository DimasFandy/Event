@extends('admin.layouts.app')

@section('content')
<!-- Tambahkan CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<h1 class="mb-4 text-primary">Tambah Event</h1>
<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Nama:</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="kategori_id">Kategori:</label>
        <select name="kategori_id[]" class="form-control select2" multiple="multiple" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategori as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-3 mb-3">
        <label for="image">Gambar:</label>
        <input type="file" name="image" class="form-control-file" accept="image/*" {{ isset($event) ? '' : 'required' }}>
    </div>

    <div class="form-group">
        <label for="description">Deskripsi:</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
    </div>

    <div class="form-group">
        <label for="start_date">Tanggal Mulai:</label>
        <input type="datetime-local" name="start_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="end_date">Tanggal Selesai:</label>
        <input type="datetime-local" name="end_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" class="form-control" required>
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
</form>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Tambahkan JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 pada elemen dengan class select2
        $('.select2').select2({
            placeholder: "Pilih Kategori",
            allowClear: true
        });
    });
</script>
