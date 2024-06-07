@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
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

        .seminar-card {
            box-sizing: border-box;
            width: 340px;
            height: 354px;
            background: rgba(217, 217, 217, 0.58);
            border: 1px solid white;
            box-shadow: 12px 17px 51px rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(6px);
            border-radius: 17px;
            text-align: center;
            cursor: pointer;
            transition: all 0.5s;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            font-weight: bolder;
            color: black;
        }

        .seminar-card:hover {
            border: 1px solid black;
            transform: scale(1.05);
        }

        .seminar-card:active {
            transform: scale(0.95) rotateZ(1.7deg);
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

            @if(Auth::user()->role == 'PIC SeminarorWebinar')
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-body">
                        <form method="POST" action="{{ route('seminar.store') }}" enctype="multipart/form-data">
                            @csrf
                            <h3>Formulir Pendaftaran Seminar</h3>
                            <input type="date" name="tanggal_seminar" placeholder="Masukkan tanggal seminar" class="form-control form-control-custom">
                            <input type="text" name="lokasi_seminar" placeholder="Masukkan lokasi seminar" class="form-control form-control-custom">
                            <input type="url" name="google_map_link" placeholder="Masukkan link Google Map lokasi seminar" class="form-control form-control-custom">
                            <input type="file" name="gambar_seminar" class="form-control form-control-custom">
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
                            <label for="materi">Materi:</label>
                            <input type="file" id="materi" name="materi" class="form-control form-control-custom">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <h1 class="my-4 text-center">Seminar Terdekat</h1>
        @if (Auth::user()->role == 'PIC SeminarorWebinar')
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
                            <a href="{{ route('seminar.edit', $seminar->id) }}" class="btn btn-info">Edit</a>
                            <button type="button" class="btn btn-danger" onclick="confirmDeletion({{ $seminar->id }})">Delete</button>
                            <a href="{{ route('seminar.show', $seminar->id) }}" class="btn btn-primary">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="d-flex flex-wrap justify-content-center">
            @foreach ($seminars as $seminar)
            <div class="seminar-card m-2">
                <a >
                    <div class="main-content">
                        <h5>{{ $seminar->topik }}</h5>
                        <p>{{ $seminar->tanggal_seminar }}</p>
                        <p>{{ $seminar->lokasi_seminar }}</p>
                        <p>Pembicara: {{ $seminar->pembicara }}</p>
                        <p>Instansi: {{ $seminar->asal_instansi }}</p>
                        <a href="{{ $seminar->google_map_link }}" target="_blank" class="btn btn-link">Lokasi di Google Maps</a>
                        @if ($seminar->is_paid)
                        <span class="badge badge-success">Berbayar</span>
                        @else
                        <span class="badge badge-info">Gratis</span>
                        @endif
                        <span>Materi: <a href="{{ asset('storage/materi/' . $seminar->materi) }}" target="_blank">Download Materi</a></span>
                    </div>
                </a>
                @if (Auth::user()->role == 'PIC SeminarorWebinar')
                <a href="{{ route('seminar.edit', $seminar->id) }}" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" onclick="confirmDeletion({{ $seminar->id }})">Delete</button>
                @endif
            </div>
            @if ($loop->iteration % 3 == 0)
            <div class="w-100"></div> <!-- Break setelah setiap 3 kartu -->
            @endif
            @endforeach
        </div>
        @endif

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // Script untuk menampilkan waktu secara real-time
            function updateTime() {
                var now = new Date();
                var options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                var formattedTime = now.toLocaleDateString('id-ID', options);
                document.getElementById('liveDateTime').innerText = formattedTime;
            }
            setInterval(updateTime, 1000);
            updateTime();
        </script>
        <script>
            console.log("Logout URL: '{{ route('logout') }}'");
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const seminarForm = document.querySelector('form[action="{{ route('seminar.store') }}"]');
                seminarForm.addEventListener('submit', function(event) {

                    if (!googleMapPattern.test(googleMapLink)) {
                        alert('Masukkan link Google Map yang valid.');
                        event.preventDefault(); // Menghentikan pengiriman formulir
                    }
                });
            });
        </script>
        <script>
            var baseUrl = "{{ route('seminar.destroy', ['seminar' => 'tempId']) }}".replace('tempId', '');
            function confirmDeletion(seminarId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus saja!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Membuat form penghapusan dan mengirimkannya
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = baseUrl + seminarId; // Menggunakan baseUrl dan menambahkan seminarId
                        form.style.display = 'none';

                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                })
            }
        </script>
</body>
</html>
@endsection