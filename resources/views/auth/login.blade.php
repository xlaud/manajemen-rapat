<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Rapat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white">

<div class="flex min-h-screen">
    
    <div class="hidden lg:flex w-1/2 items-center justify-center bg-slate-50 p-12">
        <div class="w-full max-w-md">
            {{-- Ilustrasi SVG - menggantinya dengan gambar Anda sendiri jika ada --}}
            <svg viewBox="0 0 593 548" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M548.511 289.26C555.648 289.48 559.614 297.89 555.225 303.41L502.215 369.31C497.825 374.84 489.195 375.14 484.415 370.01L435.582 316.59C430.802 311.46 431.142 302.83 435.972 298.05L490.271 248.16C495.101 243.38 503.211 243.61 507.721 248.59L548.511 289.26Z" fill="#D6D6D6"/><rect x="42.998" y="320" width="258" height="228" rx="15" fill="#4A4A4A"/><rect x="238.998" y="271" width="87" height="49" rx="15" fill="#4A4A4A"/><path d="M550.998 423C550.998 491.283 495.281 547 426.998 547C358.715 547 302.998 491.283 302.998 423C302.998 354.717 358.715 299 426.998 299C495.281 299 550.998 354.717 550.998 423Z" fill="#6675FF"/><path d="M42.998 318C42.998 249.717 98.7151 194 166.998 194C235.281 194 290.998 249.717 290.998 318V533C290.998 541.284 284.282 548 275.998 548H57.998C49.7137 548 42.998 541.284 42.998 533V318Z" fill="#D6D6D6"/><path d="M57.998 335H275.998" stroke="#4A4A4A" stroke-width="6" stroke-linecap="round"/><path d="M57.998 360H275.998" stroke="#4A4A4A" stroke-width="6" stroke-linecap="round"/><path d="M239.998 269C239.998 200.717 295.715 145 363.998 145C432.281 145 487.998 200.717 487.998 269V318H239.998V269Z" fill="#F2F2F2"/><path d="M244.998 284H482.998" stroke="#4A4A4A" stroke-width="6" stroke-linecap="round"/><rect x="281.998" y="249" width="162" height="15" rx="7.5" fill="#4A4A4A"/><rect x="339.998" y="102" width="48" height="48" rx="24" fill="#6675FF"/><path d="M381.866 99.1339C383.614 98.3598 384.998 96.6083 384.998 94.6191V57.3809C384.998 55.3917 383.614 53.6402 381.866 52.866L351.866 39.1339C350.384 38.4831 348.616 38.4831 347.134 39.1339L317.134 52.866C315.386 53.6402 313.998 55.3917 313.998 57.3809V94.6191C313.998 96.6083 315.386 98.3598 317.134 99.1339L347.134 112.866C348.616 113.517 350.384 113.517 351.866 112.866L381.866 99.1339Z" fill="#4A4A4A"/><path d="M167 194C167 125.717 222.717 70 291 70H435C503.283 70 559 125.717 559 194V269H167V194Z" fill="#B9B9B9"/><rect x="167" y="157" width="24" height="24" rx="12" fill="#6675FF"/><rect x="210" y="157" width="24" height="24" rx="12" fill="#F2F2F2"/><rect x="253" y="157" width="24" height="24" rx="12" fill="#4A4A4A"/><path d="M523 0L548.913 22.8447C552.348 25.8457 550.457 31 546.069 31H499.931C495.543 31 493.652 25.8457 497.087 22.8447L523 0Z" fill="#6675FF"/><path d="M70 31L95.9134 9.15528C99.3482 6.15433 104.457 8.04294 104.457 12.4306V49.5694C104.457 53.9571 99.3482 55.8457 95.9134 52.8447L70 31Z" fill="#4A4A4A"/><path d="M42.998 547H1L1 504.087C1 500.652 3.8457 498.761 6.84666 500.196L42.998 516.329V547Z" fill="#4A4A4A"/></svg>
        </div>
    </div>
    
    <div class="w-full lg:w-1/2 flex items- enter justify-center p-6">
        <div class="w-full max-w-md space-y-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Manajemen Rapat</h1>
                <p class="mt-2 text-slate-600">Selamat datang kembali! Silakan masukkan data Anda.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4" role="alert">
                    <p class="font-bold text-red-800">Error</p>
                    <p class="text-red-700">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-slate-900">Ingat saya</label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Lupa password?</a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>
            
            <p class="text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Sign up</a>
            </p>
        </div>
    </div>

</div>

</body>
</html>