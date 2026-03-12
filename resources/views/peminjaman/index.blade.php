<x-app-layout>
    @section('title', 'Peminjaman')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Data Peminjaman</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Peminjaman</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-200
                    flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Daftar Peminjaman</h2>
                <p class="text-sm text-gray-500 mt-0.5">Kelola seluruh transaksi peminjaman buku</p>
            </div>
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('peminjaman.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2
                          bg-indigo-600 text-white text-sm font-medium rounded-lg
                          hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Peminjaman
                </a>
            @endif
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-14">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-40">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($peminjamans as $i => $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3.5 text-gray-500">{{ $peminjamans->firstItem() + $i }}</td>
                            <td class="px-6 py-3.5 font-medium text-gray-800">{{ $p->user->nama_lengkap ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $p->buku->judul ?? '-' }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $p->TanggalPeminjaman->format('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $p->TanggalPengembalian->format('d M Y') }}</td>
                            <td class="px-6 py-3.5">
                                @if ($p->StatusPeminjaman === 'dipinjam')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full
                                                 text-xs font-medium bg-amber-100 text-amber-800">
                                        Dipinjam
                                    </span>
                                @elseif ($p->StatusPeminjaman === 'dikembalikan')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full
                                                 text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Dikembalikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full
                                                 text-xs font-medium bg-red-100 text-red-800">
                                        Terlambat
                                    </span>
                                @endif
                            </td>
                            @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center justify-center gap-1">
                                        @if ($p->StatusPeminjaman === 'dipinjam')
                                            <form action="{{ route('peminjaman.update', $p) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="StatusPeminjaman" value="dikembalikan">
                                                <button type="submit"
                                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium
                                                               text-emerald-700 bg-emerald-50 border border-emerald-200
                                                               rounded-md hover:bg-emerald-100 transition">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                        @if (Auth::user()->role === 'admin')
                                            <form action="{{ route('peminjaman.destroy', $p) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium
                                                               text-red-700 bg-red-50 border border-red-200
                                                               rounded-md hover:bg-red-100 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ in_array(Auth::user()->role, ['admin', 'petugas']) ? 7 : 6 }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    <p class="text-gray-400 text-sm">Belum ada data peminjaman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($peminjamans->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $peminjamans->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
