<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Econnect Register') }}</title>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/app.js'], 'resources/js/app.js')
    
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-1">
                <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" 
                     alt="EcoConnect Logo" 
                     class="h-12 w-auto">
                <span class="text-green-800 text-2xl font-semibold tracking-wide">nnect</span>
            </a>

            <!-- Right: Auth Links -->
            <div class="space-x-4">
                <a href="/login" 
                   class="text-green-800 font-medium hover:text-green-600 transition">
                   Login
                </a>
                <a href="/signup" 
                   class="bg-green-700 text-white px-4 py-2 rounded-full hover:bg-green-800 transition">
                   Sign Up
                </a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-24 px-4 min-h-screen flex items-center justify-center bg-gray-50">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white shadow-inner py-4 text-center text-sm text-gray-500">
        © {{ date('Y') }} Econnect. All rights reserved.
    </footer>

</body>
</html>
