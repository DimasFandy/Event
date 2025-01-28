    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Potta+One&family=Rampart+One&display=swap"
            rel="stylesheet">
        <!-- Link to external CSS file -->
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <title>Login</title>
    </head>
    <!-- Tambahkan Notifikasi Error Global -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <body class="bx">

        <div class="container d-flex align-items-center" style="height: 80vh;">
            <div class="row w-100">
                <!-- Kolom Kiri -->
                <div class="col-md-6 d-flex flex-column justify-content-center">
                    <h2 class="text-center mb-3 text-white">PT. Bidik Inovasi Global</h2>
                    <p class="text-center text-white">Selamat datang di sistem login kami! Silakan masukkan email dan
                        password untuk
                        melanjutkan.</p>
                </div>

                <!-- Kolom Kanan (Form) -->
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="card shadow-lg p-4" style="width: 400px;">
                        <h3 class="text-center mb-4">Login</h3>
                        <form id="loginForm" method="POST" action="{{ url('/login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                                    placeholder="Masukkan Email">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                                    placeholder="Masukkan Password">
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Menampilkan alert error jika session 'error' ada
            @if (session('error'))
                Swal.fire({
                    title: 'Login Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'Coba Lagi'
                });
            @endif


        </script>
    </body>

    </html>
