<style>
    :root {
        --primary-color: #007bff;
        --primary-color-hover: #0056b3;
        --border-radius: 10px;
        --box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        --background-color: #ffffff;
        --font-family: Arial, sans-serif;
    }

    body {
        font-family: var(--font-family);
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card-custom {
        border: 1px solid #ccc;
        box-shadow: var(--box-shadow);
        width: 100%;
        max-width: 600px;
        border-radius: var(--border-radius);
        background-color: var(--background-color);
        padding: 20px;
        margin: 20px;
        margin-top: auto ;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s;
        color: #fff;
        cursor: pointer;
        text-align: center;
        display: inline-block;
    }

    .btn-primary:hover {
        background-color: var(--primary-color-hover);
        border-color: var(--primary-color-hover);
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-group {
        margin-bottom: 20px;
    }
</style>

<div class="card card-custom">
    <div class="card-body">
        <form method="POST" action="{{ route('seminar.update', $seminar->id) }}" class="text-center" style="padding: 20px;">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tanggal_seminar">Tanggal Seminar:</label>
                <input type="date" class="form-control" id="tanggal_seminar" name="tanggal_seminar" value="{{ $seminar->tanggal_seminar }}" required>
            </div>
            <div class="form-group">
                <label for="lokasi_seminar">Lokasi Seminar:</label>
                <input type="text" class="form-control" id="lokasi_seminar" name="lokasi_seminar" value="{{ $seminar->lokasi_seminar }}" required>
            </div>
            <div class="form-group">
                <label for="google_map_link">Link Google Map:</label>
                <input type="text" class="form-control" id="google_map_link" name="google_map_link" value="{{ $seminar->google_map_link }}" required>
            </div>
            <div class="form-group">
                <label for="gambar_seminar">Gambar Seminar:</label>
                <input type="text" class="form-control" id="gambar_seminar" name="gambar_seminar" value="{{ $seminar->gambar_seminar }}" required>
            </div>
            <div class="form-group">
                <label for="is_paid">Berbayar:</label>
                <select class="form-control" id="is_paid" name="is_paid" required>
                    <option value="1" {{ $seminar->is_paid ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ !$seminar->is_paid ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_registration">Mulai Pendaftaran:</label>
                <input type="date" class="form-control" id="start_registration" name="start_registration" value="{{ $seminar->start_registration }}" required>
            </div>
            <div class="form-group">
                <label for="end_registration">Akhir Pendaftaran:</label>
                <input type="date" class="form-control" id="end_registration" name="end_registration" value="{{ $seminar->end_registration }}" required>
            </div>
            <div class="form-group">
                <label for="pembicara">Pembicara:</label>
                <input type="text" class="form-control" id="pembicara" name="pembicara" value="{{ $seminar->pembicara }}" required>
            </div>
            <div class="form-group">
                <label for="asal_instansi">Asal Instansi:</label>
                <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" value="{{ $seminar->asal_instansi }}" required>
            </div>
            <div class="form-group">
                <label for="topik">Topik:</label>
                <input type="text" class="form-control" id="topik" name="topik" value="{{ $seminar->topik }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Seminar</button>
        </form>
    </div>
</div>

