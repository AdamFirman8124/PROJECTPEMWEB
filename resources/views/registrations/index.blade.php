@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Rekap Peserta Seminar</h1>

        <div class="table-container">
            <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No Identitas</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">No Telepon</th>
                    <th scope="col">Asal Instansi</th>
                    <th scope="col">Info</th>
                    <th scope="col">Topik Seminar</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $registration)
                <tr>
                    <td>{{ $registration->identitas }}</td>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->instansi }}</td>
                    <td>{{ $registration->info }}</td>
                    <td>{{ $registration->seminar->topik }}</td>
                    <td>
                        <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
