<!-- rekap-peserta.blade.php -->
@extends('layouts.app')

@section('content')

<body style="background-color: #e9ecef;">
    <div class="container mx-auto" style="margin-top: 60px;">
        <h1 class="my-4 text-center">Data User</h1>

        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'PIC WebinarorSeminar')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role == 'admin' ? 'PIC WebinarorSeminar' : 'Peserta' }}</td>
                        <td>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'PIC WebinarorSeminar')
                            <a href="{{ route('users.edit-role', $user->id) }}" class="btn btn-warning">Edit Role</a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('landingpage') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit(); // Submit form jika pengguna mengkonfirmasi
                }
            });
        }
    </script>
</body>
@endsection