@extends('layouts.appadmin')

@section('content')
<div class="container mt-5 pt-5">
    <h2>Data Pembicara</h2>
    <!-- <a href="{{ route('admin.exportPembicara') }}" class="btn btn-secondary mb-3">Ekspor Data Pembicara</a> -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pembicara</th>
                <th>Topik</th>
                <th>Asal Instansi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembicaras as $pembicara)
            <tr>
                <td>{{ $pembicara->nama_pembicara }}</td>
                <td>{{ $pembicara->topik }}</td>
                <td>{{ $pembicara->asal_instansi }}</td>
                <td>
                    <a href="{{ route('admin.editPembicara', $pembicara->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.deletePembicara', $pembicara->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.exportPembicara') }}" class="btn btn-secondary mb-3">Ekspor Data Pembicara</a>
</div>
@endsection