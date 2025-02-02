@extends('user.layouts.app')

@section('title', 'The Events')

@section('content')

    <!--==========================
        Intro Section
      ============================-->
    <section id="intro">
        <div class="intro-container wow fadeIn">
            <h1 class="mb-4 pb-0">PT.Bidik<br><span>Inovasi</span>Global</h1>
            <p class="mb-4 pb-0">10-12 December, Jl. Trosobo No.82 Tropodo Wetan, Kec. Waru , Kabupaten Sidoarjo, Jawa Timur, Indonesia</p>
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
                        <p>Acara ini diselenggarakan untuk memberikan pengalaman yang berkesan bagi para peserta. Dengan
                            berbagai kegiatan menarik, peserta akan mendapatkan wawasan baru, kesempatan untuk
                            berjejaring, serta pengalaman yang tidak terlupakan. Jangan lewatkan kesempatan ini untuk
                            bergabung dan menjadi bagian dari acara yang inspiratif dan penuh manfaat!</p>
                    </div>
                    <div class="col-lg-3">
                        <h3>Where</h3>
                        <p>Jl. Trosobo No.82 Tropodo Wetan, Kec. Waru , Kabupaten Sidoarjo, Jawa Timur, Indonesia</p>
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
                                    <h3><a href="{{ route('user.events_details', $event->id) }}">{{ $event->name }}</a></h3>
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

                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $events->links('pagination::bootstrap-4') }}
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

                @php
                    // Mengelompokkan event berdasarkan bulan dan tahun (format: 'F Y' untuk bulan dan tahun)
                    $groupedEvents = $events->groupBy(function ($event) {
                        return \Carbon\Carbon::parse($event->start_date)->format('F Y');
                    });
                @endphp

                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($groupedEvents as $monthYear => $monthEvents)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="#{{ Str::slug($monthYear) }}"
                                role="tab" data-toggle="tab">
                                {{ $monthYear }} <!-- Menampilkan bulan dan tahun -->
                            </a>
                        </li>
                    @endforeach
                </ul>

                <h3 class="sub-heading">Menampilkan Events yang Tersedia</h3>

                <div class="tab-content-container">
                    <div class="tab-content row justify-content-center">
                        @foreach ($groupedEvents as $monthYear => $monthEvents)
                            <div role="tabpanel" class="col-lg-9 tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="{{ Str::slug($monthYear) }}">
                                @foreach ($monthEvents as $event)
                                    <div class="row schedule-item mb-4">
                                        <div class="col-md-2 d-flex flex-column align-items-center">
                                            <time class="mb-2">
                                                {{ \Carbon\Carbon::parse($event->start_date)->setTimezone('Asia/Jakarta')->format('d-M-Y H:i A') }}
                                            </time>
                                            <time>
                                                {{ \Carbon\Carbon::parse($event->end_date)->setTimezone('Asia/Jakarta')->format('d-M-Y H:i A') }}
                                            </time>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="d-flex align-items-start">
                                                <img src="{{ asset('storage/' . $event->image_path) }}"
                                                    alt="{{ $event->name }}" class="img-fluid mr-3"
                                                    style="max-width: 200px; height: auto;">
                                                <div>
                                                    <h4>{{ $event->title }} <span
                                                            class="text-muted">{{ $event->speaker_name }}</span></h4>
                                                    <p>{{ $event->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
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
                <a href="img/gallery/1.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/1.jpg"
                        alt=""></a>
                <a href="img/gallery/2.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/2.jpg"
                        alt=""></a>
                <a href="img/gallery/3.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/3.jpg"
                        alt=""></a>
                <a href="img/gallery/4.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/4.jpg"
                        alt=""></a>
                <a href="img/gallery/5.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/5.jpg"
                        alt=""></a>
                <a href="img/gallery/6.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/6.jpg"
                        alt=""></a>
                <a href="img/gallery/7.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/7.jpg"
                        alt=""></a>
                <a href="img/gallery/8.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/8.jpg"
                        alt=""></a>
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

@endsection
