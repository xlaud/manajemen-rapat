@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg max-w-2xl mx-auto">

        {{-- Header Halaman --}}
        <div class="mb-8 pb-6 border-b border-gray-200">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Ubah Password</h1>
            <p class="mt-1 text-sm text-gray-500">Pastikan Anda menggunakan password yang kuat dan mudah diingat.</p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded-r-md" role="alert">
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

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

        {{-- Form Ubah Password --}}
        <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Password Saat Ini --}}
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                <input type="password" name="current_password" id="current_password"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    required>
            </div>

            {{-- Password Baru --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password" id="password"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    required>
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password
                    Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    required>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('dashboard') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-6 rounded-lg transition-colors">
                    Kembali
                </a>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
