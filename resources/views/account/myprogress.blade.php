@extends('layouts.accountLayout')

@section('account_content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div>
            <h1 class="text-3xl font-bold text-[#4F6B3F] flex items-center">
                Your Eco-Journey So Far <span class="ml-3 text-2xl">🌱</span>
            </h1>
            <p class="text-[#6B665E] mt-2 text-lg">Track your growth, achievements, and daily impact.</p>
        </div>

        <div class="flex flex-col md:items-end space-y-3 w-full md:w-auto">
            <div
                class="bg-gradient-to-r from-[#8B6E4A] to-[#9D845F] text-white rounded-full px-6 py-3 flex items-center space-x-3 font-bold shadow-lg">
                <span class="text-xl">🌿</span>
                <span class="text-xl">{{ $ecoPoints }} Eco Points</span>
            </div>

            <div
                class="bg-gradient-to-r from-[#F2E8D5] to-[#F8F2E6] text-[#4F6B3F] rounded-full px-5 py-2 font-semibold shadow-md border border-[#E8DBC7]">
                Rank: Eco Defender
            </div>
        </div>
    </div>

    <!-- Progress Cards -->
    @php
        $progressCards = [
            [
                'title' => 'Tree Growth',
                'percent' => $treePercent,
                'color' => '#4F6B3F',
                'desc' => 'Grow your virtual tree!',
            ],
            [
                'title' => 'Quests Completed',
                'percent' => $questsPercent,
                'color' => '#7CA86C',
                'desc' => "$completedQuestsByUser quests completed!",
            ],
        ];
    @endphp
    <div class="flex flex-wrap gap-6 mb-8">

        <!-- Progress Cards -->
        @foreach ($progressCards as $card)
            <div
                class="flex-1 min-w-[220px] bg-gradient-to-br from-white to-[#F8F9F5] rounded-2xl p-6 shadow-lg hover:shadow-xl transform transition-all hover:scale-[1.02] border border-[#E6F4EA] text-center">
                <div class="relative flex justify-center mb-4">
                    <div class="relative w-28 h-28">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" stroke="#E8E6DC" stroke-width="8" fill="none" />
                            <circle cx="50" cy="50" r="40" stroke="{{ $card['color'] }}" stroke-width="8"
                                fill="none" stroke-dasharray="251.2"
                                stroke-dashoffset="{{ 251.2 - 251.2 * ($card['percent'] / 100) }}" stroke-linecap="round" />
                        </svg>
                        <div class="absolute inset-0 flex justify-center items-center">
                            <span class="text-2xl font-bold text-[#4B3F2F]">{{ round($card['percent']) }}%</span>
                        </div>
                    </div>
                </div>

                <p class="font-semibold text-lg text-[#4B3F2F]">{{ $card['title'] }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $card['desc'] }}</p>

                <div class="mt-4 bg-[#ECF4E7] rounded-full h-2">
                    <div class="h-2 rounded-full" style="background: {{ $card['color'] }}; width: {{ $card['percent'] }}%">
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Stats Summary -->
        <div
            class="flex-1 min-w-[220px] bg-gradient-to-r from-[#FDFCF8] to-[#FCFFF6] rounded-2xl shadow-md p-6 border border-[#F2E8D5] grid grid-cols-1 gap-4">
            <div class="bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-md">
                <p class="text-sm font-semibold text-[#4B3F2F] mb-2">Total Eco-Actions</p>
                <p class="text-3xl font-bold text-[#4F6B3F]">{{ $ecoActions }}</p>
            </div>

            <div class="bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-md">
                <p class="text-sm font-semibold text-[#4B3F2F] mb-2">Points Earned</p>
                <p class="text-3xl font-bold text-[#4F6B3F]">{{ $ecoPoints }}</p>
            </div>

        </div>

    </div>


    <!-- Consistency Tracker -->
    <div class="bg-gradient-to-r from-[#FDFCF8] to-[#FCFFF6] p-6 rounded-2xl shadow-md mb-8 border border-[#F2E8D5]">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-[#4B3F2F]">Consistency Tracker</h2>
            <div class="mt-2 md:mt-0 bg-[#4F6B3F] text-white rounded-full px-4 py-1 text-sm font-medium">
                Current Streak: {{ $currentStreak ?? 0 }} days
            </div>
        </div>

        <p class="text-[#4B3F2F] mb-4 text-center md:text-left">
            You've been consistent for {{ $currentStreak ?? 0 }} days! Keep going 😊
        </p>

        <div class="flex items-center justify-center md:justify-start space-x-3 flex-wrap gap-3">
            @php
                // Display the dates for the current streak
                $streakDates = [];
                for ($i = 0; $i < $currentStreak; $i++) {
                    $streakDates[] = now()->subDays($i)->format('M d'); // e.g., Nov 25
                }
                $streakDates = array_reverse($streakDates); // oldest first
            @endphp

            @foreach ($streakDates as $date)
                <div
                    class="rounded-full bg-gradient-to-br from-[#4F6B3F] to-[#5A7A47] w-14 h-14 flex justify-center items-center text-white text-sm font-semibold shadow-md">
                    {{ $date }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="bg-gradient-to-br from-[#FCFFF6] to-[#FDFCF8] rounded-2xl shadow-md p-6 mb-8 border border-[#ECF4E7]">
        <h2 class="text-xl font-semibold text-[#4B3F2F] mb-4">Recent Quest Submissions</h2>

        <div class="space-y-4">
            @foreach ($recentSubmissions as $submission)
                <div class="flex justify-between items-center bg-white rounded-xl p-4 shadow-sm hover:shadow-md border">
                    <div>
                        <p class="font-semibold text-[#4B3F2F]">{{ $submission->quest->title }}</p>

                        <p class="text-sm text-gray-500 mt-1">
                            Submitted:
                            {{ $submission->date_submitted ? $submission->date_submitted->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>

                    <div
                        class="rounded-full px-3 py-1 text-sm font-medium 
        {{ $submission->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($submission->status) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Badges Section -->
    <div class="bg-gradient-to-br from-[#F2E8D5] to-[#F8F2E6] rounded-3xl p-6 shadow-md mb-8 border border-[#E8DBC7]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#4F6B3F]">Your Badges</h2>
            <span class="text-[#6B665E] text-sm">3 of 12 unlocked</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            <div
                class="flex flex-col items-center bg-white rounded-2xl p-4 shadow hover:scale-105 transform transition duration-300 border border-[#F2E8D5]">
                <div
                    class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-[#8B6E4A] to-[#9D845F] text-white text-3xl shadow-md mb-3">
                    ☀️
                </div>
                <p class="text-sm font-semibold text-[#4B3F2F] text-center">Mindful Mover</p>
                <p class="text-xs text-gray-500 mt-1">Earned: Nov 5</p>
            </div>
            <div
                class="flex flex-col items-center bg-white rounded-2xl p-4 shadow hover:scale-105 transform transition duration-300 border border-[#F2E8D5]">
                <div
                    class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-[#7CA86C] to-[#8BB87A] text-white text-3xl shadow-md mb-3">
                    💧
                </div>
                <p class="text-sm font-semibold text-[#4B3F2F] text-center">Eco Warrior</p>
                <p class="text-xs text-gray-500 mt-1">Earned: Nov 3</p>
            </div>
            <div
                class="flex flex-col items-center bg-white rounded-2xl p-4 shadow hover:scale-105 transform transition duration-300 border border-[#F2E8D5]">
                <div
                    class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-[#4F6B3F] to-[#5A7A47] text-white text-3xl shadow-md mb-3">
                    🌿
                </div>
                <p class="text-sm font-semibold text-[#4B3F2F] text-center">Tree Tender</p>
                <p class="text-xs text-gray-500 mt-1">Earned: Oct 28</p>
            </div>
            <!-- Locked badges -->
            <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow border border-[#F2E8D5] opacity-60">
                <div
                    class="w-16 h-16 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 text-3xl shadow-md mb-3">
                    🌎
                </div>
                <p class="text-sm font-semibold text-gray-400 text-center">Global Guardian</p>
                <p class="text-xs text-gray-400 mt-1">Locked</p>
            </div>
            <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow border border-[#F2E8D5] opacity-60">
                <div
                    class="w-16 h-16 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 text-3xl shadow-md mb-3">
                    ♻️
                </div>
                <p class="text-sm font-semibold text-gray-400 text-center">Recycling Hero</p>
                <p class="text-xs text-gray-400 mt-1">Locked</p>
            </div>
            <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow border border-[#F2E8D5] opacity-60">
                <div
                    class="w-16 h-16 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 text-3xl shadow-md mb-3">
                    🚶
                </div>
                <p class="text-sm font-semibold text-gray-400 text-center">Carbon Walker</p>
                <p class="text-xs text-gray-400 mt-1">Locked</p>
            </div>
        </div>
    </div>
    <!-- Leaderboard Section -->
    <div class="bg-gradient-to-br from-[#FCFFF6] to-[#FDFCF8] p-6 rounded-2xl shadow-md mb-8 border border-[#ECF4E7]">
        <h2 class="text-2xl font-bold text-[#4F6B3F] mb-4">Top Progress Leaderboard</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-[#E8E6DC]">
                        <th class="py-2 font-semibold">Rank</th>
                        <th class="py-2 font-semibold">User</th>
                        <th class="py-2 font-semibold">Progress Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $index => $user)
                        <tr class="border-b border-[#F2E8D5] hover:bg-[#FCFFF6] transition cursor-pointer"
                            onclick="window.location='{{ route('leaderboard') }}'">
                            <td class="py-2 font-semibold">{{ $index + 1 }}</td>
                            <td class="py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-2 font-semibold text-[#4F6B3F]">{{ $user->progressPoints }}</td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
    </div>

    <!-- History Table -->
    <div class="bg-gradient-to-br from-[#FDFCF8] to-[#FCFFF6] p-6 rounded-2xl shadow-md border">
        <h2 class="text-xl font-semibold text-[#4B3F2F] mb-4">Recent Activity History</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[#4B3F2F]">
                <thead>
                    <tr class="border-b-2 border-[#E8E6DC]">
                        <th class="pb-3 font-semibold">Date</th>
                        <th class="pb-3 font-semibold">Points Change</th>
                        <th class="pb-3 font-semibold">Reason</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($recentHistory as $row)
                        <tr class="border-b border-[#F2E8D5] hover:bg-[#FCFFF6] transition">
                            <td class="py-3">{{ $row->created_at->format('M d, Y') }}</td>
                            <td
                                class="py-3 font-semibold {{ $row->points_change > 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $row->points_change }}
                            </td>
                            <td class="py-3">
                                @php
                                    $reason = 'Activity';

                                    if (is_string($row->source)) {
                                        $reason = $row->source;
                                    } elseif ($row->questSubmission) {
                                        $questTitle = $row->questSubmission->quest
                                            ? $row->questSubmission->quest->title
                                            : 'Unknown Quest';
                                        $reason =
                                            'Quest #' .
                                            $row->questSubmission->quest_id .
                                            ' | ' .
                                            $questTitle .
                                            ' - ' .
                                            ucfirst($row->questSubmission->status);
                                    }
                                @endphp

                                {{ $reason }}
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
