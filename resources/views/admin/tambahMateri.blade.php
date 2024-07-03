@extends('layouts.appadmin')

@section('content')
<section class="vh-100">
    <div class="container mt-5">
        <h2>Tambah Materi Seminar</h2>
        <form method="POST" action="{{ route('admin.simpanMateri') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="seminar_id">Pilih Seminar:</label>
                <select class="form-control" id="seminar_id" name="seminar_id" required>
                    @foreach ($seminars as $seminar)
                        <option value="{{ $seminar->id }}">{{ $seminar->nama_seminar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="judul_materi">Judul Materi:</label>
                <input type="text" class="form-control" id="judul_materi" name="judul_materi" required>
            </div>
            <div class="form-group">
                <label for="file_materi">File Materi:</label>
                <input type="file" class="form-control" id="file_materi" name="file_materi[]" multiple required>
            </div>
            <div class="form-group">
                <div style="margin-top: 1em; display: inline-block; margin-right: 10px;">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
                <div style="margin-top: 1em; display: inline-block;">
                    <a href="{{ route('admin.exportMateri') }}" class="btn btn-secondary btn-block">Unduh Data Seminar</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
