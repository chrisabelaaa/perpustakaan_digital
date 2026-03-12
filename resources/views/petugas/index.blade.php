<x-app-layout>
    @section('title', 'Data Petugas')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Data Petugas</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Data Petugas</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-200
                    flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Daftar Petugas</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola akun petugas perpustakaan</p>
            </div>
            <a href="{{ route('petugas.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2
                      bg-indigo-600 text-white text-sm font-medium rounded-lg
                      hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4" />
                </svg>
                Tambah Petugas
            </a>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-14">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($petugas as $i => $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3.5 text-gray-500">{{ $petugas->firstItem() + $i }}</td>
                            <td class="px-6 py-3.5 font-medium text-gray-800">{{ $p->nama_lengkap }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $p->username }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $p->email }}</td>
                            <td class="px-6 py-3.5 text-gray-600 max-w-xs truncate">{{ $p->alamat }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center justify-center">
                                    <form action="{{ route('petugas.destroy', $p) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                                             M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                                             m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-400 text-sm">Belum ada data petugas.</p>
                                <a href="{{ route('petugas.create') }}"
                                   class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                    Tambah petugas pertama &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($petugas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $petugas->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
