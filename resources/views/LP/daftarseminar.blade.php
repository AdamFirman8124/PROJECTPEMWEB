@extends('layouts.appuser')

@section('content')
<div style="margin-top: 120px;" class="container">
    <div class="card shadow-lg p-3 w-50 mb-5 mx-auto bg-white rounded">
        <div class="card-body">
            <h2 class="card-title text-center">Form Pendaftaran</h2>
            <form id="daftarForm" enctype="multipart/form-data" method="POST" action="{{ route('registrations.store') }}" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="identitas" class="form-label">No Identitas:</label>
                    <input type="text" class="form-control" id="identitas" name="identitas" required>
                    <div class="invalid-feedback">
                        Mohon masukkan No Identitas.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="name" required>
                    <div class="invalid-feedback">
                        Mohon masukkan Nama.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">
                        Mohon masukkan Email yang valid.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">No Telepon:</label>
                    <input type="text" class="form-control" id="telepon" name="phone" required>
                    <div class="invalid-feedback">
                        Mohon masukkan No Telepon.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="instansi" class="form-label">Asal Instansi:</label>
                    <input type="text" class="form-control" id="instansi" name="instansi" required>
                    <div class="invalid-feedback">
                        Mohon masukkan Asal Instansi.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="info" class="form-label">Tahu Info Dari Mana:</label>
                    <input type="text" class="form-control" id="info" name="info" required>
                    <div class="invalid-feedback">
                        Mohon masukkan informasi ini.
                    </div>
                </div>
                <div class="mb-3" id="buktiBayarContainer" style="display: none;">
                    <label for="bukti_bayar" class="form-label">Upload Bukti Pembayaran:</label>
                    <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar">
                    <div class="invalid-feedback">
                        Mohon upload bukti pembayaran.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
        </div>
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
        const seminarSelect = document.getElementById('seminar_id');
        const buktiBayarContainer = document.getElementById('buktiBayarContainer');

        seminarSelect.addEventListener('change', async function () {
            const seminarId = seminarSelect.value;
            try {
                const response = await fetch(`/registration-controller/is-paid/${seminarId}`);
                const data = await response.json();
                if (data.is_paid === '1') {
                    buktiBayarContainer.style.display = 'block';
                } else {
                    buktiBayarContainer.style.display = 'none';
                }
            } catch (error) {
                console.error('Error fetching bukti bayar data:', error);
            }
        });
    });
</script>
@endsection
