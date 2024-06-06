@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-body">
            <h3>Formulir Pendaftaran Seminar</h3>
            <form method="POST" action="{{ route('registrations.store', $seminar->id) }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon:</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
        </div>
    </div>
</div>
@endsection
