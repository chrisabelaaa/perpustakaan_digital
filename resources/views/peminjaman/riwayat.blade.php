<x-app-layout>
    @section('title', 'Riwayat Peminjaman')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Riwayat Peminjaman Saya</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Riwayat Peminjaman</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-200
                    flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-base font-semibold text-gray-800">Peminjaman Saya</h2>
                <p class="text-sm text-gray-500 mt-0.5">Riwayat buku yang pernah kamu pinjam</p>
            </div>
            <a href="{{ route('peminjaman.pinjam') }}"
               class="inline-flex items-center gap-2 px-4 py-2
                      bg-indigo-600 text-white text-sm font-medium rounded-lg
                      hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4" />
                </svg>
                Pinjam Buku
            </a>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-14">No</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($peminjamans as $i => $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3.5 text-gray-500">{{ $peminjamans->firstItem() + $i }}</td>
                            <td class="px-6 py-3.5 font-medium text-gray-800">{{ $p->buku->judul ?? '-' }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                                                 C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                                 C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                                                 C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-gray-400 text-sm">Belum ada riwayat peminjaman.</p>
                                    <a href="{{ route('peminjaman.pinjam') }}"
                                       class="mt-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                        Pinjam buku sekarang &rarr;
                                    </a>
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
