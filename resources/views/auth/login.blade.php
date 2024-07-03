<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .background-radial-gradient {
            background-color: #A675E4;
            background-image: radial-gradient(650px circle at 0% 0%,
                rgba(102, 16, 242, 0.6) 15%,
                rgba(102, 16, 242, 0.5) 35%,
                rgba(102, 16, 242, 0.3) 75%,
                rgba(102, 16, 242, 0.2) 80%,
                transparent 100%),
                radial-gradient(1250px circle at 100% 100%,
                rgba(102, 16, 242, 0.6) 15%,
                rgba(102, 16, 242, 0.5) 35%,
                rgba(102, 16, 242, 0.3) 75%,
                rgba(102, 16, 242, 0.2) 80%,
                transparent 100%);
        }

        #radius-shape-1 {
            height: 220px;
            width: 220px;
            top: -60px;
            left: -130px;
            background: radial-gradient(#44006b, #ad1fff);
            overflow: hidden;
        }

        #radius-shape-2 {
            border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
            bottom: -60px;
            right: -110px;
            width: 300px;
            height: 300px;
            background: radial-gradient(#44006b, #ad1fff);
            overflow: hidden;
        }

        .bg-glass {
            background-color: hsla(0, 0%, 100%, 0.9) !important;
            backdrop-filter: saturate(200%) blur(25px);
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            margin-top: 1rem;
        }

        .alert {
            margin-top: 1rem;
        }
    </style>
    <title>Login</title>
</head>
<body>
    <section class="background-radial-gradient overflow-hidden vh-100 d-flex justify-content-center align-items-center">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                       SEMINARKU<span>.ID</span> <br />
                    </h1>
                    
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card" style="background-color: rgba(255, 255, 255, 0.7);">
                        <div class="card-body">
                            <h2 class="fw-bold mb-4">Login</h2>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-4" >
                                    <label for="password" class="form-label" >{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            
                                <div class="mt-4">
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
            </div>
        </div>
    </section>
</body>
</html>
