@extends('layouts.appadmin')

@section('content')
<div style="margin-top: 120px;" class="container">
    <h1 class="mb-4 text-center">Rekapitulasi Seminar</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Topik Seminar</th>
                    <th>Tanggal Seminar</th>
                    <th>Lokasi</th>
                    <th>Pembicara</th>
                    <th>Instansi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seminars as $index => $seminar)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $seminar->topik }}</td>
                    <td>{{ $seminar->tanggal_seminar }}</td>
                    <td>{{ $seminar->lokasi_seminar }}</td>
                    <td>{{ $seminar->pembicara }}</td>
                    <td>{{ $seminar->asal_instansi }}</td>
                    <td>
                        @if($seminar->gambar_seminar)
                        <img src="{{ asset($seminar->gambar_seminar) }}" alt="Gambar Seminar" class="img-thumbnail" style="width: 100px; height: 70px; background-size: contain;">

                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('seminars.destroy', $seminar->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        <a href="{{ route('admin.seminar.edit', $seminar->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
