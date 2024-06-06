<!-- resources/views/certificates.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Bagian untuk menampilkan pesan sukses -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tombol untuk menambah sertifikat -->
        <a href="{{ route('certificates.create') }}" class="btn btn-primary mb-2">Tambah Sertifikat</a>

        <!-- Tabel untuk menampilkan sertifikat -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Template</th>
                    <th>Tanggal Download Mulai</th>
                    <th>Created At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificates as $certificate)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $certificate->template }}</td>
                        <td>{{ $certificate->download_start_date }}</td>
                        <td>{{ $certificate->created_at }}</td>
                        <td>
                            <a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
