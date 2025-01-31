@extends('user.layouts.app')

@section('title', 'The Events')

@section('content')

    <!--==========================
    Event Details Section
  ============================-->
    <section id="event-details" class="wow fadeIn">
        <div class="container">
            <div class="section-header">
                <h2>Event Details</h2>
                <p>{{ $event->name }}</p>
            </div>

            <!-- Menampilkan Notifikasi -->
            @if (session('success'))
                <!-- Modal for Success -->
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog"
                    aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel">Success</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ session('success') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <!-- Modal for Error -->
                <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ session('error') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <a href="#" class="btn btn-primary mb-2" onclick="window.history.back(); return false;"><img width="20" height="20" src="https://img.icons8.com/ios-filled/50/FFFFFF/long-arrow-left.png" alt="long-arrow-left"/> Previous</a>
            <a href="{{ route('home') }}" class="btn btn-primary mb-2"> back to home</a>
            <div class="row mb-5">
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}"
                        class="event-img">
                </div>

                <div class="col-md-6">
                    <div class="details">
                        <h2>{{ $event->name }}</h2>
                        <p><strong>Kategori:</strong> {{ $event->kategori->pluck('name')->join(', ') }}</p>
                        <p><strong>Deskripsi:</strong> {{ $event->description }}</p>
                        <p><strong>Mulai:</strong>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y h:i A') }}</p>
                        <p><strong>Selesai:</strong>
                            {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y h:i A') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>

                        <!-- Menampilkan jumlah peserta yang terdaftar -->
                        <p><strong>Jumlah Peserta Terdaftar:</strong> {{ $participantCount }} peserta</p>

                        <div class="d-flex">
                            <!-- Cek apakah member sudah mendaftar -->
                            @php
                                $isRegistered = \App\Models\EventMember::where('event_id', $event->id)
                                    ->where('member_id', auth('member')->id())
                                    ->exists();
                            @endphp

                            @if ($isRegistered)
                                <button class="btn btn-secondary" disabled>Sudah Terdaftar</button>
                            @else
                                <form action="{{ route('events.register', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Daftar Event</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Template Main Javascript File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Modal Trigger Script -->
    @if (session('success'))
        <script>
            $(document).ready(function() {
                $('#successModal').modal('show');
            });
        </script>
    @elseif (session('error'))
        <script>
            $(document).ready(function() {
                $('#errorModal').modal('show');
            });
        </script>
    @endif

    @endsection
