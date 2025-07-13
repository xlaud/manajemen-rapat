@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dokumentasi Rapat</h1>
            <p class="mt-1 text-sm text-gray-500">Galeri foto dari berbagai kegiatan rapat.</p>
        </div>
        
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('dokumentasi.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-up mr-2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 11V3"/><path d="m18 8-6-6-6 6"/></svg>
                <span>Unggah Dokumentasi</span>
            </a>
        </div>
    </div>

    {{-- Form Pencarian --}}
    <div class="mt-4">
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
                    class="block w-full py-2 pl-10 pr-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Galeri Dokumentasi --}}
    @if($dokumentasis->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($dokumentasis as $dokumentasi)
                <a href="{{ route('dokumentasi.show', $dokumentasi->id) }}" class="bg-white rounded-lg shadow-lg overflow-hidden group relative transition-all duration-300 hover:shadow-2xl">
                    @php
                        // Decode JSON dan ambil gambar pertama
                        $images = json_decode($dokumentasi->image_path, true);
                        $thumbnail = $images[0] ?? 'default-image.jpg'; // Sediakan gambar default jika tidak ada gambar
                    @endphp
                    <img src="{{ asset('storage/' . $thumbnail) }}" alt="{{ $dokumentasi->caption ?? 'Dokumentasi Rapat' }}" class="w-full h-56 object-cover transform group-hover:scale-105 transition-transform duration-300">
                    
                    {{-- Informasi di Bawah Gambar --}}
                    <div class="p-4">
                        <p class="font-semibold text-gray-800 truncate" title="{{ $dokumentasi->caption }}">{{ $dokumentasi->caption ?? 'Tanpa caption' }}</p>
                        <p class="text-sm text-gray-500 mt-1">Agenda: {{ $dokumentasi->agenda->title ?? 'N/A' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="col-span-1 sm:col-span-2 md:col-span-3 bg-white p-8 rounded-2xl shadow-lg text-center">
            <p class="text-gray-500">Tidak ada dokumentasi yang cocok dengan pencarian Anda.</p>
        </div>
    @endif

    {{-- Link Pagination --}}
    <div class="mt-6">
        {{ $dokumentasis->appends(request()->query())->links() }}
    </div>
</div>
@endsection