<x-app-layout>
    @section('title', 'Tambah Buku')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Tambah Buku</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <a href="{{ route('buku.index') }}" class="hover:text-gray-700">Data Buku</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Tambah</span>
    </nav>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200">

            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-800">Formulir Buku Baru</h2>
                <p class="text-sm text-gray-500 mt-0.5">Isi data buku yang akan ditambahkan ke perpustakaan</p>
            </div>

            <form method="POST" action="{{ route('buku.store') }}" class="p-6 space-y-5" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                        Judul Buku <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="judul"
                        id="judul"
                        value="{{ old('judul') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan judul buku"
                    >
                    @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="penulis" class="block text-sm font-medium text-gray-700 mb-1">
                        Penulis <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="penulis"
                        id="penulis"
                        value="{{ old('penulis') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan nama penulis"
                    >
                    @error('penulis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1">
                        Penerbit <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="penerbit"
                        id="penerbit"
                        value="{{ old('penerbit') }}"
                        required
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan nama penerbit"
                    >
                    @error('penerbit') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tahun_terbit" class="block text-sm font-medium text-gray-700 mb-1">
                        Tahun Terbit <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="tahun_terbit"
                        id="tahun_terbit"
                        value="{{ old('tahun_terbit') }}"
                        required
                        min="1900"
                        max="{{ date('Y') }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Contoh: 2024"
                    >
                    @error('tahun_terbit') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="cover" class="block text-sm font-medium text-gray-700 mb-1">
                        Cover Buku
                    </label>
                    <input
                        type="file"
                        name="cover"
                        id="cover"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                               file:rounded-lg file:border-0 file:text-sm file:font-medium
                               file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                               border border-gray-300 rounded-lg cursor-pointer"
                    >
                    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, WEBP. Maks 2MB</p>
                    @error('cover') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Buku
                    </label>
                    @if ($kategoris->isEmpty())
                        <p class="text-sm text-gray-400">Belum ada kategori. <a href="{{ route('kategori.index') }}" class="text-indigo-600 hover:underline">Tambah kategori</a></p>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach ($kategoris as $kategori)
                                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200
                                              hover:bg-gray-50 cursor-pointer transition text-sm">
                                    <input
                                        type="checkbox"
                                        name="kategori_ids[]"
                                        value="{{ $kategori->id }}"
                                        {{ in_array($kategori->id, old('kategori_ids', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                    <span class="text-gray-700">{{ $kategori->nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    @error('kategori_ids')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('buku.index') }}"
                       class="px-5 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>

</x-app-layout>