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
        <div class="lg:col-span-9 bg-[#F9F6EB] rounded-3xl p-4 md:p-10 shadow-md">

            <!-- BUTTONS -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 md:gap-0">
                <div>
                    <h1 class="text-2xl md:text-[36px] font-bold">Leaderboard</h1>
                    <p class="text-sm md:text-[16px] -mt-1">Track your progress and achievements</p>
                </div>

                <div class="flex flex-wrap gap-2 md:gap-4 mt-2 md:mt-0">
                    <button id="btn-points"
                        class="px-4 md:px-6 py-2 bg-[#7A8F55] hover:bg-[#5E7345] transition duration-200 text-white rounded-full shadow-sm text-sm md:text-base">
                        Top Points
                    </button>

                    <button id="btn-quests"
                        class="px-4 md:px-6 py-2 bg-[#7A8F55] hover:bg-[#5E7345] transition duration-200 text-white rounded-full shadow-sm text-sm md:text-base">
                        Top Quests
                    </button>

                    <button id="btn-ewan"
                        class="px-4 md:px-6 py-2 bg-[#7A8F55] hover:bg-[#5E7345] transition duration-200 text-white rounded-full shadow-sm text-sm md:text-base">
                        Top Eco-Taps
                    </button>
                </div>
            </div>

            <!-- Leaderboard Sections -->
            @php
                $leaderboards = [
                    'points' => ['title' => 'Top Progress Points', 'items' => $topByPoints, 'value' => 'progressPoints'],
                    'quests' => ['title' => 'Top Completed Quests', 'items' => $topByQuests, 'value' => 'questsCompleted'],
                    'ewan' => ['title' => 'Top Daily Eco-Taps', 'items' => $topDailyActions, 'value' => 'dailyEcoActions']
                ];
            @endphp

            @foreach ($leaderboards as $key => $board)
                <div id="leaderboard-{{ $key }}" class="bg-white rounded-3xl p-6 md:p-10 shadow-sm h-[500px] md:h-[675px] overflow-y-auto @if($key !== 'points') hidden @endif mb-6">
                    <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">{{ $board['title'] }}</h2>

                    <div class="grid grid-cols-3 text-center text-sm md:text-xl font-semibold pb-2 md:pb-3 mb-2 md:mb-3 border-b border-[#D7E2C3]">
                        <p>Rank</p>
                        <p>User</p>
                        <p>{{ $key === 'quests' ? 'Quests Completed' : ($key === 'ewan' ? 'Daily Eco Actions' : 'Points') }}</p>
                    </div>

                    @foreach ($board['items'] as $index => $user)
                        <div class="grid grid-cols-3 text-center py-2 md:py-3 border-b border-[#D7E2C3] hover:bg-green-50 cursor-pointer"
                             onclick="window.location='{{ route('myprogress') }}'">
                            <p class="font-semibold">{{ $index + 1 }}</p>
                            <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p class="font-semibold">{{ $user->{$board['value']} }}</p>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sections = {
        points: document.getElementById('leaderboard-points'),
        quests: document.getElementById('leaderboard-quests'),
        ewan: document.getElementById('leaderboard-ewan')
    };

    const buttons = {
        points: document.getElementById('btn-points'),
        quests: document.getElementById('btn-quests'),
        ewan: document.getElementById('btn-ewan')
    };

    function showSection(target) {
        Object.values(sections).forEach(sec => sec.classList.add('hidden'));
        sections[target].classList.remove('hidden');

        Object.values(buttons).forEach(btn => {
            btn.classList.remove('bg-[#5E7345]', 'font-semibold');
            btn.classList.add('bg-[#7A8F55]');
        });

        buttons[target].classList.remove('bg-[#7A8F55]');
        buttons[target].classList.add('bg-[#5E7345]', 'font-semibold');
    }

    buttons.points.addEventListener('click', () => showSection('points'));
    buttons.quests.addEventListener('click', () => showSection('quests'));
    buttons.ewan.addEventListener('click', () => showSection('ewan'));

    showSection('points');
});
</script>
@endsection
