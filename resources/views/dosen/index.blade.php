<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#C5B358] leading-tight">
            {{ __('Data Dosen') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Tombol Tambah + Flash Message --}}
            <div class="flex justify-between items-center px-6">
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('dosen.create') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-white border border-gray-800 dark:border-gray-200 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-800 uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        Add Dosen
                    </a>
                @endif

                @if (session('success'))
                    <div class="text-green-600 dark:text-green-400 text-sm font-semibold px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-white">
                        <thead style="background-color: #CFB53B;" class="text-xs uppercase text-black">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Nama Dosen</th>
                                <th class="px-6 py-3">NIK / NIDN</th>
                                <th class="px-6 py-3">Jabatan</th>
                                <th class="px-6 py-3">Email</th>
                                @if (Auth::user()->role === 'admin')
                                    <th class="px-6 py-3">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dosens as $dosen)
                                <tr class="bg-black border-b border-gray-700 hover:bg-[#CFB53B33]">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-semibold" style="color: #CFB53B;">{{ $dosen->nama }}</td>
                                    <td class="px-6 py-4">{{ $dosen->nidn }}</td>
                                    <td class="px-6 py-4">{{ $dosen->jabatan }}</td>
                                    <td class="px-6 py-4">{{ $dosen->user->email }}</td>
                                    @if (Auth::user()->role === 'admin')
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('dosen.edit', $dosen->id) }}"
                                                   class="inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                                    Edit
                                                </a>
                                                <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus dosen ini?')"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 bg-red-700 text-white text-xs font-semibold rounded-md hover:bg-red-800 transition duration-150">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr class="bg-black">
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                        Tidak ada data dosen.
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
