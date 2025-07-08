@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Rekapitulasi Presensi</h1>
        <p class="mt-1 text-sm text-gray-500">Daftar kehadiran guru yang dikelompokkan per agenda rapat.</p>
    </div>

    @forelse ($agendas as $agenda)
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            {{-- Header untuk setiap Agenda --}}
            <div class="border-b pb-4 mb-4">
                <h2 class="text-2xl font-bold text-blue-600">{{ $agenda->title }}</h2>
                <p class="text-sm text-gray-500">
                    Tanggal: <span class="font-medium">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') }}</span>
                </p>
            </div>

            {{-- Tabel Presensi untuk Agenda ini --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Guru</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Waktu Mengisi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Loop di dalam loop: menampilkan setiap presensi dari agenda ini --}}
                        @forelse ($agenda->presensi as $p)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $p->user->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                        {{ $p->status == 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $p->status == 'tidak_hadir' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $p->status == 'izin' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ str_replace('_', ' ', $p->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada guru yang mengisi presensi untuk agenda ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
            <p class="text-gray-500">Belum ada agenda rapat yang dibuat untuk ditampilkan.</p>
        </div>
    @endforelse
</div>
@endsection
