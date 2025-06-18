@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Isi Presensi Rapat</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('presensi.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="agenda_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Agenda Rapat</label>
            <select name="agenda_id" id="agenda_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <option value="">-- Pilih Agenda --</option>
                @foreach($agendas as $agenda)
                    <option value="{{ $agenda->id }}" {{ old('agenda_id') == $agenda->id ? 'selected' : '' }}>
                        {{ $agenda->title }} ({{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') ?? 'Tanggal tidak diketahui' }})
                    </option>
                @endforeach
            </select>
            @if($agendas->count() === 0)
                <p class="text-sm text-gray-500 mt-2">Belum ada agenda rapat tersedia.</p>
            @endif
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Presensi</label>
            <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="Alpha" {{ old('status') == 'Alpha' ? 'selected' : '' }}>Alpha</option>
            </select>
        </div>
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="Tambahkan catatan jika diperlukan">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="flex items-center space-x-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
            <span>Simpan Presensi</span>
        </button>
    </form>
</div>
@endsection
