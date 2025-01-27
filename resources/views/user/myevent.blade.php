@extends('user.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/myevent.css') }}">
<div class="container mt-4">
    <h1>Event yang Diikuti</h1>

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
                                <span>
                                    <strong>Tanggal:</strong>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                </span>
                                @php
                                    // Pastikan start_date dan end_date diparsing sebagai objek Carbon
                                    $startDate = \Carbon\Carbon::parse($event->start_date);
                                    $endDate = \Carbon\Carbon::parse($event->end_date);
                                    $now = \Carbon\Carbon::now();

                                    // Tentukan status berdasarkan tanggal sekarang
                                    if ($now->between($startDate, $endDate)) {
                                        $status = 'active';
                                        $label = 'Sedang Berlangsung';
                                        $badgeClass = 'bg-success';
                                    } elseif ($now->lt($startDate)) {
                                        $status = 'upcoming';
                                        $label = 'Akan Datang';
                                        $badgeClass = 'bg-info';
                                    } else {
                                        $status = 'inactive';
                                        $label = 'Selesai';
                                        $badgeClass = 'bg-secondary';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $label }}
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
