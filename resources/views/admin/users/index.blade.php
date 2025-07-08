<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guru</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 antialiased">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold rounded-md px-3 py-1 bg-white text-blue-800 shadow-md">
                Manajemen Rapat
            </a>
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-sm font-medium">Peran: <span class="font-semibold bg-blue-700 rounded-md px-2 py-1 capitalize">{{ Auth::user()->role }}</span></span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                            <span>Logout</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
        @auth
        <div class="container mx-auto mt-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('dashboard') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span>Dashboard</span>
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('users.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('users.*') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span>Guru</span>
                    </a>
                    <a href="{{ route('agendas.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('agendas.*') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                        <span>Agenda</span>
                    </a>
                    <a href="{{ route('presensi.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('presensi.index') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 15h4"/></svg>
                        <span>Presensi</span>
                    </a>
                    <a href="{{ route('notulas.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('notulas.*') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                        <span>Notula</span>
                    </a>
                    <a href="{{ route('dokumentasi.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('dokumentasi.*') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-open"><path d="M6 14.5V2a2 2 0 0 1 2-2h4l2 2h4a2 2 0 0 1 2 2v14.5A2.5 2 0 0 1 17.5 19H6a2.5 2 0 0 1-2.5-2.5V5.5L6 7z"/><path d="M10 12l2 2l4-4"/></svg>
                        <span>Dokumentasi</span>
                    </a>
                @elseif(Auth::user()->role === 'guru')
                    <a href="{{ route('agendas.guru') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('agendas.guru') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        <span>Lihat Agenda</span>
                    </a>
                    <a href="{{ route('notulas.guru') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('notulas.guru') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                        <span>Lihat Notula</span>
                    </a>
                    <a href="{{ route('dokumentasi.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition duration-300 ease-in-out text-sm {{ request()->routeIs('dokumentasi.*') ? 'bg-blue-900 text-white shadow-md' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-open"><path d="M6 14.5V2a2 2 0 0 1 2-2h4l2 2h4a2 2 0 0 1 2 2v14.5A2.5 2 0 0 1 17.5 19H6a2.5 2 0 0 1-2.5-2.5V5.5L6 7z"/><path d="M10 12l2 2l4-4"/></svg>
                        <span>Lihat Dokumentasi</span>
                    </a>
                @endif
            </div>
        </div>
        @endauth
    </nav>

    <main class="container mx-auto p-6">
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Data Guru</h1>
                <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                    Tambah Guru Baru
                </a>
            </div>

            @include('components.message')

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->nip ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data guru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
