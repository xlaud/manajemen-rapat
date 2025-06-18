{{-- resources/views/teachers/form.blade.php --}}
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $mode === 'create' ? 'Tambah Guru Baru' : 'Edit Guru' }}</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $mode === 'create' ? route('teachers.store') : route('teachers.update', $teacher->id) }}" method="POST" class="space-y-4">
        @csrf
        @if($mode === 'edit')
            @method('PUT')
        @endif
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Guru</label>
            <input type="text" name="name" id="name" value="{{ old('name', $teacher->name ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan nama guru" required>
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $teacher->email ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan email guru" required>
        </div>
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $teacher->nip ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan NIP guru" required>
        </div>
        
        <div class="flex space-x-3">
            <button type="submit" class="flex items-center space-x-2 bg-{{ $mode === 'create' ? 'green' : 'yellow' }}-600 hover:bg-{{ $mode === 'create' ? 'green' : 'yellow' }}-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                @if($mode === 'create')
                    <span>Simpan Guru</span>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                    <span>Perbarui Guru</span>
                @endif
            </button>
            <a href="{{ route('teachers.index') }}" class="flex items-center space-x-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
