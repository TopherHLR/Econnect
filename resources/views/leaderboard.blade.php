@extends('layouts.mainLayout')

@section('content')
    <div class="min-h-screen bg-[#E2EBD7] p-4 md:p-10 text-[#4F6B3F]">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

            <!-- LEFT SIDEBAR -->
            <div class="lg:col-span-3 bg-[#FAF7EE] rounded-3xl p-6 shadow-lg space-y-7">

                <h2 class="text-2xl font-bold text-[#4F6B3F] text-center">Your Growth</h2>

                <!-- MAIN TREE BADGE CARD -->
                <div
                    class="bg-gradient-to-br from-[#F8F2E6] to-[#E8F0D8] rounded-3xl p-10 shadow-inner border-2 border-[#D4E4C1] relative overflow-hidden">

                    <!-- Tree / Seed Display -->
                    <div class="flex justify-center mb-6">
                        @if ($stage === 1)
                            <!-- Special Seed Stage: Cute bouncing seed + warm welcome -->
                            <div class="text-9xl animate-bounce-slow drop-shadow-lg">
                                Seed
                            </div>
                        @else
                            <!-- All other stages: Your real beautiful SVGs -->
                            <img src="{{ Vite::asset('resources/images/badges/' . $treeStageSvgs[$stage]) }}"
                                alt="{{ $treeNames[$stage] }}" class="w-52 h-52 object-contain drop-shadow-2xl">
                        @endif
                    </div>

                    <!-- Tree Name -->
                    <h3 class="text-center text-3xl font-bold text-[#4F6B3F] tracking-wider">
                        {{ $treeNames[$stage] ?? 'Growing Tree' }}
                    </h3>

                    <p class="text-center text-sm text-[#6B8254] mt-2 font-medium">
                        Stage <span class="text-xl font-bold text-[#5E7345]">{{ $stage - 1 }}</span> / 10
                    </p>

                    <!-- Special Message + Mini Progress for Seed Stage -->
                    @if ($stage === 1)
                        <div class="mt-8 text-center px-6">
                            <p class="text-lg font-semibold text-[#5E7345] italic leading-relaxed">
                                Grow your tree by earning points!
                            </p>
                            <p class="text-sm text-[#6B8254] mt-3">
                                Complete quests & daily eco-actions to watch it sprout
                            </p>

                            <!-- Mini progress to first real stage (50 pts) -->
                            <div class="mt-6">
                                <div class="text-xs text-[#6B8254] text-center mb-2">
                                    <span>0</span> → <span class="font-bold text-[#5E7345]">50 pts</span> for Sprout
                                </div>
                                <div class="w-full bg-[#E0E8D5]/70 rounded-full h-3 shadow-inner">
                                    <div class="bg-gradient-to-r from-[#7A8F55] to-[#5E7345] h-full rounded-full transition-all duration-1000"
                                        style="width: {{ min(100, ($myPoints / 50) * 100) }}%">
                                    </div>
                                </div>
                                <p class="text-xs text-[#6B8254] mt-2 font-medium">
                                    {{ $myPoints }} / 50 points
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Normal Progress Bar for Stage 2+ -->
                        <div class="mt-8">
                            <div class="flex justify-between text-xs text-[#6B8254] mb-2">
                                <span>{{ number_format($myPoints) }} pts</span>
                                <span>Next: {{ number_format($nextThreshold) }} pts</span>
                            </div>
                            <div class="w-full bg-[#E0E8D5]/80 rounded-full h-4 shadow-inner overflow-hidden">
                                <div class="bg-gradient-to-r from-[#7A8F55] to-[#5E7345] h-full rounded-full transition-all duration-1000 relative"
                                    style="width: {{ $progress }}%">
                                    <div class="absolute inset-0 bg-white/30 animate-shine"></div>
                                </div>
                            </div>
                            <p class="text-center text-xs text-[#6B8254] mt-3 font-medium">
                                {{ round($progress) }}% to {{ $treeNames[$stage + 1] ?? 'next stage' }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Compact Stats Grid -->
                <div class="grid grid-cols-3 gap-4 text-center">

                    <!-- Points -->
                    <div class="bg-white rounded-2xl py-5 shadow-sm border border-[#E8DBC7]">
                        <p class="text-2xl font-bold text-[#5E7345]">{{ number_format($myPoints) }}</p>
                        <p class="text-xs text-gray-600 mt-1">Points</p>
                        <p class="text-xs font-bold text-[#7A8F55] mt-2">Rank #{{ $rankPoints }}</p>
                    </div>

                    <!-- Quests -->
                    <div class="bg-white rounded-2xl py-5 shadow-sm border border-[#E8DBC7]">
                        <p class="text-2xl font-bold text-[#5E7345]">{{ $myQuests }}</p>
                        <p class="text-xs text-gray-600 mt-1">Quests</p>
                        <p class="text-xs font-bold text-[#7A8F55] mt-2">Rank #{{ $rankQuests }}</p>
                    </div>

                    <!-- Daily Taps -->
                    <div class="bg-white rounded-2xl py-5 shadow-sm border border-[#E8DBC7]">
                        <p class="text-2xl font-bold text-[#5E7345]">{{ $myDailyTaps }}</p>
                        <p class="text-xs text-gray-600 mt-1">Eco-Taps</p>
                        <p class="text-xs font-bold text-[#7A8F55] mt-2">Rank #{{ $rankTaps }}</p>
                    </div>

                </div>

                <!-- Pending Quests Placeholder -->
                <div class="text-center">
                    <p class="font-medium text-[#4F6B3F] mb-3">Pending Quests</p>
                    <div class="bg-white rounded-2xl p-6 shadow-sm text-gray-500 border border-dashed border-[#D7E2C3]">
                        <p class="text-3xl font-bold">3</p>
                        <p class="text-sm">In progress</p>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="lg:col-span-9 bg-[#F9F6EB] rounded-3xl p-10 shadow-md text-[#4F6B3F]">

                <!-- TITLE & BUTTONS -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div>
                        <h1 class="text-4xl font-serif font-bold">Leaderboard</h1>
                        <p class="text-lg font-sans text-[#6B8254]">Track your progress and achievements</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button id="btn-points"
                            class="px-6 py-3 bg-[#5E7345] text-white rounded-full shadow-sm font-semibold transition-all duration-200 hover:bg-[#4e5f3a]">
                            Top Points
                        </button>
                        <button id="btn-quests"
                            class="px-6 py-3 bg-[#7A8F55] text-white rounded-full shadow-sm transition-all duration-200 hover:bg-[#6b7d49]">
                            Top Quests
                        </button>
                        <button id="btn-ecotap"
                            class="px-6 py-3 bg-[#7A8F55] text-white rounded-full shadow-sm transition-all duration-200 hover:bg-[#6b7d49]">
                            Top Eco-Taps
                        </button>
                    </div>
                </div>

                <!-- LEADERBOARD CONTAINER -->
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

                    <!-- TOP BY POINTS -->
                    <div id="leaderboard-points" class="p-10 h-[675px] overflow-y-auto">
                        <h2 class="text-2xl font-serif font-bold mb-6 text-[#4F6B3F]">Top Progress Points</h2>
                        <div
                            class="grid grid-cols-3 text-center font-semibold text-lg pb-3 mb-4 border-b-2 border-[#D7E2C3] bg-[#E9ECDF]">
                            <p>Rank</p>
                            <p>User</p>
                            <p>Points</p>
                        </div>
                        @forelse($topByPoints as $index => $user)
                            <div class="grid grid-cols-3 text-center py-4 border-b border-[#D7E2C3] hover:bg-green-50 transition cursor-pointer"
                                onclick="window.location='{{ route('myprogress') }}'">
                                <p class="font-bold text-[#5E7345]">{{ $index + 1 }}</p>
                                <p class="font-medium">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="font-bold text-[#7A8F55]">{{ number_format($user->progressPoints) }}</p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-gray-500">No data available yet.</p>
                        @endforelse
                    </div>

                    <!-- TOP BY QUESTS -->
                    <div id="leaderboard-quests" class="p-10 h-[675px] overflow-y-auto hidden">
                        <h2 class="text-2xl font-serif font-bold mb-6 text-[#4F6B3F]">Top Completed Quests</h2>
                        <div
                            class="grid grid-cols-3 text-center font-semibold text-lg pb-3 mb-4 border-b-2 border-[#D7E2C3] bg-[#E9ECDF]">
                            <p>Rank</p>
                            <p>User</p>
                            <p>Quests Completed</p>
                        </div>
                        @forelse($topByQuests as $index => $user)
                            <div class="grid grid-cols-3 text-center py-4 border-b border-[#D7E2C3] hover:bg-green-50 transition cursor-pointer"
                                onclick="window.location='{{ route('myprogress') }}'">
                                <p class="font-bold text-[#5E7345]">{{ $index + 1 }}</p>
                                <p class="font-medium">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="font-bold text-[#7A8F55]">{{ $user->questsCompleted }}</p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-gray-500">No data available yet.</p>
                        @endforelse
                    </div>

                    <!-- TOP BY ECO-TAPS -->
                    <div id="leaderboard-ecotap" class="p-10 h-[675px] overflow-y-auto hidden">
                        <h2 class="text-2xl font-serif font-bold mb-6 text-[#4F6B3F]">Top Daily Eco-Taps</h2>
                        <div
                            class="grid grid-cols-3 text-center font-semibold text-lg pb-3 mb-4 border-b-2 border-[#D7E2C3] bg-[#E9ECDF]">
                            <p>Rank</p>
                            <p>User</p>
                            <p>Daily Eco Taps</p>
                        </div>
                        @forelse($topDailyTaps as $index => $user)
                            <div class="grid grid-cols-3 text-center py-4 border-b border-[#D7E2C3] hover:bg-green-50 transition cursor-pointer"
                                onclick="window.location='{{ route('myprogress') }}'">
                                <p class="font-bold text-[#5E7345]">{{ $index + 1 }}</p>
                                <p class="font-medium">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="font-bold text-[#7A8F55]">{{ $user->dailyEcoTaps }}</p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-gray-500">No data available yet.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sections = {
                points: document.getElementById('leaderboard-points'),
                quests: document.getElementById('leaderboard-quests'),
                ecotap: document.getElementById('leaderboard-ecotap')
            };

            const buttons = {
                points: document.getElementById('btn-points'),
                quests: document.getElementById('btn-quests'),
                ecotap: document.getElementById('btn-ecotap')
            };

            function showSection(target) {
                // Hide all sections
                Object.values(sections).forEach(sec => {
                    if (sec) sec.classList.add('hidden');
                });

                // Show target section
                if (sections[target]) sections[target].classList.remove('hidden');

                // Reset button styles
                Object.values(buttons).forEach(btn => {
                    if (btn) {
                        btn.classList.remove('bg-[#5E7345]', 'font-bold');
                        btn.classList.add('bg-[#7A8F55]', 'font-medium');
                    }
                });

                // Highlight active button
                if (buttons[target]) {
                    buttons[target].classList.remove('bg-[#7A8F55]', 'font-medium');
                    buttons[target].classList.add('bg-[#5E7345]', 'font-bold');
                }
            }

            // Add click listeners
            buttons.points?.addEventListener('click', () => showSection('points'));
            buttons.quests?.addEventListener('click', () => showSection('quests'));
            buttons.ecotap?.addEventListener('click', () => showSection('ecotap'));

            // Default: show Points leaderboard
            showSection('points');
        });
    </script>
@endsection
