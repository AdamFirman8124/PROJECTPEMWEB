<style>
    .card {
        width: 390px; /* Diperbesar dari 390px */
        height: 454px; /* Diperbesar dari 454px */
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
        height: 100vh; /* Menambahkan tinggi penuh viewport */
    }
    .form-control {
        border-radius: 10px; /* Menambahkan border radius */
        padding: 15px; /* Diperbesar dari 10px */
        font-size: 18px; /* Diperbesar dari default */
    }
    .btn-primary {
        border-radius: 20px; /* Menambahkan border radius */
        padding: 15px 30px; /* Diperbesar dari 10px 20px */
        font-size: 18px; /* Diperbesar dari 16px */
        margin-top: 20px; /* Menambahkan jarak dengan atas */
    }
    .form-check-input {
        margin-top: 6px; /* Menyesuaikan margin atas */
    }
    .form-check-label {
        margin-left: 10px; /* Menambahkan margin kiri */
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

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
