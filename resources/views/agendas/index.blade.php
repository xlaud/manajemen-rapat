@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Agenda Rapat</h2>

    <a href="{{ route('agendas.create') }}" class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
        <span>Tambah Agenda Baru</span>
    </a>

    <div class="overflow-x-auto">
        @if($agendas->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider rounded-tl-lg">Judul</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Deskripsi</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Tanggal Rapat</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($agendas as $agenda)
                        <tr>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $agenda->title }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ \Illuminate\Support\Str::limit($agenda->description, 100) }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') ?? '-' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">
                                <div class="flex space-x-2">
                                    <a href="{{ route('agendas.edit', $agenda->id) }}" class="flex items-center space-x-1 text-blue-600 hover:text-blue-800 font-semibold transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center space-x-1 text-red-600 hover:text-red-800 font-semibold transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada data agenda.</p>
        @endif
    </div>
</div>
@endsection
