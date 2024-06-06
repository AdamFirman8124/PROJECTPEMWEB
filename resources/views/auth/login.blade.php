<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f0f2f5; 
    }

    .card {
        width: 350px;
        height: 190px;
        max-width: 420px;
        padding: 20px;
        border-radius: 20px;
        background: #e0e0e0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .card-body {
        width: 100%;
    }

    .form-control, .form-select {
        width: 100%;
        border-radius: 10px;
        padding: 10px; 
        margin-bottom: 15px; 
        border: 1px solid #ccc; 
    }

    .btn-primary {
        width: 100%;
        border-radius: 20px; 
        padding: 10px 20px; 
        font-size: 16px; 
        background-color: #4CAF50; 
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 12px; 
    }

    .btn-primary:hover {
        background-color: #45a049; 
    }

    .error-message {
        color: red; 
        display: block; 
        font-size: 14px; 
        margin-top: 5px; 
    }

    .form-check-input {
        margin-top: 6px; 
    }

    .form-check-label {
        margin-left: 10px; 
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
