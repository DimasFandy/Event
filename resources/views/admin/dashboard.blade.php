@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <div class="container mt-4">
        <div class="row mt-4">
            <!-- Total Members Card -->
            <div class="col-md-3">
                <div class="card custom-card shadow-lg">
                    <div class="card-header gradient-header">
                        Total Members
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $memberCount }}</h5>
                        <p class="card-text">Total angka member yang sudah terdaftar platform</p>
                    </div>
                </div>
            </div>

            <!-- Total Events Card -->
            <div class="col-md-3">
                <div class="card custom-card shadow-lg">
                    <div class="card-header gradient-header">
                        Total Events
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $eventCount }}</h5>
                        <p class="card-text">Total angka events yang sudah di buat.</p>
                    </div>
                </div>
            </div>

            <!-- Members Registered for Events Card -->
            <div class="col-md-3">
                <div class="card custom-card shadow-lg">
                    <div class="card-header gradient-header">
                        Members terdaftar
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $registeredMembersCount }}</h5>
                        <p class="card-text">Total angka members yang sudah masuk ke events.</p>
                    </div>
                </div>
            </div>

            <!-- Completed Events Card -->
            <div class="col-md-3">
                <div class="card custom-card shadow-lg">
                    <div class="card-header gradient-header">
                        Completed Events
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $completedEventsCount }}</h5>
                        <p class="card-text">Total angka events yang sudah selesai.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Chart.js Data -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="chart-container p-3 shadow-sm">
                <canvas id="eventChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container p-3 shadow-sm">
                <canvas id="membersChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Menampilkan alert sukses jika session 'success' ada
        @if (session('success'))
            Swal.fire({
                title: 'Login Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Lanjutkan'
            });
        @endif
    </script>
    <script>
        // Membuat chart untuk jumlah event per bulan
        var eventCtx = document.getElementById('eventChart').getContext('2d');
        var eventChart = new Chart(eventCtx, {
            type: 'line',
            data: {
                labels: [
                    ...@json(array_keys($eventsPerMonth->toArray())), // Bulan yang ada
                    ...@json(array_keys($nextMonths->toArray())) // Bulan selanjutnya
                ], // Gabungkan bulan yang ada dengan bulan selanjutnya
                datasets: [{
                        label: 'Events per bulan',
                        data: [
                            ...@json($eventsPerMonth->values()), // Data event bulan ini
                            ...@json($nextMonths->values()) // Data event bulan selanjutnya
                        ],
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)', // Warna garis untuk events
                        tension: 0.1,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointBorderColor: 'rgba(75, 192, 192, 1)',
                        pointRadius: 5
                    },
                    {
                        label: 'Registered Members per bulan', // Label untuk dataset members
                        data: [
                            ...@json($membersPerMonth->values()), // Data jumlah member yang terdaftar bulan ini
                            ...@json($nextMembers->values()) // Data jumlah member yang terdaftar bulan depan
                        ],
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)', // Warna garis untuk members
                        tension: 0.1,
                        pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                        pointBorderColor: 'rgba(255, 99, 132, 1)',
                        pointRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Event dan Members per Bulan',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        padding: {
                            top: 20,
                            bottom: 30
                        }
                    },
                    datalabels: {
                        align: 'top',
                        color: '#000',
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        formatter: function(value) {
                            return value;
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear',
                        from: 1,
                        to: 0,
                        loop: true
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        var membersCtx = document.getElementById('membersChart').getContext('2d');
        // Mengambil event names dan menggantinya dengan indeks
        var eventIndexes = @json($eventsWithMembers->pluck('event_name')->toArray()).map((_, index) => index + 1); // Menggunakan angka sebagai label
        var combinedChart = new Chart(membersCtx, {
            type: 'bar', // Tipe chart bar untuk dataset Interest Percentage
            data: {
                labels: eventIndexes, // Ganti label menjadi angka (indeks)
                datasets: [{
                        label: 'Members Registered per Event',
                        data: @json($eventsWithMembers->pluck('member_count')->toArray()), // Jumlah member terdaftar per event
                        type: 'line', // Ganti tipe chart menjadi line untuk dataset ini
                        borderColor: 'rgba(54, 162, 235, 1)', // Warna garis untuk chart line
                        backgroundColor: 'rgba(54, 162, 235, 0)', // Menghapus warna background untuk chart line
                        borderWidth: 2, // Ketebalan garis chart line
                        tension: 0.4, // Membuat garis sedikit melengkung (smooth)
                        fill: false, // Tidak mengisi area bawah garis
                        animation: {
                            tension: {
                                duration: 1000, // Durasi animasi (1 detik)
                                easing: 'linear', // Menggunakan efek linear
                                from: 1, // Nilai awal tension
                                to: 0, // Nilai akhir tension
                                loop: true // Menambahkan looping pada animasi
                            }
                        }
                    },
                    {
                        label: 'Presentase Peminat per Event',
                        data: @json($eventsWithInterestPercentage->pluck('interest_percentage')->toArray()).map(function(val) {
                            return val / 10; // Mengubah nilai ke persen (misalnya 600 menjadi 60)
                        }), // Data persentase untuk event
                        backgroundColor: 'rgba(255, 99, 132, 0.7)', // Warna latar belakang untuk dataset kedua
                        borderWidth: 0 // Menghilangkan border untuk dataset kedua
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true, // Menampilkan judul
                        text: 'Member Registered and Interest Percentage per Event', // Judul chart gabungan
                        font: {
                            size: 16, // Ukuran font
                            weight: 'bold' // Berat font
                        },
                        padding: {
                            top: 20, // Padding atas untuk memberi jarak antara judul dan chart
                            bottom: 50 // Padding bawah untuk memberi jarak antara judul dan chart
                        }
                    },
                    legend: {
                        display: true, // Menampilkan legend
                        position: 'bottom', // Menempatkan legend di bawah chart
                        labels: {
                            font: {
                                size: 14, // Ukuran font
                                weight: 'bold' // Berat font
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var eventName = @json($eventsWithMembers->pluck('event_name')->toArray());
                                var datasetLabel = tooltipItem.dataset.label; // Mendapatkan label dataset
                                var value = tooltipItem.raw; // Nilai yang ditampilkan pada tooltip
                                var eventIndex = tooltipItem.dataIndex; // Mengambil indeks data yang dipilih
                                if (datasetLabel === 'Members Registered per Event') {
                                    return eventName[eventIndex] + ': ' + value +
                                        ' Members'; // Menampilkan nama event dan jumlah member
                                } else if (datasetLabel === 'Presentase Peminat per Event') {
                                    return eventName[eventIndex] + ': ' + value +
                                        '%'; // Menampilkan nama event dan persentase
                                }
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end', // Menempatkan label di ujung batang
                        align: 'end', // Menyesuaikan label sejajar dengan ujung batang
                        color: '#000', // Warna teks
                        font: {
                            size: 12, // Ukuran font
                            weight: 'bold' // Berat font
                        },
                        formatter: function(value, context) {
                            // Memformat data untuk tampil sebagai persentase
                            if (context.dataset.label === 'Presentase Peminat per Event') {
                                return value + '%'; // Tambahkan simbol % untuk persentase
                            }
                            return value; // Menampilkan nilai data langsung
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah / Persentase', // Label untuk sumbu y
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                }
            },
            plugins: [ChartDataLabels] // Menambahkan plugin dataLabels
        });
    </script>

    <div class="row mt-4">
    <div class="col-md-12">
        <div class="card custom-card shadow-lg">
            <div class="card-header gradient-header">
                Events Terbaru
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Event</th>
                            <th>Tanggal Dibuat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestEvents as $index => $event)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $event->image_path) }}"
                                         alt="{{ $event->name }}"
                                         class="img-thumbnail"
                                         width="100">
                                </td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->created_at->format('d M Y') }}</td>
                                <td><span class="badge bg-success">Baru</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection
