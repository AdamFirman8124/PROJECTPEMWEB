<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Sertifikat Webinar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Gaya CSS Anda */
    </style>
</head>
<body>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <button class="btn btn-primary mb-3" id="showCreateModal">Tambah Sertifikat</button>

        <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Sertifikat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm" action="{{ route('certificates.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="seminar_id">Seminar</label>
                                <select class="form-control" id="seminar_id" name="seminar_id" required>
                                    <option value="" disabled selected>Pilih Seminar</option>
                                    @foreach($seminars as $seminar)
                                        <option value="{{ $seminar->id }}">{{ $seminar->topik }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="download_start_date">Tanggal Download Mulai</label>
                                <input type="date" class="form-control" id="download_start_date" name="download_start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="user_id">User</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="" disabled selected>Pilih User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user_name">Nama Pengguna</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Seminar</th>
                    <th>Tanggal Download Mulai</th>
                    <th>User ID</th>
                    <th>Nama Pengguna</th>
                    <th>Dibuat pada</th>
                    <th>Diperbarui pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificates as $certificate)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $certificate->seminar->topik }}</td>
                    <td>{{ $certificate->download_start_date }}</td>
                    <td>{{ $certificate->user_id }}</td>
                    <td>{{ $certificate->user->name }}</td>
                    <td>{{ $certificate->created_at }}</td>
                    <td>{{ $certificate->updated_at }}</td>
                    <td>
                        <a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#showCreateModal').click(function() {
                $('#createModal').modal('show');
            });
        });
    </script>
</body>
</html>

