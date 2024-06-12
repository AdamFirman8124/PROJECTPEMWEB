@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 60px;">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Detail Seminar: {{ $seminar->topik }}</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $seminar->topik }}</h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text"><strong>Tanggal Pelaksanaan:</strong> <span id="tanggal_seminar">{{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->format('d M Y') }}</span></p>
                    <p class="card-text"><strong>Penutupan Pendaftaran:</strong> <span id="end_registration">{{ $seminar->end_registration }}</span></p>
                    <p class="card-text"><strong>Lokasi:</strong> <span id="lokasi_seminar">{{ $seminar->lokasi_seminar }}</span></p>
                    <p class="card-text"><strong>Pembicara:</strong> <span id="pembicara">{{ $seminar->pembicara }}</span></p>
                    <p class="card-text"><strong>Instansi:</strong> <span id="instansi">{{ $seminar->asal_instansi }}</span></p>
                </div>
                <div class="col-md-6">
                    <p class="card-text"><strong>Status:</strong> @if ($seminar->is_paid)
                                <span class="badge badge-success">Berbayar</span>
                            @else
                                <span class="badge badge-info">Gratis</span>
                            @endif</span></p>
                    <p class="card-text">
                        <strong>Google Map:</strong> 
                        <a href="{{ $seminar->google_map_link }}" target="_blank" class="btn btn-sm btn-info">Lihat Lokasi</a>
                    </p>
                    <p class="card-text" id="materi_seminar">
                        <strong>Materi Seminar:</strong>
                        @if($seminar->materi)
                            <a href="{{ asset('storage/materi/' . $seminar->materi) }}" target="_blank" class="btn btn-sm btn-success">Download Materi</a>
                        @else
                            Tidak ada materi yang tersedia
                        @endif
                    </p>
                    @if($isRegistered)
                    <a href="{{ route('seminar.certificate-detail', $seminar->id) }}" class="btn btn-primary">Unduh Sertifikat</a>
                    @endif
                </div>
            </div>
            @if ($seminar->is_paid && $registration->bukti_pembayaran)
                <div class="mt-4">
                    <p class="card-text"><strong>Bukti Pembayaran:</strong></p>
                    <img src="{{ asset('storage/app/public/payment_proofs' . $registration->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid">
                </div>
            @endif
            <div id="registration_status" class="mt-4">
                @if($isRegistered)
                    <button class="btn btn-success disabled">Anda sudah mendaftar, mohon tunggu untuk verifikasi</button>
                @else
                    <a href="{{ route('registrations.create', ['seminar_id' => $seminar->id]) }}" class="btn btn-primary">Daftar Seminar</a>
                @endif
            </div>
            <a href="{{ route('home') }}" class="btn btn-info mt-3">Kembali ke Daftar Seminar</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function registerSeminar(seminarId) {
        $.ajax({
            url: "{{ route('registrations.create') }}",
            type: 'POST',
            data: {
                seminar_id: seminarId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#registration_status').html('<button class="btn btn-secondary disabled">Pendaftaran berhasil, mohon tunggu untuk verifikasi</button>');
                alert('Pendaftaran berhasil!');
            },
            error: function() {
                alert('Pendaftaran gagal, silakan coba lagi.');
            }
        });
    }
</script>
@endsection
