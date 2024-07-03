@extends('layouts.appadmin')

@section('content')
<section class="vh-100">
    <div class="container mt-5 pt-5" style="margin-top: 7em;">
        <h2>Edit Pembicara</h2>
        <form method="POST" action="{{ route('admin.updatePembicara', $pembicara->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_pembicara">Nama Pembicara:</label>
                <input type="text" class="form-control" id="nama_pembicara" name="nama_pembicara" value="{{ $pembicara->nama_pembicara }}" required>
            </div>
            <div class="form-group">
                <label for="topik">Topik Pembicaraan:</label>
                <input type="text" class="form-control" id="topik" name="topik" value="{{ $pembicara->topik }}" required>
            </div>
            <div class="form-group">
                <label for="asal_instansi">Asal Instansi:</label>
                <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" value="{{ $pembicara->asal_instansi }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</section>
@endsection