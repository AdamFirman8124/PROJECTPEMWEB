<style>
        body {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f0f2f5; 
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

        .card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-body {
            width: 100%;
        }

        .form-control {
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
            background-color: #007bff;
            color: white;
            border: none; 
            cursor: pointer; 
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3; 
        }

        .form-check-input {
            margin-top: 6px; 
        }

        .form-check-label {
            margin-left: 10px; 
        }

        .btn-link {
            display: inline-block;
            margin-top: 10px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .invalid-feedback { 
            display: block;
            color: red;
            font-size: 14px;
            margin-top: 5px;
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
