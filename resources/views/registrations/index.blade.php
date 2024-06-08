@extends('layouts.app')

@section('content')
<body style="background-color: #e9ecef;">
    <div class="container" style="margin-top: 5em;">
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
                        <td>{{ $registration->seminar->topik }}</td>
                        <td>
                            <form action="{{ route('registrations.destroy', $registration->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('home') }}" type="button" class="btn btn-danger btn-sm">Kembali ke Beranda</a>
    </div>
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
</body>
@endsection
