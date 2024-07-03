@extends('layouts.appadmin')

@section('content')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
                                        <h4>{{ $seminar->nama_seminar }}</h4>
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
                   
                            </div>
               
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
                <a href="{{ asset($certificate->file_path) }}" target="_blank" class="btn btn-success">Lihat Sertifikat</a>
    @else
    <div class="text-center">
        <p class="text-danger">Sertifikat belum tersedia.</p>
    </div>
    @endif
            </p>
            </div>
        </div>
    </div>
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
@endsection