<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#C5B358] leading-tight">
            {{ __('Daftar Pengaduan') }}
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
                @if (session('error'))
                    <div class="text-red-500 text-sm font-semibold px-4 py-2">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            {{-- Tombol Buat Pengaduan --}}
            @if (in_array(Auth::user()->role, ['mahasiswa', 'admin']))
                <div class="flex justify-between items-center px-6">
                    <a href="{{ route('pengaduan.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-white dark:bg-white border border-gray-800 dark:border-gray-200 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-800 uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        Create Pengaduan
                    </a>
                </div>
            @endif

            {{-- Tabel Pengaduan --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead style="background-color: #CFB53B;" class="text-xs uppercase text-black">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Pengaduan</th>
                                <th class="px-6 py-3">Bagian</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Waktu</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengaduans as $pengaduan)
                                <tr class="bg-black border-b border-gray-700 hover:bg-[#CFB53B33]">
                                    <td class="px-6 py-4 text-white">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">
    <a href="{{ route('pengaduan.show', $pengaduan->id) }}"
       class="font-semibold inline-flex items-center" style="color: #C5B358;">
        {{ $pengaduan->judul }}
        @if($pengaduan->tanggapan_count > 0)
            <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                {{ $pengaduan->tanggapan_count }}
            </span>
        @endif
    </a>
</td>

                                    <td class="px-6 py-4 text-white">{{ $pengaduan->bagian }}</td>
                                    <td class="px-6 py-4">
                                        @php $status = $pengaduan->status ?? 'menunggu'; @endphp
                                        <span class="@if($status === 'selesai') text-green-500 @elseif($status === 'diproses') text-yellow-500 @else text-gray-300 @endif font-semibold capitalize">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-white">{{ $pengaduan->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 space-x-2">
                                        {{-- Tombol Edit/Delete untuk Admin atau Pemilik --}}
                                        @if(Auth::user()->role === 'admin' || Auth::id() === $pengaduan->user_id)
                                            <a href="{{ route('pengaduan.edit', $pengaduan->id) }}"
                                               class="inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                                Edit
                                            </a>

                                            <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Tombol Like/Dislike untuk Mahasiswa --}}
                                        @if(Auth::user()->role === 'mahasiswa' && Auth::id() === $pengaduan->user_id && $pengaduan->tanggapan_count > 0)
                                            @if($pengaduan->status === 'selesai')
                                                <form action="{{ route('pengaduan.dislike', $pengaduan->id) }}"
                                                      method="POST"
                                                      class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                            class="px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">
                                                        Dislike
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('pengaduan.like', $pengaduan->id) }}"
                                                      method="POST"
                                                      class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                            class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                                                        Like
                                                    </button>
                                                </form>
                                            @endif
                                        @endif

                                        {{-- Tombol Tanggapi untuk Dosen dan Admin--}}
                                        @if(in_array(Auth::user()->role, ['dosen', 'admin']) && $pengaduan->status !== 'selesai')
                                            <a href="{{ route('tanggapan.create', ['pengaduanId' => $pengaduan->id]) }}"
                                               class="inline-block px-3 py-1 bg-indigo-500 text-white text-xs rounded hover:bg-indigo-600">
                                                Tanggapi
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada pengaduan.
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
