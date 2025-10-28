<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Econnect') }}</title>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/auth.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        
</head>
<body class="bg-[#E0E9D6] text-gray-800 font-sans">
    <nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-100">
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

                @auth
                    <!-- Only visible when logged in -->
                    <a href="/myprogress" class="nav-link text-green-900 hover:text-green-800">PROGRESS</a>
                    <a href="/rewards" class="nav-link text-green-900 hover:text-green-800">REWARDS</a>
                @endauth
            </div>

            <!-- Right: Profile / Auth Buttons -->
            <div x-data class="hidden md:flex items-center relative" id="profileDropdown">
                @guest
                    <!-- When not logged in -->
                    <div class="flex items-center space-x-4">
                        <button 
                            @click="$store.authModal.open = true; $store.authModal.mode = 'signin'"
                            class="text-green-900 font-semibold hover:text-green-800 transition"
                        >
                            Log In
                        </button>
                        <span class="text-green-900 font-semibold">|</span>
                        <button 
                            @click="$store.authModal.open = true; $store.authModal.mode = 'signup'"
                            class="text-green-900 font-semibold hover:text-green-800 transition"
                        >
                            Sign Up
                        </button>
                    </div>
                @endguest

                @auth
                    <!-- When logged in -->
                    <button id="dropdownButton" class="flex items-center space-x-3 focus:outline-none">
                        <img src="{{ Vite::asset('resources/images/icons/icon_acc.png') }}" alt="Profile" class="h-10 w-11 rounded-full">
                        <svg class="w-4 h-4 ml-1 text-green-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                        <ul class="flex flex-col py-1">
                            <li>
                                <a href="/" 
                                class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-green-100">
                                    My Account Settings
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-green-100">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
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
            <a href="/myprogress" class="nav-link">PROGRESS</a>
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
        @include('modal.authModal')
        @yield('content')
    </main>

    {{-- Footer --}}
   <footer class="bg-[#7a8c4f] text-white pt-8 pb-6 px-4 md:px-8">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- ECOnnect -->
        <div>
            <h3 class="font-semibold text-lg mb-3">ECOnnect</h3>
            <p class="text-sm text-gray-200 leading-relaxed">
                Your companion for everyday sustainable living.<br>
                Built to guide, inspire, and connect eco-conscious individuals.
            </p>
        </div>

        <!-- Learn More -->
        <div>
            <h3 class="font-semibold text-lg mb-3">Learn More</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="text-gray-200 hover:text-white transition">Sustainability Guides</a></li>
                <li><a href="#" class="text-gray-200 hover:text-white transition">Community Partners</a></li>
                <li><a href="#" class="text-gray-200 hover:text-white transition">Educational Resources</a></li>
                <li><a href="#" class="text-gray-200 hover:text-white transition">FAQs</a></li>
            </ul>
        </div>

        <!-- About ECOnnect -->
        <div>
            <h3 class="font-semibold text-lg mb-3">About ECOnnect</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="text-gray-200 hover:text-white transition">About ECOnnect</a></li>
                <li><a href="#" class="text-gray-200 hover:text-white transition">Team Members</a></li>
                <li><a href="#" class="text-gray-200 hover:text-white transition">Contact Us</a></li>
            </ul>
        </div>

        <!-- Quick Links + Legal + Social -->
        <div>
            <!-- Quick Links -->
            <h3 class="font-semibold text-lg mb-3">Quick Links</h3>
            <ul class="space-y-2 text-sm mb-6">
                <li><a href="/" class="text-gray-200 hover:text-white transition">Home</a></li>
                <li><a href="/lifestyle" class="text-gray-200 hover:text-white transition">Lifestyle (Eco Actions & Library)</a></li>
                <li><a href="/quests" class="text-gray-200 hover:text-white transition">Quests</a></li>
                <li><a href="/myprogress" class="text-gray-200 hover:text-white transition">My Progress</a></li>
                <li><a href="/about" class="text-gray-200 hover:text-white transition">About</a></li>
            </ul>

            <!-- Legal -->
            <h3 class="font-semibold text-lg mb-3">Legal</h3>
            <ul class="space-y-2 text-sm mb-6">
                <li><a href="#" class="text-gray-200 hover:text-white transition">Privacy Policy</a></li>
                <li><a href="#" class="text-gray-200 hover:text-white transition">Terms of Use</a></li>
            </ul>

            <!-- Social Icons (as image assets) -->
            <div class="flex space-x-4">
                <a href="#" class="block">
                    <img 
                        src="{{ Vite::asset('resources/images/icons/social-x.png') }}" 
                        alt="X (Twitter)"
                        class="w-5 h-5"
                    />
                </a>
                <a href="#" class="block">
                    <img 
                        src="{{ Vite::asset('resources/images/icons/social-instagram.png') }}" 
                        alt="Instagram"
                        class="w-5 h-5"
                    />
                </a>
                <a href="#" class="block">
                    <img 
                        src="{{ Vite::asset('resources/images/icons/social-youtube.png') }}" 
                        alt="YouTube"
                        class="w-5 h-5"
                    />
                </a>
                <a href="#" class="block">
                    <img 
                        src="{{ Vite::asset('resources/images/icons/social-linkedin.png') }}" 
                        alt="LinkedIn"
                        class="w-5 h-5"
                    />
                </a>
            </div>
        </div>

    </div>

    <!-- Copyright -->
    <div class="bg-[#C37A49] mt-3 pt-2 text-center text-xs text-gray-300">
        © {{ date('Y') }} ECOnnect. All rights reserved.
    </div>
</footer>
</body>
</html>
