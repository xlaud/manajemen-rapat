@extends('layouts.app')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
    
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Daftar Agenda Rapat</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat agenda yang akan datang dan isi presensi Anda.</p>
        </div>
    </div>

    {{-- Filter dan Pencarian --}}
    <div class="py-4">
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
                    placeholder="Cari agenda berdasarkan judul..." 
                    class="block w-full py-2.5 pl-10 pr-3 text-gray-900 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Tabel Data Agenda untuk Guru --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Agenda</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Presensi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($agendas as $index => $agenda)
                    @php
                        // Cek apakah guru yang sedang login sudah mengisi presensi untuk agenda ini
                        $userPresensi = $agenda->presensi->firstWhere('user_id', Auth::id());
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $agendas->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $agenda->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($agenda->description, 40) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') }}</div>
                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($agenda->meeting_time)->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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
                                <a href="{{ route('presensi.create', ['agenda' => $agenda->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                    Isi Presensi
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mb-2"><path d="M21.54 15.64c.52-.39.81-1.03.81-1.74 0-2.3-2.42-3.41-4.43-2.39-1.39.7-3.32.32-4.03-1.12-1.2-2.34-4.23-2.34-5.43 0-1.28 2.4-3.7.8-4.03-1.12C2.42 8.5 0 9.61 0 11.9c0 .71.3 1.35.81 1.74.52.39 1.16.56 1.8.56h16.78c.64 0 1.28-.17 1.8-.56z"/><path d="M6.35 18.35c.38-.38.38-1.02 0-1.4-.38-.38-1.02-.38-1.4 0-.38.38-.38 1.02 0 1.4.38.38 1.02.38 1.4 0zm12.7-1.4c-.38-.38-1.02-.38-1.4 0-.38.38-.38 1.02 0 1.4.38.38 1.02.38 1.4 0 .38-.38.38-1.02 0-1.4zM12 19.4c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/></svg>
                                <p class="font-semibold">Tidak ada data agenda</p>
                                <p>Saat ini belum ada agenda rapat yang tersedia.</p>
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
