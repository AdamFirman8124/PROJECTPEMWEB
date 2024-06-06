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

        .table-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                @if(Auth::user()->role == 'PIC SeminarorWebinar')
                <div class="card card-custom">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('seminar.rekap') }}';">Rekap Seminar</button>
                    </div>
                </div>
                @endif
            </div>

            @if(Auth::user()->role == 'PIC SeminarorWebinar')
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-body">
                        <form method="POST" action="{{ route('seminar.store') }}">
                            @csrf
                            <h3>Formulir Pendaftaran Seminar</h3>
                            <input type="date" name="tanggal_seminar" placeholder="Masukkan tanggal seminar" class="form-control form-control-custom">
                            <input type="text" name="lokasi_seminar" placeholder="Masukkan lokasi seminar" class="form-control form-control-custom">
                            <input type="text" name="google_map_link" placeholder="Masukkan link Google Map lokasi seminar" class="form-control form-control-custom">
                            <input type="text" name="gambar_seminar" placeholder="Masukkan URL gambar seminar" class="form-control form-control-custom">
                            <label for="start_registration">Tanggal Mulai Pendaftaran:</label>
                            <input type="date" id="start_registration" name="start_registration" class="form-control form-control-custom">
                            <label for="end_registration">Tanggal Akhir Pendaftaran:</label>
                            <input type="date" id="end_registration" name="end_registration" class="form-control form-control-custom">
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
            @endif
        </div>

        <h1 class="my-4 text-center">Seminar Terdekat</h1>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Topik</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Pembicara</th>
                        <th>Instansi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seminars as $seminar)
                    <tr>
                        <td>{{ $seminar->topik }}</td>
                        <td>{{ $seminar->tanggal_seminar }}</td>
                        <td>{{ $seminar->lokasi_seminar }}</td>
                        <td>{{ $seminar->pembicara }}</td>
                        <td>{{ $seminar->asal_instansi }}</td>
                        <td>
                            @if ($seminar->is_paid)
                            <span class="badge badge-success">Berbayar</span>
                            @else
                            <span class="badge badge-info">Gratis</span>
                            @endif
                        </td>
                        <td>
                            @if (Auth::user()->role == 'PIC SeminarorWebinar')
                            <a href="{{ route('seminar.edit', $seminar->id) }}" class="btn btn-info">Edit</a>
                            <form action="{{ route('seminar.destroy', $seminar->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
