<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow" style="width: 100%; max-width: 480px;">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Login</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">
                        {{ __('Login') }}
                    </button>
                </div>
                <div class="mt-3">
                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            <strong>Email yang kamu masukkan salah</strong>
                        </div>
                    @enderror
                    @error('password')
                        <div class="alert alert-danger" role="alert">
                            <strong>Password yang kamu masukkan salah</strong>
                        </div>
                    @enderror
                </div>
            </form>
        </div>
    </div>
</div>
