<!-- resources/views/users/edit-role.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Role Pengguna</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update-role', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Peserta</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>PIC Webinar/Seminar</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Role</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection