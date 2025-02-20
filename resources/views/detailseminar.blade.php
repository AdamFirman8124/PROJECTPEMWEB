<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width,
    initial-scale=1, shrink-to-fit=no"> <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet"> <title>Seminarku - Daftar Seminar mudah</title> <!-- Bootstrap core CSS --> <link
    href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- Additional CSS Files --> <link
    rel="stylesheet" href="/assets/css/fontawesome.css">
<link rel="stylesheet" href="/assets/css/templatemo-scholar.css"> <link rel="stylesheet" href="/assets/css/owl.css">
    <link rel="stylesheet" href="/assets/css/animate.css"> <link rel="stylesheet"
    href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
<!--

TemplateMo 586 Scholar

https://templatemo.com/tm-586-scholar

-->
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <!-- <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div> -->
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area background-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">
                            <h1>Seminarku.id</h1>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Serach Start ***** -->
                        <div class="search-input">
                            <form id="search" action="#">
                                <input type="text" placeholder="Cari disini..." id='searchText' name="searchKeyword"
                                    onkeypress="handle" />
                                <i class="fa fa-search"></i>
                            </form>
                        </div>
                        <!-- ***** Serach Start ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class=""><a href="{{ route('landingpage')}}">Beranda</a></li>
                            <li class=""><a href="{{ route('landingpage')}}">Fitur</a></li>
                            <li class=""><a href="{{ route('landingpage')}}"  class="active">Seminar</a></li>
                            <!-- <li class="scroll-to-section"><a href="#team">Team</a></li> -->
                            <!-- <li class="scroll-to-section"><a href="#about-us">FAQ</a></li> -->
                            <li class="scroll-to-section"><a href="/login">Login</a></li>
    <li class="scroll-to-section"><a href="/register">Daftar Sekarang!</a></li>

                        </ul>
                        <!-- <a class='menu-trigger'>
                        <span>Menu</span>
                    </a> -->
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="section events" id="events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Detail Seminar</h6>
                        <h2>{{ $seminar->topik }}</h2>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="item">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="image">
                                    <img src="{{ asset($seminar->gambar_seminar) }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <ul>
                                    <li>
                                        @if ($seminar->is_paid)
                                        <span class="category">Berbayar</span>
                                        @else
                                        <span class="category">Gratis</span>
                                        @endif
                                        <h4>{{ $seminar->topik }}</h4>
                                    </li>
                                    <li>
                                        <span>Tanggal Pelaksanaan:</span>
                                        <h6>{{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->format('d M Y') }}</h6>
                                    </li>
                                    <li>
                                        <span>Penutupan:</span>
                                        <h6>{{ $seminar->end_registration }}</h6>
                                    </li>
                                    <li>
                                        <span>Lokasi:</span>
                                        <h6>{{ $seminar->lokasi_seminar }}</h6>
                                    </li>
                                </ul>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                   
                            </div>
               
                        </div>
                    </div>
                </div>
                <p class="card-text" id="materi_seminar">
                @if($seminar->materi)
                    <a href="{{ asset($seminar->materi) }}" target="_blank" class="btn btn-primary">Download Materi</a>
                @else
                    Tidak ada materi yang tersedia
                @endif
                
                @if($isRegistered)
                <a href="{{ asset($certificate->file_path) }}" target="_blank" class="btn btn-success">Unduhss Sertifikat</a>
                <!-- tombol download sertifikat -->
                <a href="/admin/certificate/export" class="btn btn-success">Export Sertifikat</a>    
                @else
                    <!-- If not registered, show a disabled link -->
                    <button class="btn btn-success" disabled>Unduh Sertifikat</button>
                @endif
            </p>
                <!-- <div class="map-container">
                                        <iframe width="100%" height="300" frameborder="0" style="border:0"
                                            src="{{ $seminar->google_map_link }}" allowfullscreen></iframe>
                                    </div> -->

            </div>
        </div>
    </div>

    <div class="section fun-facts">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="150" data-speed="1000"></h2>
                                    <p class="count-text ">Pengguna terdaftar</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="804" data-speed="1000"></h2>
                                    <p class="count-text ">Materi</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="50" data-speed="1000"></h2>
                                    <p class="count-text ">Pembicara</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter end">
                                    <h2 class="timer count-title count-number" data-to="15" data-speed="1000"></h2>
                                    <p class="count-text ">Seminar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="container">
            <div class="col-lg-12">
                <p>Copyright © 2036 Scholar Organization. All rights reserved. &nbsp;&nbsp;&nbsp; Design: <a
                        href="https://templatemo.com" rel="nofollow" target="_blank">TemplateMo</a> Distribution: <a
                        href="https://themewagon.com" rel="nofollow" target="_blank">ThemeWagon</a></p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/isotope.min.js"></script>
    <script src="/assets/js/owl-carousel.js"></script>
    <script src="/assets/js/counter.js"></script>
    <script src="/assets/js/customdetail.js"></script>

</body>

</html>