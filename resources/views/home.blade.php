<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0; /* Ubah warna background */
            font-family: Arial, sans-serif; /* Ubah jenis font */
        }

        .card-custom {
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .form-control-custom {
            margin-bottom: 10px;
        }

        .seminar-card {
            width: 320px;
            height: auto;
            padding: 20px;
            color: white;
            background: linear-gradient(#212121, #212121) padding-box,
                        linear-gradient(145deg, transparent 35%, #e81cff, #40c9ff) border-box;
            border: 2px solid transparent;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transform-origin: right bottom;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
            margin-bottom: 20px;
        }

        .seminar-card .main-content {
            flex: 1;
        }

        .seminar-card .header span {
            display: block;
            font-weight: 600;
            color: #717171;
            margin-bottom: 8px;
        }

        .seminar-card .heading {
            font-size: 24px;
            margin: 24px 0 16px;
            font-weight: 600;
        }

        .seminar-card .categories {
            display: flex;
            gap: 8px;
        }

        .seminar-card .categories span {
            background-color: #e81cff;
            padding: 4px 8px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            border-radius: 50em;
        }

        .seminar-card .footer {
            font-weight: 600;
            color: #717171;
            margin-top: 16px;
        }

        .seminar-card:hover {
            rotate: 8deg;
        }

        .link-overflow {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- Kartu di sebelah kiri -->
            <div class="col-md-4">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <h5 class="card-title">Selamat datang, {{ Auth::user()->name }}</h5>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-logout">{{ __('Logout') }}</button>
                        </form>
                    </div>
                </div>

                <div class="card card-custom">
                    <div class="card-body">
                        <div id="liveDateTime"></div>
                    </div>
                </div>
            </div>

            <!-- Formulir di sebelah kanan -->
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-body">
                        <form method="POST" action="{{ route('seminar.store') }}">
                            @csrf
                            <h3>Formulir Pendaftaran Seminar</h3>
                            <input type="text" name="tanggal_seminar" placeholder="Masukkan tanggal seminar" class="form-control form-control-custom">
                            <input type="text" name="lokasi_seminar" placeholder="Masukkan lokasi seminar" class="form-control form-control-custom">
                            <input type="text" name="google_map_link" placeholder="Masukkan link Google Map lokasi seminar" class="form-control form-control-custom">
                            <input type="text" name="gambar_seminar" placeholder="Masukkan URL gambar seminar" class="form-control form-control-custom">
                            <label for="start_registration">Tanggal Mulai Pendaftaran:</label>
                            <input type="date" id="start_registration" name="start_registration" placeholder="Masukkan tanggal mulai pendaftaran" class="form-control form-control-custom">
                            <label for="end_registration">Tanggal Akhir Pendaftaran:</label>
                            <input type="date" id="end_registration" name="end_registration" placeholder="Masukkan tanggal akhir pendaftaran" class="form-control form-control-custom">
                            <input type="text" name="pembicara" placeholder="Masukkan nama pembicara" class="form-control form-control-custom">
                            <input type="text" name="asal_instansi" placeholder="Masukkan asal instansi pembicara" class="form-control form-control-custom">
                            <input type="text" name="topik" placeholder="Masukkan topik seminar" class="form-control form-control-custom">
                            <div class="form-check">
                                <input type="checkbox" name="is_paid" value="1" class="form-check-input" id="isPaidCheck">
                                <label class="form-check-label" for="isPaidCheck">Centang jika seminar ini berbayar</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="my-4 text-center">Seminar Terdekat</h1>
        <div class="d-flex flex-wrap justify-content-center">
            @foreach ($seminars as $seminar)
                <div class="seminar-card m-2">
                    <div class="main-content">
                        <div class="header">
                            <span>Tanggal: {{ $seminar->tanggal_seminar }}</span>
                            <span>Lokasi: {{ $seminar->lokasi_seminar }}</span>
                            <span class="link-overflow">Link: <a href="{{ $seminar->google_map_link }}" target="_blank">{{ $seminar->google_map_link }}</a></span>
                            <span>Gambar: <img src="{{ $seminar->gambar_seminar }}" alt="Gambar Seminar" style="max-width: 100%; height: auto;"></span>
                            <span>Status: {{ $seminar->is_paid ? 'Berbayar' : 'Gratis' }}</span>
                            <span>Mulai Pendaftaran: {{ $seminar->start_registration }}</span>
                            <span>Akhir Pendaftaran: {{ $seminar->end_registration }}</span>
                            <span>Pembicara: {{ $seminar->pembicara }}</span>
                            <span>Asal Instansi: {{ $seminar->asal_instansi }}</span>
                        </div>
                        <div class="heading">{{ $seminar->topik }}</div>
                    </div>
                    <div class="footer">
                        <a href="{{ route('seminar.show', $seminar->id) }}" class="rounded-md bg-slate-300 hover:bg-slate-600 hover:text-slate-200 duration-300 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                    </div>
                </div>
                @if ($loop->iteration % 3 == 0)
                    <div class="w-100"></div> <!-- Break setelah setiap 3 kartu -->
                @endif
            @endforeach
        </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script untuk menampilkan waktu secara real-time
        function updateTime() {
            var now = new Date();
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            var formattedTime = now.toLocaleDateString('id-ID', options);
            document.getElementById('liveDateTime').innerText = formattedTime;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
</html>