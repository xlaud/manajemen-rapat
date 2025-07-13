@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Agenda Rapat</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat semua agenda rapat yang akan datang dan yang sudah berlalu.</p>
        </div>
    </div>

    {{-- Pencarian Agenda --}}
    <div class="mt-4">
        <form action="{{ route('agendas.guru') }}" method="GET" class="w-full">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
                <input 
                    type="search" 
                    name="search" 
                    placeholder="Cari agenda berdasarkan judul atau deskripsi..." 
                    class="block w-full py-2 pl-10 pr-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Daftar Agenda untuk Guru --}}
    <div class="space-y-4">
        @forelse ($agendas as $agenda)
            @php
                // Cek apakah guru yang sedang login sudah mengisi presensi untuk agenda ini
                $userPresensi = $agenda->presensi->firstWhere('user_id', Auth::id());
            @endphp
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $agenda->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('l, d F Y') }} &middot; {{ \Carbon\Carbon::parse($agenda->meeting_time)->format('H:i') }} WIB
                            </p>
                        </div>
                        {{-- Tombol Aksi --}}
                        <div class="flex-shrink-0 ml-4">
                            @if ($userPresensi)
                                {{-- Jika sudah mengisi, tampilkan status --}}
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                    {{ $userPresensi->status == 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $userPresensi->status == 'tidak_hadir' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $userPresensi->status == 'izin' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ str_replace('_', ' ', $userPresensi->status) }}
                                </span>
                            @else
                                {{-- Jika belum, tampilkan tombol untuk mengisi presensi --}}
                                <a href="{{ route('presensi.create', $agenda->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                    Isi Presensi
                                </a>
                            @endif
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        {{ $agenda->description }}
                    </p>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <p class="text-gray-500">Tidak ada agenda yang ditemukan.</p>
            </div>
        @endforelse
    </div>
    {{-- Pagination --}}
    <div class="mt-6">
        {{ $agendas->links() }}
    </div>
</div>
@endsection