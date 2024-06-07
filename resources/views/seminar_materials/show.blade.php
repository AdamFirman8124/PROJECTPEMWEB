@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Detail Seminar</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Topik</th>
                    <td>{{ $seminar->topik }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $seminar->tanggal_seminar }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $seminar->lokasi_seminar }}</td>
                </tr>
                <tr>
                    <th>Pembicara</th>
                    <td>{{ $seminar->pembicara }}</td>
                </tr>
                <tr>
                    <th>Asal Instansi</th>
                    <td>{{ $seminar->asal_instansi }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($seminar->is_paid)
                        <span class="badge badge-success">Berbayar</span>
                        @else
                        <span class="badge badge-info">Gratis</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Google Map Link</th>
                    <td><a href="{{ $seminar->google_map_link }}" target="_blank">View Location</a></td>
                </tr>
                <tr>
                    <th>Gambar</th>
                    <td><img src="{{ $seminar->gambar_seminar }}" alt="Seminar Image" class="img-fluid"></td>
                </tr>
                <tr>
                    <th>Materi Seminar</th>
                    <td>
                        @if($seminar->materi)
                            <a href="{{ asset('storage/materi/' . $seminar->materi) }}" target="_blank">Download Materi</a>
                        @else
                            Tidak ada materi yang tersedia
                        @endif
                    </td>
                </tr>
            </table>
            <a href="{{ route('home', $seminar->id) }}" class="btn btn-primary">Kembali ke Daftar Seminar</a>
        </div>
    </div>
</div>
@endsection
