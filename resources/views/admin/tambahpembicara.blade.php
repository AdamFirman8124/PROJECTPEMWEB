@extends('layouts.appadmin')

@section('content')
<section class="vh-100">
<div class="container" style="margin-top: 7em;">
    <h2>Tambah Pembicara</h2>
    <form method="POST" action="{{ route('admin.simpanPembicara') }}">
        @csrf
        <div class="form-group">
            <label for="nama_pembicara">Nama Pembicara:</label>
            <input type="text" class="form-control" id="nama_pembicara" name="nama_pembicara" required>
        </div>
        <div class="form-group">
            <label for="topik">Topik Pembicaraan:</label>
            <input type="text" class="form-control" id="topik" name="topik" required>
        </div>
        <div class="form-group">
            <label for="asal_instansi">Asal Instansi:</label>
            <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.exportPembicara') }}" class="btn btn-secondary">Ekspor Data Pembicara</a>
    </form>
</div>
</section>
@endsection