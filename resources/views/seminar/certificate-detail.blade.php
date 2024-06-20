@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Detail Sertifikat Seminar: {{ $seminar->topik }}</h1>
    @if ($seminar->certificateTemplate)
        <div class="text-center">
            <img src="{{ asset('storage/certificate_templates/' . $seminar->certificateTemplate->file_path) }}" alt="Sertifikat" class="img-fluid">
            <p>Tanggal Akses: {{ $seminar->certificateTemplate->access_time }}</p>
            @php
            Log::info('Now: ' . \Carbon\Carbon::now());
            Log::info('Access Time: ' . \Carbon\Carbon::parse($seminar->certificateTemplate->access_time));
            @endphp
            <!-- Tombol unduh di bawah ini -->
            <a href="{{ route('seminar.download-certificate', $seminar->id) }}" class="btn btn-success">Unduh Sertifikat</a>
           
        </div>
    @else
        <div class="text-center">
            <p>Tidak ada sertifikat yang diberikan</p>
        </div>
    @endif
</div>
@endsection