<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Econnect') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
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
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* 🌱 Sidebar Variables */
        :root {
            --sidebar-width-expanded: 250px;
            --sidebar-width-collapsed: 100px;
            --sidebar-transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }

        /* 🌱 Sidebar Container */
        aside.mainsidebar {
            position: fixed;
            top: 153px;
            left: 24px;
            height: calc((100vh - 160px) * 0.96);
            width: var(--sidebar-width-expanded);
            background: #FCF9EF;
            border-radius: 2rem;
            box-shadow: 0 8px 32px rgba(79, 107, 63, 0.12);
            transition: var(--sidebar-transition);
            font-family: 'Nunito Sans', sans-serif;
            z-index: 100;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar Collapsed State */
        aside.mainsidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(122, 140, 79, 0.1);
            border: 2px solid rgba(122, 140, 79, 0.2);
            color: #6A8A52;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        /* Sidebar Toggle Button */
        aside.mainsidebar.collapsed .sidebar-toggle {

            width: 60px;
            height: 60px;

        }

        .sidebar-toggle:hover {
            background: rgba(122, 140, 79, 0.2);
            transform: rotate(180deg);
            color: #4F6B3F;
        }

        /* Sidebar Content */
        .sidebar-content {
            flex: 1;
            padding: 100px 20px 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* 🌿 Sidebar nav items */
        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #6A8A52;
            padding: 20px 24px;
            border-radius: 1.5rem;
            transition: all 0.3s ease-out;
            cursor: pointer;
            text-decoration: none;
            overflow: hidden;
            min-height: 60px;
        }

        /* Show text when sidebar is expanded */
        aside.mainsidebar:not(.collapsed) .nav-item span {
            opacity: 1;
            transform: translateX(0);
            white-space: nowrap;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Hide text when sidebar is collapsed */
        aside.mainsidebar.collapsed .nav-item span {
            display: none;
        }

        /* Center icon when collapsed */
        /* 🌿 Sidebar nav items - collapsed state as rounded boxes */
        aside.mainsidebar.collapsed .nav-item {
            justify-content: center;
            /* Center icon horizontally */
            padding: 0.9rem 1.1rem;
            /* Compact but not tiny */
            font-size: 1.5rem;
            /* Icon size */
            min-height: auto;
            /* Remove fixed height */
            gap: 0;
            /* No extra spacing inside */
            border-radius: 1rem;
            /* Rounded rectangle */
            box-shadow:
                inset 2px 2px 4px rgba(140, 160, 130, 0.15),
                inset -2px -2px 4px rgba(255, 255, 255, 0.8);
        }

        /* Nav icon */
        .nav-item i {
            font-size: 1.5rem;
            min-width: 30px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        aside.mainsidebar.collapsed .nav-item i {
            font-size: 2rem;
            min-width: 35px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        /* 🌿 Sidebar nav items - Default state */
        .nav-item {
            box-shadow:
                inset 2px 2px 4px rgba(140, 160, 130, 0.25),
                inset -2px -2px 4px rgba(255, 255, 255, 0.6);
        }

        /* 🌤 Hover Effects */
        .nav-item:hover {
            transform: translateY(-2px);
            box-shadow:
                -3px -3px 6px rgba(255, 255, 255, 0.7),
                3px 3px 6px rgba(160, 180, 150, 0.2);
            color: #4F6B3F;
        }

        .nav-item:hover i {
            transform: scale(1.1);
        }

        /* Tooltip for collapsed state */
        aside.mainsidebar.collapsed .nav-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(100% + 15px);
            top: 50%;
            transform: translateY(-50%);
            background: rgba(79, 107, 63, 0.95);
            color: white;
            padding: 8px 16px;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            white-space: nowrap;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            pointer-events: none;
            opacity: 0;
            animation: fadeIn 0.2s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* 🌾 Active state */
        .nav-item.active {
            background: linear-gradient(135deg, rgba(122, 140, 79, 0.95), rgba(79, 107, 63, 0.9));
            color: white;
            box-shadow:
                inset 3px 3px 6px rgba(70, 85, 45, 0.3),
                inset -3px -3px 6px rgba(200, 220, 170, 0.3),
                0 4px 8px rgba(122, 140, 79, 0.25);
        }

        .nav-item.active:hover {
            background: linear-gradient(135deg, rgba(122, 140, 79, 0.95), rgba(79, 107, 63, 0.9));
            color: white;
            transform: translateY(-1px);
        }

        /* 🌾 Active: subtle press */
        .nav-item:active {
            transform: translateY(1px);
            box-shadow:
                inset 3px 3px 5px rgba(120, 140, 110, 0.3),
                inset -2px -2px 4px rgba(255, 255, 255, 0.5);
        }

        /* Logo in Sidebar */
        .sidebar-logo {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            transition: var(--sidebar-transition);
        }

        .sidebar-logo img {
            height: 36px;
            width: auto;
            transition: var(--sidebar-transition);
        }

        .sidebar-logo span {
            font-size: 1.2rem;
            font-weight: 700;
            color: #4F6B3F;
            opacity: 1;
            transition: var(--sidebar-transition);
        }

        aside.mainsidebar.collapsed .sidebar-logo {
            left: 50%;
            transform: translateX(-50%);
        }

        aside.mainsidebar.collapsed .sidebar-logo img {
            height: 40px;
        }

        aside.mainsidebar.collapsed .sidebar-logo span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* 🌿 Main Content Area */
        main.mainonly {
            margin-left: calc(var(--sidebar-width-expanded) + 48px);
            margin-top: 24px;
            margin-right: 24px;
            background: #FCF9EF;
            border-radius: 2rem;
            box-shadow: 0 8px 32px rgba(79, 107, 63, 0.08);
            border: 1px solid rgba(79, 107, 63, 0.06);
            transition: var(--sidebar-transition);
            font-family: 'Nunito Sans', sans-serif;
            padding: 32px;
            min-height: calc(100vh - 200px);
        }

        /* Adjust main content when sidebar is collapsed */
        aside.mainsidebar.collapsed~main.mainonly {
            margin-left: calc(var(--sidebar-width-collapsed) + 48px);
        }

        /* 🌿 Top Bar */
        header {
            background: #FCF9EF;
            box-shadow: 0 4px 20px rgba(79, 107, 63, 0.08);
            border-bottom: 1px solid rgba(79, 107, 63, 0.08);
            border-radius: 0 0 2rem 2rem;
            transition: all 0.3s ease;
            margin: 24px 24px 0;
            padding: 20px 32px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        /* 🌾 Toasts */
        #feedback-toast,
        #error-toast {
            backdrop-filter: blur(6px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            border-radius: 2rem;
            transition: opacity 0.8s ease;
            font-family: 'Crimson Text', serif;
            font-style: italic;
            z-index: 1000;
        }

        /* 🍂 Footer */
        footer {
            margin-top: 48px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            font-family: 'Nunito Sans', sans-serif;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            aside.mainsidebar {
                width: var(--sidebar-width-collapsed);
                top: 100px;
            }

            main.mainonly {
                margin-left: calc(var(--sidebar-width-collapsed) + 32px);
            }

            .sidebar-logo span {
                display: none;
            }
        }

        @media (max-width: 768px) {
            aside.mainsidebar {
                width: var(--sidebar-width-collapsed);
                height: calc(100vh - 140px);
                top: 80px;
                left: 16px;
            }

            main.mainonly {
                margin-left: calc(var(--sidebar-width-collapsed) + 24px);
                margin-right: 16px;
                padding: 24px;
            }

            header {
                margin: 16px 16px 0;
                padding: 16px 24px;
            }
        }

        /* Smooth transitions for all sidebar related elements */
        .sidebar-transition {
            transition: var(--sidebar-transition);
        }

        /* Add to your CSS */
        .no-transition {
            transition: none !important;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <!-- 🌿 Top Bar -->
    <header class="flex justify-between items-center py-4 px-3 w-[97%] mx-auto mt-3 relative">
        <!-- 🌿 Feedback Notification -->
        @if (session('success'))
            <div id="feedback-toast"
                class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919] font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000 ease-in-out opacity-100">
                🌱 {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="error-toast"
                class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#fff5f5]/90 border border-[#d9534f]/40 text-[#d9534f] font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000 ease-in-out opacity-100">
                ❌ {{ session('error') }}
            </div>
        @endif



        <div class="flex items-center space-x-4">
            <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="Econnect Logo" class="h-12 w-auto">

            <h1 class="text-xl md:text-2xl font-semibold leading-tight">
                Welcome back, <span class="font-bold">Admin</span>!
            </h1>
        </div>
        <!-- Profile, Notifications, Logout + Dynamic Eco Image -->
        <div class="flex items-center space-x-6 relative">

            <!-- Include Alpine.js if not already -->
            <script src="//unpkg.com/alpinejs" defer></script>

            <!-- ⭐ ECO-ACTIVITY IMAGE -->
            <div x-data="{ open: false }" class="relative">
                <img src="{{ Vite::asset('resources/images/nav-image1.jpg') }}"
                    class="w-[1000px] h-16 object-cover rounded-xl hidden md:block cursor-zoom-in" alt="Eco Activity"
                    @click="open = true" />

                <!-- Lightbox Overlay -->
                <div x-show="open" x-transition @click.self="open = false"
                    class="fixed inset-0 bg-black/80 flex items-center justify-center z-50" style="display: none;">
                    <!-- Close Button -->
                    <button @click="open = false"
                        class="absolute top-5 right-5 text-white text-3xl font-bold z-50 hover:text-gray-300">
                        &times;
                    </button>

                    <!-- Zoomed Image -->
                    <img src="{{ Vite::asset('resources/images/nav-image1.jpg') }}"
                        class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-lg" alt="Eco Activity" />
                </div>
            </div>



            <!-- Notification Bell -->
            <div class="relative">
                <button id="notification-btn" class="text-[#6A8A52] hover:text-[#4F6B3F] relative">
                    <i class="fa-solid fa-bell text-3xl"></i>
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
    <aside class="mainsidebar" id="sidebar">
        <!-- Sidebar Logo -->
        <div class="sidebar-logo">
            <span>Admin Views</span>
        </div>

        <!-- Toggle Button -->
        <div class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-chevron-left"></i>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-content">
            <a href="/adminHome" class="nav-item" data-tooltip="Dashboard">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
            <a href="/adminUsers" class="nav-item" data-tooltip="Manage Users">
                <i class="fa-solid fa-users"></i>
                <span>Manage Users</span>
            </a>
            <a href="/adminQuests" class="nav-item" data-tooltip="Quests">
                <i class="fa-solid fa-bullseye"></i>
                <span>Quests</span>
            </a>
            <a href="{{ route('adminRewards') }}" class="nav-item" data-tooltip="Rewards">
                <i class="fa-solid fa-gift"></i>
                <span>Rewards</span>
            </a>
            <a href="{{ route('adminLifestyle') }}" class="nav-item" data-tooltip="Library / Lifestyle">
                <i class="fa-solid fa-book-open"></i>
                <span>Library / Lifestyle</span>
            </a>
            <a href="/adminAnalytics" class="nav-item" data-tooltip="Analytics">
                <i class="fa-solid fa-chart-column"></i>
                <span>Analytics</span>
            </a>
        </nav>
    </aside>

    <!-- 🌾 Main Content -->
    <main class="mainonly">
        @include('modal.qrScannerModal')
        @include('modal.ecoTopics_ecoActionModal')
        @yield('content')
    </main>

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
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const toggleIcon = sidebarToggle.querySelector('i');

            // Check for saved state in localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            // Set initial state without animation
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            }

            // Remove no-transition after a short delay to allow regular transitions
            setTimeout(() => {
                sidebar.classList.remove('no-transition');
            }, 10);

            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');

                if (sidebar.classList.contains('collapsed')) {
                    toggleIcon.classList.remove('fa-chevron-left');
                    toggleIcon.classList.add('fa-chevron-right');
                    localStorage.setItem('sidebarCollapsed', 'true');
                } else {
                    toggleIcon.classList.remove('fa-chevron-right');
                    toggleIcon.classList.add('fa-chevron-left');
                    localStorage.setItem('sidebarCollapsed', 'false');
                }
            });

            // Auto-collapse on smaller screens
            function handleResize() {
                if (window.innerWidth < 1200 && !sidebar.classList.contains('collapsed')) {
                    sidebar.classList.add('collapsed');
                    toggleIcon.classList.remove('fa-chevron-left');
                    toggleIcon.classList.add('fa-chevron-right');
                    localStorage.setItem('sidebarCollapsed', 'true');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Run on initial load

            // Toast notifications
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

            // Active nav item highlighting
            const navItems = document.querySelectorAll('.nav-item');
            const currentPath = window.location.pathname.replace(/\/$/, '');

            navItems.forEach(item => {
                const href = new URL(item.href).pathname.replace(/\/$/, '');
                item.classList.remove('active');

                if (href === currentPath || currentPath.includes('eco-library')) {
                    item.classList.add('active');
                }
            });
        });
    </script>


</body>

</html>
