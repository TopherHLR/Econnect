<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background-color: #e0e9d6">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Econnect') }}</title>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/auth.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="flex flex-col min-h-screen">
    <nav id="navbar"
        class="navbar {{ !Request::is('/') && !Request::is('home') ? 'navbar-scrolled navbar-green-shadow' : '' }}">
        <div class="navbar-container">
            <div class="max-w-7xl mx-auto px-2 py-2 flex items-center justify-between">
                <!-- Left: Logo -->
                <a href="/" class="flex items-center space-x-1 mr-5">
                    <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="EcoConnect Logo"
                        class="h-10 w-auto">
                </a>

                <!-- Hamburger (Mobile) -->
                <button id="menu-toggle" class="block md:hidden text-green-900 focus:outline-none">
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
                    <!-- nav-highlight will be inserted here by JavaScript -->
                    <a href="{{ route('leaderboard') }}"
                        class="nav-link {{ request()->is('leaderboard') ? 'active' : '' }}">
                        LEADERBOARD
                    </a>
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
                        @include('modal.notificationModal')
                        <div class="flex items-center space-x-3 relative ms-5">
                            <!-- Notification Bell -->
                            <!-- Notification Bell -->
                            <div class="relative">
                                <button id="notification-btn"
                                    class="relative text-[#6A8A52] hover:text-[#4F6B3F] focus:outline-none">
                                    <i class="fa-solid fa-bell text-2xl"></i>
                                    <!-- Red dot for unread -->
                                    @if (App\Models\Notification::where('user_id', Auth::id())->whereNull('read_at')->exists())
                                        <span id="notification-dot"
                                            class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                    @endif
                                </button>
                            </div>

                            <div x-data="{ open: false }" class="relative">
                                <!-- Profile Button -->
                                <button @click="open = !open" class="flex items-center justify-center w-11 h-11 bg-[#E0E9D6] border-2 border-[#6A8A52] rounded-full 
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
                                                class="flex items-center gap-3 px-5 py-2.5 rounded-lg hover:bg-[#E5EED3] hover:text-[#3E5632] transition-all duration-200">

                                                <!-- Rectangle icon -->
                                                <span
                                                    class="flex items-center justify-center w-7 h-7 bg-[#E0E9D6] border border-[#6A8A52] rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
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
                                                class="flex items-center gap-3 px-5 py-2.5 rounded-lg hover:bg-[#E5EED3] hover:text-[#3E5632] transition-all duration-200">
                                                <span
                                                    class="flex items-center justify-center w-7 h-7 bg-[#E0E9D6] border border-[#6A8A52] rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2"
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
                                                class="flex items-center gap-3 px-5 py-2.5 rounded-lg hover:bg-[#E5EED3] hover:text-[#3E5632] transition-all duration-200">
                                                <span
                                                    class="flex items-center justify-center w-7 h-7 bg-[#E0E9D6] border border-[#6A8A52] rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2"
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
                                                    class="flex items-center gap-3 w-full text-left px-5 py-2.5 rounded-lg hover:bg-[#F4D4D4] hover:text-[#642B2B] transition-all duration-200">
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
                                    </ul>

                                </div>
                            </div>
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
    <!-- 🌿 Feedback Notification -->
    @if (session('success'))
        <div id="feedback-toast"
            class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919] font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000 ease-in-out opacity-100">
            🌱 {{ session('success') }}
        </div>
    @endif

    @if (session('error') || $errors->any())
        <div id="error-toast"
            class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#fff5f5]/90 border border-[#d9534f]/40 text-[#d9534f]
                        font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000">
            ❌ {{ session('error') ?? $errors->first() }}
        </div>
    @endif


    {{-- Main Content --}}
    <main class="mt-10">
        @include('modal.authModal')
        @yield('content')
    </main>
