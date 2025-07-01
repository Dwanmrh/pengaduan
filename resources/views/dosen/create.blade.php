<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-200 leading-tight">
            {{ __('Tambah Dosen') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-6" style="background-color: #C5B358;">

                {{-- Tampilkan error validasi --}}
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600 dark:text-red-400">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('dosen.store') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-6">
                        <label class="block text-black text-sm font-medium mb-2">Nama Dosen</label>
                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                            placeholder="Masukkan Nama Dosen"
                            required
                        >
                    </div>

                    {{-- Email --}}
                    <div class="mb-6">
                        <label for="email" class="block text-black text-sm font-medium mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                            placeholder="Masukkan Email Dosen"
                            required
                        >
                    </div>

                    {{-- NIDN --}}
                    <div class="mb-6">
                        <label class="block text-black text-sm font-medium mb-2">NIK / NIDN</label>
                        <input
                            type="text"
                            name="nidn"
                            value="{{ old('nidn') }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                            placeholder="Masukkan NIK / NIDN"
                            required
                        >
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-6">
                        <label class="block text-black text-sm font-medium mb-2">Jabatan</label>
                        <input
                            type="text"
                            name="jabatan"
                            value="{{ old('jabatan') }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                            placeholder="Masukkan Jabatan"
                            required
                        >
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm">
                            Save
                        </button>
                        <a href="{{ route('dosen.index') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm border border-red-700">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
