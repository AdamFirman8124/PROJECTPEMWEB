@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Daftar Pendaftaran Seminar</h1>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Topik Seminar</th>
                    <th>Tanggal Seminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registrations as $registration)
                <tr>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->seminar->topik }}</td>
                    <td>{{ $registration->seminar->tanggal_seminar }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
