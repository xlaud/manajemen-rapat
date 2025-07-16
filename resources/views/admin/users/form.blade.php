@extends('layouts.app')

@section('content')
    @php
        $isEdit = isset($user);
        $title = $isEdit ? 'Edit Data Guru' : 'Tambah Guru Baru';
        $route = $isEdit ? route('users.update', $user->id) : route('users.store');
    @endphp

    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg max-w-3xl mx-auto">
        {{-- Header Halaman --}}
        <div class="mb-8 pb-6 border-b border-gray-200">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $title }}</h1>
            <p class="mt-1 text-sm text-gray-500">
                @if ($isEdit)
                    Perbarui detail data untuk guru: <span class="font-semibold">{{ $user->name }}</span>.
                @else
                    Isi formulir untuk menambahkan akun guru baru. Password akan dibuat secara otomatis.
                @endif
            </p>
        </div>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 mb-6 rounded-r-md" role="alert">
                <p class="font-bold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $route }}" method="POST" class="space-y-6">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                        value="{{ old('name', $user->name ?? '') }}" required>
                </div>

                {{-- NIP --}}
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" id="nip"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                        value="{{ old('nip', $user->nip ?? '') }}">
                </div>
            </div>

            {{-- Alamat Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" id="email"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    value="{{ old('email', $user->email ?? '') }}" required>
            </div>

            {{-- Password Baru (hanya saat edit) --}}
            @if ($isEdit)
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('users.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-6 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
