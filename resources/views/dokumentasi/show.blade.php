@extends('layouts.app')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">

    {{-- Header dan Aksi --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $dokumentasi->caption ?? 'Dokumentasi Rapat' }}</h1>
            <p class="mt-1 text-sm text-gray-500">
                Agenda Terkait: <span class="font-medium text-gray-700">{{ $dokumentasi->agenda->title ?? 'N/A' }}</span>
            </p>
        </div>
        <div class="flex items-center space-x-2 mt-4 sm:mt-0 flex-shrink-0">
            {{-- Tombol Edit --}}
            <a href="{{ route('dokumentasi.edit', $dokumentasi->id) }}" class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-300 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                Edit
            </a>
            
            {{-- Tombol Unduh Semua --}}
            <a href="{{ route('dokumentasi.download', $dokumentasi->id) }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-300 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Unduh
            </a>
            
            {{-- Tombol Hapus --}}
            <form action="{{ route('dokumentasi.destroy', $dokumentasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-300 w-full text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Galeri Gambar --}}
    <div class="py-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Galeri Foto</h3>
        @php
            $images = json_decode($dokumentasi->image_path, true);
        @endphp
        @if(is_array($images) && count($images) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($images as $image)
                    <a href="{{ asset('storage/' . $image) }}" target="_blank" class="block rounded-lg overflow-hidden shadow-md transition-shadow hover:shadow-xl">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $dokumentasi->caption }}" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mx-auto mb-2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                <p class="font-semibold text-gray-600">Tidak Ada Gambar</p>
                <p class="text-sm text-gray-500">Tidak ada gambar yang diunggah untuk dokumentasi ini.</p>
            </div>
        @endif
    </div>

    <div class="mt-8 pt-6 border-t border-gray-200">
        <a href="{{ route('dokumentasi.index') }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Galeri
        </a>
    </div>
</div>
@endsection
