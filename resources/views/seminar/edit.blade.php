@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-uppercase text-secondary">Edit Seminar</h2>
    <form action="{{ route('seminars.update', $seminar->id) }}" method="POST" class="shadow-lg p-4 rounded bg-light">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="topik" class="form-label">Topik Seminar:</label>
            <input type="text" class="form-control" id="topik" name="topik" value="{{ $seminar->topik }}" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_seminar" class="form-label">Tanggal Seminar:</label>
            <input type="date" class="form-control" id="tanggal_seminar" name="tanggal_seminar" value="{{ $seminar->tanggal_seminar->toDateString() }}" required>
        </div>
        <div class="mb-3">
            <label for="lokasi_seminar" class="form-label">Lokasi Seminar:</label>
            <input type="text" class="form-control" id="lokasi_seminar" name="lokasi_seminar" value="{{ $seminar->lokasi_seminar }}" required>
        </div>
        <div class="mb-3">
            <label for="pembicara" class="form-label">Pembicara:</label>
            <input type="text" class="form-control" id="pembicara" name="pembicara" value="{{ $seminar->pembicara }}" required>
        </div>
        <div class="mb-3">
            <label for="asal_instansi" class="form-label">Asal Instansi:</label>
            <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" value="{{ $seminar->asal_instansi }}" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Update Seminar</button>
    </form>
</div>
@endsection

