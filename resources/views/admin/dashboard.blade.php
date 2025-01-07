@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Welcome to the Dashboard!</h2>
        <p>Overview of your metrics and events.</p>
        <div class="row mt-4">
            <!-- Home Card -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3 animated-card">
                    <div class="card-header">Home</div>
                    <div class="card-body">
                        <h5 class="card-title">Dashboard Overview</h5>
                        <p class="card-text">View and manage your overall performance metrics here.</p>
                    </div>
                </div>
            </div>

            <!-- Events Card -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3 animated-card">
                    <div class="card-header">Events</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Events</h5>
                        <p class="card-text">Add, update, or view the list of events and criteria.</p>
                        <ul>
                            @foreach($events as $event)
                                <li>{{ $event->name }} - {{ $event->date }}</li> <!-- Replace with actual event attributes -->
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3 animated-card">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Categories</h5>
                        <p class="card-text">Add or manage registered categories here.</p>
                        <ul>
                            @foreach($kategoris as $kategori)
                                <li>{{ $kategori->name }}</li> <!-- Replace with actual category attributes -->
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
