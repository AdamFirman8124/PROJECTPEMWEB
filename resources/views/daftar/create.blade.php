@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Form Pendaftaran</h2>
    <form action="{{ route('daftar.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="identitas">No Identitas:</label>
            <input type="text" class="form-control" id="identitas" name="identitas" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="telepon">No Telepon:</label>
            <input type="text" class="form-control" id="telepon" name="telepon" required>
        </div>
        <div class="form-group">
            <label for="instansi">Asal Instansi:</label>
            <input type="text" class="form-control" id="instansi" name="instansi" required>
        </div>
        <div class="form-group">
            <label for="info">Tahu Info Dari Mana:</label>
            <input type="text" class="form-control" id="info" name="info" required>
        </div>
        <div class="form-group">
            <label for="seminar">Mau mendaftar di seminar apa?</label>
            <select class="form-control text-dark" id="seminar" name="seminar">
                @foreach ($seminars as $seminar)
                    <option value="{{ $seminar->id }}">{{ $seminar->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>

<style>
    .form-control {
        color: black; /* Warna teks hitam */
        background-color: white; /* Latar belakang putih */
    }
    .form-control option {
        color: black; /* Warna teks hitam */
        background-color: white; /* Latar belakang putih */
    }
</style>
@endsection