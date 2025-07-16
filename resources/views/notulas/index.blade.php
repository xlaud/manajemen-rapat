@extends('layouts.app')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
    
    {{-- (Header dan Form Pencarian tidak berubah) --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Manajemen Notula</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola semua notula rapat yang telah dibuat.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('notulas.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 -ml-1"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12"x2="19" y2="12"/></svg>
                Tambah Notula
            </a>
        </div>
    </div>
    <div class="py-4">
        <form action="{{ route('notulas.index') }}" method="GET" class="w-full">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
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
                            {{ $notula->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-4">
                                {{-- PERUBAHAN DI SINI --}}
                                <a href="{{ route('notulas.download', $notula->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Unduh
                                </a>
                                <a href="{{ route('notulas.edit', $notula->id) }}" class="text-green-600 hover:text-green-800">Edit</a>
                                <form action="{{ route('notulas.destroy', $notula->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus notula ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- (Bagian 'empty' tidak berubah) --}}
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- (Pagination tidak berubah) --}}
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