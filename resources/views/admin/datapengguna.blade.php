@extends('layouts.appadmin')

@section('content')
<body>
    <div class="container mx-auto" style="margin-top: 120px;">
        <h1 class="my-4 text-center">Data Pengguna</h1>

        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        @if (Auth::user()->role == 'admin')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            @if (Auth::user()->role == 'admin')
                            <a href="{{ route('users.edit-role', $user->id) }}" class="btn btn-warning">Edit Role</a>

                            <form action="{{ route('data_pengguna', $user->id) }}" method="POST" style="display: inline-block;">
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
        <a href="{{ route('admin_dashboard') }}" class="btn btn-primary">Kembali ke Beranda</a>
        <a href="{{ route('users.export') }}" class="btn btn-success">Download Data User (.xls)</a>
        <a href="{{ route('users.download-pdf') }}" class="btn btn-warning">Download Data User (PDF)</a>


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