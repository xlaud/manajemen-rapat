{{-- resources/views/agendas/form.blade.php --}}
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $mode === 'create' ? 'Tambah Agenda Baru' : 'Edit Agenda' }}</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $mode === 'create' ? route('agendas.store') : route('agendas.update', $agenda->id) }}" method="POST" class="space-y-4">
        @csrf
        @if($mode === 'edit')
            @method('PUT')
        @endif
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Agenda</label>
            <input type="text" name="title" id="title" value="{{ old('title', $agenda->title ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan judul agenda" required>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi/Detail</label>
            <textarea name="description" id="description" rows="5"
                      class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="Masukkan deskripsi atau detail lainnya">{{ old('description', $agenda->description ?? '') }}</textarea>
        </div>
        <div>
            <label for="meeting_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rapat</label>
            <input type="date" name="meeting_date" id="meeting_date" value="{{ old('meeting_date', $agenda->meeting_date ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <div>
            <label for="meeting_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Rapat</label>
            <input type="time" name="meeting_time" id="meeting_time" value="{{ old('meeting_time', isset($agenda->meeting_time) ? \Carbon\Carbon::parse($agenda->meeting_time)->format('H:i') : '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        
        <button type="submit" class="flex items-center space-x-2 bg-{{ $mode === 'create' ? 'green' : 'yellow' }}-600 hover:bg-{{ $mode === 'create' ? 'green' : 'yellow' }}-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
            <span>{{ $mode === 'create' ? 'Simpan Agenda' : 'Perbarui Agenda' }}</span>
        </button>
    </form>
</div>
@endsection
