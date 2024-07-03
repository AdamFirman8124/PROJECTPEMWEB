<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width,
    initial-scale=1, shrink-to-fit=no"> <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet"> <title>Seminarku - Daftar Seminar mudah</title> <!-- Bootstrap core CSS --> <link
    href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- Additional CSS Files --> <link
    rel="stylesheet" href="/assets/css/fontawesome.css">
<link rel="stylesheet" href="/assets/css/templatemo-scholar.css"> <link rel="stylesheet" href="/assets/css/owl.css">
    <link rel="stylesheet" href="/assets/css/animate.css"> <link rel="stylesheet"
    href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!--

TemplateMo 586 Scholar

https://templatemo.com/tm-586-scholar

-->
</head>

<body>

<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">Download Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Pilih materi yang ingin diunduh:</p>
                <ul>
                    <!-- Iterate through $seminar->materi and generate download links -->
                    @foreach($seminar->materi as $materi)
                        <li>
                            <a href="{{ asset($materi->file_path) }}" target="_blank">{{ $materi->judul_materi }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

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
                            <li class=""><a href="{{ route('homeuser')}}">Beranda</a></li>
                            <li class=""><a href="{{ route('homeuser')}}">Fitur</a></li>
                            <li class=""><a href="{{ route('homeuser')}}"  class="active">Seminar</a></li>
                            <!-- <li class="scroll-to-section"><a href="#team">Team</a></li> -->
                            <!-- <li class="scroll-to-section"><a href="#about-us">FAQ</a></li> -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-logout">{{ __('Logout') }}</button>
                            </form>
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

        <!-- Modal untuk menampilkan info pembayaran -->
        <div class="modal fade" id="paymentInfoModal" tabindex="-1" role="dialog" aria-labelledby="paymentInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentInfoModalLabel">Informasi Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($seminar->is_paid)
                        <!-- Tampilkan informasi rekening atau pembayaran lainnya untuk seminar berbayar -->
                        <p>Silakan transfer ke salah satu rekening berikut:</p>
                        <ul>
                            <li>
                                <strong>BCA</strong> 1984567000123 a.n. Danang Aprianto
                            </li>
                            <li>
                                <strong>BRI</strong> 33880104498509 a.n. Jamilatul Muyasaroh
                            </li>
                            <li>
                                <strong>MANDIRI</strong> 0700006801670 a.n. Fadhila Nur Aisyah
                            </li>
                        </ul>
                    @else
                        <p>Seminar ini gratis. Tidak ada informasi pembayaran yang diperlukan.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="section events" id="events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Detail Seminar</h6>
                        <h2>{{ $seminar->nama_seminar }}</h2>
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
                                    <li>
                                        <span>Harga:</span>
                                        <h6>{{ $seminar->harga_seminar ? 'Rp ' . number_format($seminar->harga_seminar, 0, ',', '.') : '-' }}</h6>
                                    </li>
                                </ul>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                                <!-- Tombol untuk membuka modal info pembayaran -->
                                @if ($seminar->is_paid)
                                    <button type="button" class="btn btn-info mt-3" data-toggle="modal" data-target="#paymentInfoModal">Info Pembayaran</button>
                                @endif
                                
                            </div>
               
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Status Registrasi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Mengambil hanya data registrasi user yang sedang login -->
                                @foreach($registrations as $registration)
                                    @if($registration->user_id === auth()->user()->id)
                                        <tr>
                                            <td>{{ $registration->name }}</td>
                                            <td>{{ $registration->email }}</td>
                                            <td>{{ $registration->status }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <p class="card-text" id="materi_seminar">
                @if($seminar->materi)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#downloadModal">Download Materi</button>
                @else
                    Tidak ada materi yang tersedia
                @endif

                @if($certificate)
                    <a href="{{ route('downloadCertificate', $seminar->id) }}" class="btn btn-success">Unduh Sertifikat</a>
                @else
                    <div class="text-center">
                        <p class="text-danger">Sertifikat belum tersedia, pastikan anda sudah mengisi kuis untuk mendapatkan sertifikat</p>
                    </div>
                @endif
            </p>

            <div class="d-flex justify-content-end">
                <a href="{{ route('homeuser', $seminar->id) }}" class="btn btn-primary mt-3">Kembali</a>
            </div>
        </div>
    </div>
</div>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var showMateriBtn = document.getElementById('showMateriBtn');
        var materiList = document.getElementById('materiList');

        showMateriBtn.addEventListener('click', function() {
            if (materiList.style.display === 'none') {
                materiList.style.display = 'block';
            } else {
                materiList.style.display = 'none';
            }
        });
    });
</script>

</body>

</html>