@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Agenda Rapat</h2>

    <div class="overflow-x-auto">
        @if($agendas->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Judul</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Tanggal Rapat</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Deskripsi</th>
                        {{-- == INI KOLOM BARU YANG DITAMBAHKAN == --}}
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($agendas as $agenda)
                        <tr>
                            <td class="py-4 px-6 text-sm text-gray-800 align-top">{{ $agenda->title }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800 align-top">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') ?? '-' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800 align-top">{{ $agenda->description }}</td>
                            {{-- == INI TOMBOL AKSI YANG DITAMBAHKAN == --}}
                            <td class="py-4 px-6 text-sm text-gray-800 align-top">
                                @php
                                    // Cek apakah guru ini sudah mengisi presensi untuk agenda terkait
                                    $presensiExists = $agenda->presensi()->where('user_id', Auth::id())->exists();
                                @endphp

                                @if ($presensiExists)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Sudah Presensi
                                    </span>
                                @else
                                    <a href="{{ route('presensi.create', $agenda) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                        Isi Presensi
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada agenda rapat yang tersedia.</p>
        @endif
    </div>
</div>
@endsection