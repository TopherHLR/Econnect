@extends('layouts.mainLayout')

@section('content')
    <div class="min-h-screen bg-[#E2EBD7] p-4 md:p-10 text-[#4F6B3F]">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

            <!-- LEFT SIDEBAR – Only for Authenticated Users -->
            @auth

                {{-- Sidebar Wrapper --}}
                <div id="sidebarLeader"
                    class="fixed inset-y-0  left-0 w-80 bg-[#FAF7EE] rounded-3xl shadow-xl p-8
                       transform transition-transform duration-300 ease-in-out
                       -translate-x-full lg:translate-x-0 lg:static lg:inset-auto lg:w-auto
                       lg:col-span-3 lg:py-8 py-15 md:col-span-3 sm:col-span-12" style="z-index: 1200;">

                    <h2 class="text-2xl font-bold text-[#4F6B3F] text-center mb-6">Your Growth</h2>

                    {{-- Content (same as before) --}}
                    <div class="flex flex-col space-y-6">

                        {{-- MAIN TREE BADGE CARD --}}
                        <div
                            class="bg-gradient-to-br from-[#F8F2E6] to-[#E8F0D8] rounded-3xl p-4 shadow-inner border-2 border-[#D4E4C1] overflow-hidden">
                            <div class="flex justify-center mb-2">
                                <img src="{{ Vite::asset('resources/images/badges/' . $treeStageSvgs[$stage]) }}"
                                    alt="{{ $treeNames[$stage] }}"
                                    class="w-44 h-44 sm:w-52 sm:h-52 md:w-60 md:h-60 animate-bounce-slow object-contain drop-shadow-2xl">
                            </div>

                            <h3 class="text-center text-2xl sm:text-3xl font-bold text-[#4F6B3F] tracking-wider">
                                {{ $treeNames[$stage] ?? 'Growing Tree' }}
                            </h3>
                            <p class="text-center text-sm text-[#6B8254] mt-1 font-medium">
                                Stage <span class="text-lg font-bold text-[#5E7345]">{{ $stage }}</span> / 10
                            </p>

                            @if ($stage === 1)
                                <div class="mt-3 text-center">
                                    <p class="text-base font-semibold text-[#5E7345] italic">Grow your tree by earning points!
                                    </p>
                                    <div class="mt-3 space-y-1">
                                        <div class="text-xs text-[#6B8254] text-center">
                                            <span>{{ $myPoints }}</span> / <span
                                                class="font-bold text-[#5E7345]">{{ $nextThreshold }} pts</span> for Sprout
                                        </div>
                                        <div class="w-full bg-[#E0E8D5]/70 rounded-full h-3 shadow-inner">
                                            <div class="bg-gradient-to-r from-[#7A8F55] to-[#5E7345] h-full rounded-full transition-all duration-1000"
                                                style="width: {{ $progressPercent }}%"></div>
                                        </div>
                                        <p class="text-xs text-[#6B8254] text-center">
                                            {{ round($progressPercent) }}% to next stage
                                            @if ($pointsRemaining > 0)
                                                ({{ $pointsRemaining }} pts)
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="mt-6 space-y-2">
                                    <div class="flex justify-between text-xs text-[#6B8254]">
                                        <span>{{ number_format($myPoints) }} pts</span>
                                        <span>Next: {{ number_format($nextThreshold) }}</span>
                                    </div>
                                    <div class="w-full bg-[#E0E8D5]/80 rounded-full h-3 shadow-inner overflow-hidden">
                                        <div class="bg-gradient-to-r from-[#7A8F55] to-[#5E7345] h-full rounded-full transition-all duration-1000 relative"
                                            style="width: {{ $progressPercent }}%">
                                            <div class="absolute inset-0 bg-white/30 animate-shine"></div>
                                        </div>
                                    </div>
                                    <p class="text-center text-xs text-[#6B8254]">
                                        {{ round($progressPercent) }}% to {{ $treeNames[$stage + 1] ?? 'next stage' }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Compact Stats Grid --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-white rounded-2xl py-7 shadow-sm border border-[#E8DBC7] text-center">
                                <p class="text-xl font-bold text-[#5E7345]">{{ number_format($myPoints) }}</p>
                                <p class="text-sm text-gray-600">Points</p>
                                <p class="text-md font-bold text-[#7A8F55]">Rank #{{ $rankPoints }}</p>
                            </div>
                            <div class="bg-white rounded-2xl py-7 shadow-sm border border-[#E8DBC7] text-center">
                                <p class="text-xl font-bold text-[#5E7345]">{{ $myQuests }}</p>
                                <p class="text-sm text-gray-600">Quests</p>
                                <p class="text-md font-bold text-[#7A8F55]">Rank #{{ $rankQuests }}</p>
                            </div>
                            <div class="bg-white rounded-2xl py-7 shadow-sm border border-[#E8DBC7] text-center">
                                <p class="text-xl font-bold text-[#5E7345]">{{ $myDailyTaps }}</p>
                                <p class="text-sm text-gray-600">Eco-Taps</p>
                                <p class="text-md font-bold text-[#7A8F55]">Rank #{{ $rankTaps }}</p>
                            </div>
                        </div>

                        {{-- Pending Quests --}}
                        <div class="text-center">
                            <p class="font-medium text-[#4F6B3F] mb-2">Pending Quests</p>
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-dashed border-[#D7E2C3]">
                                <p class="text-3xl font-bold text-[#5E7345]">{{ $pendingQuests }}</p>
                                <p class="text-sm text-gray-500">In progress</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Overlay (click to close on mobile) --}}
                <div id="sidebar-overlayLeader"
                    class="fixed inset-0 bg-black/30 z-30 hidden lg:hidden transition-opacity duration-300"></div>
            @endauth

            <!-- RIGHT SIDE – Full width for guests -->
            <div
                class="{{ auth()->check() ? 'lg:col-span-9' : 'lg:col-span-12' }} lg:mt-0 mt-5 bg-[#F9F6EB] rounded-3xl p-8 shadow-md text-[#4F6B3F]">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5 gap-4">
                    {{-- Toggle Button (mobile & tablet) --}}
                    <button id="sidebar-toggleLeader"
                        class="lg:hidden fixed top-6 mt-16 right-8 z-30 p-2 bg-[#FAF7EE] rounded-full shadow-lg transition-all duration-300 hover:scale-110">
                        <svg id="toggle-icon-open" class="w-6 h-6 text-[#4F6B3F] block" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="toggle-icon-close" class="w-6 h-6 text-[#4F6B3F] hidden" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-4xl font-serif font-bold">Leaderboard</h1>
                        <p class="text-lg font-sans text-[#6B8254]">Track your progress and achievements</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button id="btn-points"
                            class="px-6 py-3 sm:w-auto bg-[#5E7345] text-white rounded-full shadow-sm font-semibold transition-all duration-200 hover:bg-[#4e5f3a]">Top
                            Points</button>
                        <button id="btn-quests"
                            class="px-6 py-3 sm:w-auto bg-[#7A8F55] text-white rounded-full shadow-sm transition-all duration-200 hover:bg-[#6b7d49]">Top
                            Quests</button>
                        <button id="btn-ecotap"
                            class="px-6 py-3 sm:w-auto bg-[#7A8F55] text-white rounded-full shadow-sm transition-all duration-200 hover:bg-[#6b7d49]">Top
                            Eco-Taps</button>
                    </div>
                </div>

                <div class="mb-5 overflow-hidden bg-gradient-to-r from-[#5E7345] to-[#7A8F55] rounded-2xl shadow-lg">
                    <div class="py-3 px-6 text-white font-semibold flex items-center gap-4">
                        <span class="flex-shrink-0 animate-pulse bg-[#F8F2E6]/20 px-4 py-1 rounded-full text-sm">LIVE
                            TOP
                            PERFORMERS</span>
                        <div class="ticker-wrapper whitespace-nowrap">
                            <div class="ticker-content inline-block animate-ticker">
                                @php
                                    $currentUserId = auth()->check() ? auth()->user()->user_id : null;
                                @endphp

                                <!-- Generate items once -->
                                @php
                                    $items = collect();

                                    foreach ($topByPoints->take(3) as $i => $u) {
                                        $isYou = $currentUserId && $u->user_id == $currentUserId;
                                        $items->push([
                                            'icon' => $isYou ? 'star' : 'trophy',
                                            'label' => '#' . ($i + 1) . ' Points',
                                            'name' => $u->first_name . ' ' . substr($u->last_name, 0, 1) . '.',
                                            'value' => number_format($u->progressPoints) . ' pts',
                                            'is_you' => $isYou,
                                        ]);
                                    }
                                    foreach ($topByQuests->take(3) as $i => $u) {
                                        $isYou = $currentUserId && $u->user_id == $currentUserId;
                                        $items->push([
                                            'icon' => $isYou ? 'star' : 'check',
                                            'label' => '#' . ($i + 1) . ' Quests',
                                            'name' => $u->first_name . ' ' . substr($u->last_name, 0, 1) . '.',
                                            'value' => $u->questsCompleted . ' completed',
                                            'is_you' => $isYou,
                                        ]);
                                    }
                                    foreach ($topDailyTaps->take(3) as $i => $u) {
                                        $isYou = $currentUserId && $u->user_id == $currentUserId;
                                        $items->push([
                                            'icon' => $isYou ? 'star' : 'globe',
                                            'label' => '#' . ($i + 1) . ' Eco-Taps',
                                            'name' => $u->first_name . ' ' . substr($u->last_name, 0, 1) . '.',
                                            'value' => $u->dailyEcoTaps . ' taps',
                                            'is_you' => $isYou,
                                        ]);
                                    }
                                @endphp

                                <!-- Render items twice for seamless loop -->
                                @foreach ([$items, $items] as $set)
                                    @foreach ($set as $item)
                                        <span
                                            class="mx-8 inline-flex items-center gap-3 {{ $item['is_you'] ? 'animate-pulse font-extrabold drop-shadow-lg' : '' }}">
                                            @if ($item['icon'] === 'star')
                                                <svg class="w-7 h-7 text-yellow-300 drop-shadow" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 .587l3.668 7.431 8.332 1.209-6 5.849 1.416 8.258L12 19.897l-7.416 3.897 1.416-8.258-6-5.849 8.332-1.209z" />
                                                </svg>
                                            @elseif($item['icon'] === 'trophy')
                                                <svg class="w-7 h-7 text-yellow-200" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2l2.5 5.5h5.5l-4.5 3.5 1.5 5.5-5-3.5-5 3.5 1.5-5.5-4.5-3.5h5.5z" />
                                                    <path d="M8 21h8v-4h-8v4z" />
                                                    <path
                                                        d="M5 17c-1.1 0-2 .9-2 2v2h2v-2c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v2h2v-2c0-1.1-.9-2-2-2h-1v-2h-2v2H8v-2H6v2H5z" />
                                                </svg>
                                            @elseif($item['icon'] === 'check')
                                                <svg class="w-7 h-7 text-emerald-200" fill="none" stroke="currentColor"
                                                    stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @elseif($item['icon'] === 'globe')
                                                <svg class="w-7 h-7 text-cyan-200" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.055 11h3.89m7.11 0h3.89M12 4.5a8.5 8.5 0 100 17 8.5 8.5 0 000-17z" />
                                                    <circle cx="12" cy="12" r="3.5" stroke="currentColor"
                                                        stroke-width="2" fill="none" />
                                                </svg>
                                            @endif

                                            <span
                                                class="font-bold {{ $item['is_you'] ? 'text-yellow-300' : '' }}">{{ $item['label'] }}</span>
                                            <span
                                                class="font-medium {{ $item['is_you'] ? 'text-white underline decoration-2 underline-offset-2' : '' }}">
                                                {{ $item['name'] }} @if ($item['is_you'])
                                                    (You!)
                                                @endif
                                            </span>
                                            <span class="text-[#F8F2E6] font-medium">{{ $item['value'] }}</span>
                                            <span class="mx-4 text-[#F8F2E6]/60">|</span>
                                        </span>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LEADERBOARD CONTAINER -->
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
                    @php $currentUserId = auth()->check() ? auth()->user()->user_id : null; @endphp

                    <!-- TOP BY POINTS -->
                    <div id="leaderboard-points" class="p-8 h-[650px] overflow-y-auto">
                        <h2 class="text-2xl font-serif font-bold mb-6 text-[#4F6B3F]">Top Progress Points</h2>
                        <div
                            class="grid grid-cols-3 text-center font-semibold text-lg pb-3 mb-4 border-b-2 border-[#D7E2C3] bg-[#E9ECDF]">
                            <p>Rank</p>
                            <p>User</p>
                            <p>Points</p>
                        </div>
                        @forelse($topByPoints as $index => $user)
                            @php $isYou = $currentUserId && $user->user_id == $currentUserId; @endphp
                            <div class="grid grid-cols-3 text-center py-4 border-b border-[#D7E2C3] transition cursor-pointer
                                {{ $isYou ? 'bg-gradient-to-r from-yellow-50 to-green-50 border-l-4 border-l-[#7A8F55] shadow-md font-bold' : 'hover:bg-green-50' }}"
                                onclick="window.location='{{ route('myprogress') }}'">
                                <p class="text-[#5E7345]">
                                    {{ $index + 1 }} @if ($isYou)
                                    @endif
                                </p>
                                <p class="font-medium {{ $isYou ? 'text-[#4F6B3F]' : '' }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    @if ($isYou)
                                        <span class="text-xs text-[#7A8F55] font-bold">(You)</span>
                                    @endif
                                </p>
                                <p class="font-bold text-[#7A8F55]">{{ number_format($user->progressPoints) }}</p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-gray-500">No data available yet.</p>
                        @endforelse
                    </div>

                    <!-- TOP BY QUESTS -->
                    <div id="leaderboard-quests" class="p-8 h-[650px] overflow-y-auto hidden">
                        <h2 class="text-2xl font-serif font-bold mb-6 text-[#4F6B3F]">Top Completed Quests</h2>
                        <div
                            class="grid grid-cols-3 text-center font-semibold text-lg pb-3 mb-4 border-b-2 border-[#D7E2C3] bg-[#E9ECDF]">
                            <p>Rank</p>
                            <p>User</p>
                            <p>Quests Completed</p>
                        </div>
                        @forelse($topByQuests as $index => $user)
                            @php $isYou = $currentUserId && $user->user_id == $currentUserId; @endphp
                            <div class="grid grid-cols-3 text-center py-4 border-b border-[#D7E2C3] transition cursor-pointer
                                {{ $isYou ? 'bg-gradient-to-r from-yellow-50 to-green-50 border-l-4 border-l-[#7A8F55] shadow-md font-bold' : 'hover:bg-green-50' }}"
                                onclick="window.location='{{ route('myprogress') }}'">
                                <p class="text-[#5E7345]">
                                    {{ $index + 1 }} @if ($isYou)
                                    @endif
                                </p>
                                <p class="font-medium {{ $isYou ? 'text-[#4F6B3F]' : '' }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    @if ($isYou)
                                        <span class="text-xs text-[#7A8F55] font-bold">(You)</span>
                                    @endif
                                </p>
                                <p class="font-bold text-[#7A8F55]">{{ $user->questsCompleted }}</p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-gray-500">No data available yet.</p>
                        @endforelse
                    </div>

                    <!-- TOP BY ECO-TAPS -->
                    <div id="leaderboard-ecotap" class="p-8 h-[650px] overflow-y-auto hidden">
                        <h2 class="text-2xl font-serif font-bold mb-6 text-[#4F6B3F]">Top Daily Eco-Taps</h2>
                        <div
                            class="grid grid-cols-3 text-center font-semibold text-lg pb-3 mb-4 border-b-2 border-[#D7E2C3] bg-[#E9ECDF]">
                            <p>Rank</p>
                            <p>User</p>
                            <p>Daily Eco Taps</p>
                        </div>
                        @forelse($topDailyTaps as $index => $user)
                            @php $isYou = $currentUserId && $user->user_id == $currentUserId; @endphp
                            <div class="grid grid-cols-3 text-center py-4 border-b border-[#D7E2C3] transition cursor-pointer
                                {{ $isYou ? 'bg-gradient-to-r from-yellow-50 to-green-50 border-l-4 border-l-[#7A8F55] shadow-md font-bold' : 'hover:bg-green-50' }}"
                                onclick="window.location='{{ route('myprogress') }}'">
                                <p class="text-[#5E7345]">
                                    {{ $index + 1 }} @if ($isYou)
                                    @endif
                                </p>
                                <p class="font-medium {{ $isYou ? 'text-[#4F6B3F]' : '' }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    @if ($isYou)
                                        <span class="text-xs text-[#7A8F55] font-bold">(You)</span>
                                    @endif
                                </p>
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
                Object.values(sections).forEach(sec => sec?.classList.add('hidden'));
                sections[target]?.classList.remove('hidden');

                Object.values(buttons).forEach(btn => {
                    btn?.classList.remove('bg-[#5E7345]', 'font-bold');
                    btn?.classList.add('bg-[#7A8F55]', 'font-medium');
                });

                buttons[target]?.classList.remove('bg-[#7A8F55]', 'font-medium');
                buttons[target]?.classList.add('bg-[#5E7345]', 'font-bold');
            }

            buttons.points?.addEventListener('click', () => showSection('points'));
            buttons.quests?.addEventListener('click', () => showSection('quests'));
            buttons.ecotap?.addEventListener('click', () => showSection('ecotap'));

            showSection('points');
        });
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('sidebar-toggleLeader');
            const sidebar = document.getElementById('sidebarLeader');
            const overlay = document.getElementById('sidebar-overlayLeader');
            const openIcon = document.getElementById('toggle-icon-open');
            const closeIcon = document.getElementById('toggle-icon-close');

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');

            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');

            };

            toggleBtn?.addEventListener('click', () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            overlay?.addEventListener('click', closeSidebar);

            // Auto-close on large screens
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
@endsection
