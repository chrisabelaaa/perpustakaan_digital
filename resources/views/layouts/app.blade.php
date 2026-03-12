<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Perpustakaan') }} &mdash; @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">

        {{-- Overlay Mobile --}}
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-black/40 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        {{-- ==================== SIDEBAR ==================== --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200
                   transform transition-transform duration-200 ease-in-out
                   lg:translate-x-0 lg:static lg:inset-auto lg:z-auto
                   flex flex-col"
        >
            {{-- Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-gray-200 shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                                     C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                     C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                                     C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-800">Perpustakaan</span>
                </a>
            </div>

            {{-- Menu Navigasi --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

                <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Menu Utama
                </p>

                @php
                    $menu = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'match' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1'],
                        ['route' => 'buku.index', 'label' => 'Data Buku', 'match' => 'buku.*', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ];
                @endphp

                @foreach ($menu as $item)
                    @php $active = request()->routeIs($item['match']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition
                              {{ $active ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 {{ $active ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach

                {{-- Peminjam: menu khusus --}}
                @if (Auth::user()->role === 'peminjam')
                    <p class="px-3 mt-6 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Peminjaman
                    </p>

                    @php $activePinjam = request()->routeIs('peminjaman.pinjam'); @endphp
                    <a href="{{ route('peminjaman.pinjam') }}"
                       class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition
                              {{ $activePinjam ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 {{ $activePinjam ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Pinjam Buku
                    </a>

                    @php $activeRiwayat = request()->routeIs('peminjaman.riwayat'); @endphp
                    <a href="{{ route('peminjaman.riwayat') }}"
                       class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition
                              {{ $activeRiwayat ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 {{ $activeRiwayat ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Riwayat Saya
                    </a>
                @endif

                {{-- Admin & Petugas: menu kelola data --}}
                @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                    <p class="px-3 mt-6 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Kelola Data
                    </p>

                    @php
                        $kelola = [
                            ['route' => 'kategori.index',   'label' => 'Kategori Buku',  'match' => 'kategori.*',   'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z'],
                            ['route' => 'peminjaman.index', 'label' => 'Peminjaman',     'match' => 'peminjaman.index|peminjaman.create', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                        ];
                    @endphp

                    @foreach ($kelola as $item)
                        @php $active = request()->routeIs($item['match']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition
                                  {{ $active ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 {{ $active ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                @endif

                {{-- Admin only --}}
                @if (Auth::user()->role === 'admin')
                    <p class="px-3 mt-6 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Admin
                    </p>

                    @php $activePetugas = request()->routeIs('petugas.*'); @endphp
                    <a href="{{ route('petugas.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition
                              {{ $activePetugas ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 {{ $activePetugas ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Data Petugas
                    </a>
                @endif

            </nav>

            {{-- Info User --}}
            <div class="border-t border-gray-200 p-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-sm font-semibold text-indigo-600">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->username, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">
                            {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
                        </p>
                        <p class="text-xs text-gray-500 truncate capitalize">
                            {{ Auth::user()->role }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ==================== MAIN ==================== --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top Bar --}}
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0">

                <div class="flex items-center gap-3">
                    {{-- Burger Button (Mobile) --}}
                    <button
                        @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden inline-flex items-center justify-center w-10 h-10
                               rounded-lg border border-gray-200 bg-gray-50
                               text-gray-600 hover:bg-gray-100 hover:text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               transition"
                        aria-label="Toggle navigasi"
                    >
                        <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="sidebarOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    {{-- Logo (Mobile — karena sidebar tersembunyi) --}}
                    <a href="{{ route('dashboard') }}"
                       class="lg:hidden flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                                         C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                         C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                                         C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-base font-bold text-gray-800 hidden sm:inline">Perpustakaan</span>
                    </a>

                    {{-- Separator --}}
                    <div class="hidden lg:block w-px h-6 bg-gray-200"></div>

                    {{-- Page Title --}}
                    @isset($header)
                        <div class="hidden sm:block">{{ $header }}</div>
                    @endisset
                </div>

                {{-- Right: Dropdown User --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-sm text-gray-600
                                       hover:text-gray-800 transition">
                            <div class="w-8 h-8 rounded-full bg-indigo-100
                                        flex items-center justify-center">
                                <span class="text-xs font-semibold text-indigo-600">
                                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->username, 0, 1)) }}
                                </span>
                            </div>
                            <span class="hidden sm:inline font-medium">
                                {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
                            </span>
                            <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil Saya
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                            >
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </header>

            {{-- Notifikasi Flash --}}
            @if (session('success'))
                <div class="mx-6 mt-4">
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Konten Halaman --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>
</html>
