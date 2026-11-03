<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Website Pengaduan Mahasiswa TI</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('favicon-192.png') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #1a0000;
            color: white;
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center text-center px-6">
        <h1 class="text-4xl sm:text-5xl font-bold text-[#C5B358] mb-6">
            Selamat Datang di Website Pengaduan Sistem Informasi
        </h1>
        <h1 class="text-4xl sm:text-5xl font-bold text-[#C5B358] mb-6">
            Mahasiswa Teknologi Informasi
        </h1>

        <p class="text-lg text-gray-200 mb-10 max-w-xl">
            Website ini memfasilitasi mahasiswa untuk menyampaikan pengaduan secara langsung dan transparan kepada dosen.
        </p>

        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-block px-6 py-3 bg-[#C5B358] text-black font-semibold rounded-md hover:bg-yellow-600 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block px-6 py-3 bg-[#C5B358] text-black font-semibold rounded-md hover:bg-yellow-600 transition">
                        Sign in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-block px-6 py-3 border border-[#C5B358] text-[#C5B358] font-semibold rounded-md hover:bg-[#C5B358] hover:text-black transition">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
