@extends('admin.layouts.app')
@section('title', 'Tambah Events')

@section('content')

<!-- Tambahkan CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Show success or error notifications -->
@if(session('success'))
    <script>
        $(document).ready(function() {
            $('#successModal').modal('show');
        });
    </script>
@endif

@if(session('error'))
    <script>
        $(document).ready(function() {
            $('#errorModal').modal('show');
        });
    </script>
@endif

<h1 class="mb-4 text-primary" style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #004085; text-align: center; margin-bottom: 20px;">
    Tambah Event
</h1>

<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" style="background: linear-gradient(135deg, #f5f7fa, #c3cfe2); padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 0 auto; transition: all 0.3s ease;">
    @csrf

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="name" style="font-size: 1rem; font-weight: 600; color: #333;">Nama:</label>
        <input type="text" name="name" class="form-control" required style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="kategori_id" style="font-size: 1rem; font-weight: 600; color: #333;">Kategori:</label>
        <select name="kategori_id[]" class="form-control select2" multiple="multiple" required style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategori as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-3 mb-3" style="margin-bottom: 20px;">
        <label for="image" style="font-size: 1rem; font-weight: 600; color: #333;">Gambar:</label>
        <input type="file" name="image" class="form-control-file" accept="image/*" {{ isset($event) ? '' : 'required' }} style="padding: 10px; border-radius: 8px; background-color: #f8f9fa; font-size: 1rem;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="description" style="font-size: 1rem; font-weight: 600; color: #333;">Deskripsi:</label>
        <textarea name="description" class="form-control" rows="4" style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;"></textarea>
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="start_date" style="font-size: 1rem; font-weight: 600; color: #333;">Tanggal Mulai:</label>
        <input type="datetime-local" name="start_date" class="form-control" required style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="end_date" style="font-size: 1rem; font-weight: 600; color: #333;">Tanggal Selesai:</label>
        <input type="datetime-local" name="end_date" class="form-control" required style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="status" style="font-size: 1rem; font-weight: 600; color: #333;">Status:</label>
        <select name="status" class="form-control" required style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; background-color: #fff;">
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px 30px; background: linear-gradient(135deg, #ff7e5f, #feb47b); color: white; font-size: 1.1rem; border: none; border-radius: 50px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease; display: block; width: 100%; margin-top: 20px;">
        Simpan
    </button>
</form>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Tambahkan JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 pada elemen dengan class select2
        $('.select2').select2({
            placeholder: "Pilih Kategori",
            allowClear: true
        });
    });
</script>
