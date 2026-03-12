<x-app-layout>
    @section('title', 'Data Buku')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Data Buku</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Data Buku</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200">

        {{-- Header Tabel --}}
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Daftar Buku</h2>
                <p class="text-sm text-gray-500 mt-0.5">Seluruh koleksi buku perpustakaan</p>
            </div>
            @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                <a href="{{ route('buku.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Buku
                </a>
            @endif
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-14">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Cover</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Penerbit</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Tahun</th>
                        @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-32">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($bukus as $i => $buku)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3.5 text-gray-500">{{ $bukus->firstItem() + $i }}</td>
                            <td class="px-6 py-3.5">
                                @if ($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}"
                                         alt="Cover"
                                         class="w-10 h-14 object-cover rounded border border-gray-200">
                                @else
                                    <div class="w-10 h-14 bg-gray-100 rounded border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 font-medium text-gray-800">{{ $buku->judul }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $buku->penulis }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $buku->penerbit }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $buku->tahun_terbit }}</td>
                            @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('buku.edit', $buku) }}"
                                           class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium
                                                  text-amber-700 bg-amber-50 border border-amber-200
                                                  rounded-md hover:bg-amber-100 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('buku.destroy', $buku) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium
                                                           text-red-700 bg-red-50 border border-red-200
                                                           rounded-md hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ in_array(Auth::user()->role, ['admin', 'petugas']) ? 7 : 6 }}" class="px-6 py-14 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                                             C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                             C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                                             C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="text-gray-400 text-sm">Belum ada data buku.</p>
                                @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                                    <a href="{{ route('buku.create') }}"
                                       class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                        Tambah buku pertama &rarr;
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($bukus->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bukus->links() }}
            </div>
        @endif

    </div>

</x-app-layout>