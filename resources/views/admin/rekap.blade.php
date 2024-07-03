@extends('layouts.appadmin')

@section('content')
<section class="vh-100">
    <div style="margin-top: 120px;" class="container">
        <h1 class="mb-4 text-center">Rekapitulasi Seminar</h1>
        
        <a href="{{ route('admin.exportSeminar') }}" class="btn btn-success mb-3">Unduh Data Seminar</a>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Seminar</th>
                        <th>Tanggal Seminar</th>
                        <th>Lokasi</th>
                        <th>Pembicara</th>
                        <th>Instansi</th>
                        <th>Harga Seminar</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seminars as $index => $seminar)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $seminar->nama_seminar }}</td>
                        <td>{{ $seminar->tanggal_seminar }}</td>
                        <td>{{ $seminar->lokasi_seminar }}</td>
                        <td>{{ $seminar->pembicara ? $seminar->pembicara->nama_pembicara : 'Tidak ada pembicara' }}</td>
                        <td>{{ $seminar->pembicara ? $seminar->pembicara->asal_instansi : 'Tidak ada instansi' }}</td>
                        <td>{{ $seminar->harga_seminar }}</td>
                        <td>
                            @if($seminar->gambar_seminar)
                            <img src="{{ asset($seminar->gambar_seminar) }}" alt="Gambar Seminar" class="img-thumbnail" style="width: 100px; height: 70px; background-size: contain;">
                            @else
                            Tidak ada gambar
                            @endif
                        </td>
                        <td class="d-flex">
                            <a href="{{ route('admin.seminar.edit', $seminar->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('seminars.destroy', $seminar->id) }}" method="POST" style="margin-left: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
