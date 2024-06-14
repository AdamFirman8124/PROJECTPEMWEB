<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMINAR</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fixed-top-spacing {
            margin-top: 60px;
        }
        /* Membuat navbar transparan */
        .navbar-transparent {
            background-color: transparent !important; /* Mengatur background menjadi transparan */
            border: none; /* Menghilangkan border */
        }
        /* Menjaga warna teks navbar tetap hitam */
        .navbar-light .navbar-nav .nav-link {
            color: black; /* Warna teks hitam */
        }
        /* Menengahkan isi navbar */
        .navbar-nav {
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <!-- Fixed Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-transparent">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-link nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-link nav-link" href="{{ route('seminar.create') }}">Tambah Seminar</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-link nav-link" href="{{ route('seminar.rekap') }}">Rekap Seminar</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-link nav-link" href="{{ route('registrations.index') }}">Rekap Peserta</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-link nav-link" href="{{ route('seminar.rekap-peserta') }}">Data User</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-link nav-link" href="{{ route('seminar.certificate') }}">Upload Sertifikat</a>
                </li>
            </ul>
            <!-- Menampilkan nama user yang login di bagian kanan navbar -->
            <span class="navbar-text d-flex align-items-center">
                @if (Auth::check())
                    <span class="mr-3">{{ Auth::user()->name }}</span>
                @endif
            </span>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
