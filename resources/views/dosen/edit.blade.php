<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Dosen') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('dosen.update', $dosen->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-6">
                        <label for="nama" class="block text-black text-sm font-medium mb-2">Nama</label>
                        <input
                            type="text"
                            name="nama"
                            id="nama"
                            value="{{ old('nama', $dosen->nama) }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                        >
                    </div>

                    {{-- Email --}}
                    <div class="mb-6">
                        <label for="email" class="block text-black text-sm font-medium mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $dosen->email) }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                        >
                    </div>

                    {{-- NIDN --}}
                    <div class="mb-6">
                        <label for="nidn" class="block text-black text-sm font-medium mb-2">NIDN</label>
                        <input
                            type="text"
                            name="nidn"
                            id="nidn"
                            value="{{ old('nidn', $dosen->nidn) }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                        >
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-6">
                        <label for="jabatan" class="block text-black text-sm font-medium mb-2">Jabatan</label>
                        <input
                            type="text"
                            name="jabatan"
                            id="jabatan"
                            value="{{ old('jabatan', $dosen->jabatan) }}"
                            class="w-full px-3 py-2 rounded-lg border border-black bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#9c8b33]"
                        >
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('dosen.index') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm border border-red-700">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 transition ease-in-out duration-150">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
