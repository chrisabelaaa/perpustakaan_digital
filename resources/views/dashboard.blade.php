<x-app-layout>
    @section('title', 'Dashboard')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
    </x-slot>

    {{-- Sapaan --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800">
            Selamat datang, {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
        </h2>
        <p class="text-sm text-gray-500 mt-0.5">
            @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                Berikut ringkasan data perpustakaan hari ini.
            @else
                Berikut ringkasan peminjaman Anda.
            @endif
        </p>
    </div>

    @if (in_array(Auth::user()->role, ['admin', 'petugas']))
        {{-- ===== ADMIN / PETUGAS DASHBOARD ===== --}}

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            {{-- Total Buku --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Buku</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBuku }}</p>
                    </div>
                    <div class="w-11 h-11 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                                     C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                     C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                                     C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

        
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalKategori }}</p>
                    </div>
                    <div class="w-11 h-11 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7
                                     a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalDipinjam }}</p>
                    </div>
                    <div class="w-11 h-11 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Anggota --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Anggota</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalAnggota }}</p>
                    </div>
                    <div class="w-11 h-11 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                                     M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                                     m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- Tabel Peminjaman Terbaru --}}
        <div class="bg-white rounded-xl border border-gray-200">

            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Peminjaman Terbaru</h2>
                    <p class="text-sm text-gray-500 mt-0.5">5 transaksi peminjaman terakhir</p>
                </div>
                <a href="{{ route('peminjaman.index') }}"
                   class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Lihat semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($peminjamanTerbaru as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3.5 text-gray-800">{{ $p->user->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-gray-800">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-gray-600">{{ $p->TanggalPeminjaman->format('d M Y') }}</td>
                                <td class="px-6 py-3.5 text-gray-600">{{ $p->TanggalPengembalian->format('d M Y') }}</td>
                                <td class="px-6 py-3.5">
                                    @if ($p->StatusPeminjaman === 'dipinjam')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Dipinjam
                                        </span>
                                    @elseif ($p->StatusPeminjaman === 'dikembalikan')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Terlambat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    @else
        {{-- ===== PEMINJAM DASHBOARD ===== --}}

        {{-- Kartu Statistik Peminjam --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">

            {{-- Sedang Dipinjam --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalDipinjam }}</p>
                    </div>
                    <div class="w-11 h-11 bg-amber-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Selesai Dikembalikan --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Selesai Dikembalikan</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalSelesai }}</p>
                    </div>
                    <div class="w-11 h-11 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- Riwayat Peminjaman Terbaru --}}
        <div class="bg-white rounded-xl border border-gray-200">

            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Riwayat Peminjaman</h2>
                    <p class="text-sm text-gray-500 mt-0.5">5 peminjaman terakhir Anda</p>
                </div>
                <a href="{{ route('peminjaman.riwayat') }}"
                   class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Lihat semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($riwayatTerbaru as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3.5 text-gray-800">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-6 py-3.5 text-gray-600">{{ $p->TanggalPeminjaman->format('d M Y') }}</td>
                                <td class="px-6 py-3.5 text-gray-600">{{ $p->TanggalPengembalian->format('d M Y') }}</td>
                                <td class="px-6 py-3.5">
                                    @if ($p->StatusPeminjaman === 'dipinjam')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Dipinjam
                                        </span>
                                    @elseif ($p->StatusPeminjaman === 'dikembalikan')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Terlambat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">
                                    Belum ada riwayat peminjaman.
                                    <a href="{{ route('peminjaman.pinjam') }}" class="text-indigo-600 hover:underline">Pinjam buku sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    @endif

</x-app-layout>
