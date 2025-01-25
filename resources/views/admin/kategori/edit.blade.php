@extends('admin.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kategori.css') }}">
<div class="container-edit">
    <h1>Edit Kategori</h1>
    <form action="{{ route('kategoris.update', $kategori) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ $kategori->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description">{{ $kategori->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="weight">Bobot</label>
            <input type="number" id="weight" name="weight" value="{{ $kategori->weight }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="active" {{ $kategori->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $kategori->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit">Update</button>
    </form>
</div>
@endsection
