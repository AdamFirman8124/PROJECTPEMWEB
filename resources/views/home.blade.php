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
                            <input type="text" name="tanggal_seminar" placeholder="Tanggal Seminar" class="form-control form-control-custom">
                            <input type="text" name="lokasi_seminar" placeholder="Lokasi Seminar" class="form-control form-control-custom">
                            <input type="text" name="google_map_link" placeholder="Link Google Map" class="form-control form-control-custom">
                            <input type="text" name="gambar_seminar" placeholder="URL Gambar Seminar" class="form-control form-control-custom">
                            <div class="form-check">
                                <input type="checkbox" name="is_paid" value="1" class="form-check-input" id="isPaidCheck">
                                <label class="form-check-label" for="isPaidCheck">Seminar Berbayar</label>
                            </div>
                            <input type="date" name="start_registration" placeholder="Tanggal Mulai Pendaftaran" class="form-control form-control-custom">
                            <input type="date" name="end_registration" placeholder="Tanggal Akhir Pendaftaran" class="form-control form-control-custom">
                            <input type="text" name="pembicara" placeholder="Nama Pembicara" class="form-control form-control-custom">
                            <input type="text" name="asal_instansi" placeholder="Asal Instansi Pembicara" class="form-control form-control-custom">
                            <input type="text" name="topik" placeholder="Topik Pembicara" class="form-control form-control-custom">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="my-4">Seminar Terdekat</h1>
        <div class="card card-custom">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tanggal Seminar</th>
                            <th>Lokasi Seminar</th>
                            <th>Link Google Map</th>
                            <th>Gambar Seminar</th>
                            <th>Seminar Berbayar</th>
                            <th>Tanggal Mulai Pendaftaran</th>
                            <th>Tanggal Akhir Pendaftaran</th>
                            <th>Pembicara</th>
                            <th>Asal Instansi</th>
                            <th>Topik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seminars as $seminar)
                        <tr>
                            <td>{{ $seminar->tanggal_seminar }}</td>
                            <td>{{ $seminar->lokasi_seminar }}</td>
                            <td>
                                @if ($seminar->google_map_link)
                                <a href="{{ $seminar->google_map_link }}" target="_blank">Lihat Lokasi</a>
                                @else
                                Tidak Tersedia
                                @endif
                            </td>
                            <td>
                                @if ($seminar->gambar_seminar)
                                <img src="{{ $seminar->gambar_seminar }}" alt="Gambar Seminar">
                                @else
                                Tidak Ada Gambar
                                @endif
                            </td>
                            <td>{{ $seminar->is_paid ? 'Ya' : 'Tidak' }}</td>
                            <td>{{ $seminar->start_registration }}</td>
                            <td>{{ $seminar->end_registration }}</td>
                            <td>{{ $seminar->pembicara }}</td>
                            <td>{{ $seminar->asal_instansi }}</td>
                            <td>{{ $seminar->topik }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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