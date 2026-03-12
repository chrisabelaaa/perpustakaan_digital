<x-app-layout>
    @section('title', 'Tambah Petugas')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Tambah Petugas</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <a href="{{ route('petugas.index') }}" class="hover:text-gray-700">Data Petugas</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Tambah</span>
    </nav>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200">

            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-800">Formulir Petugas Baru</h2>
                <p class="text-sm text-gray-500 mt-0.5">Buat akun petugas perpustakaan baru</p>
            </div>

            <form method="POST" action="{{ route('petugas.store') }}" class="p-6 space-y-5">
                @csrf

                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_lengkap"
                        id="nama_lengkap"
                        value="{{ old('nama_lengkap') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan nama lengkap"
                    >
                    @error('nama_lengkap')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        value="{{ old('username') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan username"
                    >
                    @error('username')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan alamat email"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="alamat"
                        id="alamat"
                        rows="3"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan alamat"
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Min. 8 karakter"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm
                                   focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ulangi password"
                        >
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium
                                   rounded-lg hover:bg-indigo-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('petugas.index') }}"
                       class="px-5 py-2 bg-white text-gray-700 text-sm font-medium
                              rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
