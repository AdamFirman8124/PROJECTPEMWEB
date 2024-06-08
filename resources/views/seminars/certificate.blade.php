@extends('layouts.app')

@section('content')
<body style="background-color: #e9ecef;">
<div class="container" style="margin-top: 60px;">
    <h1 class="text-center mb-4">Silahkan pilih seminar mana yang akan diberikan sertifikat</h1>
    <div class="row justify-content-center">
        @foreach ($seminars as $seminar)
        <div class="col-md-4 mb-4">
            <div class="card seminar-card shadow-lg" style="border-radius: 15px; overflow: hidden; height: 100%;">
                <img src="{{ asset('storage/seminar_images/' . $seminar->gambar_seminar) }}" alt="Gambar Seminar" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title"><strong>Topik:</strong> {{ $seminar->topik }}</h3>
                    <div class="mt-auto">
                        <form action="{{ route('seminar.uploadCertificate') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <input type="file" name="certificate_template" accept="image/jpeg, image/png" class="form-control" style="height: auto;">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai Unduh:</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Upload Template Sertifikat</button>
                        </form>
                    </div>
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
                if (!form.certificate_template.value || !form.start_date.value) {
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
