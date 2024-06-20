@extends('layouts.appadmin')

@section('content')
<div class="container" style="margin-top: 120px;">
    <h2 class="mb-4 text-center text-uppercase text-secondary">Edit Seminar</h2>
    <form action="{{ route('admin.seminar.update', $seminar->id) }}" method="POST" class="shadow-lg p-4 rounded bg-light">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_seminar" class="form-label">Nama Seminar:</label>
            <input type="text" class="form-control" id="nama_seminar" name="nama_seminar" value="{{ $seminar->nama_seminar }}" required>
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
            <label for="is_paid" class="form-label">Apakah Seminar Berbayar?</label>
            <select class="form-control" id="is_paid" name="is_paid" required>
                <option value="1" {{ $seminar->is_paid ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ !$seminar->is_paid ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Update Seminar</button>
    </form>
</div>
@endsection