</body>
{{-- Footer --}}
<footer class="mt-16">
    <!-- Top Bar -->
    <div class="bg-[#C37A49] text-center py-2 text-white font-medium text-sm tracking-wide">
        Developed by the BuggedOut Team • © {{ date('Y') }}
    </div>

    <!-- Main Footer Section -->
    <div class="bg-[#7F8A4F] text-white px-8 md:px-20 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 text-sm leading-relaxed">

            <!-- Column 1 -->
            <div>
                <h3 class="font-bold text-xl mb-3">ECOconnect</h3>
                <p class="text-gray-100">
                    Your companion for everyday sustainable living. Built to guide, inspire, and connect eco-conscious
                    individuals.
                </p>

                <!-- Social Icons -->
                <div class="flex space-x-5 mt-5 text-lg">
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
            <div>
                <h3 class="font-semibold text-lg mb-3 border-l-4 border-[#C37A49] pl-2">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="hover:text-green-200 transition">Home</a></li>
                    <li><a href="/lifestyle" class="hover:text-green-200 transition">Lifestyle</a></li>
                    <li><a href="/quests" class="hover:text-green-200 transition">Quests</a></li>
                    <li><a href="/progress" class="hover:text-green-200 transition">My Progress</a></li>
                    <li><a href="/about" class="hover:text-green-200 transition">About</a></li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div>
                <h3 class="font-semibold text-lg mb-3 border-l-4 border-[#C37A49] pl-2">Learn More</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-green-200 transition">Sustainability Guides</a></li>
                    <li><a href="#" class="hover:text-green-200 transition">Community Partners</a></li>
                    <li><a href="#" class="hover:text-green-200 transition">Educational Resources</a></li>
                    <li><a href="#" class="hover:text-green-200 transition">FAQs</a></li>
                </ul>
            </div>

            <!-- Column 4 -->
            <div>
                <h3 class="font-semibold text-lg mb-3 border-l-4 border-[#C37A49] pl-2">About & Legal</h3>
                <ul class="space-y-2 mb-4">
                    <li><a href="#" class="hover:text-green-200 transition">About ECOconnect</a></li>
                    <li><a href="#" class="hover:text-green-200 transition">Team Members</a></li>
                    <li><a href="#" class="hover:text-green-200 transition">Contact Us</a></li>
                </ul>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-green-200 transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-green-200 transition">Terms of Use</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script>
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

        // Navbar scroll effect - should run on ALL pages
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.getElementById('navbar');
            if (!navbar) return;

            function updateNavbar() {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-solid');
                } else {
                    navbar.classList.remove('navbar-solid');
                }
            }

            // Initial check
            updateNavbar();

            // Throttled scroll event
            let scrollTimeout;
            window.addEventListener('scroll', function () {
                if (!scrollTimeout) {
                    scrollTimeout = setTimeout(function () {
                        scrollTimeout = null;
                        updateNavbar();
                    }, 10);
                }
            });

            // Also check on resize
            window.addEventListener('resize', updateNavbar);
        });

        // Nav highlight - should run on ALL pages
        // Navbar scroll effect - should be on every page
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.getElementById('navbar');
            if (!navbar) return;

            function updateNavbar() {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-solid');
                } else {
                    navbar.classList.remove('navbar-solid');
                }
            }

            // Initial check
            updateNavbar();

            // Scroll event
            window.addEventListener('scroll', function () {
                updateNavbar();
            });
        });

        // Navbar with permanent green shadow for non-home pages (full width)
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.getElementById('navbar');
            if (!navbar) return;

            function updateNavbar() {
                const isHomePage = window.location.pathname === '/';

                // Always add green shadow for non-home pages, but keep full width
                if (!isHomePage) {
                    navbar.classList.add('navbar-green-shadow');
                    // Remove navbar-solid to keep full width
                    navbar.classList.remove('navbar-solid');
                } else {
                    navbar.classList.remove('navbar-green-shadow');
                    // Home page behavior - solid only when scrolled
                    if (window.scrollY > 50) {
                        navbar.classList.add('navbar-solid');
                    } else {
                        navbar.classList.remove('navbar-solid');
                    }
                }
            }

            // Initial check
            updateNavbar();

            // Only listen to scroll for home page
            let scrollTimeout;
            window.addEventListener('scroll', function () {
                const isHomePage = window.location.pathname === '/';
                if (isHomePage && !scrollTimeout) {
                    scrollTimeout = setTimeout(function () {
                        scrollTimeout = null;
                        updateNavbar();
                    }, 10);
                }
            });

            window.addEventListener('resize', updateNavbar);
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.7/minified/html5-qrcode.min.js"></script>


    </body>

</html>