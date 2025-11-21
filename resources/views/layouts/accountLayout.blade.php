@extends('layouts.mainLayout')

@section('content')
    <main class="pt-12 px-6 flex min-h-screen space-x-6">

        {{-- 🌿 Sidebar --}}
        <aside class="w-80 bg-[#FCF9EF] rounded-3xl shadow-md p-6 h-fit max-w-3xl">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4">Profile</h2>

            {{-- Profile Card --}}
            <div class="bg-white rounded-2xl shadow p-5 mb-5">
                <div class="flex items-center justify-between mb-2">
                    <a href="{{ route('account.show') }}">
                        <div class="flex items-center justify-between">
                            {{-- Left: Profile Info --}}
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-[#E0F2D4] rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#4F6B3F]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $user->name ?? 'Guest User' }}</h3>
                                    <p class="text-sm text-gray-500">Seed Sprouter</p>
                                </div>
                            </div>

                            {{-- Right: Edit Icon --}}
                            <button class="text-[#4F6B3F] hover:text-[#3B541F] transition ml-12 cursor-pointer"
                                title="Edit Profile">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536M16.732 3.732a2.5 2.5 0 113.536 3.536L7.5 20.036H4v-3.5l12.732-12.804z" />
                                </svg>
                            </button>
                        </div>
                    </a>
                </div>

                {{-- Dynamic Stats --}}
                <div class="text-sm text-gray-700 space-y-1 mt-3">
                    <p>
                        <span class="font-semibold text-[#4F6B3F]">Total Eco-points:</span>
                        {{ $progressPoints ?? 0 }} pts
                    </p>
                    <p>
                        <span class="font-semibold text-[#4F6B3F]">Current Points (for redemption):</span>
                        {{ $currentPoints ?? 0 }} pts
                    </p>
                    <p>
                        <span class="font-semibold text-[#4F6B3F]">Earned badges:</span>
                        {{ $earnedBadges ?? 0 }}
                    </p>
                    <p>
                        <span class="font-semibold text-[#4F6B3F]">Quests completed:</span>
                        {{ $completedQuests ?? 0 }}
                    </p>
                </div>

                {{-- Badge Display --}}
                <div class="mt-4 bg-[#E6F0D9] p-3 rounded-xl text-center text-[#4F6B3F] text-sm font-medium">
                    {{ $badgeLevel }}
                </div>

                @if (($totalPoints ?? 0) < 200)
                    <div class="mt-3 text-center text-gray-500 text-sm italic">
                        🌱 Earn more points and complete eco challenges to level up!
                    </div>
                @endif


                {{-- View Progress & Rewards Buttons --}}
                <a href="/myprogress"
                    class="block w-full text-center bg-[#4F6B3F] text-white mt-2 py-2 rounded-xl hover:bg-[#3B541F] transition">
                    View Progress
                </a>
                <a href="/rewards"
                    class="block w-full text-center bg-[#4F6B3F] text-white mt-2 py-2 rounded-xl hover:bg-[#3B541F] transition">
                    View Rewards
                </a>
            </div>

            {{-- Settings & Privacy --}}
            <div class="bg-white rounded-2xl shadow p-3 space-y-3">
                <a href="#" class="flex items-center justify-between text-[#4F6B3F] font-medium hover:text-[#3B541F]">
                    <span>Settings and Privacy</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </aside>

        {{-- 🌱 Main Account Content --}}
        <section
            class="bg-[#FCFFF6] w-full max-w-[1400px] rounded-3xl shadow-md p-10 space-y-8 min-h-[600px] max-h-[90vh] overflow-y-auto mx-auto">

            @yield('account_content')
        </section>

    </main>
@endsection
