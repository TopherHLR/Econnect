<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Econnect') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-[#E0E9D6] text-[#4F6B3F] font-sans min-h-screen flex flex-col">

    <!-- Top Bar -->
    <header class="flex justify-between items-center bg-[#FCF9EF] py-4 px-3 shadow-md rounded-b-xl w-[97%] mx-auto">


        <div class="flex items-center space-x-3">
            <img src="{{ Vite::asset('resources/images/logo/realLogo.png') }}" alt="Econnect Logo" class="h-10 w-auto">
            <h1 class="text-2xl font-semibold text-[#4F6B3F]">
                Welcome back, <span class="font-bold">Admin Name</span>! 🌱
            </h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="#" class="text-[#6A8A52] hover:text-[#4F6B3F]" title="Profile">
                <i class="fa-solid fa-user-circle text-4xl"></i>
            </a>
            <form method="POST" action="#">
                @csrf
                <button type="button" class="text-[#9B4040] hover:text-[#642B2B]" title="Logout">
                    <i class="fa-solid fa-right-from-bracket text-3xl"></i>
                </button>
            </form>
        </div>
    </header>
<div class="flex flex-1 relative">
    <!-- Sidebar -->
    <aside class="absolute top-8 left-6 h-[78vh] w-20 bg-[#FCF9EF] rounded-3xl shadow-md flex flex-col items-center py-8">

        <nav class="flex flex-col items-center justify-evenly text-[#6A8A52] h-full">
    <a href="/adminHome" class="hover:text-[#4F6B3F] transition" title="Dashboard">
        <i class="fa-solid fa-house text-4xl"></i>
    </a>
    <a href="/adminUsers" class="hover:text-[#4F6B3F] transition" title="Manage Users">
        <i class="fa-solid fa-users text-4xl"></i>
    </a>
    <a href="/adminQuests" class="hover:text-[#4F6B3F] transition" title="Quests">
        <i class="fa-solid fa-bullseye text-4xl"></i>
    </a>
    <a href="/adminRewards" class="hover:text-[#4F6B3F] transition" title="Rewards">
        <i class="fa-solid fa-gift text-4xl"></i>
    </a>
    <a href="/adminAnalytics" class="hover:text-[#4F6B3F] transition" title="Analytics">
        <i class="fa-solid fa-chart-column text-4xl"></i>
    </a>
    <a href="/adminSystemAlerts" class="hover:text-[#4F6B3F] transition" title="Notifications">
        <i class="fa-solid fa-bell text-4xl"></i>
    </a>
    <a href="/adminSettings" class="hover:text-[#4F6B3F] transition" title="Settings">
        <i class="fa-solid fa-gear text-4xl"></i>
    </a>
</nav>

    </aside>
</div>

        <!-- Main Container -->
        <main class="flex-1 ml-32 mt-8 mr-6 mb-8 bg-[#FCF9EF] rounded-3xl shadow-sm p-8 overflow-y-auto min-h-[78vh]">
            @yield('content')
        </main>
    </div>

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
                        Your companion for everyday sustainable living. Built to guide, inspire, and connect eco-conscious individuals.
                    </p>

                    <!-- Social Icons -->
                    <div class="flex space-x-5 mt-5 text-lg">
                        <a href="#" class="hover:text-green-200 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-green-200 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-green-200 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-green-200 transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Column 2 -->
                <div>
                    <h3 class="font-semibold text-lg mb-3 border-l-4 border-[#C37A49] pl-2">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-green-200 transition">Home</a></li>
                        <li><a href="#" class="hover:text-green-200 transition">Lifestyle</a></li>
                        <li><a href="#" class="hover:text-green-200 transition">Quests</a></li>
                        <li><a href="#" class="hover:text-green-200 transition">My Progress</a></li>
                        <li><a href="#" class="hover:text-green-200 transition">About</a></li>
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
    </footer>

</body>
</html>
