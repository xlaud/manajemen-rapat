@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Presensi</h2>

    <div class="overflow-x-auto">
        @if($presensi->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider rounded-tl-lg">Guru</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Agenda Rapat</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Catatan</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider rounded-tr-lg">Waktu Presensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($presensi as $item)
                        <tr>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $item->user->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $item->agenda->title ?? 'N/A' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $item->status }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $item->notes ?? '-' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ \Carbon\Carbon::parse($item->presensi_time)->translatedFormat('d F Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada data presensi.</p>
        @endif
    </div>
</div>
@endsection
