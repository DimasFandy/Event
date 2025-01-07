@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Kategori</h1>

        <form action="{{ route('kategoris.update', $kategori) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $kategori->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control" id="description" name="description">{{ $kategori->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="weight">Bobot</label>
                <input type="number" class="form-control" id="weight" name="weight" value="{{ $kategori->weight }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" {{ $kategori->status == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ $kategori->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
