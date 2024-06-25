@extends('layouts.appadmin')

@section('content')
<section class="vh-100">
    <div class="container" style="margin-top: 120px;">
        <h1 class="my-4 text-center">Rekap Peserta Seminar</h1>

        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No Identitas</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">No Telepon</th>
                        <th scope="col">Asal Instansi</th>
                        <th scope="col">Info</th>
                        <th scope="col">Topik Seminar</th>
                        <th scope="col">Bukti Bayar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                    <tr>
                        <td>{{ $registration->identitas }}</td>
                        <td>{{ $registration->name }}</td>
                        <td>{{ $registration->email }}</td>
                        <td>{{ $registration->phone }}</td>
                        <td>{{ $registration->instansi }}</td>
                        <td>{{ $registration->info }}</td>
                        <td>{{ $registration->seminar->topik }}</td> <!-- Pastikan menangani jika seminar tidak ada -->
                        <td>
                            @if($registration->bukti_bayar)
                                <a href="{{ asset($registration->bukti_bayar) }}" target="_blank">Lihat Bukti</a>
                            @else
                                Seminar ini gratis
                            @endif
                        </td>
                        <td>{{ $registration->status }}</td>
                        <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <form action="{{ route('admin.registrations.edit', $registration->id) }}" method="GET">
                                <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                            </form>
                            <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Delete</button>
                            </form>
                        </div>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('admin_dashboard') }}" type="button" class="btn btn-danger btn-sm">Kembali ke Beranda</a>
    </div>
</section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit(); // Submit form jika pengguna mengkonfirmasi
                }
            });
        }
    </script>
@endsection
