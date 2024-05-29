<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body, html {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .card {
                width: 290px;
                height: 354px;
                border-radius: 50px;
                background: #e0e0e0;
                box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
            .button {
                display: inline-block; /* Ubah dari block menjadi inline-block agar tombol sebelahan */
                margin: 10px;
                text-align: center;
                padding: 15px; /* Perbesar padding */
                border-radius: 20px;
                background-color: #f2f2f2;
                text-decoration: none;
                color: black;
            }
            h2 {
                font-size: 24px;
                font-weight: 600;
                width: 100%;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <h2>Selamat datang di sistem webinar kami!</h2>
            @if (Route::has('login'))
                <div class="links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="button">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="button">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="button">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>
