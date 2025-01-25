@extends('admin.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kategori.css') }}">
<div class="container">
    <h1>Tambah Kategori Baru</h1>
    <form action="{{ route('kategoris.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="weight">Bobot</label>
            <input type="number" id="weight" name="weight" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>
        <button type="submit">Simpan</button>
    </form>
</div>
@endsection
