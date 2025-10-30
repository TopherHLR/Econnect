@extends('layouts.mainLayout')

@section('content')
<main class="pt-24 px-6 flex min-h-screen space-x-6">
    
    {{-- 🌿 Sidebar --}}
    <aside class="w-80 bg-[#f6f8f1] rounded-3xl shadow-md p-6 h-fit">
        <h2 class="text-lg font-semibold text-green-900 mb-4">Profile</h2>

        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl shadow p-5 mb-5">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $user->name ?? 'Guest User' }}</h3>
                        <p class="text-sm text-gray-500">Seed Sprouter</p>
                    </div>
                </div>
            </div>

            {{-- Dynamic Stats --}}
            <div class="text-sm text-gray-700 space-y-1">
                <p>
                    <span class="font-semibold text-green-800">Total Eco-points:</span> 
                    {{ $totalPoints ?? 0 }} pts
                </p>
                <p>
                    <span class="font-semibold text-green-800">Earned badges:</span> 
                    {{ $earnedBadges ?? 0 }}
                </p>
                <p>
                    <span class="font-semibold text-green-800">Quests completed:</span> 
                    {{ $completedQuests ?? 0 }}
                </p>
            </div>

            {{-- Badge Display --}}
            <div class="mt-4 bg-green-50 p-3 rounded-xl text-center text-green-800 text-sm font-medium">
                {{ $badgeLevel }}
            </div>

            @if(($totalPoints ?? 0) < 200)
                <div class="mt-3 text-center text-gray-500 text-sm italic">
                    🌱 Earn more points and complete eco challenges to level up!
                </div>
            @endif
        </div>

        {{-- Settings & Progress --}}
        <div class="bg-white rounded-2xl shadow p-5 space-y-3">
            <a href="#" class="flex items-center justify-between text-green-900 font-medium hover:text-green-700">
                <span>Settings and Privacy</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <button class="w-full bg-green-700 text-white py-2 rounded-xl hover:bg-green-800 transition">
                View Progress
            </button>
        </div>
    </aside>

    {{-- 🌱 Main Account Content --}}
    <section class="flex-1 bg-white rounded-3xl shadow-md p-8">
        @yield('account_content')
    </section>

</main>
@endsection
