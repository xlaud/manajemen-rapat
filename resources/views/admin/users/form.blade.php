@extends('layouts.app')

@section('content')
@php
    $isEdit = isset($user);
    $title = $isEdit ? 'Edit Guru' : 'Tambah Guru Baru';
    $route = $isEdit ? route('users.update', $user->id) : route('users.store');
@endphp

<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $title }}</h1>
        <p class="mt-1 text-sm text-gray-500">
            @if($isEdit)
                Perbarui detail data untuk guru: <span class="font-semibold">{{ $user->name }}</span>.
            @else
                Isi formulir untuk menambahkan akun guru baru. Password akan dibuat otomatis.
            @endif
        </p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-md" role="alert">
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

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <div class="mt-1">
                <input type="text" name="name" id="name" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('name', $user->name ?? '') }}" required>
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
            <div class="mt-1">
                <input type="email" name="email" id="email" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm" value="{{ old('email', $user->email ?? '') }}" required>
            </div>
        </div>

        @if ($isEdit)
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <div class="mt-1">
                    <input type="password" name="password" id="password" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                </div>
                <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
            </div>
        @endif

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">Simpan</button>
        </div>
    </form>
</div>
@endsection