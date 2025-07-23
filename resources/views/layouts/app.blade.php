<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Rapat Guru</title>

    <link rel="icon" href="{{ asset('images/logo-smp.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.10/css/dataTables.tailwindcss.css">

    {{-- AlpineJS untuk interaktivitas dropdown --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
        }
    </style>
</head>

<body class="antialiased">
    <div id="app" class="flex flex-col min-h-screen">

        {{-- Header/Navbar dengan state untuk menu mobile & user --}}
        <header x-data="{ userMenuOpen: false, mobileMenuOpen: false }"
            class="bg-green-700/80 backdrop-blur-lg sticky top-0 z-50 shadow-lg border-b border-green-600/30">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">

                    {{-- [KIRI] Logo & Navigasi Desktop --}}
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center space-x-3">
                            <img class="h-10 w-auto" src="{{ asset('images/logo-smp.png') }}"
                                alt="Logo SMPN 3 Mojosongo">

                            <span class="text-xl font-bold text-white hidden sm:inline">SMPN 3 Mojosongo</span>
                        </a>
                        {{-- Navigasi Links Desktop --}}
                        <nav class="hidden md:flex items-center space-x-2">
                            @php
                                $navLinkClasses =
                                    'px-3 py-2 rounded-md text-sm font-medium text-green-200 hover:bg-green-600 hover:text-white transition-colors duration-200';
                                $activeLinkClasses = 'bg-green-600 text-white font-semibold';
                            @endphp

                            <a href="{{ route('dashboard') }}"
                                class="{{ $navLinkClasses }} {{ request()->routeIs('dashboard') ? $activeLinkClasses : '' }}">Dashboard</a>
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('users.index') }}"
                                    class="{{ $navLinkClasses }} {{ request()->routeIs('users.*') ? $activeLinkClasses : '' }}">Guru</a>
                                <a href="{{ route('agendas.index') }}"
                                    class="{{ $navLinkClasses }} {{ request()->routeIs('agendas.*') ? $activeLinkClasses : '' }}">Agenda</a>
                                <a href="{{ route('presensi.index') }}"
                                    class="{{ $navLinkClasses }} {{ request()->routeIs('presensi.*') ? $activeLinkClasses : '' }}">Presensi</a>
                                <a href="{{ route('notulas.index') }}"
                                    class="{{ $navLinkClasses }} {{ request()->routeIs('notulas.*') ? $activeLinkClasses : '' }}">Notula</a>
                                <a href="{{ route('dokumentasi.index') }}"
                                    class="{{ $navLinkClasses }} {{ request()->routeIs('dokumentasi.*') ? $activeLinkClasses : '' }}">Dokumentasi</a>
                            @elseif(Auth::user()->role === 'guru')
                                <a href="{{ route('agendas.guru') }}"
                                    class="{{ $navLinkClasses }} {{ request()->routeIs('agendas.guru') ? $activeLinkClasses : '' }}">Lihat
                                    Agenda</a>
                                <a href="{{ route('notulas.guru') }}"
                                    class="{{ $navLinkClasses }} {{ request()->routeIs('notulas.guru') ? $activeLinkClasses : '' }}">Lihat
                                    Notula</a>
                            @endif
                        </nav>
                    </div>

                    {{-- [KANAN] Menu Dropdown User & Tombol Hamburger --}}
                    <div class="flex items-center">
                        {{-- Menu Dropdown Pengguna --}}
                        <div @click.away="userMenuOpen = false" class="relative">
                            <button @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center space-x-2 text-white bg-green-600/50 hover:bg-green-600 px-3 py-2 rounded-lg transition-colors">
                                <span class="text-sm font-semibold capitalize">{{ Auth::user()->role }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" class="transition-transform"
                                    :class="{ 'rotate-180': userMenuOpen }">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div x-show="userMenuOpen" x-transition
                                class="absolute right-0 mt-2 w-56 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                style="display: none;">
                                <div class="py-1">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm text-gray-800 font-semibold">Halo, {{ Auth::user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                            <path d="m9 12 2 2 4-4" />
                                        </svg>
                                        <span>Ubah Password</span>
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" class="w-full"> @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:font-semibold flex items-center space-x-2 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                                <polyline points="16 17 21 12 16 7" />
                                                <line x1="21" x2="9" y1="12" y2="12" />
                                            </svg>
                                            <span>Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Hamburger (Hanya Tampil di Mobile) --}}
                        <div class="ml-2 md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen"
                                class="inline-flex items-center justify-center p-2 rounded-md text-green-200 hover:text-white hover:bg-green-600 focus:outline-none focus:bg-green-600 transition">
                                <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" class="h-6 w-6"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <svg :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="h-6 w-6"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Menu Mobile --}}
            <div x-show="mobileMenuOpen" x-transition class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-green-700">
                    @php
                        $mobileNavLinkClasses =
                            'block px-3 py-2 rounded-md text-base font-medium text-green-200 hover:text-white hover:bg-green-600 transition-colors';
                        $mobileActiveLinkClasses = 'bg-green-800 text-white';
                    @endphp

                    <a href="{{ route('dashboard') }}"
                        class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('dashboard') ? $mobileActiveLinkClasses : '' }}">Dashboard</a>
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('users.index') }}"
                            class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('users.*') ? $mobileActiveLinkClasses : '' }}">Guru</a>
                        <a href="{{ route('agendas.index') }}"
                            class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('agendas.*') ? $mobileActiveLinkClasses : '' }}">Agenda</a>
                        <a href="{{ route('presensi.index') }}"
                            class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('presensi.*') ? $mobileActiveLinkClasses : '' }}">Presensi</a>
                        <a href="{{ route('notulas.index') }}"
                            class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('notulas.*') ? $mobileActiveLinkClasses : '' }}">Notula</a>
                        <a href="{{ route('dokumentasi.index') }}"
                            class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('dokumentasi.*') ? $mobileActiveLinkClasses : '' }}">Dokumentasi</a>
                    @elseif(Auth::user()->role === 'guru')
                        <a href="{{ route('agendas.guru') }}"
                            class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('agendas.guru') ? $mobileActiveLinkClasses : '' }}">Lihat
                            Agenda</a>
                        <a href="{{ route('notulas.guru') }}"
                            class="{{ $mobileNavLinkClasses }} {{ request()->routeIs('notulas.guru') ? $mobileActiveLinkClasses : '' }}">Lihat
                            Notula</a>
                    @endif
                </div>
            </div>
        </header>

        <main class="flex-grow">
            <div class="container mx-auto p-4 sm:p-6 lg:p-8">
                <x-message type="success" />
                <x-message type="error" />
                @yield('content')
            </div>
        </main>

        <footer class="bg-white border-t border-gray-200 mt-8">
            <div class="container mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Sistem Manajemen Rapat SMPN 3 Mojosongo. All rights reserved.
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.10/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.10/js/dataTables.tailwindcss.js"></script>
    @stack('scripts')
</body>

</html>
