@extends('layouts.mainLayout')

@section('content')
<div class="min-h-screen bg-[#E2EBD7] p-10">
    <div class="grid grid-cols-12 gap-8">

        <!-- LEFT SIDEBAR -->
        <div class="col-span-3 bg-[#FAF7EE] rounded-3xl p-6 shadow-md space-y-6">

            <h2 class="text-lg font-semibold text-gray-700">Your Stats</h2>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white border rounded-2xl p-5 text-center shadow-sm">
                </div>

                <div class="bg-white border rounded-2xl p-5 text-center shadow-sm">
                </div>
            </div>

            <div class="bg-white border rounded-2xl p-8 text-center shadow-sm">
            </div>

            <div>
                <p class="font-medium text-gray-700 mb-2">Pending Quests</p>
                <div class="bg-white border rounded-2xl h-40 shadow-sm"></div>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-span-9 bg-[#F9F6EB] rounded-3xl p-10 shadow-md">

            <h1 class="text-4xl font-bold text-black">Leaderboard</h1>
            <p class="text-sm text-gray-700 -mt-1 mb-6">Track your progress</p>

            <!-- BUTTONS -->
            <div class="flex gap-4 mb-8">
                <button class="px-6 py-2 bg-[#7A8F55] text-white rounded-full shadow-sm">
                    Top Points
                </button>
                <button class="px-6 py-2 bg-[#7A8F55] text-white rounded-full shadow-sm">
                    Top Quests
                </button>
                <button class="px-6 py-2 bg-[#7A8F55] text-white rounded-full shadow-sm">
                    Top Ewan
                </button>
            </div>

            <!-- ==== TOP BY PROGRESS POINTS ==== -->
            <div class="bg-white border rounded-3xl p-10 shadow-sm mb-10">

                <h2 class="text-2xl font-bold text-green-800 mb-6">Top Progress Points</h2>

                <div class="grid grid-cols-3 text-center text-xl font-semibold text-black border-b pb-3 mb-3">
                    <p>Rank</p>
                    <p>User</p>
                    <p>Points</p>
                </div>

                @foreach ($topByPoints as $index => $user)
                <div class="grid grid-cols-3 text-center py-3 border-b hover:bg-green-50 cursor-pointer"
                     onclick="window.location='{{ route('myprogress') }}'">
                    <p class="font-semibold">{{ $index + 1 }}</p>
                    <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="font-semibold text-green-800">{{ $user->progressPoints }}</p>
                </div>
                @endforeach
            </div>

            <!-- ==== TOP BY COMPLETED QUESTS ==== -->
            <div class="bg-white border rounded-3xl p-10 shadow-sm mb-10">

                <h2 class="text-2xl font-bold text-green-800 mb-6">Top Completed Quests</h2>

                <div class="grid grid-cols-3 text-center text-xl font-semibold text-black border-b pb-3 mb-3">
                    <p>Rank</p>
                    <p>User</p>
                    <p>Quests Completed</p>
                </div>

                @foreach ($topByQuests as $index => $user)
                <div class="grid grid-cols-3 text-center py-3 border-b hover:bg-green-50 cursor-pointer"
                     onclick="window.location='{{ route('myprogress') }}'">
                    <p class="font-semibold">{{ $index + 1 }}</p>
                    <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="font-semibold text-green-800">{{ $user->questsCompleted }}</p>
                </div>
                @endforeach
            </div>

            <!-- ==== TOP DAILY ECO ACTIONS ==== -->
            <div class="bg-white border rounded-3xl p-10 shadow-sm">

                <h2 class="text-2xl font-bold text-green-800 mb-6">Top Daily Eco Actions</h2>

                <div class="grid grid-cols-3 text-center text-xl font-semibold text-black border-b pb-3 mb-3">
                    <p>Rank</p>
                    <p>User</p>
                    <p>Daily Eco Actions</p>
                </div>

<<<<<<< HEAD
=======
    {{-- Top by Daily Eco Actions --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Top Daily Eco-Taps</h2>
        <table class="w-full text-left border-collapse mb-4">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Rank</th>
                    <th class="py-2">User</th>
                    <th class="py-2">Daily Eco Actions</th>
                </tr>
            </thead>
            <tbody>
>>>>>>> 487624faff039268c5f02a3ffc1d79a5188c88ee
                @foreach ($topDailyActions as $index => $user)
                <div class="grid grid-cols-3 text-center py-3 border-b hover:bg-green-50 cursor-pointer"
                     onclick="window.location='{{ route('myprogress') }}'">
                    <p class="font-semibold">{{ $index + 1 }}</p>
                    <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="font-semibold text-green-800">{{ $user->dailyEcoActions }}</p>
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>



</div>
@endsection
