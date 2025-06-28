<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register | Website Pengaduan Mahasiswa TI</title>

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
    <div class="min-h-screen flex flex-col justify-center items-center px-6">
        <div class="w-full max-w-md bg-[#450000] rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-[#C5B358] mb-6">Register Account</h2>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-500">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-[#C5B358] font-medium mb-1">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-2 rounded bg-[#3a1f1f] border border-gray-600 text-white focus:ring focus:ring-yellow-700 focus:outline-none">
                    @error('name')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[#C5B358] font-medium mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 rounded bg-[#3a1f1f] border border-gray-600 text-white focus:ring focus:ring-yellow-700 focus:outline-none">
                    @error('email')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-[#C5B358] font-medium mb-1">Daftar Sebagai</label>
                    <select id="role" name="role" required
                            class="w-full px-4 py-2 rounded bg-[#3a1f1f] text-white border border-gray-600 focus:ring focus:ring-yellow-700 focus:outline-none">
                        <option disabled selected>-- Pilih Role --</option>
                        <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    </select>
                    @error('role')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM (Mahasiswa) -->
                <div id="nim-field" style="display: none;">
                    <label for="nim" class="block text-[#C5B358] font-medium mb-1">NIM</label>
                    <input id="nim" type="text" name="nim" value="{{ old('nim') }}"
                           class="w-full px-4 py-2 rounded bg-[#3a1f1f] border border-gray-600 text-white focus:ring focus:ring-yellow-700 focus:outline-none">
                    @error('nim')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIDN (Dosen) -->
                <div id="nidn-field" style="display: none;">
                    <label for="nidn" class="block text-[#C5B358] font-medium mb-1">NIK / NIDN</label>
                    <input id="nidn" type="text" name="nidn" value="{{ old('nidn') }}"
                           class="w-full px-4 py-2 rounded bg-[#3a1f1f] border border-gray-600 text-white focus:ring focus:ring-yellow-700 focus:outline-none">
                    @error('nidn')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-[#C5B358] font-medium mb-1">Password</label>
                    <input id="password" type="password" name="password" required minlength="6"
                           class="w-full px-4 py-2 rounded bg-[#3a1f1f] border border-gray-600 text-white focus:ring focus:ring-yellow-700 focus:outline-none">
                    @error('password')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-[#C5B358] font-medium mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 rounded bg-[#3a1f1f] border border-gray-600 text-white focus:ring focus:ring-yellow-700 focus:outline-none">
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-300 hover:text-white" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit"
                            class="px-6 py-2 bg-[#C5B358] text-black font-semibold rounded hover:bg-yellow-600 transition">
                        Register
                    </button>
                </div>
            </form>

            <p class="text-sm text-gray-400 mt-4 text-center">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-500 hover:underline">Login sekarang</a>
            </p>
        </div>
    </div>

    <!-- Script for role-based input toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const nimField = document.getElementById('nim-field');
            const nidnField = document.getElementById('nidn-field');

            function toggleFields() {
                const role = roleSelect.value;
                nimField.style.display = role === 'mahasiswa' ? 'block' : 'none';
                nidnField.style.display = role === 'dosen' ? 'block' : 'none';
            }

            roleSelect.addEventListener('change', toggleFields);
            toggleFields(); // initial load
        });
    </script>
</body>
</html>
