@extends('layouts.app')

@section('content')
    <h1>Daftar Seminar</h1>
    <table>
        <thead>
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
                    <td>{{ $seminar->google_map_link }}</td>
                    <td>{{ $seminar->gambar_seminar }}</td>
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
@endsection

