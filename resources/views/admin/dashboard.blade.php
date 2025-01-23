@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row mt-4">
            <!-- Total Members Card -->
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3 animated-card">
                    <div class="card-header">Total Members</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $memberCount }}</h5>
                        <p class="card-text">Total number of members who have registered on the platform.</p>
                    </div>
                </div>
            </div>

            <!-- Total Events Card -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 animated-card">
                    <div class="card-header">Total Events</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $eventCount }}</h5>
                        <p class="card-text">Total number of events that have been created.</p>
                    </div>
                </div>
            </div>

            <!-- Members Registered for Events Card -->
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 animated-card">
                    <div class="card-header">Members Registered for Events</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $registeredMembersCount }}</h5>
                        <p class="card-text">Total number of members who have registered for events.</p>
                    </div>
                </div>
            </div>

            <!-- Completed Events Card -->
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3 animated-card">
                    <div class="card-header">Completed Events</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $completedEventsCount }}</h5>
                        <p class="card-text">Total number of events that have been completed.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Chart.js Data -->
        <div class="row mt-4">
            <div class="col-md-6">
                <canvas id="eventChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="membersChart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="interestChart"></canvas> <!-- Canvas untuk chart persentase peminat -->
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


        <script>
            // Membuat chart untuk jumlah event per bulan
            var eventCtx = document.getElementById('eventChart').getContext('2d');
            var eventChart = new Chart(eventCtx, {
                type: 'line',
                data: {
                    labels: @json(array_keys($eventsPerMonth->toArray())).concat(
                        @json(array_keys($nextMonths->toArray()))
                    ), // Gabungkan bulan yang ada dengan bulan selanjutnya
                    datasets: [{
                        label: 'Events per Month',
                        data: @json($eventsPerMonth->values()).concat(
                            @json($nextMonths->values())
                        ), // Gabungkan data event yang ada dengan data event bulan depan
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Warna titik data
                        pointBorderColor: 'rgba(75, 192, 192, 1)', // Warna border titik data
                        pointRadius: 5 // Ukuran titik data
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true, // Menampilkan judul
                            text: 'Jumlah Event per Bulan', // Judul chart
                            font: {
                                size: 16, // Ukuran font
                                weight: 'bold' // Berat font
                            },
                            padding: {
                                top: 20, // Padding atas untuk memberi jarak antara judul dan chart
                                bottom: 30 // Padding bawah untuk memberi jarak antara judul dan chart
                            }
                        },
                        datalabels: {
                            align: 'top', // Posisi label di atas titik data
                            color: '#000', // Warna teks label
                            font: {
                                size: 12, // Ukuran font
                                weight: 'bold' // Berat font
                            },
                            formatter: function(value) {
                                return value; // Menampilkan nilai data di setiap titik
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true, // Memulai sumbu y dari 0
                            title: {
                                display: true,
                                text: 'Jumlah Event', // Label untuk sumbu y
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan', // Label untuk sumbu x
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Menambahkan plugin dataLabels
            });



            var membersCtx = document.getElementById('membersChart').getContext('2d');

            // Mengambil event names dan menggantinya dengan indeks
            var eventIndexes = @json($eventsWithMembers->pluck('event_name')->toArray()).map((_, index) => index + 1); // Menggunakan angka sebagai label

            var membersChart = new Chart(membersCtx, {
                type: 'bar', // Bar chart untuk perbandingan yang lebih jelas
                data: {
                    labels: eventIndexes, // Ganti label menjadi angka (indeks)
                    datasets: [{
                        label: 'Members Registered per Event',
                        data: @json($eventsWithMembers->pluck('member_count')->toArray()), // Jumlah member terdaftar per event
                        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true, // Menampilkan judul
                            text: 'Persentase Peminat per Event', // Judul chart
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
                                // Kustomisasi tooltip untuk menampilkan nama event
                                label: function(tooltipItem) {
                                    var eventName = @json($eventsWithMembers->pluck('event_name')->toArray());
                                    var memberCount = tooltipItem.raw; // Nilai member yang ditampilkan pada tooltip
                                    var eventIndex = tooltipItem
                                    .dataIndex; // Mengambil indeks dari data yang dipilih
                                    return eventName[eventIndex] + ': ' + memberCount +
                                    ' Members'; // Menampilkan nama event dan jumlah member
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
                            formatter: function(value) {
                                return value; // Menampilkan nilai data langsung
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Member', // Label untuk sumbu y
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




            // Membuat chart untuk persentase peminat per event
            var interestCtx = document.getElementById('interestChart').getContext('2d');
            var interestChart = new Chart(interestCtx, {
                type: 'doughnut', // Doughnut chart untuk persentase
                data: {
                    labels: @json($eventsWithInterestPercentage->pluck('event_name')->toArray()), // Nama event
                    datasets: [{
                        label: 'Interest Percentage per Event',
                        data: @json($eventsWithInterestPercentage->pluck('interest_percentage')->toArray()), // Pastikan data ini dalam bentuk nilai mentah, bukan persentase
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(255, 99, 132, 0.5)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true, // Menampilkan judul
                            text: 'Persentase Peminat per Event', // Judul chart
                            font: {
                                size: 16, // Ukuran font
                                weight: 'bold' // Berat font
                            },
                            padding: {
                                top: 70, // Padding atas untuk memberi jarak antara judul dan chart
                                bottom: 0 // Padding bawah untuk memberi jarak antara judul dan chart
                            }
                        },
                        legend: {
                            position: 'right', // Menempatkan legend di samping kanan chart
                            labels: {
                                boxWidth: 20, // Ukuran kotak warna di legend
                                padding: 15 // Jarak antara kotak warna dan label
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.chart.data.datasets[0].data.reduce((a, b) => a + b,
                                        0); // Total nilai data
                                    let percentage = ((value / total) * 100).toFixed(2); // Hitung persentase
                                    return `${label}: ${percentage}%`; // Tampilkan persentase
                                }
                            }
                        },
                        datalabels: {
                            color: '#000', // Warna teks
                            font: {
                                weight: 'bold' // Berat font
                            },
                            formatter: function(value, context) {
                                let total = context.chart.data.datasets[0].data.reduce((a, b) => a + b,
                                    0); // Total nilai data
                                let percentage = ((value / total) * 100).toFixed(0); // Hitung persentase
                                return percentage + '%'; // Menampilkan persentase di dalam chart
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Menambahkan plugin dataLabels
            });
        </script>
    @endsection
