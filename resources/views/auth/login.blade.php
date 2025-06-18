@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-500 to-purple-600 -mt-20">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md transform transition-all duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login Sistem Rapat</h2>
        <p class="text-center text-gray-600 mb-6">
            *Ini adalah simulasi. Anda dapat "login" sebagai Admin atau Guru.
        </p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" placeholder="Email"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('email') }}" required autofocus>
            </div>
            <div>
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" placeholder="Password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <div class="space-y-4">
                <button type="submit" name="role" value="admin"
                        class="w-full flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                    <span>Login sebagai Admin (Simulasi)</span>
                </button>
                <button type="submit" name="role" value="guru"
                        class="w-full flex items-center justify-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                    <span>Login sebagai Guru (Simulasi)</span>
                </button>
            </div>
        </form>
        <p class="text-xs text-gray-500 mt-6 text-center">
            Untuk simulasi ini, Anda bisa menggunakan email dan password apa saja.
            Role akan ditentukan oleh tombol yang Anda pilih.
        </p>
    </div>
</div>
@endsection
