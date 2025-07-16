<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Rapat Guru</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.10/css/dataTables.tailwindcss.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB; /* bg-gray-50 */
        }
        .nav-link {
            position: relative;
            transition: color 0.3s ease-in-out;
            padding-bottom: 8px;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: #FFFFFF;
            transition: width 0.3s ease-in-out;
        }
        .nav-link.active {
            color: #FFFFFF;
        }
        .nav-link:hover {
            color: #FFFFFF;
        }
        .nav-link.active::after,
        .nav-link:hover::after {
            width: 60%;
        }
    </style>
</head>
<body class="antialiased">
    <div id="app" class="flex flex-col min-h-screen">
        
        {{-- Header/Navbar --}}
        <header class="bg-green-700 sticky top-0 z-50 shadow-lg">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    
                    {{-- Logo dan Navigasi Utama --}}
                    <div class="flex items-center space-x-8">
                        {{-- Logo --}}
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center space-x-3">
                            <img class="h-10 w-auto" src="https://placehold.co/40x40/FFFFFF/15803D?text=SMR" alt="Logo">
                            <span class="text-xl font-bold text-white hidden sm:inline">Manajemen Rapat</span>
                        </a>

                        {{-- Navigasi Links --}}
                        <nav class="hidden md:flex items-center space-x-6">
                            <a href="{{ route('dashboard') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('dashboard') ? 'active font-semibold' : '' }}">
                                Dashboard
                            </a>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('users.index') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('users.*') ? 'active font-semibold' : '' }}">Guru</a>
                                <a href="{{ route('agendas.index') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('agendas.*') ? 'active font-semibold' : '' }}">Agenda</a>
                                <a href="{{ route('presensi.index') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('presensi.index') ? 'active font-semibold' : '' }}">Presensi</a>
                                <a href="{{ route('notulas.index') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('notulas.*') ? 'active font-semibold' : '' }}">Notula</a>
                                <a href="{{ route('dokumentasi.index') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('dokumentasi.*') ? 'active font-semibold' : '' }}">Dokumentasi</a>
                            @elseif(Auth::user()->role === 'guru')
                                <a href="{{ route('agendas.guru') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('agendas.guru') ? 'active font-semibold' : '' }}">Lihat Agenda</a>
                                <a href="{{ route('notulas.guru') }}" class="nav-link text-sm font-medium text-green-200 {{ request()->routeIs('notulas.guru') ? 'active font-semibold' : '' }}">Lihat Notula</a>
                            @endif
                        </nav>
                    </div>
                    
                    {{-- Aksi Pengguna (Kanan) --}}
                    <div class="flex items-center space-x-6">
                        {{-- Informasi Peran Pengguna --}}
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse"></span>
                            <span class="text-sm font-semibold text-white capitalize">
                                {{ Auth::user()->role }}
                            </span>
                        </div>

                        {{-- Tombol Logout --}}
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-green-200 hover:text-white transition-colors flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
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
