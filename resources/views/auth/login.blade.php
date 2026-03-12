<x-guest-layout>

    <h2 class="text-xl font-bold text-gray-800 mb-1">Masuk</h2>
    <p class="text-sm text-gray-500 mb-6">Masuk ke akun perpustakaan Anda</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="nama@email.com"
            >
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
                type="password"
                name="password"
                id="password"
                required
                autocomplete="current-password"
                class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Masukkan password"
            >
            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                >
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700">
                    Lupa password?
                </a>
            @endif
        </div>

        <button
            type="submit"
            class="w-full px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition"
        >
            Masuk
        </button>

        <p class="text-center text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Daftar</a>
        </p>
    </form>

</x-guest-layout>
