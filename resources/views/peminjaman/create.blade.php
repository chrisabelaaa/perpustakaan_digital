<x-app-layout>
    @section('title', 'Tambah Peminjaman')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Tambah Peminjaman</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <a href="{{ route('peminjaman.index') }}" class="hover:text-gray-700">Peminjaman</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Tambah</span>
    </nav>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200">

            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-800">Formulir Peminjaman Baru</h2>
                <p class="text-sm text-gray-500 mt-0.5">Catat transaksi peminjaman buku baru</p>
            </div>

            <form method="POST" action="{{ route('peminjaman.store') }}" class="p-6 space-y-5">
                @csrf

                {{-- Peminjam --}}
                <div>
                    <label for="UserID" class="block text-sm font-medium text-gray-700 mb-1">
                        Peminjam <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="UserID"
                        id="UserID"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">-- Pilih Peminjam --</option>
                        @foreach ($users as $user)
                            <option
                                value="{{ $user->id }}"
                                {{ old('UserID') == $user->id ? 'selected' : '' }}
                            >
                                {{ $user->nama_lengkap }} ({{ $user->username }})
                            </option>
                        @endforeach
                    </select>
                    @error('UserID')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buku --}}
                <div>
                    <label for="BukuID" class="block text-sm font-medium text-gray-700 mb-1">
                        Buku <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="BukuID"
                        id="BukuID"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($bukus as $buku)
                            <option
                                value="{{ $buku->id }}"
                                {{ old('BukuID') == $buku->id ? 'selected' : '' }}
                            >
                                {{ $buku->judul }} &mdash; {{ $buku->penulis }}
                            </option>
                        @endforeach
                    </select>
                    @error('BukuID')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="TanggalPeminjaman" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Pinjam <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="TanggalPeminjaman"
                            id="TanggalPeminjaman"
                            value="{{ old('TanggalPeminjaman', date('Y-m-d')) }}"
                            required
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        @error('TanggalPeminjaman')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="TanggalPengembalian" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Kembali <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="TanggalPengembalian"
                            id="TanggalPengembalian"
                            value="{{ old('TanggalPengembalian') }}"
                            required
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        @error('TanggalPengembalian')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium
                                   rounded-lg hover:bg-indigo-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('peminjaman.index') }}"
                       class="px-5 py-2 bg-white text-gray-700 text-sm font-medium
                              rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
