@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Agenda Rapat (Lihat Saja)</h2>

    <div class="overflow-x-auto">
        @if($agendas->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider rounded-tl-lg">Judul</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Tanggal Rapat</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider rounded-tr-lg">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($agendas as $agenda)
                        <tr>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $agenda->title }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') ?? '-' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $agenda->description }}</td>
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
