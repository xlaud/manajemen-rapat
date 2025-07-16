@extends('layouts.app')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
    
    {{-- Header dan Aksi --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Dokumentasi Rapat</h1>
            <p class="mt-1 text-sm text-gray-500">Galeri foto dari berbagai kegiatan rapat.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('dokumentasi.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 -ml-1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Unggah Foto
            </a>
        </div>
    </div>

    {{-- Filter dan Pencarian --}}
    <div class="py-4">
        <form action="{{ route('dokumentasi.index') }}" method="GET" class="w-full">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
                <input 
                    type="search" 
                    name="search" 
                    placeholder="Cari berdasarkan caption atau nama agenda..." 
                    class="block w-full py-2.5 pl-10 pr-3 text-gray-900 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Galeri Dokumentasi --}}
    @if($dokumentasis->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($dokumentasis as $dokumentasi)
                <div class="group relative block bg-black rounded-xl overflow-hidden">
                    <a href="{{ route('dokumentasi.show', $dokumentasi->id) }}">
                        @php
                            $images = json_decode($dokumentasi->image_path, true);
                            $thumbnail = $images[0] ?? 'https://placehold.co/600x400/E2E8F0/4A5568?text=No+Image';
                        @endphp
                        <img src="{{ asset('storage/' . $thumbnail) }}" 
                             alt="{{ $dokumentasi->caption ?? 'Dokumentasi Rapat' }}" 
                             class="w-full h-64 object-cover transform transition-transform duration-300 ease-in-out group-hover:scale-110 group-hover:opacity-50">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <p class="font-bold text-lg leading-tight">{{ $dokumentasi->caption ?? 'Tanpa caption' }}</p>
                            <p class="text-xs text-gray-300 mt-1">
                                {{ $dokumentasi->agenda->title ?? 'N/A' }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mx-auto mb-2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <p class="font-semibold text-gray-600">Galeri Kosong</p>
            <p class="text-sm text-gray-500">Tidak ada dokumentasi yang cocok dengan pencarian Anda.</p>
        </div>
    @endif

    {{-- Link Pagination --}}
    <div class="mt-8">
        {{ $dokumentasis->appends(request()->query())->links() }}
    </div>
</div>
@endsection
