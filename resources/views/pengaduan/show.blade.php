<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-200 leading-tight">
            {{ __('Detail Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Card Utama --}}
            <div class="rounded-2xl shadow-lg p-8" style="background-color: #C5B358;">
                <div class="text-black space-y-6 text-lg space-y-3">
                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h2.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H16a2 2 0 012 2v1H2V5zM2 9h16v6a2 2 0 01-2 2H4a2 2 0 01-2-2V9z"/>
                            </svg>
                            Pengaduan
                        </h3>
                        <p>{{ $pengaduan->judul }}</p>
                    </div>

                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a1 1 0 011-1h2.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H15a1 1 0 011 1v2H4V4zM4 9h12v7a2 2 0 01-2 2H6a2 2 0 01-2-2V9z"/>
                            </svg>
                            Bagian
                        </h3>
                        <p>{{ $pengaduan->bagian }}</p>
                    </div>

                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v10a1 1 0 01-1 1h-5l-3 3v-3H4a1 1 0 01-1-1V4z"/>
                            </svg>
                            Isi Pengaduan
                        </h3>
                        <p class="whitespace-pre-line">{{ $pengaduan->isi_pengaduan }}</p>
                    </div>

                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Pengaduan Oleh
                        </h3>
                        @php
                            function mask($name) {
                                $parts = explode(' ', $name);
                                return implode(' ', array_map(fn($part) =>
                                    mb_substr($part, 0, 1) . str_repeat('*', max(mb_strlen($part) - 1, 0)), $parts));
                            }
                        @endphp
                        <p>
                            {{ Auth::user()->role !== 'mahasiswa' || Auth::id() !== $pengaduan->user_id
                                ? mask($pengaduan->user->name)
                                : $pengaduan->user->name }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3 1-1.41-2.5-2.59V8zM12 2a10 10 0 100 20 10 10 0 000-20z"/>
                            </svg>
                            Waktu Pengaduan
                        </h3>
                        <p>{{ $pengaduan->created_at->format('d M Y , H:i') }}</p>
                    </div>

                    <div>
                        <h3 class="font-bold flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11H9v4h2V7zm0 6H9v2h2v-2z"/>
                            </svg>
                            Status
                        </h3>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            {{ $pengaduan->status === 'selesai' ? 'bg-green-700 text-white' : 'bg-yellow-700 text-white' }}">
                            {{ ucfirst($pengaduan->status) }}
                        </span>
                    </div>

                    @if ($pengaduan->lampiran)
                        <div>
                            <h3 class="font-bold flex items-center gap-2">
                                <svg class="w-6 h-6 text-yellow-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 2a2 2 0 00-2 2v12a2 2 0 002 2h5.586a1 1 0 00.707-.293l2.414-2.414A1 1 0 0017 14.586V4a2 2 0 00-2-2H8z"/>
                                </svg>
                                Lampiran
                            </h3>
                            <a href="{{ asset('storage/' . $pengaduan->lampiran) }}" target="_blank" class="text-blue-800 underline hover:text-blue-900">
                                Lihat Lampiran
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tanggapan --}}
            @if($pengaduan->tanggapan->isNotEmpty())
                <div class="mt-6 p-4 bg-green-100 rounded shadow">
                    <h3 class="text-lg font-bold mb-2 text-green-800">Detail Tanggapan</h3>
                    @foreach($pengaduan->tanggapan as $tanggapan)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mt-1">
                                Ditanggapi oleh: {{ $tanggapan->user->name ?? 'Dosen' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Isi tanggapan: {{ $tanggapan->isi_tanggapan }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-6 p-4 bg-yellow-100 rounded shadow">
                    <p class="text-yellow-800">Belum ada tanggapan untuk pengaduan ini.</p>
                </div>
            @endif

            {{-- Tampilkan tombol tanggapi jika user adalah dosen/admin dan pengaduan belum selesai --}}
            @auth
                @if(in_array(Auth::user()->role, ['dosen', 'admin']) && $pengaduan->status !== 'selesai')
                    <div class="pt-2">
                        <a href="{{ route('tanggapan.create', ['pengaduanId' => $pengaduan->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md transition">
                            ✎ Beri Tanggapan
                        </a>
                    </div>
                @endif
            @endauth

            {{-- Tombol Kembali --}}
            <div class="pt-4">
                <a href="{{ route('pengaduan.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-md transition">
                    ← Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
