<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-200 leading-tight">
            {{ __('Detail Tanggapan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php
                function mask($name) {
                    $parts = explode(' ', $name);
                    return implode(' ', array_map(fn($part) =>
                        mb_substr($part, 0, 1) . str_repeat('*', max(mb_strlen($part) - 1, 0)), $parts));
                }
            @endphp

            {{-- Card Utama --}}
            <div class="rounded-2xl shadow-lg p-8" style="background-color: #C5B358;">
                <div class="text-black text-lg space-y-6">

                    {{-- Status --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11H9v4h2V7zm0 6H9v2h2v-2z"/></svg>
                            Status
                        </h3>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            {{ $tanggapan->pengaduan->status === 'selesai' ? 'bg-green-700 text-white' : 'bg-yellow-700 text-white' }}">
                            {{ ucfirst($tanggapan->pengaduan->status) }}
                        </span>
                    </div>

                    {{-- Judul Pengaduan --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h2.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H16a2 2 0 012 2v1H2V5zM2 9h16v6a2 2 0 01-2 2H4a2 2 0 01-2-2V9z"/>
                            </svg>
                            Pengaduan
                        </h3>
                        <p>{{ $tanggapan->pengaduan->judul }}</p>
                    </div>

                    {{-- Bagian --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a1 1 0 011-1h2.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H15a1 1 0 011 1v2H4V4zM4 9h12v7a2 2 0 01-2 2H6a2 2 0 01-2-2V9z"/>
                            </svg>
                            Bagian
                        </h3>
                        <p>{{ $tanggapan->pengaduan->bagian }}</p>
                    </div>

                    {{-- Isi Pengaduan --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a1 1 0 011-1h2.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H15a1 1 0 011 1v2H4V4zM4 9h12v7a2 2 0 01-2 2H6a2 2 0 01-2-2V9z"/>
                            </svg>
                            Isi Pengaduan
                        </h3>
                        <p>{{ $tanggapan->pengaduan->isi_pengaduan }}</p>
                    </div>

                    {{-- Pengaduan Oleh (Anonimkan jika mahasiswa dan bukan pemilik pengaduan) --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Pengaduan Oleh
                        </h3>
                        <p>
                            @php
                                $pengaduUser = $tanggapan->pengaduan->user;
                                $shouldMask = $pengaduUser->role === 'mahasiswa' && Auth::id() !== $pengaduUser->id;
                            @endphp

                            {{ $shouldMask ? mask($pengaduUser->name) : $pengaduUser->name }}
                        </p>
                    </div>

                    {{-- Waktu Pengaduan --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3 1-1.41-2.5-2.59V8zM12 2a10 10 0 100 20 10 10 0 000-20z"/>
                            </svg>
                            Waktu Pengaduan
                        </h3>
                        <p>{{ $tanggapan->pengaduan->created_at->format('d M Y , H:i') }}</p>
                    </div>

                    {{-- Tanggapan --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v10a1 1 0 01-1 1h-5l-3 3v-3H4a1 1 0 01-1-1V4z"/>
                            </svg>
                            Tanggapan
                        </h3>
                        <p class="whitespace-pre-line">{{ $tanggapan->isi_tanggapan }}</p>
                    </div>

                    {{-- Ditanggapi Oleh (TIDAK anonim) --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Ditanggapi Oleh
                        </h3>
                        <p>{{ $tanggapan->user->name ?? '-' }}</p>
                    </div>

                    {{-- Waktu Tanggapan --}}
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3 1-1.41-2.5-2.59V8zM12 2a10 10 0 100 20 10 10 0 000-20z"/>
                            </svg>
                            Waktu Tanggapan
                        </h3>
                        <p>{{ $tanggapan->updated_at->format('d M Y , H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Kembali --}}
            <div class="pt-4">
                <a href="{{ route('tanggapan.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-md transition">
                    ← Kembali ke Daftar
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
