<style>
    .card {
        width: 390px;
        height: 454px;
        border-radius: 50px;
        background: #e0e0e0;
        box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .form-control {
        border-radius: 10px;
        padding: 15px;
        font-size: 18px;
    }
    .btn-primary {
        border-radius: 20px;
        padding: 15px 30px;
        font-size: 18px;
        margin-top: 20px;
    }
    .form-check-input {
        margin-top: 6px;
    }
    .form-check-label {
        margin-left: 10px;
    }
    .error-message {
        color: red;
        font-size: 14px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="error-message" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @error('email')
                                    <span class="error-message" role="alert">
                                        <strong>Email yang kamu masukkan salah</strong>
                                    </span>
                                @enderror
                                @error('password')
                                    <span class="error-message" role="alert">
                                        <strong>Password yang kamu masukkan salah</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
