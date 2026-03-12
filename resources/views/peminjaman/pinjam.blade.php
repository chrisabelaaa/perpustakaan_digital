<x-app-layout>
    @section('title', 'Pinjam Buku')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Pinjam Buku</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Pinjam Buku</span>
    </nav>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200">

            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-800">Formulir Peminjaman</h2>
                <p class="text-sm text-gray-500 mt-0.5">Pilih buku yang ingin kamu pinjam</p>
            </div>

            <form method="POST" action="{{ route('peminjaman.storePinjam') }}" class="p-6 space-y-5">
                @csrf

                {{-- Buku --}}
                <div>
                    <label for="BukuID" class="block text-sm font-medium text-gray-700 mb-1">
                        Pilih Buku <span class="text-red-500">*</span>
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

                {{-- Tanggal Kembali --}}
                <div>
                    <label for="TanggalPengembalian" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Pengembalian <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="TanggalPengembalian"
                        id="TanggalPengembalian"
                        value="{{ old('TanggalPengembalian') }}"
                        required
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('TanggalPengembalian')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium
                                   rounded-lg hover:bg-indigo-700 transition">
                        Pinjam
                    </button>
                    <a href="{{ route('buku.index') }}"
                       class="px-5 py-2 bg-white text-gray-700 text-sm font-medium
                              rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
