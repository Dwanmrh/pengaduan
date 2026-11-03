<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#C5B358] leading-tight">
            {{ __('Daftar Tanggapan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Flash Message --}}
            <div class="flex justify-end px-6">
                @if (session('success'))
                    <div class="text-green-600 dark:text-green-400 text-sm font-semibold px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead style="background-color: #CFB53B;" class="text-xs uppercase text-black">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Tanggapan</th>
                                <th class="px-6 py-3">Bagian</th>
                                <th class="px-6 py-3">Ditanggapi Oleh</th>
                                <th class="px-6 py-3">Waktu</th>
                                <th class="px-6 py-3">Status</th>
                                @if (in_array(Auth::user()->role, ['admin', 'dosen']))
                                    <th class="px-6 py-3">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tanggapans as $tanggapan)
                                <tr class="bg-black border-b border-gray-700 hover:bg-[#CFB53B33]">
                                    <td class="px-6 py-4 text-white">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tanggapan.show', $tanggapan->id) }}"
                                           class="font-semibold" style="color: #C5B358;">
                                            {{ $tanggapan->pengaduan->judul }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-white">{{ $tanggapan->pengaduan->bagian }}</td>
                                    <td class="px-6 py-4 text-white">{{ $tanggapan->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-white">{{ $tanggapan->updated_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $status = $tanggapan->pengaduan->status;
                                        @endphp
                                        <span class="@if($status === 'selesai') text-green-500 @elseif($status === 'diproses') text-yellow-500 @else text-gray-300 @endif font-semibold capitalize">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    @if (in_array(Auth::user()->role, ['admin', 'dosen']))
                                        <td class="px-6 py-4 space-x-2">
                                        @if (Auth::user()->role === 'admin' || $tanggapan->user_id === Auth::id())
                                            <a href="{{ route('tanggapan.edit', $tanggapan->id) }}"
                                               class="inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                                Edit
                                            </a>

                                            <form action="{{ route('tanggapan.destroy', $tanggapan->id) }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Yakin ingin menghapus tanggapan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-xs">-</span>
                                        @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data tanggapan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
