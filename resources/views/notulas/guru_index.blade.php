@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Notula Rapat (Lihat Saja)</h2>

    <div class="overflow-x-auto">
        @if($notulas->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider rounded-tl-lg">Judul</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Agenda Terkait</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider rounded-tr-lg">Isi Notula</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($notulas as $notula)
                        <tr>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $notula->title }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $notula->agenda->title ?? 'N/A' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $notula->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada notula rapat yang tersedia.</p>
        @endif
    </div>
</div>
@endsection
