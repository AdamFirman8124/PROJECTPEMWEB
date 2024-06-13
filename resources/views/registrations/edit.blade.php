@extends('layouts.app')

@section('content')
<body style="background-color: #e9ecef;">
    <div class="container" style="margin-top: 5em;">
        <h1 class="my-4 text-center">Edit Data Peserta Seminar</h1>

        <form action="{{ route('registrations.update', $registration->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="identitas">No Identitas</label>
                <input type="text" class="form-control" id="identitas" name="identitas" value="{{ $registration->identitas }}" required>
            </div>

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $registration->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $registration->email }}" required>
            </div>

            <div class="form-group">
                <label for="phone">No Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $registration->phone }}" required>
            </div>

            <div class="form-group">
                <label for="instansi">Asal Instansi</label>
                <input type="text" class="form-control" id="instansi" name="instansi" value="{{ $registration->instansi }}" required>
            </div>

            <div class="form-group">
                <label for="info">Info</label>
                <textarea class="form-control" id="info" name="info" rows="3" required>{{ $registration->info }}</textarea>
            </div>

            <div class="form-group">
                <label for="seminar">Topik Seminar</label>
                <select class="form-control" id="seminar" name="seminar" required>
                    @foreach($seminars as $seminar)
                        <option value="{{ $seminar->id }}" {{ $seminar->id == $registration->seminar_id ? 'selected' : '' }}>{{ $seminar->topik }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="bukti_bayar">Bukti Bayar</label>
                <input type="file" class="form-control-file" id="bukti_bayar" name="bukti_bayar">
                @if($registration->bukti_bayar)
                    <a href="{{ Storage::url($registration->bukti_bayar) }}" target="_blank">Lihat Bukti Bayar</a>
                @else
                    Belum ada bukti bayar
                @endif
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Belum diverifikasi" {{ $registration->status == 'Belum diverifikasi' ? 'selected' : '' }}>Belum diverifikasi</option>
                    <option value="Sudah diverifikasi" {{ $registration->status == 'Sudah diverifikasi' ? 'selected' : '' }}>Sudah diverifikasi</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
@endsection
