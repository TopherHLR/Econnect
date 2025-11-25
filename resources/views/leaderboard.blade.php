@extends('layouts.mainLayout')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10 space-y-10">

    {{-- Top by Progress Points --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Top Progress Points</h2>
        <table class="w-full text-left border-collapse mb-4">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Rank</th>
                    <th class="py-2">User</th>
                    <th class="py-2">Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topByPoints as $index => $user)
                <tr class="border-b hover:bg-green-50 cursor-pointer"
                    onclick="window.location='{{ route('myprogress') }}'">
                    <td class="py-2 font-semibold">{{ $index + 1 }}</td>
                    <td class="py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td class="py-2 font-semibold text-green-800">{{ $user->progressPoints }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Top by Completed Quests --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Top Completed Quests</h2>
        <table class="w-full text-left border-collapse mb-4">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Rank</th>
                    <th class="py-2">User</th>
                    <th class="py-2">Quests Completed</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topByQuests as $index => $user)
                <tr class="border-b hover:bg-green-50 cursor-pointer"
                    onclick="window.location='{{ route('myprogress') }}'">
                    <td class="py-2 font-semibold">{{ $index + 1 }}</td>
                    <td class="py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td class="py-2 font-semibold text-green-800">{{ $user->questsCompleted }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Top by Daily Eco Actions --}}
    <div>
        <h2 class="text-2xl font-bold text-green-800 mb-4">Top Daily Eco Actions</h2>
        <table class="w-full text-left border-collapse mb-4">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Rank</th>
                    <th class="py-2">User</th>
                    <th class="py-2">Daily Eco Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topDailyActions as $index => $user)
                <tr class="border-b hover:bg-green-50 cursor-pointer"
                    onclick="window.location='{{ route('myprogress') }}'">
                    <td class="py-2 font-semibold">{{ $index + 1 }}</td>
                    <td class="py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td class="py-2 font-semibold text-green-800">{{ $user->dailyEcoActions }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</div>
@endsection
