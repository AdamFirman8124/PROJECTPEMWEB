@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Seminar</h1>
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
                <td><a href="{{ $seminar->google_map_link }}" target="_blank">Lihat Lokasi</a></td>
                <td>
                    @if($seminar->gambar_seminar)
                    <img src="{{ asset('storage/' . $seminar->gambar_seminar) }}" alt="Gambar Seminar" style="width: 100px;">
                    @else
                    Tidak ada gambar
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
@endsection