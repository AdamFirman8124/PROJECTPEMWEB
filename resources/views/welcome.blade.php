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
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f2f5; 
            font-family: Arial, Helvetica, sans-serif;
        }

        .card {
            width: 320px;
            padding: 20px;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .links {
            display: flex;
            gap: 10px; 
        }

        .button {
            padding: 10px 20px;
            border-radius: 25px;
            background-color: #007bff; 
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3; 
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Selamat datang di sistem webinar kami!</h2>
        @if (Route::has('login'))
        <div class="links">
            @auth
            <a href="{{ url('/home') }}" class="button">Dashboard</a>
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