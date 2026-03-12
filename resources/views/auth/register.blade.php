<x-guest-layout>

    <h2 class="text-xl font-bold text-gray-800 mb-1">Buat Akun</h2>
    <p class="text-sm text-gray-500 mb-6">Daftarkan diri Anda sebagai anggota perpustakaan</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="nama_lengkap"
                id="nama_lengkap"
                value="{{ old('nama_lengkap') }}"
                required
                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Masukkan nama lengkap"
            >
            @error('nama_lengkap') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="username"
                id="username"
                value="{{ old('username') }}"
                required
                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Masukkan username"
            >
            @error('username') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="nama@email.com"
            >
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="alamat"
                id="alamat"
                value="{{ old('alamat') }}"
                required
                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Masukkan alamat"
            >
            @error('alamat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Min. 8 karakter"
                >
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Ulangi password"
                >
            </div>
        </div>

        <button
            type="submit"
            class="w-full px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition"
        >
            Daftar
        </button>

        <p class="text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Masuk</a>
        </p>
    </form>

</x-guest-layout>