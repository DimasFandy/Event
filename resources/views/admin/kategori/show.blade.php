@extends('admin.layouts.app')
@section('title', 'Detail Katgeori')

@section('content')

<div class="container-show" style="max-width: 800px; margin: 20px auto; padding: 20px; background: #ffffff; border-radius: 12px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">
    <h1 style="font-size: 2rem; font-weight: bold; color: #374151; margin-bottom: 20px;">Detail Kategori</h1>
    <div class="card" style="padding: 20px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
        <h2 style="font-size: 1.5rem; color: #1f2937; margin-bottom: 10px;">{{ $kategori->name }}</h2>
        <p style="font-size: 1rem; color: #4b5563;"><strong>Deskripsi:</strong> {{ $kategori->description }}</p>
        <p style="font-size: 1rem; color: #4b5563;"><strong>Bobot:</strong> {{ $kategori->weight }}</p>
        <p style="font-size: 1rem; color: #4b5563;"><strong>Status:</strong> <span style="color: {{ $kategori->status == 'active' ? '#10b981' : '#ef4444' }}; font-weight: bold;">{{ $kategori->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}</span></p>
    </div>
    <a href="{{ route('kategoris.index') }}" class="btn btn-primary mr-2">Kembali</a>
</div>
@endsection
