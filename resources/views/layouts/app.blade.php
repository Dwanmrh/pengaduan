<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Website Pengaduan Mahasiswa TI') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Custom Dropdown Styles -->
    <style>
        .custom-dropdown {
        border-radius: 10px;
        overflow: hidden;
        padding: 0;
    }

        .custom-dropdown a {
        background-color: #C5B358;
        color: black;
        padding: 10px 16px;
        display: block;
        text-decoration: none;
        font-size: 14px;
    }

        .custom-dropdown a:hover {
        background-color: #a68f3a;
        color: black;
    }

        .custom-dropdown a:first-child {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

        .custom-dropdown a:last-child {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    </style>



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#1a0000] text-white">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-[#450000] text-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="py-6 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
