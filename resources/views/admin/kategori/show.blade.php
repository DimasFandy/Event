@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Kategori</h1>

        <p><strong>Nama:</strong> {{ $kategori->name }}</p>
        <p><strong>Deskripsi:</strong> {{ $kategori->description }}</p>
        <p><strong>Bobot:</strong> {{ $kategori->weight }}</p>
        <p><strong>Status:</strong> {{ $kategori->status }}</p>
    </div>
@endsection
