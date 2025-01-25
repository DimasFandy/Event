@extends('admin.layouts.app')

@section('content')

<!-- Tambahkan CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<h1 class="mb-4 text-primary" style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #004085; text-align: center; margin-bottom: 20px;">Tambah Event</h1>
<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 0 auto; transition: all 0.3s ease;">
    @csrf
    <div class="form-group" style="margin-bottom: 20px;">
        <label for="name" style="font-size: 1rem; font-weight: 600; color: #333;">Nama:</label>
        <input type="text" name="name" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="kategori_id" style="font-size: 1rem; font-weight: 600; color: #333;">Kategori:</label>
        <select name="kategori_id[]" class="form-control select2" multiple="multiple" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">
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
        <textarea name="description" class="form-control" rows="4" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;"></textarea>
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="start_date" style="font-size: 1rem; font-weight: 600; color: #333;">Tanggal Mulai:</label>
        <input type="datetime-local" name="start_date" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="end_date" style="font-size: 1rem; font-weight: 600; color: #333;">Tanggal Selesai:</label>
        <input type="datetime-local" name="end_date" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">
    </div>

    <div class="form-group" style="margin-bottom: 20px;">
        <label for="status" style="font-size: 1rem; font-weight: 600; color: #333;">Status:</label>
        <select name="status" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem;">
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px 30px; background-color: #007bff; color: white; font-size: 1.1rem; border: none; border-radius: 50px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease; display: block; width: 100%; margin-top: 20px;">
        Simpan
    </button>
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
