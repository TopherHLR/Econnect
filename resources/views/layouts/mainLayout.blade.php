<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background-color: #e0e9d6">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/webp" href="{{ Vite::asset('resources/images/viewport1/store2.webp') }}" />
    <title>{{ config('app.name', 'Econnect') }} | @yield('title', 'Admin Dashboard')</title>
    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/auth.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="flex flex-col min-h-screen">

    @include('modal.notificationModal')

    <nav id="navbar"
        class="navbar {{ !Request::is('/') && !Request::is('home') ? 'navbar-scrolled navbar-green-shadow' : '' }}">
        {{-- FLOATING MANUAL ICON (visible only if a page sets manualImage) --}}
        <div id="manualTrigger" class="fixed top-20 right-4 z-40 hidden md:flex cursor-pointer">
            <img id="manualIconImg" src="{{ Vite::asset('resources/images/viewport1/manual-icon.webp') }}"
                class="w-10 h-10 md:w-12 md:h-12 drop-shadow-xl hover:scale-110 transition">
        </div>

        {{-- MANUAL VIEWER --}}
        <!-- Manual Viewer Modal -->
        <div id="manualViewer" class="fixed inset-0  hidden z-50 flex items-center justify-center p-4">

            <img id="manualImage" class="max-w-full max-h-[90vh] rounded-xl shadow-lg manual-offset">
        </div>


        <div class="navbar-container">
            <div class="max-w-7xl mx-auto px-2 py-2 flex items-center justify-between">
                <!-- Left: Logo -->
                <a href="/" class="flex items-center space-x-1 mr-5">
                    <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="EcoConnect Logo"
                        class="h-10 w-auto">
                </a>

                <!-- Hamburger (Mobile) -->
                <button id="menu-toggle" class="block md:hidden mr-5 text-green-900 focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Center: Navigation Links with Highlight (Desktop) -->
                <div class="hidden md:flex flex-1 justify-center space-x-10 nav-links">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">HOME</a>
                    <a href="{{ route('lifestyle') }}"
                        class="nav-link {{ request()->is('lifestyle') ? 'active' : '' }}">LIFESTYLE</a>
                    @auth
                        <a href="/quests" class="nav-link {{ request()->is('quests') ? 'active' : '' }}">QUESTS</a>
                    @endauth
                    <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">ABOUT</a>
                    <a href="{{ route('leaderboard') }}"
                        class="nav-link {{ request()->is('leaderboard') ? 'active' : '' }}">LEADERBOARD</a>
                </div>

                <!-- Right: Profile / Auth Buttons -->
                <div x-data class="hidden md:flex items-center relative" id="profileDropdown">
                    @guest
                        <!-- When not logged in -->
                        <div class="flex items-center space-x-4">
                            <button @click="$store.authModal.open = true; $store.authModal.mode = 'signin'"
                                class="text-green-900 font-semibold hover:text-green-800 transition cursor-pointer">
                                Log In
                            </button>
                            <span class="text-green-900 font-semibold">|</span>
                            <button @click="$store.authModal.open = true; $store.authModal.mode = 'signup'"
                                class="text-green-900 font-semibold hover:text-green-800 transition cursor-pointer">
                                Sign Up
                            </button>
                        </div>
                    @endguest

                    @auth
                        <div class="flex items-center space-x-3 relative ms-5">
                            <!-- Notification Bell -->
                            <!-- Notification Bell -->
                            <div class="relative">
                                <button id="notification-btn"
                                    class="relative text-[#6A8A52] hover:text-[#4F6B3F] focus:outline-none">
                                    <i class="fa-solid fa-bell text-2xl"></i>
                                    @php
                                        $unreadCount = App\Models\Notification::where('user_id', Auth::id())
                                            ->whereNull('read_at')
                                            ->count();
                                    @endphp

                                    @if ($unreadCount > 0)
                                        <span id="notification-dot"
                                            class="absolute top-0 right-0 min-w-[15px] h-[15px] bg-red-500 text-white text-[10px] font-bold 
               flex items-center justify-center rounded-full px-1">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif

                                </button>
                            </div>

                            <div x-data="{ open: false }" class="relative">
                                <!-- Profile Button -->
                                <button @click="open = !open"
                                    class="flex items-center justify-center w-11 h-11 bg-[#E0E9D6] border-2 border-[#6A8A52] rounded-full 
                                                    hover:bg-[#C8D5B9] hover:border-[#4F6B3F] transition-all duration-300 shadow-sm focus:outline-none group
                                                    z-50 relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5"
                                        class="w-6 h-6 text-[#4F6B3F] group-hover:text-[#3E5632] transition-colors duration-300">
                                        <circle cx="12" cy="8" r="4" />
                                        <path d="M4 20c0-4 4-7 8-7s8 3 8 7" />
                                    </svg>
                                </button>

                                <!-- Dropdown -->
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                    class="absolute -right-42  -mt-13 w-56 bg-[#F9F8F4] border border-[#BFD1B0] rounded-2xl shadow-lg z-40 overflow-hidden
                                                    before:content-[''] before:absolute before:top-[-10px] before:right-[18px] before:w-5 before:h-5 
                                                    before:bg-[#F9F8F4] before:rotate-45 before:border-l before:border-t before:border-[#BFD1B0]">

                                    <ul class="flex flex-col py-3 mt-10 text-sm font-medium text-[#4F6B3F] space-y-1">
                                        <li>
                                            <a href="{{ route('account.show') }}"
                                                class="flex items-center gap-3 px-5 py-2.5  hover:bg-[#E5EED3] hover:text-[#3E5632] transition-all duration-200">

                                                <!-- Rectangle icon -->
                                                <span
                                                    class="flex items-center justify-center w-7 h-7 bg-[#E0E9D6] border border-[#6A8A52] rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        class="w-4 h-4 text-[#4F6B3F]">
                                                        <circle cx="12" cy="8" r="4" />
                                                        <path d="M4 20c0-4 4-7 8-7s8 3 8 7" />
                                                    </svg>
                                                </span>
                                                My Account
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/myprogress"
                                                class="flex items-center gap-3 px-5 py-2.5  hover:bg-[#E5EED3] hover:text-[#3E5632] transition-all duration-200">
                                                <span
                                                    class="flex items-center justify-center w-7 h-7 bg-[#E0E9D6] border border-[#6A8A52] rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                                        class="w-4 h-4 text-[#4F6B3F]">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 17l6-6 4 4 8-8" />
                                                    </svg>
                                                </span>
                                                My Progress
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/rewards"
                                                class="flex items-center gap-3 px-5 py-2.5  hover:bg-[#E5EED3] hover:text-[#3E5632] transition-all duration-200">
                                                <span
                                                    class="flex items-center justify-center w-7 h-7 bg-[#E0E9D6] border border-[#6A8A52] rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                                        class="w-4 h-4 text-[#4F6B3F]">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 8v8m0 0l-3-3m3 3l3-3m-3-7v7" />
                                                    </svg>
                                                </span>
                                                My Rewards
                                            </a>
                                        </li>

                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center gap-3 w-full text-left px-5 py-2.5  hover:bg-[#F4D4D4] hover:text-[#642B2B] transition-all duration-200">
                                                    <span
                                                        class="flex items-center justify-center w-7 h-7 bg-[#FCE8E8] border border-[#DFA7A7] rounded-md">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                                            class="w-4 h-4 text-[#9B4040]">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H3m12 0l-4-4m4 4l-4 4m4-4h8" />
                                                        </svg>
                                                    </span>
                                                    Logout
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            @auth
                                                @if (auth()->user()->user_type === 'admin')
                                                    <a href="/adminHome"
                                                        class="flex items-center gap-3 px-5 py-2.5  hover:bg-[#E5EED3] hover:text-[#3E5632] transition-all duration-200">
                                                        ADMIN DASHBOARD
                                                    </a>
                                                @endif
                                            @endauth
                                        </li>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    @endauth
                </div>

            </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 right-0 h-full w-64 bg-[#F7F3E7] shadow-lg transform translate-x-full transition-transform duration-300 z-[1200]">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="EcoConnect Logo" class="h-10">
            <button id="close-sidebar" class="text-green-900">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- Sidebar Auth / Profile Section -->
        <div class=" pt-4 px-4">

            @guest
                <!-- When NOT logged in -->
                <div x-data class="flex flex-col space-y-3">
                    <button @click="$store.authModal.open = true; $store.authModal.mode = 'signin'"
                        class="text-green-900 font-semibold hover:text-green-800 transition w-full text-left">
                        Log In
                    </button>

                    <button @click="$store.authModal.open = true; $store.authModal.mode = 'signup'"
                        class="text-green-900 font-semibold hover:text-green-800 transition w-full text-left">
                        Sign Up
                    </button>
                </div>
            @endguest


            @auth
                <div class="flex items-center justify-between mt-3">

                    <!-- Notification bell -->
                    <button id="notification-btn-sidebar"
                        class="relative text-[#6A8A52] hover:text-[#4F6B3F] focus:outline-none">
                        <i class="fa-solid fa-bell text-2xl"></i>
                        @php
                            $unreadCount = App\Models\Notification::where('user_id', Auth::id())
                                ->whereNull('read_at')
                                ->count();
                        @endphp

                        @if ($unreadCount > 0)
                            <span id="notification-dot"
                                class="absolute top-0 right-0 min-w-[15px] h-[15px] bg-red-500 text-white text-[10px] font-bold 
               flex items-center justify-center rounded-full px-1">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Profile dropdown -->
                    <div x-data="{ open: false }" class="relative">

                        <!-- Profile button -->
                        <button @click="open = !open"
                            class="flex items-center justify-center w-11 h-11 bg-[#E0E9D6] border-2 border-[#6A8A52] rounded-full 
                    hover:bg-[#C8D5B9] hover:border-[#4F6B3F] transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5" class="w-6 h-6 text-[#4F6B3F]">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 4-7 8-7s8 3 8 7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-3 w-52 bg-[#F9F8F4] border border-[#BFD1B0] rounded-xl shadow-lg z-50">

                            <ul class="py-2 text-sm text-[#4F6B3F]">

                                <li>
                                    <a href="{{ route('account.show') }}"
                                        class="flex items-center gap-3 px-4 py-2 hover:bg-[#E5EED3] rounded-lg">
                                        My Account
                                    </a>
                                </li>

                                <li>
                                    <a href="/myprogress"
                                        class="flex items-center gap-3 px-4 py-2 hover:bg-[#E5EED3] rounded-lg">
                                        My Progress
                                    </a>
                                </li>

                                <li>
                                    <a href="/rewards"
                                        class="flex items-center gap-3 px-4 py-2 hover:bg-[#E5EED3] rounded-lg">
                                        My Rewards
                                    </a>
                                </li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-3 px-4 py-2 w-full text-left hover:bg-[#F4D4D4] hover:text-[#642B2B] rounded-lg">
                                            Logout
                                        </button>
                                    </form>
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>
            @endauth

        </div>
        <div class="flex flex-col mt-4 space-y-2 p-4">
            <a href="/" class="nav-link">HOME</a>
            <a href="/lifestyle" class="nav-link">LIFESTYLE</a>
            <a href="/quests" class="nav-link">QUESTS</a>
            <a href="/about" class="nav-link">ABOUT</a>
        </div>
    </aside>

    <!-- Overlay -->
    <!-- Overlay - FIXED for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 hidden z-[1199] cursor-pointer"></div>
    <!-- 🌿 Feedback Notification -->
    <!-- 🌿 Feedback Notification - HIGHEST Z-INDEX -->
    @if (session('success'))
        <div id="feedback-toast"
            class="fixed top-6 left-1/2 -translate-x-1/2 
               w-[90%] max-w-[420px]        
               bg-[#f5f8ef]/95 border border-[#5C7919]/40 text-[#5C7919]
               font-serif italic 
               sm:text-base md:text-lg          
               shadow-md px-4 py-2 md:px-6 md:py-3  
               rounded-2xl z-[99999]
               transition-opacity duration-1000 ease-in-out opacity-100
               flex items-center gap-2">

            <!-- Success Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>

            <span class="text-center w-full">{{ session('success') }}</span>
        </div>
    @endif


    @if (session('error') || $errors->any())
        <div id="error-toast"
            class="fixed top-6 left-1/2 -translate-x-1/2
               w-[90%] max-w-[420px] 
               bg-[#fff5f5]/95 border border-[#d9534f]/40 text-[#d9534f]
               font-serif italic 
               sm:text-base md:text-lg
               shadow-md px-4 py-2 md:px-6 md:py-3
               rounded-2xl z-[99999]
               transition-opacity duration-1000 ease-in-out opacity-100
               flex items-center gap-2">

            <!-- Error Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>

            <span class="text-center w-full">{{ session('error') ?? $errors->first() }}</span>
        </div>
    @endif





<main class="flex-1 mt-10">
    @include('modal.authModal')
    @yield('content')
    @yield('manualImage')
</main>

</body>
{{-- Footer --}}
{{-- Footer --}}
<footer class="mt-16">

    <!-- Top Bar -->
    <div class="bg-[#C37A49] text-center py-2 text-white font-medium text-sm tracking-wide">
        Developed by the BuggedOut Team • © {{ date('Y') }}
    </div>

    <!-- Main Footer Section -->
    <div class="bg-[#7F8A4F] text-white px-4 md:px-8 lg:px-20 py-6 md:py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-10 text-sm leading-relaxed">

            <!-- Column 1 -->
            <div class="text-center sm:text-left mb-4 sm:mb-0">
                <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-3">ECOconnect</h3>
                <p class="text-gray-100 text-xs md:text-sm">
                    Your companion for everyday sustainable living. Built to guide, inspire, and connect eco-conscious
                    individuals.
                </p>

                <!-- Social Icons -->
                <div class="flex justify-center sm:justify-start space-x-3 md:space-x-5 mt-2 md:mt-5 text-base md:text-lg">
                    <a href="https://www.facebook.com/profile.php?id=100090120161622"
                        class="hover:text-green-200 transition" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/EcoBrew/?fbclid=IwY2xjawOh5dhleHRuA2FlbQIxMABicmlkETFyU2RuWG9Gb3kzSkVmNnpWc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHvLvkrK1EaTByI00utS7TNFikIydMIudrv_yn3IpqdevW0yI2PvZuyvKJV11_aem_dPcvW9XVcdAd5HP0Dqu7YQ#"
                        class="hover:text-green-200 transition" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="text-center sm:text-left mb-4 sm:mb-0">
                <h3 class="font-semibold text-base md:text-lg mb-2 md:mb-3 border-l-0 sm:border-l-4 border-[#C37A49] sm:pl-2">
                    Quick Links
                </h3>
                <ul class="space-y-1 md:space-y-2">
                    <li><a href="/" class="hover:text-green-200 transition text-xs md:text-sm">Home</a></li>
                    <li><a href="/lifestyle" class="hover:text-green-200 transition text-xs md:text-sm">Lifestyle</a></li>
                    <li><a href="/quests" class="hover:text-green-200 transition text-xs md:text-sm">Quests</a></li>
                    <li><a href="/progress" class="hover:text-green-200 transition text-xs md:text-sm">My Progress</a></li>
                    <li><a href="/about" class="hover:text-green-200 transition text-xs md:text-sm">About</a></li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div class="text-center sm:text-left mb-4 sm:mb-0">
                <h3 class="font-semibold text-base md:text-lg mb-2 md:mb-3 border-l-0 sm:border-l-4 border-[#C37A49] sm:pl-2">
                    Learn More
                </h3>
                <ul class="space-y-1 md:space-y-2">
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">Sustainability Guides</a></li>
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">Community Partners</a></li>
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">Educational Resources</a></li>
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">FAQs</a></li>
                </ul>
            </div>

            <!-- Column 4 -->
            <div class="text-center sm:text-left mb-4 sm:mb-0">
                <h3 class="font-semibold text-base md:text-lg mb-2 md:mb-3 border-l-0 sm:border-l-4 border-[#C37A49] sm:pl-2">
                    About & Legal
                </h3>
                <ul class="space-y-1 md:space-y-2 mb-2 md:mb-4">
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">About ECOconnect</a></li>
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">Team Members</a></li>
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">Contact Us</a></li>
                </ul>
                <ul class="space-y-1 md:space-y-2">
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-green-200 transition text-xs md:text-sm">Terms of Use</a></li>
                </ul>
            </div>

        </div>
    </div>
</footer>
<style>
    #manualImage {
        width: auto;
        /* maintain aspect ratio */
        height: 70vh;
        /* slightly smaller than before */
        max-width: 90%;
        /* almost full width */
        transition: transform 0.2s ease;
        /* optional hover zoom */
    }

    #manualImage:hover {
        transform: scale(1.05);
        /* gentle zoom on hover */
    }

    /* Responsive adjustments for mobile */
    @media (max-width: 640px) {
        #manualImage {
            height: 40vh;
            /* smaller for mobile */
            max-width: 85%;
        }
    }

    #manualTrigger {
        top: 5.5rem;
        /* push a bit lower under mobile nav */
        right: 1rem;
        z-index: 50;
        display: flex;
    }

    #manualIconImg {
        width: 2.5rem;
        height: 2.5rem;
    }

    /* KEEP margin-top offsets intact */
    .manual-offset {
        margin-top: 8rem;
        /* change globally here */
    }

    /* For small screens (mobile) */
    @media (max-width: 468px) {
        .manual-offset {
            margin-top: 10rem;
            /* adjust this to move lower */
        }
    }

    /* Slightly bigger screens (tablet) */
    @media (min-width: 469px) and (max-width: 767px) {
        .manual-offset {
            margin-top: 50rem;
        }
    }

    /* Default for larger screens */
    .manual-offset {
        margin-top: 50rem;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const trigger = document.getElementById("manualTrigger");
        const viewer = document.getElementById("manualViewer");
        const manualImage = document.getElementById("manualImage");
        const manualIconImg = document.getElementById("manualIconImg");

        const manualPath = window.manualImagePath;

        if (trigger && manualPath) {
            trigger.classList.remove("hidden");
        }

        if (trigger && viewer && manualImage) {
            trigger.addEventListener("click", () => {
                // Toggle visibility
                if (viewer.classList.contains("hidden")) {
                    manualImage.src = manualIconImg?.dataset.manualImage || manualPath || manualIconImg
                        ?.src;
                    viewer.classList.remove("hidden");
                } else {
                    viewer.classList.add("hidden");
                }
            });

            // Close when clicking outside image
            viewer.addEventListener("click", (e) => {
                if (e.target === viewer) {
                    viewer.classList.add("hidden");
                }
            });
        }


        // --- Sidebar ---
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('close-sidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeSidebarFunc() {
            sidebar.classList.add('translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scrolling
        }

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeSidebarFunc();
        });

        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', closeSidebarFunc);
        });

        menuToggle?.addEventListener('click', openSidebar);
        closeSidebar?.addEventListener('click', closeSidebarFunc);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebar.classList.contains('translate-x-full')) {
                closeSidebarFunc();
            }
        });

        // --- Auto-hide feedback toasts ---
        setTimeout(() => {
            const toast = document.getElementById('feedback-toast');
            const errorToast = document.getElementById('error-toast');
            [toast, errorToast].forEach(el => {
                if (el) {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 1000);
                }
            });
        }, 3000);

        // --- Navbar green shadow for non-home pages ---
        const navbar = document.getElementById('navbar');
        if (navbar) {
            function updateNavbar() {
                const isHomePage = window.location.pathname === '/';
                if (!isHomePage) {
                    navbar.classList.add('navbar-green-shadow');
                    navbar.classList.remove('navbar-solid');
                } else {
                    navbar.classList.remove('navbar-green-shadow');
                    if (window.scrollY > 50) {
                        navbar.classList.add('navbar-solid');
                    } else {
                        navbar.classList.remove('navbar-solid');
                    }
                }
            }

            updateNavbar();

            let scrollTimeout;
            window.addEventListener('scroll', () => {
                const isHomePage = window.location.pathname === '/';
                if (isHomePage && !scrollTimeout) {
                    scrollTimeout = setTimeout(() => {
                        scrollTimeout = null;
                        updateNavbar();
                    }, 10);
                }
            });

            window.addEventListener('resize', updateNavbar);
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.7/minified/html5-qrcode.min.js"></script>
</body>

</html>