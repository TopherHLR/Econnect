<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Econnect') }}</title>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 bg-white shadow transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Left: Logo -->
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ Vite::asset('resources/images/logo/greenLogo.png') }}" alt="EcoConnect Logo" class="h-10 w-auto">
            </a>

            <!-- Center: Navigation links -->
            <div class="flex-1 flex justify-center space-x-8">
                <a href="/" class="nav-link text-green-900 hover:text-green-700">Home</a>
                <a href="/lifestyle" class="nav-link text-green-900 hover:text-green-700">Lifestyle</a>
                <a href="/quests" class="nav-link text-green-900 hover:text-green-700">Quests</a>
                <a href="/about" class="nav-link text-green-900 hover:text-green-700">About</a>
                <a href="/progress" class="nav-link text-green-900 hover:text-green-700">Progress</a>
                <a href="/rewards" class="nav-link text-green-900 hover:text-green-700">Rewards</a>
            </div>

            <!-- Right: Button -->
            <div class="space-x-4">
                <a href="/signup" class="nav-button bg-green-700 text-white px-4 py-2 rounded-full hover:bg-green-800 transition">
                    Sign Up
                </a>
            </div>
        </div>
    </nav>


    {{-- Main Content --}}
    <main class="px-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white shadow-inner mt-10 py-4 text-center text-sm text-gray-500">
        © {{ date('Y') }} Econnect. All rights reserved.
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-solid');
            } else {
                navbar.classList.remove('navbar-solid');
            }
        });
    });
    </script>


</body>
</html>
