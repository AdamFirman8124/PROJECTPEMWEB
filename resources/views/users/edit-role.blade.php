@extends('layouts.appadmin')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 67.5vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-black text-white text-center">
                        <h3 style="color: white;">Edit Role Pengguna</h3>
                    </div>
                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('users.update-role', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-4">
                                <label for="role" class="form-label text-black">Pilih Role:</label>
                                <select id="role" name="role" class="form-control">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Peserta</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>PIC Webinar/Seminar</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Perbarui Role</button>
                                <a href="/admin/rekap-pengguna" class="btn btn-outline-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
@endsection
