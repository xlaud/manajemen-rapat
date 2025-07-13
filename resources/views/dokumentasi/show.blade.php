@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $dokumentasi->caption ?? 'Dokumentasi Rapat' }}</h2>
            <p class="text-lg text-gray-600">Agenda: {{ $dokumentasi->agenda->title }}</p>
        </div>
        
        {{-- Grup Tombol Aksi --}}
        <div class="flex space-x-3">
            {{-- Tombol Edit --}}
            <a href="{{ route('dokumentasi.edit', $dokumentasi->id) }}" class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                Edit
            </a>
            
            {{-- Tombol Unduh Semua --}}
            <a href="{{ route('dokumentasi.download', $dokumentasi->id) }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Unduh
            </a>
            
            {{-- **[BARU]** Form dan Tombol Hapus --}}
            <form action="{{ route('dokumentasi.destroy', $dokumentasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- ... sisa kode untuk galeri gambar ... --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @php
            $images = json_decode($dokumentasi->image_path, true);
        @endphp
        @if(is_array($images))
            @forelse($images as $image)
                <div>
                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $dokumentasi->caption }}" class="w-full h-auto rounded-lg shadow">
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Tidak ada gambar untuk dokumentasi ini.</p>
            @endforelse
        @endif
    </div>

    <div class="mt-8">
        <a href="{{ route('dokumentasi.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Galeri</a>
    </div>
</div>
@endsection