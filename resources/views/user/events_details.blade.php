<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheEvent - Detail Event</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon">
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">



    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800"
        rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="{{ asset('lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Main Stylesheet File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/notifications.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>

<body>

    <!--==========================
    Header
  ============================-->
    <header id="header" class="header-fixed">
        <div class="container">

            <div id="logo" class="pull-left">
                <!-- Uncomment below if you prefer to use a text logo -->
                <!-- <h1><a href="#main">C<span>o</span>nf</a></h1> -->
                <a href="index.html#intro" class="scrollto"><img src="{{ asset('img/logo.png') }}" alt=""
                        title=""></a>
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}#about">About</a></li>
                    <li><a href="{{ route('home') }}#schedule">Schedule</a></li>
                    <li><a href="{{ route('home') }}#supporters">Supporters</a></li>
                    <li><a href="{{ route('home') }}#contact">Contact</a></li>
                    <!-- Tampilkan opsi berdasarkan status login -->

                    @auth('member')
                        <!-- Jika user login -->
                        <li class="dropdown">
                            <a href="#" class="d-flex align-items-center justify-content-between" id="userMenu" data-toggle="dropdown" aria-expanded="false">
                                <!-- Tampilkan Nama -->
                                <span class="me-2">{{ Auth::guard('member')->user()->name }}</span>
                                <!-- Tampilkan Foto Profil -->
                                <img src="{{ asset('storage/' . (Auth::guard('member')->user()->photo ?? 'user.jpg')) }}"
                                    alt="User Photo" class="rounded-circle user-photo mx-2">
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userMenu">
                                <li>
                                    <a href="{{ route('user.myevent') }}" class="dropdown-item">Event Saya</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.editprofile') }}" class="dropdown-item">Edit Profil</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.editpassword') }}" class="dropdown-item">Ubah Password</a>
                                </li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout.user') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Jika user belum login -->
                        <li><a href="{{ route('user.auth.register_user') }}">Register</a></li>
                        <li><a href="{{ route('user.auth.login_user') }}">Login</a></li>
                    @endauth
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->

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

            <a href="{{ route('home') }}" class="btn btn-primary mb-2"><img width="20" height="20" src="https://img.icons8.com/ios-filled/50/FFFFFF/long-arrow-left.png" alt="long-arrow-left"/> back to home</a>
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
                            <a href="#" class="btn btn-primary mr-2" onclick="window.history.back(); return false;">Kembali</a>

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


    <!--==========================
    Footer
  ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-info">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" title="TheEvent">
                        <p>In alias aperiam. Placeat tempore facere. Officiis voluptate ipsam vel eveniet est dolor et
                            totam porro. Perspiciatis ad omnis fugit molestiae recusandae possimus. Aut consectetur id
                            quis. In inventore consequatur ad voluptate cupiditate debitis accusamus repellat cumque.
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Home</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">About us</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Services</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Home</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">About us</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Services</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Contact Us</h4>
                        <p>
                            A108 Adam Street <br>
                            New York, NY 535022<br>
                            United States <br>
                            <strong>Phone:</strong> +1 5589 55488 55<br>
                            <strong>Email:</strong> info@example.com<br>
                        </p>

                        <div class="social-links">
                            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>TheEvent</strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=TheEvent
        -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer><!-- #footer -->

    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/jquery/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/superfish/hoverIntent.js') }}"></script>
    <script src="{{ asset('lib/superfish/superfish.min.js') }}"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>


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

</body>

</html>
