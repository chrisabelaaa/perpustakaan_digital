<x-app-layout>
    @section('title', 'Kategori Buku')

    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">Kategori Buku</h1>
    </x-slot>

    {{-- Breadcrumb --}}
    <nav class="mb-4 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-1">/</span>
        <span class="text-gray-800 font-medium">Kategori Buku</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Form Tambah / Edit --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200">

                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-800">
                        {{ isset($edit) ? 'Edit Kategori' : 'Tambah Kategori' }}
                    </h2>
                </div>

                <form method="POST"
                      action="{{ isset($edit) ? route('kategori.update', $edit) : route('kategori.store') }}"
                      class="p-6">
                    @csrf
                    @if (isset($edit))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama"
                            id="nama"
                            value="{{ old('nama', $edit->nama ?? '') }}"
                            required
                            class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Contoh: Fiksi, Sains, dll"
                        >
                        @error('nama')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                            {{ isset($edit) ? 'Perbarui' : 'Simpan' }}
                        </button>
                        @if (isset($edit))
                            <a href="{{ route('kategori.index') }}"
                               class="px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                                Batal
                            </a>
                        @endif
                    </div>
                </form>

            </div>
        </div>

        {{-- Tabel Kategori --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">

                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-800">Daftar Kategori</h2>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $kategoris->total() }} kategori terdaftar</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-14">No</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-28">Jumlah Buku</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($kategoris as $i => $kategori)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3.5 text-gray-500">{{ $kategoris->firstItem() + $i }}</td>
                                    <td class="px-6 py-3.5 font-medium text-gray-800">{{ $kategori->nama }}</td>
                                    <td class="px-6 py-3.5 text-center text-gray-600">{{ $kategori->bukus_count }}</td>
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('kategori.index', ['edit' => $kategori->id]) }}"
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium
                                                      text-amber-700 bg-amber-50 border border-amber-200
                                                      rounded-md hover:bg-amber-100 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($kategoris->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $kategoris->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>

</x-app-layout>
