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
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <h5 class="card-title">Selamat datang, {{ Auth::user()->name }}</h5>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-logout">{{ __('Logout') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <link href="{{ asset('css/calendar/custom.css') }}" rel="stylesheet">
                <div class="calendar-card">
                    <div class="calendar-card-details">
                        <p class="calendar-text-title">Arahkan mouse anda kesini untuk melihat daftar seminar yang anda ikuti</p>
                        <p class="calendar-text-calendar" id="liveDateTime"></p>
                    </div>
                    <button id="checkRegistration" class="calendar-card-button" data-toggle="modal" data-target="#registrationModal">Lihat Daftar</button>
                </div>
            </div>
        </div>
        @php
            $registrations = \App\Models\Registration::where('user_id', auth()->id())->with('seminar')->get();
        @endphp

        <!-- Modal -->
        <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registrationModalLabel">Daftar Seminar Yang Telah Diikuti</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Tempat untuk menampilkan daftar seminar yang telah diikuti -->
                        @if($registrations->isEmpty())
                            <p>Belum ada seminar yang kamu ikuti.</p>
                        @else
                            <ul class="list-group">
                                @foreach($registrations as $registration)
                                    <li class="list-group-item">
                                        {{ $registration->seminar->topik }}
                                        <span class="badge badge-primary">{{ \Carbon\Carbon::parse($registration->seminar->tanggal_seminar)->format('d M Y') }}</span>

                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="my-4 text-center">Seminar Terdekat</h1>
        <div class="d-flex flex-wrap justify-content-center">
            @foreach ($seminars as $seminar)
                <div class="seminar-card m-2">
                    <a>
                        <div class="main-content d-flex flex-column">
                            <img src="{{ asset('storage/seminar_images/' . $seminar->gambar_seminar) }}" alt="Gambar Seminar" class="card-img-top" style="height: 200px; object-fit: cover;">
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
                            <span><a href="{{ asset('storage/materi/' . $seminar->materi) }}" target="_blank">Download Materi</a></span>
                            <a href="{{ route('seminar.certificate-detail', $seminar->id) }}" class="btn btn-primary">Lihat Sertifikat</a>
                            <a href="{{ route('seminar.detail', $seminar->id) }}" class="btn btn-secondary btn-sm">Lihat Detail</a>
                        </div>
                    </a>
                </div>
                @if ($loop->iteration % 3 == 0)
                    <div class="w-100"></div>
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

            console.log("Logout URL: '{{ route('logout') }}'");

            document.addEventListener('DOMContentLoaded', function() {
                const seminarForm = document.querySelector('form[action="' + "{{ route('seminar.store') }}" + '"]');
                seminarForm.addEventListener('submit', function(event) {

                    if (!googleMapPattern.test(googleMapLink)) {
                        alert('Masukkan link Google Map yang valid.');
                        event.preventDefault(); // Menghentikan pengiriman formulir
                    }
                });
            });
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

            document.getElementById('checkRegistration').addEventListener('click', function() {
                // Misalkan Anda memiliki endpoint API untuk memeriksa pendaftaran
                fetch('/api/check-registration')
                    .then(response => response.json())
                    .then(data => {
                        if (data.registered) {
                            alert('Anda sudah terdaftar di seminar.');
                        } else {
                            alert('Anda belum terdaftar di seminar.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        </script>
    </body>
</html>
@endsection


