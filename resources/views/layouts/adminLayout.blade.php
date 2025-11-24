<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Econnect') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Crimson+Text:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* 🌿 MAIN ECO THEME */
        body {
            background-color: #E0E5D8;
            color: #4F6B3F;
            font-family: 'Nunito Sans', sans-serif;
            transition: background-color 0.3s ease;
        }

        header {
            background: #FCF9EF;
            box-shadow: 0 2px 8px rgba(79, 107, 63, 0.08);
            border-bottom: 1px solid rgba(79, 107, 63, 0.08);
            border-radius: 0 0 1.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        /* 🌱 Sidebar */
        aside {
            background: #FCF9EF;
            border-radius: 1.8rem;
            box-shadow: 0 4px 10px rgba(79, 107, 63, 0.05);
            transition: all 0.3s ease;
            font-family: 'Nunito Sans', sans-serif;
        }

        /* 🌿 Sidebar nav items */
        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #6A8A52;
            padding: 0.6rem;
            border-radius: 1.5rem;
            transform: translateY(0);
            transition: all 0.3s ease-out;
            cursor: pointer;
            z-index: 40;
        }

        /* 🌿 Sidebar nav items */
        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #6A8A52;
            padding: 0.6rem;
            border-radius: 1.5rem;
            transform: translateY(0);
            transition: all 0.3s ease-out;
            cursor: pointer;
        }

        /* Default state - soft sunken */
        .nav-item {
            box-shadow:
                inset 2px 2px 4px rgba(140, 160, 130, 0.25),
                inset -2px -2px 4px rgba(255, 255, 255, 0.6);
        }

        /* 🌤 Hover: gentle lift + show tooltip */
        .nav-item:hover {
            transform: translateY(-1px);
            box-shadow:
                -2px -2px 4px rgba(255, 255, 255, 0.7),
                2px 2px 4px rgba(160, 180, 150, 0.25);
            filter: brightness(1.03);
            color: #4F6B3F;
        }

        /* Tooltip for hover state */
        .nav-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(79, 107, 63, 0.95);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            white-space: nowrap;
            margin-left: 0.75rem;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* 🌾 Active state - no tooltip, distinct visual */
        .nav-item.active {
            background: rgba(122, 140, 79, 0.95);
            color: white;
            box-shadow:
                inset 2px 2px 4px rgba(70, 85, 45, 0.35),
                inset -2px -2px 4px rgba(200, 220, 170, 0.4),
                0 2px 6px rgba(122, 140, 79, 0.25);
            transform: translateY(0);
        }

        /* Active state hover - maintain active style */
        .nav-item.active:hover {
            background: rgba(122, 140, 79, 0.95);
            color: white;
            transform: translateY(0);
            box-shadow:
                inset 2px 2px 4px rgba(70, 85, 45, 0.35),
                inset -2px -2px 4px rgba(200, 220, 170, 0.4),
                0 2px 6px rgba(122, 140, 79, 0.25);
        }

        /* Active state - no tooltip */
        .nav-item.active:hover::after {
            display: none;
        }

        /* 🌾 Active: subtle press */
        .nav-item:active {
            transform: translateY(1px);
            box-shadow:
                inset 3px 3px 5px rgba(120, 140, 110, 0.3),
                inset -2px -2px 4px rgba(255, 255, 255, 0.5);
            filter: brightness(0.97);
        }

        /* 🌾 Toasts */
        #feedback-toast,
        #error-toast {
            backdrop-filter: blur(6px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 2rem;
            transition: opacity 0.8s ease;
            font-family: 'Crimson Text', serif;
            font-style: italic;
        }

        /* 🌿 Main Container */
        main {
            background: #FCF9EF;
            border-radius: 2rem;
            box-shadow: 0 4px 8px rgba(79, 107, 63, 0.1);
            border: 1px solid rgba(79, 107, 63, 0.06);
            transition: all 0.3s ease-in-out;
            font-family: 'Nunito Sans', sans-serif;
            z-index: 1;
        }

        /* 🌿 Main Container */
        main {
            background: #FCF9EF;
            border-radius: 2rem;
            box-shadow: 0 4px 8px rgba(79, 107, 63, 0.1);
            border: 1px solid rgba(79, 107, 63, 0.06);
            transition: all 0.3s ease-in-out;
            font-family: 'Nunito Sans', sans-serif;
        }


        /* 🍂 Footer */
        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            font-family: 'Nunito Sans', sans-serif;
        }

        footer .bg-#C37A49 {
            background-color: #C37A49 !important;
        }

        footer .bg-#7F8A4F {
            background-color: #7F8A4F !important;
        }

        footer a {
            transition: all 0.25s ease-in-out;
        }

        footer a:hover {
            color: #E0E5D8 !important;
            transform: translateY(-2px);
        }

        footer i:hover {
            transform: scale(1.15);
            transition: transform 0.25s ease;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <!-- 🌿 Top Bar -->
    <header class="flex justify-between items-center py-4 px-3 w-[97%] mx-auto mt-3 relative">
        <!-- Success/Error Toasts -->
        @if (session('success'))
            <div id="feedback-toast"
                class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#f5f8ef]/90 text-[#5C7919] text-lg px-6 py-3 z-[9999] opacity-100 rounded-lg shadow-md">
                🌱 {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="error-toast"
                class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#fff5f5]/90 text-[#d9534f] text-lg px-6 py-3 z-[9999] opacity-100 rounded-lg shadow-md">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Logo and Greeting -->
        <div class="flex items-center space-x-3">
            <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="Econnect Logo" class="h-10 w-auto">
            <h1 class="text-2xl font-semibold">
                Welcome back, <span class="font-bold">Admin Name</span>! 🌱
            </h1>
        </div>

        <!-- Profile, Notifications, Logout -->
        <div class="flex items-center space-x-4 relative">
            <!-- Notification Bell -->
            <div class="relative">
                <button id="notification-btn" class="text-[#6A8A52] hover:text-[#4F6B3F] relative">
                    <i class="fa-solid fa-bell text-3xl"></i>
                    <!-- Red dot for unread -->
                    <span id="notification-dot"
                        class="absolute top-0 right-0 inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                </button>

            </div>

            <!-- Profile Icon -->
            <a href="#" class="text-[#6A8A52] hover:text-[#4F6B3F]" title="Profile">
                <i class="fa-solid fa-user-circle text-4xl"></i>
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[#9B4040] hover:text-[#642B2B]" title="Logout">
                    <i class="fa-solid fa-right-from-bracket text-3xl"></i>
                </button>
            </form>
            @include('modal.notificationModal')
        </div>
    </header>

    <!-- 🍃 Sidebar -->
    <div class="flex flex-1 relative">
        <aside class="absolute top-8 left-6 h-[78vh] w-20 flex flex-col items-center py-8">
            <nav class="flex flex-col items-center justify-evenly h-full">
                <a href="/adminHome" class="nav-item" data-tooltip="Dashboard"><i class="fa-solid fa-house"></i></a>
                <a href="/adminUsers" class="nav-item" data-tooltip="Manage Users"><i class="fa-solid fa-users"></i></a>
                <a href="/adminQuests" class="nav-item" data-tooltip="Quests"><i class="fa-solid fa-bullseye"></i></a>
                <a href="{{ route('adminRewards') }}" class="nav-item" data-tooltip="Rewards">
                    <i class="fa-solid fa-gift"></i>
                </a>
                <a href="{{ route('admin.eco-library') }}" class="nav-item" data-tooltip="Library / Lifestyle"><i
                        class="fa-solid fa-book-open"></i></a>
                <a href="/adminAnalytics" class="nav-item" data-tooltip="Analytics"><i
                        class="fa-solid fa-chart-column"></i></a>
                <a href="/adminSystemAlerts" class="nav-item" data-tooltip="Notifications"><i
                        class="fa-solid fa-bell"></i></a>
                <a href="/adminSettings" class="nav-item" data-tooltip="Settings"><i class="fa-solid fa-gear"></i></a>
            </nav>
        </aside>

        <!-- 🌾 Main Content -->
        <main class="flex-1 ml-32 mt-8 mr-6 mb-2 p-8 overflow-y-auto min-h-[78vh]">
            @include('modal.qrScannerModal')
            @include('modal.ecoTopics_ecoActionModal')
            @yield('content')
        </main>
    </div>

    <!-- 🍂 Footer -->
    <footer class="mt-16">
        <div class="bg-[#C37A49] text-center py-2 text-white font-medium text-sm tracking-wide">
            Developed by the BuggedOut Team • © {{ date('Y') }}
        </div>

        <div class="bg-[#7F8A4F] text-white px-8 md:px-20 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 text-sm leading-relaxed">
                <div>
                    <h3 class="font-bold text-xl mb-3">ECOconnect</h3>
                    <p>Your companion for everyday sustainable living. Built to guide, inspire, and connect
                        eco-conscious individuals.</p>
                    <div class="flex space-x-5 mt-5 text-lg">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-lg mb-3 border-l-4 border-[#C37A49] pl-2">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/">Home</a></li>
                        <li><a href="/lifestyle">Lifestyle</a></li>
                        <li><a href="/quests">Quests</a></li>
                        <li><a href="/progress">My Progress</a></li>
                        <li><a href="/about">About</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-lg mb-3 border-l-4 border-[#C37A49] pl-2">Learn More</h3>
                    <ul class="space-y-2">
                        <li><a href="#">Sustainability Guides</a></li>
                        <li><a href="#">Community Partners</a></li>
                        <li><a href="#">Educational Resources</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-lg mb-3 border-l-4 border-[#C37A49] pl-2">About & Legal</h3>
                    <ul class="space-y-2 mb-4">
                        <li><a href="#">About ECOconnect</a></li>
                        <li><a href="#">Team Members</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                    <ul class="space-y-2">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item');
            const currentPath = window.location.pathname.replace(/\/$/, ''); // remove trailing slash

            navItems.forEach(item => {
                const href = new URL(item.href).pathname.replace(/\/$/, ''); // get only path
                item.classList.remove('active');

                if (href === currentPath || currentPath.includes('eco-library')) {
                    item.classList.add('active');
                }
            });
        });
    </script>


</body>

</html>
