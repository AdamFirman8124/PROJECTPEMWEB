@extends('layouts.appadmin')

@section('content')
<body style="background-color: #e9ecef;">
    <div class="container" style="margin-top: 120px;">
        <h1 class="my-4 text-center">Edit Data Peserta Seminar</h1>

        <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card shadow-sm p-4 mb-4 bg-white rounded">
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
                        <a href="{{ Storage::url($registration->bukti_bayar) }}" target="_blank" class="btn btn-link mt-2">Lihat Bukti Bayar</a>
                    @else
                        <p class="text-muted mt-2">Belum ada bukti bayar</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Belum diverifikasi" {{ $registration->status == 'Belum diverifikasi' ? 'selected' : '' }}>Belum diverifikasi</option>
                        <option value="Sudah diverifikasi" {{ $registration->status == 'Sudah diverifikasi' ? 'selected' : '' }}>Sudah diverifikasi</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('rekap_peserta') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</body>
@endsection
