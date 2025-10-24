<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Econnect') }}</title>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/app.js'], 'resources/js/app.js')
    
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-8 py-3 flex items-center justify-between">
            <!-- Left: Logo -->
            <a href="/" class="flex items-center space-x-1">
                <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="EcoConnect Logo" class="h-10 w-auto">
            </a>

            <!-- Hamburger (Mobile) -->
            <button id="menu-toggle" class="block md:hidden text-green-900 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Center: Navigation Links (Desktop) -->
            <div class="hidden md:flex flex-1 justify-center space-x-10">
                <a href="/" class="nav-link font-semibold text-green-900 hover:text-green-800">HOME</a>
                <a href="/lifestyle" class="nav-link text-green-900 hover:text-green-800">LIFESTYLE</a>
                <a href="/quests" class="nav-link text-green-900 hover:text-green-800">QUESTS</a>
                <a href="/about" class="nav-link text-green-900 hover:text-green-800">ABOUT</a>
                <a href="/progress" class="nav-link text-green-900 hover:text-green-800">PROGRESS</a>
                <a href="/rewards" class="nav-link text-green-900 hover:text-green-800">REWARDS</a>
            </div>

            <!-- Right: Profile with Click Dropdown (Desktop) -->
            <div class="hidden md:flex items-center relative" id="profileDropdown">
                <button id="dropdownButton" class="flex items-center space-x-3 focus:outline-none">
                    <span class="italic text-green-900 font-semibold">Hi, Allen</span>
                    <img src="{{ Vite::asset('resources/images/icons/icon_acc.png') }}" alt="Profile" class="h-10 w-11 rounded-full">
                    <svg class="w-4 h-4 ml-1 text-green-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                    <ul class="flex flex-col py-1">
                        <li>
                            <a href="/login" class="block px-4 py-2 text-gray-700 hover:bg-green-100">Login</a>
                        </li>
                        <li>
                            <a href="/signup" class="block px-4 py-2 text-gray-700 hover:bg-green-100">Sign Up</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="EcoConnect Logo" class="h-10">
            <button id="close-sidebar" class="text-green-900">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="sidebar-links">
            <a href="/" class="nav-link">HOME</a>
            <a href="/lifestyle" class="nav-link">LIFESTYLE</a>
            <a href="/quests" class="nav-link">QUESTS</a>
            <a href="/about" class="nav-link">ABOUT</a>
            <a href="/progress" class="nav-link">PROGRESS</a>
            <a href="/rewards" class="nav-link">REWARDS</a>
        </div>

        <div class="sidebar-footer">
            <img src="{{ Vite::asset('resources/images/icons/icon_acc.png') }}" alt="Profile">
            <span class="italic text-green-900 font-semibold">Hi, Allen</span>
        </div>
    </aside>

    <!-- Overlay -->
    <div id="overlay"></div>




    {{-- Main Content --}}
    <main>
        @include('modal.loginModal')
        @include('modal.signupModal')
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white shadow-inner mt-10 py-4 text-center text-sm text-gray-500">
        © {{ date('Y') }} Econnect. All rights reserved.
    </footer>



</body>
</html>
