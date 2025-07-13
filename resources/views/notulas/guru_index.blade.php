@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Notula Rapat</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat semua notula rapat yang telah dipublikasikan.</p>
        </div>
    </div>

    {{-- Pencarian Notula --}}
    <div class="mt-4">
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
                    class="block w-full py-2 pl-10 pr-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Daftar Notula dalam bentuk Card --}}
    <div class="space-y-4">
        @forelse ($notulas as $notula)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $notula->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Agenda: {{ $notula->agenda->title ?? 'N/A' }}
                            </p>
                        </div>
                        <a href="{{ route('notulas.guru.show', $notula->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300">
                            Lihat Detail
                        </a>
                    </div>
                    <p class="mt-4 text-gray-600">
                        {{ Str::limit($notula->description, 200) }}
                    </p>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <p class="text-gray-500">Tidak ada data notula yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $notulas->links() }}
    </div>
</div>
@endsection
