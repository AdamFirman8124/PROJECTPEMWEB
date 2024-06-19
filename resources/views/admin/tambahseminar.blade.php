@extends('layouts.appadmin')

@section('content')
<style>
    body {
        background-color: #e9ecef;
    }
    .form-control-custom {
        border-radius: 8px;
        border: 2px solid #adb5bd;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: #495057;
        background-color: #e9ecef;
        display: block;
        width: 100%;
        height: auto;
        margin-bottom: 1rem;
    }
    .card-custom {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 50%;
        margin: 2rem auto;
        padding: 2rem;
    }
    .btn-custom {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        font-size: 1.1rem;
        line-height: 1.7;
        transition: background-color 0.3s, border-color 0.3s;
        display: block;
        width: 100%;
        margin-top: 1rem;
    }
    .btn-custom:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .label-custom {
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #343a40;
        display: block;
    }
    .btn-kirim {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        font-size: 1.1rem;
        line-height: 1.7;
        transition: background-color 0.3s, border-color 0.3s;
        display: block;
        width: 100%;
        margin-top: 1rem;
    }
    .btn-kirim:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
<body>
<div style="margin-top: 120px;" class="container" style="padding: 20px;">
    <div class="card card-custom" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
        <div class="card-header" style="background-color: #007BFF; color: white; padding: 10px 20px;">
            <h3 style="margin: 0;">Tambah Seminar</h3>
        </div>
        <div class="card-body" style="padding: 20px; background-color: #f8f9fa;">
            <form method="POST" action="{{ route('admin.tambahseminar') }}" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label for="pembicara">Nama Pembicara:</label>
                    <input type="text" id="pembicara" name="pembicara" placeholder="Masukkan nama pembicara" class="form-control form-control-custom">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="asal_instansi">Asal Instansi Pembicara:</label>
                    <input type="text" id="asal_instansi" name="asal_instansi" placeholder="Masukkan asal instansi pembicara" class="form-control form-control-custom">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="topik">Topik Seminar:</label>
                    <input type="text" id="topik" name="topik" placeholder="Masukkan topik seminar" class="form-control form-control-custom">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="tanggal_seminar">Tanggal Seminar:</label>
                    <input type="date" id="tanggal_seminar" name="tanggal_seminar" required placeholder="Masukkan tanggal seminar" class="form-control form-control-custom">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="lokasi_seminar">Lokasi Seminar:</label>
                    <input type="text" id="lokasi_seminar" name="lokasi_seminar" placeholder="Masukkan lokasi seminar" class="form-control form-control-custom">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="google_map_link">Link Google Map: (contoh https://maps.app.goo.gl)</label>
                    <input type="url" id="google_map_link" name="google_map_link" placeholder="Masukkan link Google Map lokasi seminar" class="form-control form-control-custom">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="gambar_seminar">Gambar Seminar:</label>
                    <input type="file" id="gambar_seminar" name="gambar_seminar" class="form-control form-control-custom">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="start_registration">Tanggal Mulai Pendaftaran:</label>
                    <input type="date" id="start_registration" name="start_registration" class="form-control form-control-custom">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="end_registration">Tanggal Akhir Pendaftaran:</label>
                    <input type="date" id="end_registration" name="end_registration" class="form-control form-control-custom" required>
                </div>
                
                <div class="form-check" style="margin-bottom: 20px;">
                    <input type="checkbox" name="is_paid" value="1" class="form-check-input" id="isPaidCheck">
                    <label class="form-check-label" for="isPaidCheck">Centang jika seminar ini berbayar</label>
                </div>
            
                
                <div style="margin-bottom: 15px;">
                    <label for="materi">Materi:</label>
                    <input type="file" id="materi" name="materi" class="form-control form-control-custom">
                </div>
                
                <button type="submit" class="btn btn-kirim" style="width: 100%;">Kirim</button>
                <a href="{{ route('admin_dashboard') }}" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Kembali ke Beranda</a>
            </form>
        </div>
    </div>
</div>
</body>
@endsection