@extends('layouts.appadmin')
<style>
  .gambar-container {
    width: 100%; /* Lebar container sesuai kebutuhan */
    height: 200px; /* Tinggi container sesuai kebutuhan */
    overflow: hidden; /* Mengatur agar gambar yang lebih besar dari container tidak keluar */
    border: 1px solid #ccc; /* Opsi: Menambahkan border untuk memisahkan gambar */
}

.gambar-container img {
    width: 100%; /* Menyesuaikan lebar gambar agar sesuai dengan container */
    height: auto; /* Menjaga aspek ratio gambar */
    display: block; /* Memastikan gambar ditampilkan sebagai block element */
}

</style>
@section('content')
<section class="section courses" id="courses">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Selamat datang, {{ Auth::user()->name }}</h6>
                    <h2>Daftar Seminar</h2>
                </div>
            </div>
        </div>

        <!-- Filter links -->
        <ul class="event_filter">
    <li><a class="{{ !request()->has('filter') ? 'is_active' : '' }}" href="{{ route('admin_dashboard') }}" data-filter="*">Tampilkan Semua</a></li>
    <li><a class="{{ request()->input('filter') == 'gratis' ? 'is_active' : '' }}" href="{{ route('admin_dashboard_filter', 'gratis') }}" data-filter=".gratis">Gratis</a></li>
    <li><a class="{{ request()->input('filter') == 'berbayar' ? 'is_active' : '' }}" href="{{ route('admin_dashboard_filter', 'berbayar') }}" data-filter=".berbayar">Berbayar</a></li>
</ul>


        <a href="{{ route('tambahseminar') }}" class="btn btn-success mb-3">Tambah Seminar</a>
        <a href="{{ route('admin.exportSeminar') }}" class="btn btn-success mb-3">Unduh Data Seminar</a>

        <div class="row event_box">
            @foreach ($seminars as $seminar)
                <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 {{ $seminar->is_paid ? 'berbayar' : 'gratis' }}">
                    <div class="events_item">
                        <div class="gambar-container">
                            <a href="#"><img src="{{ asset($seminar->gambar_seminar) }}" alt="{{ $seminar->topik }}"></a>
                            <span class="category">{{ $seminar->is_paid ? 'Berbayar' : 'Gratis' }}</span>
                        </div>
                        <div class="down-content">
                            <span class="author">{{ $seminar->nama_seminar }}</span>
                            <h4>{{ $seminar->topik }}</h4>
                            
                            <span class="author">{{ $seminar->tanggal_seminar }}</span> <br>
                            <span class="category">{{ $seminar->is_paid ? 'Berbayar' : 'Gratis' }}</span>
                        </div>
                        <div class="d-flex p-2">
                            <div class="main-button text-right m-2">
                                <a href="{{ route('detailseminar', $seminar->id) }}">Detail</a>
                            </div>
                           
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endsection
