@extends('layouts.mainLayout')

@section('content')
    <div class="min-h-screen bg-[#E2EBD7] p-4 md:p-10 text-[#4F6B3F]"> <!-- Responsive padding -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

            <!-- LEFT SIDEBAR -->
            <div class="lg:col-span-3 bg-[#FAF7EE] rounded-3xl p-4 md:p-6 shadow-md space-y-6">
                <h2 class="text-lg md:text-xl font-semibold">Your Stats</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl p-6 md:p-8 h-32 md:h-38 text-center shadow-sm"></div>
                    <div class="bg-white rounded-2xl p-6 md:p-8 h-32 md:h-38 text-center shadow-sm"></div>
                </div>

                <div class="bg-white rounded-2xl p-8 md:p-10 h-32 md:h-40 text-center shadow-sm"></div>

                <div>
                    <p class="font-medium mb-2">Pending Quests</p>
                    <div class="bg-white rounded-2xl h-48 md:h-90 shadow-sm"></div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-span-9 bg-[#F9F6EB] rounded-3xl p-10 shadow-md text-[#4F6B3F]">

                <!-- BUTTONS -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-[36px] text-4xl font-serif font-bold">Leaderboard</h1>
                        <p class="text-[16px] font-sans -mt-1">Track your progress and achievements</p>
                    </div>

                    <div class="flex gap-4">
                        <button id="btn-points"
                            class="px-6 py-2 bg-[#7A8F55] text-white rounded-full shadow-sm transition duration-200">
                            Top Points
                        </button>
                        <button id="btn-quests"
                            class="px-6 py-2 bg-[#7A8F55] text-white rounded-full shadow-sm transition duration-200">
                            Top Quests
                        </button>
                        <button id="btn-ecotap"
                            class="px-6 py-2 bg-[#7A8F55] text-white rounded-full shadow-sm transition duration-200">
                            Top Eco-Taps
                        </button>
                    </div>
                </div>

                <!-- ==== LEADERBOARDS ==== -->
                <!-- TOP BY PROGRESS POINTS -->
                <div id="leaderboard-points" class="bg-white rounded-3xl p-10 shadow-sm h-[675px] overflow-y-auto">
                    <h2 class="text-2xl font-serif font-bold mb-6">Top Progress Points</h2>
                    <div
                        class="grid grid-cols-3 text-center text-l font-semibold pb-3 mb-3 border-b border-[#D7E2C3] bg-[#E9ECDF] pt-3">
                        <p>Rank</p>
                        <p>User</p>
                        <p>Points</p>
                    </div>
                    @foreach ($topByPoints as $index => $user)
                        <div class="grid grid-cols-3 text-center py-3 border-b border-[#D7E2C3] hover:bg-green-50 cursor-pointer"
                            onclick="window.location='{{ route('myprogress') }}'">
                            <p class="font-semibold">{{ $index + 1 }}</p>
                            <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p class="font-semibold">{{ $user->progressPoints }}</p>
                        </div>

                        <!-- TOP BY COMPLETED QUESTS -->
                        <div id="leaderboard-quests"
                            class="bg-white rounded-3xl p-10 shadow-sm h-[675px] overflow-y-auto hidden">
                            <h2 class="text-2xl font-serif font-bold mb-6">Top Completed Quests</h2>
                            <div
                                class="grid grid-cols-3 text-center text-l font-semibold pb-3 mb-3 border-b border-[#D7E2C3] bg-[#E9ECDF] pt-3">
                                <p>Rank</p>
                                <p>User</p>
                                <p>Quests Completed</p>
                            </div>
                            @foreach ($topByQuests as $index => $user)
                                <div class="grid grid-cols-3 text-center py-3 border-b border-[#D7E2C3] hover:bg-green-50 cursor-pointer"
                                    onclick="window.location='{{ route('myprogress') }}'">
                                    <p class="font-semibold">{{ $index + 1 }}</p>
                                    <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                                    <p class="font-semibold">{{ $user->questsCompleted }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- TOP DAILY ECO ACTIONS -->
                        <div id="leaderboard-ecotap"
                            class="bg-white rounded-3xl p-10 shadow-sm h-[675px] overflow-y-auto hidden">
                            <h2 class="text-2xl font-serif font-bold mb-6">Top Daily Eco-Taps</h2>
                            <div
                                class="grid grid-cols-3 text-center text-l font-semibold pb-3 mb-3 border-b border-[#D7E2C3] bg-[#E9ECDF] pt-3">
                                <p>Rank</p>
                                <p>User</p>
                                <p>Daily Eco Actions</p>
                            </div>
                            @foreach ($topDailyActions as $index => $user)
                                <div class="grid grid-cols-3 text-center py-3 border-b border-[#D7E2C3] hover:bg-green-50 cursor-pointer"
                                    onclick="window.location='{{ route('myprogress') }}'">
                                    <p class="font-semibold">{{ $index + 1 }}</p>
                                    <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                                    <p class="font-semibold">{{ $user->dailyEcoActions }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
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
                Object.values(sections).forEach(sec => sec.classList.add('hidden'));
                sections[target].classList.remove('hidden');

                // Reset all buttons to light green
                Object.values(buttons).forEach(btn => {
                    btn.classList.remove('bg-[#5E7345]', 'font-semibold');
                    btn.classList.add('bg-[#7A8F55]');
                });

                // Make active button dark green
                buttons[target].classList.remove('bg-[#7A8F55]');
                buttons[target].classList.add('bg-[#5E7345]', 'font-semibold');
            }

            buttons.points.addEventListener('click', () => showSection('points'));
            buttons.quests.addEventListener('click', () => showSection('quests'));
            buttons.ecotap.addEventListener('click', () => showSection('ecotap'));

            // Initialize with points leaderboard active
            showSection('points');
        });
    </script>
@endsection
