@extends('layouts.app')

@section('content')
<body style="background-color: #e9ecef;">
<div class="container" style="margin-top: 60px;">
    <h1 class="text-center mb-4">Silahkan pilih seminar mana yang akan diberikan sertifikat</h1>
    <div class="row justify-content-center">
    @foreach ($seminars as $seminar)
        <div class="col-md-4 mb-4">
            <div class="card seminar-card shadow-lg" style="height: 100%; width: 100%;">
                <img src="{{ asset('storage/seminar_images/' . $seminar->gambar_seminar) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $seminar->topik }}</h5>
                    @if ($seminar->certificateTemplate && $seminar->certificateTemplate->access_time)
                        <p>Tanggal Akses: {{ $seminar->certificateTemplate->access_time }}</p>
                        <!-- Form untuk mengedit tanggal akses -->
                        <form action="{{ route('seminar.updateCertificate', $seminar->certificateTemplate->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="datetime-local" name="access_time" class="form-control mb-2" value="{{ \Carbon\Carbon::parse($seminar->certificateTemplate->access_time)->format('Y-m-d\TH:i') }}" required>
                            <button type="submit" class="btn btn-primary">Update Tanggal Akses</button>
                        </form>
                    @else
                        <!-- Form untuk mengatur tanggal akses jika belum ada -->
                        <form action="{{ route('seminar.uploadCertificate', $seminar->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="certificate_template" class="form-control mb-2" required>
                            <input type="datetime-local" name="access_time" class="form-control mb-2" value="{{ $seminar->certificateTemplate ? \Carbon\Carbon::parse($seminar->certificateTemplate->access_time)->format('Y-m-d\TH:i') : '' }}" required>
                            <button type="submit" class="btn btn-primary">Upload Template Sertifikat</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Hentikan form dari submit biasa

                // Validasi untuk memastikan semua input terisi
                if (!form.certificate_template.value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pastikan semua form terisi!',
                    });
                    return; // Hentikan eksekusi lebih lanjut jika form tidak lengkap
                }

                // Tampilkan SweetAlert untuk konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pastikan data yang diupload sudah benar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, upload sekarang!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika pengguna mengkonfirmasi
                    }
                });
            });
        });
    </script>
</div>
</body>
@endsection

