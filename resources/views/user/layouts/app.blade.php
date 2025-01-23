<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TheEvent - Bootstrap Event Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon">
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="{{ asset('lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

</head>

<body>
    <!--==========================
    Header
    ============================-->
    <header id="header" class="header-fixed">
        <div class="container">
            <div id="logo" class="pull-left">
                <a href="{{ route('user.home') }}" class="scrollto">
                    <img src="{{ asset('img/logo.png') }}" alt="" title="">
                </a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#speakers">Events</a></li>
                    <li><a href="#schedule">Schedule</a></li>

                    @guest('member')
                        <li><a href="{{ route('user.auth.login_user') }}">Login</a></li>
                        <li><a href="{{ route('user.auth.register_user') }}">Register</a></li>
                    @else
                        <!-- Jika user login -->
                        <li class="dropdown">
                            <a href="#" class="d-flex align-items-center justify-content-between" id="userMenu" data-toggle="dropdown" aria-expanded="false">
                                <!-- Tampilkan Nama -->
                                <span class="me-2">{{ Auth::guard('member')->user()->name }}</span>
                                <!-- Tampilkan Foto Profil -->
                                <img src="{{ asset('storage/' . Auth::guard('member')->user()->photo) }}"
                                     alt="User Photo"
                                     class="rounded-circle user-photo">
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
                    @endguest
                </ul>
            </nav>
        </div>
    </header>



    <!--==========================
    Content Section
    ============================-->
    @yield('content')

    <!--==========================
    Footer
    ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-info">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                        <p>In alias aperiam. Placeat tempore facere.</p>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Home</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">About us</a></li>
                            <li><i class="fa fa-angle-right"></i> <a href="#">Services</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Contact Us</h4>
                        <p>
                            A108 Adam Street<br>
                            New York, NY<br>
                            <strong>Phone:</strong> +1 5589 55488 55<br>
                            <strong>Email:</strong> info@example.com<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>PT.GPS</strong>. All Rights Reserved
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
