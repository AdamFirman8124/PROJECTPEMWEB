<style>
    body{
        background-color: #f8f9fa;
    }
    .card-date-time, .card-user {
        width: 250px;
        padding: 10px;
        background-color: #f8f9fa; /* Warna latar belakang */
        border-radius: 8px; /* Membuat sudutnya bulat */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Menambahkan bayangan */
        font-size: 16px; /* Ukuran font */
        color: #343a40; /* Warna font */
        font-family: 'Arial', sans-serif; /* Gaya font */
        margin: 20px;
        text-align: center;
    }
    .btn-logout {
        background-color: #dc3545; /* Warna merah */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    .btn-logout:hover {
        background-color: #c82333; /* Warna merah tua */
    }
</style>

    <div class="card-user">
        Selamat datang, {{ Auth::user()->name }}
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-logout">{{ __('Logout') }}</button>
    </form>
    </div>

    <div class="card-date-time" id="liveDateTime"></div>

    <form method="POST" action="{{ route('seminar.store') }}">
        @csrf
        <input type="text" name="tanggal_seminar" placeholder="Tanggal Seminar">
        <input type="text" name="lokasi_seminar" placeholder="Lokasi Seminar">
        <input type="text" name="google_map_link" placeholder="Link Google Map">
        <input type="text" name="gambar_seminar" placeholder="URL Gambar Seminar">
        <input type="checkbox" name="is_paid" value="1"> Seminar Berbayar
        <input type="date" name="start_registration" placeholder="Tanggal Mulai Pendaftaran">
        <input type="date" name="end_registration" placeholder="Tanggal Akhir Pendaftaran">
        <input type="text" name="pembicara" placeholder="Nama Pembicara">
        <input type="text" name="asal_instansi" placeholder="Asal Instansi Pembicara">
        <input type="text" name="topik" placeholder="Topik Pembicara">
        <button type="submit">Submit</button>
    </form>

    <h1>Seminar Terdekat</h1>
    <table>
        <thead>
            <tr>
                <th>Tanggal Seminar</th>
                <th>Lokasi Seminar</th>
                <th>Link Google Map</th>
                <th>Gambar Seminar</th>
                <th>Seminar Berbayar</th>
                <th>Tanggal Mulai Pendaftaran</th>
                <th>Tanggal Akhir Pendaftaran</th>
                <th>Pembicara</th>
                <th>Asal Instansi</th>
                <th>Topik</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seminars as $seminar)
                <tr>
                    <td>{{ $seminar->tanggal_seminar }}</td>
                    <td>{{ $seminar->lokasi_seminar }}</td>
                    <td>
                        @if ($seminar->google_map_link)
                            <a href="{{ $seminar->google_map_link }}" target="_blank">Lihat Lokasi</a>
                        @else
                            Tidak Tersedia
                        @endif
                    </td>
                    <td>
                        @if ($seminar->gambar_seminar)
                            <img src="{{ $seminar->gambar_seminar }}" alt="Gambar Seminar" style="width: 100px; height: auto;">
                        @else
                            Tidak Ada Gambar
                        @endif
                    </td>
                    <td>{{ $seminar->is_paid ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $seminar->start_registration }}</td>
                    <td>{{ $seminar->end_registration }}</td>
                    <td>{{ $seminar->pembicara }}</td>
                    <td>{{ $seminar->asal_instansi }}</td>
                    <td>{{ $seminar->topik }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function updateDateTime() {
            const now = new Date();
            const dateString = now.toLocaleString('id-ID', {
                weekday: 'long', // hari dalam seminggu
                day: 'numeric', // tanggal
                month: 'long', // bulan
                year: 'numeric', // tahun
                hour: '2-digit', // jam
                minute: '2-digit', // menit
                second: '2-digit' // detik
            });
            document.getElementById('liveDateTime').innerHTML = dateString;
        }
        setInterval(updateDateTime, 1000);
    </script>
</div>
