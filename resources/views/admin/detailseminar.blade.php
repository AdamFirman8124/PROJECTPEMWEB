@extends('layouts.appadmin')

@section('content')
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
                                </ul>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                   
                            </div>
               
                        </div>
                    </div>
                </div>
                <p class="card-text" id="materi_seminar">
                @if($seminar->materi)
                    <a href="{{ asset($seminar->materi) }}" target="_blank" class="btn btn-primary">Lihat Materi</a>
                @else
                    Tidak ada materi yang tersedia
                @endif
                <a href="{{ route('detailseminar', $seminar->id) }}" class="btn btn-success">Unduh Sertifikat</a>
            </p>
            </div>
        </div>
    </div>
@endsection