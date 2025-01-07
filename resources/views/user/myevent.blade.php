@extends('user.layouts.app')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Event yang Diikuti</h1>

    @if($events->isEmpty())
        <div class="alert alert-info">
            Anda belum mengikuti event apapun.
        </div>
    @else
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm rounded" style="transition: transform 0.3s ease;">
                        <img src="{{ asset('storage/' . $event->image_path) }}" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;">

                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ $event->name }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <span><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</span>
                                @php
                                    $status = \Carbon\Carbon::now()->between($event->start_date, $event->end_date) ? 'active' : 'inactive';
                                @endphp
                                <span class="badge {{ $status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $status == 'active' ? 'Sedang Berlangsung' : 'Selesai' }}
                                </span>
                            </div>
                            <p><strong>Deskripsi:</strong> {{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                        </div>

                        <div class="card-footer text-center">
                            <a href="{{ route('user.events_details', $event->id) }}" class="btn btn-sm btn-info">Detail Event</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .card:hover {
        transform: translateY(-10px);
    }
</style>

@endsection
