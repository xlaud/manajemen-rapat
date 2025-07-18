<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Rapat SMPN 3 Mojosongo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F0FDF4;
            /* a very light pastel green */
        }
    </style>
</head>

<body>

    <div class="flex min-h-screen items-center justify-center p-4">

        <div class="flex w-full max-w-5xl overflow-hidden rounded-2xl shadow-2xl bg-white">

            {{-- Kolom Kiri - Informasi --}}
            <div
                class="hidden lg:flex w-1/2 flex-col items-center justify-center p-12 bg-green-100 text-center relative">
                {{-- Decorative shapes --}}
                <div
                    class="absolute top-0 left-0 w-32 h-32 bg-green-200 rounded-full -translate-x-1/2 -translate-y-1/2">
                </div>
                <div
                    class="absolute bottom-0 right-0 w-48 h-48 bg-green-200 rounded-lg translate-x-1/4 translate-y-1/4 rotate-45">
                </div>

                <div class="z-10">
                    <img src="{{ asset('images/logo-smp.png') }}" alt="Logo SMPN 3 Mojosongo"
                        class="mx-auto mb-6 w-32 h-32 rounded-2xl">

                    <h1 class="text-3xl font-bold text-green-800 leading-tight">
                        Sistem Manajemen Rapat
                    </h1>
                    <h2 class="text-xl font-medium text-green-700 mt-1">
                        SMPN 3 MOJOSONGO
                    </h2>
                    <p class="mt-4 text-base text-green-600">
                        Efisiensi dan transparansi dalam setiap pertemuan.
                    </p>
                </div>
            </div>

            {{-- Kolom Kanan - Form Login --}}
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-gray-900">Selamat Datang</h2>
                        <p class="text-gray-500 mt-2">Silakan masuk untuk melanjutkan.</p>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 mb-6 rounded-lg relative"
                            role="alert">
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 sr-only">Alamat
                                Email</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                placeholder="Alamat Email"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm placeholder-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required placeholder="Password"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm placeholder-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox"
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <label for="remember-me" class="ml-2 block text-gray-800">Ingat saya</label>
                            </div>
                            <a href="#" class="font-medium text-green-600 hover:text-green-500">Lupa password?</a>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                Sign In
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-center text-xs text-gray-400">
                        <p>&copy; {{ date('Y') }} Sistem Manajemen Rapat SMPN 3 Mojosongo.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
