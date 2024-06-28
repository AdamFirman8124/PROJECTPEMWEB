<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Seminarku - Daftar Seminar mudah</title>

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="/assets/css/owl.css">
    <link rel="stylesheet" href="/assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
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
  <header class="header-area header-sticky background-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{ route('admin_dashboard')}}" class="logo w-10">
                        <h1>Admin</h1>
                    </a>

                    <ul class="nav">
                      <li class="scroll-to-section"><a href="{{ route('admin_dashboard')}}">Beranda</a></li>
                      <li class="scroll-to-section"><a href="{{ route('admin.rekap')}}">Rekap Seminar</a></li>
                      <li class="scroll-to-section"><a href="{{ route('rekap_peserta')}}">Data Peserta</a></li>
                      <li class="scroll-to-section"><a href="{{ route('data_pengguna')}}">Data Pengguna</a></li>
                      <li class="scroll-to-section"><a href="{{ route('admin.certificate')}}">Upload Sertifikat</a></li>
                      <li class="scroll-to-section"><a href="{{ route('admin.tambahPembicara') }}">Tambah Pembicara</a></li>
                      <li class="scroll-to-section"><a href="{{ route('admin.tambahMateri') }}">Tambah Materi</a></li>
                      <!-- <li class="scroll-to-section"><a href="#team">Team</a></li> -->
                      <!-- <li class="scroll-to-section"><a href="#about-us">FAQ</a></li> -->
                      <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-logout" style="background-color: red; color: white;">{{ __('Logout') }}</button>
                        </form>
                  </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
        @yield('content')



  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2036 Scholar Organization. All rights reserved. &nbsp;&nbsp;&nbsp; Design: <a href="https://templatemo.com" rel="nofollow" target="_blank">TemplateMo</a> Distribution: <a href="https://themewagon.com" rel="nofollow" target="_blank">ThemeWagon</a></p>
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
