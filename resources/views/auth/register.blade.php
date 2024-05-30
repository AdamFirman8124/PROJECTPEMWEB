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
            height: 420px;
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

    
<div class="container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="card">
        <div class="card-body" style="padding: 20px;">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="error-message" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="error-message" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="error-message" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                    <div class="col-md-6">
                        <select id="role" class="form-control form-select" name="role" required>
                            <option value="PIC Seminar">PIC Seminar</option>
                            <option value="Webinar">Webinar</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
