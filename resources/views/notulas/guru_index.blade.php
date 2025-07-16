@extends('layouts.app')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
    
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Daftar Notula Rapat</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat semua notula rapat yang telah dipublikasikan.</p>
        </div>
    </div>

    {{-- Filter dan Pencarian --}}
    <div class="py-4">
        <form action="{{ route('notulas.guru') }}" method="GET" class="w-full">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
                <input 
                    type="search" 
                    name="search" 
                    placeholder="Cari notula atau nama agenda..." 
                    class="block w-full py-2.5 pl-10 pr-3 text-gray-900 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Tabel Data Notula --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Notula</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agenda Terkait</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($notulas as $index => $notula)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $notulas->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $notula->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($notula->description, 40) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $notula->agenda->title ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $notula->created_at->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('notulas.guru.show', $notula->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 text-xs font-medium rounded-md hover:bg-green-200 transition-colors">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mb-2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <p class="font-semibold">Tidak ada data notula</p>
                                <p>Saat ini belum ada notula yang dipublikasikan.</p>
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
            Menampilkan <span class="font-medium">{{ $notulas->firstItem() }}</span> sampai <span class="font-medium">{{ $notulas->lastItem() }}</span> dari <span class="font-medium">{{ $notulas->total() }}</span> hasil
        </div>
        <div>
            {{ $notulas->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
