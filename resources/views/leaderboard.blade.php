@extends('layouts.mainLayout')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10">
    <h1 class="text-2xl font-bold text-green-800 mb-4">Leaderboard</h1>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b">
                <th class="py-2">Rank</th>
                <th class="py-2">User</th>
                <th class="py-2">Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaderboard as $index => $user)
            <tr class="border-b">
                <td class="py-2 font-semibold">{{ $index + 1 }}</td>

                {{-- User full name --}}
                <td class="py-2">
                    {{ $user->first_name }} {{ $user->last_name }}
                </td>

                {{-- Total progress points --}}
                <td class="py-2">{{ $user->progressPoints }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
