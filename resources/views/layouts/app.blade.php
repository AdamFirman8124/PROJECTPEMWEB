<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fixed-top-spacing {
            margin-top: 60px;
        }
    </style>
</head>

<body>

    @if (Auth::user()->role == 'PIC SeminarorWebinar')
        <!-- Fixed Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="btn btn-link nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-link nav-link" href="{{ route('seminars.create') }}">Tambah Seminar</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-link nav-link" href="{{ route('registrations.index') }}">Rekap Peserta</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-link nav-link" href="{{ route('seminars.rekap-peserta') }}">Data User</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-link nav-link" href="{{ route('seminars.certificate') }}">Upload Sertifikat</a>
                    </li>
                </ul>
            </div>
        </nav>
    @endif

    <div>
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>