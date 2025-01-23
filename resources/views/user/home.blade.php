<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Web Event</title>
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
    <!-- =======================================================
    Theme Name: TheEvent
    Theme URL: https://bootstrapmade.com/theevent-conference-event-bootstrap-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

    <!--==========================
    Header
  ============================-->
    <header id="header">
        <div class="container">
            <div id="logo" class="pull-left">
                <a href="#intro" class="scrollto"><img src="img/logo.png" alt="" title=""></a>
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="#intro">Home</a></li>
                    <li><a href="#about">Events</a></li>

                    <!-- Tampilkan opsi berdasarkan status login -->
                    @auth('member')
                        <!-- Jika user login -->
                        <li class="dropdown">
                            <a href="#" class="d-flex align-items-center justify-content-between" id="userMenu"
                                data-toggle="dropdown" aria-expanded="false">
                                <!-- Tampilkan Nama -->
                                <span class="me-2">{{ Auth::guard('member')->user()->name }}</span>
                                <!-- Tampilkan Foto Profil -->
                                <img src="{{ asset('storage/' . (Auth::guard('member')->user()->photo ?? 'user.jpg')) }}"
                                    alt="User Photo" class="rounded-circle user-photo">

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
    Intro Section
  ============================-->
    <section id="intro">
        <div class="intro-container wow fadeIn">
            <h1 class="mb-4 pb-0">PT.Bidik<br><span>Inovasi</span>Global</h1>
            <p class="mb-4 pb-0">10-12 December, Downtown Conference Center, New York</p>
            <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4" data-vbtype="video"
                data-autoplay="true"></a>
            <a href="#about" class="about-btn scrollto">About The Event</a>
        </div>
    </section>

    <main id="main">

        <!--==========================
      About Section
    ============================-->
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>About The Event</h2>
                        <p>Sed nam ut dolor qui repellendus iusto odit. Possimus inventore eveniet accusamus error amet
                            eius aut
                            accusantium et. Non odit consequatur repudiandae sequi ea odio molestiae. Enim possimus sunt
                            inventore in
                            est ut optio sequi unde.</p>
                    </div>
                    <div class="col-lg-3">
                        <h3>Where</h3>
                        <p>Downtown Conference Center, New York</p>
                    </div>
                    <div class="col-lg-3">
                        <h3>When</h3>
                        <p>Monday to Wednesday<br>10-12 December</p>
                    </div>
                </div>
            </div>
        </section>

        <!--==========================
      Events Section
    ============================-->
        <section id="speakers" class="wow fadeInUp">
            <div class="container">
                <div class="section-header">
                    <h2>Semua Events</h2>
                    <p>Silakan Pilih Event</p>
                </div>

                <div class="row">
                    @foreach ($events as $event)
                        <div class="col-lg-4 col-md-6">
                            <div class="speaker">
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}"
                                    class="img-fluid">
                                <div class="details">
                                    <h3><a
                                            href="{{ route('user.events_details', $event->id) }}">{{ $event->name }}</a>
                                    </h3>
                                    <p>{{ $event->category }}</p>
                                    <div class="social">
                                        <a href=""><i class="fa fa-twitter"></i></a>
                                        <a href=""><i class="fa fa-facebook"></i></a>
                                        <a href=""><i class="fa fa-google-plus"></i></a>
                                        <a href=""><i class="fa fa-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>



        <!--==========================
      Schedule Section
    ============================-->
        <section id="schedule" class="section-with-bg">
            <div class="container wow fadeInUp">
                <div class="section-header">
                    <h2>Event Schedule</h2>
                    <p>Here is our event schedule</p>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#day-1" role="tab" data-toggle="tab">Day 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#day-2" role="tab" data-toggle="tab">Day 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#day-3" role="tab" data-toggle="tab">Day 3</a>
                    </li>
                </ul>

                <h3 class="sub-heading">Voluptatem nulla veniam soluta et corrupti consequatur neque eveniet officia.
                    Eius
                    necessitatibus voluptatem quis labore perspiciatis quia.</h3>

                <div class="tab-content row justify-content-center">

                    <!-- Schdule Day 1 -->
                    <div role="tabpanel" class="col-lg-9 tab-pane fade show active" id="day-1">

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>09:30 AM</time></div>
                            <div class="col-md-10">
                                <h4>Registration</h4>
                                <p>Fugit voluptas iusto maiores temporibus autem numquam magnam.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>10:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/1.jpg" alt="Brenden Legros">
                                </div>
                                <h4>Keynote <span>Brenden Legros</span></h4>
                                <p>Facere provident incidunt quos voluptas.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>11:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/2.jpg" alt="Hubert Hirthe">
                                </div>
                                <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                                <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>12:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/3.jpg" alt="Cole Emmerich">
                                </div>
                                <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                                <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>02:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/4.jpg" alt="Jack Christiansen">
                                </div>
                                <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                                <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>03:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/5.jpg" alt="Alejandrin Littel">
                                </div>
                                <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                                <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>04:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/6.jpg" alt="Willow Trantow">
                                </div>
                                <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                                <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
                            </div>
                        </div>

                    </div>
                    <!-- End Schdule Day 1 -->

                    <!-- Schdule Day 2 -->
                    <div role="tabpanel" class="col-lg-9  tab-pane fade" id="day-2">

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>10:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/1.jpg" alt="Brenden Legros">
                                </div>
                                <h4>Libero corrupti explicabo itaque. <span>Brenden Legros</span></h4>
                                <p>Facere provident incidunt quos voluptas.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>11:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/2.jpg" alt="Hubert Hirthe">
                                </div>
                                <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                                <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>12:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/3.jpg" alt="Cole Emmerich">
                                </div>
                                <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                                <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>02:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/4.jpg" alt="Jack Christiansen">
                                </div>
                                <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                                <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>03:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/5.jpg" alt="Alejandrin Littel">
                                </div>
                                <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                                <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>04:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/6.jpg" alt="Willow Trantow">
                                </div>
                                <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                                <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
                            </div>
                        </div>

                    </div>
                    <!-- End Schdule Day 2 -->

                    <!-- Schdule Day 3 -->
                    <div role="tabpanel" class="col-lg-9  tab-pane fade" id="day-3">

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>10:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/2.jpg" alt="Hubert Hirthe">
                                </div>
                                <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                                <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>11:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/3.jpg" alt="Cole Emmerich">
                                </div>
                                <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                                <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>12:00 AM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/1.jpg" alt="Brenden Legros">
                                </div>
                                <h4>Libero corrupti explicabo itaque. <span>Brenden Legros</span></h4>
                                <p>Facere provident incidunt quos voluptas.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>02:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/4.jpg" alt="Jack Christiansen">
                                </div>
                                <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                                <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>03:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/5.jpg" alt="Alejandrin Littel">
                                </div>
                                <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                                <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
                            </div>
                        </div>

                        <div class="row schedule-item">
                            <div class="col-md-2"><time>04:00 PM</time></div>
                            <div class="col-md-10">
                                <div class="speaker">
                                    <img src="img/speakers/6.jpg" alt="Willow Trantow">
                                </div>
                                <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                                <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
                            </div>
                        </div>

                    </div>
                    <!-- End Schdule Day 2 -->

                </div>

            </div>

        </section>

        <!--==========================
      Venue Section
    ============================-->
        <section id="venue" class="wow fadeInUp">

            <div class="container-fluid">

                <div class="section-header">
                    <h2>Event Venue</h2>
                    <p>Event venue location info and gallery</p>
                </div>

                <div class="row no-gutters">
                    <div class="col-lg-6 venue-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                            frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>

                    <div class="col-lg-6 venue-info">
                        <div class="row justify-content-center">
                            <div class="col-11 col-lg-8">
                                <h3>Downtown Conference Center, New York</h3>
                                <p>Iste nobis eum sapiente sunt enim dolores labore accusantium autem. Cumque beatae
                                    ipsam. Est quae sit qui voluptatem corporis velit. Qui maxime accusamus possimus.
                                    Consequatur sequi et ea suscipit enim nesciunt quia velit.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container-fluid venue-gallery-container">
                <div class="row no-gutters">

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/1.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/1.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/2.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/2.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/3.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/3.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/4.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/4.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/5.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/5.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/6.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/6.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/7.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/7.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="img/venue-gallery/8.jpg" class="venobox" data-gall="venue-gallery">
                                <img src="img/venue-gallery/8.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </section>

        <!--==========================
      Hotels Section
    ============================-->


        <!--==========================
      Gallery Section
    ============================-->
        <section id="gallery" class="wow fadeInUp">

            <div class="container">
                <div class="section-header">
                    <h2>Gallery</h2>
                    <p>Check our gallery from the recent events</p>
                </div>
            </div>

            <div class="owl-carousel gallery-carousel">
                <a href="img/gallery/1.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/1.jpg" alt=""></a>
                <a href="img/gallery/2.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/2.jpg" alt=""></a>
                <a href="img/gallery/3.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/3.jpg" alt=""></a>
                <a href="img/gallery/4.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/4.jpg" alt=""></a>
                <a href="img/gallery/5.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/5.jpg" alt=""></a>
                <a href="img/gallery/6.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/6.jpg" alt=""></a>
                <a href="img/gallery/7.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/7.jpg" alt=""></a>
                <a href="img/gallery/8.jpg" class="venobox" data-gall="gallery-carousel"><img
                        src="img/gallery/8.jpg" alt=""></a>
            </div>

        </section>

        <!--==========================
      Sponsors Section
    ============================-->
        <section id="supporters" class="section-with-bg wow fadeInUp">

            <div class="container">
                <div class="section-header">
                    <h2>Sponsors</h2>
                </div>

                <div class="row no-gutters supporters-wrap clearfix">

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/1.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/2.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/3.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/4.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/5.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/6.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/7.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="supporter-logo">
                            <img src="img/supporters/8.png" class="img-fluid" alt="">
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <!--==========================
      F.A.Q Section
    ============================-->
        <section id="faq" class="wow fadeInUp">

            <div class="container">

                <div class="section-header">
                    <h2>F.A.Q </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <ul id="faq-list">

                            <li>
                                <a data-toggle="collapse" class="collapsed" href="#faq1">Non consectetur a erat nam
                                    at lectus urna duis? <i class="fa fa-minus-circle"></i></a>
                                <div id="faq1" class="collapse" data-parent="#faq-list">
                                    <p>
                                        Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus
                                        laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor
                                        rhoncus dolor purus non.
                                    </p>
                                </div>
                            </li>

                            <li>
                                <a data-toggle="collapse" href="#faq2" class="collapsed">Feugiat scelerisque varius
                                    morbi enim nunc faucibus a pellentesque? <i class="fa fa-minus-circle"></i></a>
                                <div id="faq2" class="collapse" data-parent="#faq-list">
                                    <p>
                                        Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                        interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                        scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.
                                        Mauris ultrices eros in cursus turpis massa tincidunt dui.
                                    </p>
                                </div>
                            </li>

                            <li>
                                <a data-toggle="collapse" href="#faq3" class="collapsed">Dolor sit amet consectetur
                                    adipiscing elit pellentesque habitant morbi? <i class="fa fa-minus-circle"></i></a>
                                <div id="faq3" class="collapse" data-parent="#faq-list">
                                    <p>
                                        Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                        Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl
                                        suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis
                                        convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                                    </p>
                                </div>
                            </li>

                            <li>
                                <a data-toggle="collapse" href="#faq4" class="collapsed">Ac odio tempor orci
                                    dapibus. Aliquam eleifend mi in nulla? <i class="fa fa-minus-circle"></i></a>
                                <div id="faq4" class="collapse" data-parent="#faq-list">
                                    <p>
                                        Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                        interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                        scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.
                                        Mauris ultrices eros in cursus turpis massa tincidunt dui.
                                    </p>
                                </div>
                            </li>

                            <li>
                                <a data-toggle="collapse" href="#faq5" class="collapsed">Tempus quam pellentesque
                                    nec nam aliquam sem et tortor consequat? <i class="fa fa-minus-circle"></i></a>
                                <div id="faq5" class="collapse" data-parent="#faq-list">
                                    <p>
                                        Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim
                                        suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan.
                                        Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit
                                        turpis cursus in
                                    </p>
                                </div>
                            </li>

                            <li>
                                <a data-toggle="collapse" href="#faq6" class="collapsed">Tortor vitae purus
                                    faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i
                                        class="fa fa-minus-circle"></i></a>
                                <div id="faq6" class="collapse" data-parent="#faq-list">
                                    <p>
                                        Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies
                                        leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet.
                                        Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu
                                        scelerisque. Pellentesque diam volutpat commodo sed egestas egestas fringilla
                                        phasellus faucibus. Nibh tellus molestie nunc non blandit massa enim nec.
                                    </p>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>

        </section>

        <!--==========================
      Subscribe Section
    ============================-->


        <!--==========================
      Buy Ticket Section
    ============================-->


        <!--==========================
      Contact Section
    ============================-->
        <!-- #contact -->

    </main>


    <!--==========================
    Footer
  ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-info">
                        <img src="img/logo.png" alt="PT.BIG">
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
                &copy; Copyright <strong>PT.Garis Pertama Solution</strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=TheEvent
        -->
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





    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
