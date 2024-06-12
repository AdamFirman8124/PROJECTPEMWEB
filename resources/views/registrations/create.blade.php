@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Form Pendaftaran</h2>
            <form id="daftarForm" enctype="multipart/form-data" method="POST" action="{{ route('registrations.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="identitas" class="form-label">No Identitas:</label>
                    <input type="text" class="form-control" id="identitas" name="identitas" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">No Telepon:</label>
                    <input type="text" class="form-control" id="telepon" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="instansi" class="form-label">Asal Instansi:</label>
                    <input type="text" class="form-control" id="instansi" name="instansi" required>
                </div>
                <div class="mb-3">
                    <label for="info" class="form-label">Tahu Info Dari Mana:</label>
                    <input type="text" class="form-control" id="info" name="info" required>
                </div>
                <div class="mb-3">
                    <label for="seminar" class="form-label">Mau mendaftar di topik seminar apa?</label>
                    <select class="form-control" id="seminar" name="seminar" onchange="togglePaymentProof(this)">
                        @foreach ($seminars as $seminar)
                            <option value="{{ $seminar->id }}" data-is-paid="{{ $seminar->is_paid }}">{{ $seminar->topik }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3" id="paymentProofSection" style="display: none;">
                    <label for="payment_proof">Bukti Pembayaran:</label>
                    <input type="file" class="form-control" id="payment_proof" name="payment_proof">
                </div>
                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePaymentProof(select) {
        var isPaid = select.options[select.selectedIndex].dataset.isPaid;
        var paymentProofSection = document.getElementById('paymentProofSection');
        var paymentProofInput = document.getElementById('payment_proof');
        if (isPaid === '1') {
            paymentProofSection.style.display = '';
            paymentProofInput.required = true;
        } else {
            paymentProofSection.style.display = 'none';
            paymentProofInput.required = false;
        }
    }
</script>

@if (session('success'))
    <script>
        alert('{{ session("success") }}');
    </script>
@endif
@endsection
