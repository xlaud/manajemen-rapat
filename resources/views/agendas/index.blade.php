@extends('layouts.app')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
    
    {{-- Header dan Aksi --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Daftar Agenda Rapat</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola, cari, dan lihat semua agenda yang terjadwal.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('agendas.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 -ml-1"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12"x2="19" y2="12"/></svg>
                Tambah Agenda
            </a>
        </div>
    </div>

    {{-- Filter dan Pencarian --}}
    <div class="py-4">
        <form action="{{ route('agendas.index') }}" method="GET" class="w-full">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
                <input 
                    type="search" 
                    name="search" 
                    placeholder="Cari agenda berdasarkan judul..." 
                    class="block w-full py-2.5 pl-10 pr-3 text-gray-900 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Tabel Data Agenda --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Agenda</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($agendas as $index => $agenda)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $agendas->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $agenda->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($agenda->description, 40) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') }}</div>
                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($agenda->meeting_time)->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $agenda->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-4">
                                <a href="{{ route('agendas.edit', $agenda) }}" class="text-green-600 hover:text-green-800">Edit</a>
                                <form action="{{ route('agendas.destroy', $agenda) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mb-2"><path d="M21.54 15.64c.52-.39.81-1.03.81-1.74 0-2.3-2.42-3.41-4.43-2.39-1.39.7-3.32.32-4.03-1.12-1.2-2.34-4.23-2.34-5.43 0-1.28 2.4-3.7.8-4.03-1.12C2.42 8.5 0 9.61 0 11.9c0 .71.3 1.35.81 1.74.52.39 1.16.56 1.8.56h16.78c.64 0 1.28-.17 1.8-.56z"/><path d="M6.35 18.35c.38-.38.38-1.02 0-1.4-.38-.38-1.02-.38-1.4 0-.38.38-.38 1.02 0 1.4.38.38 1.02.38 1.4 0zm12.7-1.4c-.38-.38-1.02-.38-1.4 0-.38.38-.38 1.02 0 1.4.38.38 1.02.38 1.4 0 .38-.38.38-1.02 0-1.4zM12 19.4c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/></svg>
                                <p class="font-semibold">Tidak ada data agenda</p>
                                <p>Silakan buat agenda baru untuk memulai.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination --}}
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between">
        <div class="text-sm text-gray-700 mb-4 sm:mb-0">
            Menampilkan <span class="font-medium">{{ $agendas->firstItem() }}</span> sampai <span class="font-medium">{{ $agendas->lastItem() }}</span> dari <span class="font-medium">{{ $agendas->total() }}</span> hasil
        </div>
        <div>
            {{ $agendas->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
