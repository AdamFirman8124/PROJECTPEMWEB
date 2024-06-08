@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #e0e0e0;
    }
    .card {
        margin: 0 auto;
        max-width: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 20px;
        background-color: #f8f9fa;
    }
    .form-control, .form-control option {
        color: black;
        background-color: white;
        height: auto;
    }
</style>

<body>
<div class="container">
    <div class="card shadow-sm p-3 mb-5 bg-white rounded">
        <h2>Form Pendaftaran</h2>
        <form id="daftarForm" action="{{ route('registrations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="identitas">No Identitas:</label>
                <input type="text" class="form-control" id="identitas" name="identitas" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telepon">No Telepon:</label>
                <input type="text" class="form-control" id="telepon" name="phone" required>
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
                <label for="seminar">Mau mendaftar di topik seminar apa?</label>
                <select class="form-control text-dark" id="seminar" name="seminar">
                    @foreach ($seminars as $seminar)
                        <option value="{{ $seminar->id }}">{{ $seminar->topik }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>
</div>

@if (session('success'))
    <script>
        alert('{{ session("success") }}');
    </script>
@endif
</body>
@endsection
