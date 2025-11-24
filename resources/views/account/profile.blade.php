@extends('layouts.accountLayout')

@section('account_content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-green-900">Hello, {{ $user->first_name }}!</h1>
        <a href="#" class="text-green-700 hover:underline">Edit Profile</a>
    </div>

    <!-- User Info Card -->
    <div class="bg-white shadow-md rounded-2xl p-6 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
        <div class="flex-shrink-0">
            <img src="{{ $user->profile_image ?? asset('images/default-avatar.png') }}" alt="Profile" class="w-24 h-24 rounded-full border-2 border-green-700">
        </div>
        <div class="flex-1 space-y-2">
            <p class="text-lg"><span class="font-semibold text-green-900">Full Name:</span> {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</p>
            <p class="text-lg"><span class="font-semibold text-green-900">Email:</span> {{ $user->email }}</p>
            <p class="text-lg"><span class="font-semibold text-green-900">User Type:</span> {{ ucfirst($user->user_type) }}</p>
        </div>
    </div>

    <!-- Points & Badge -->
    <div class="bg-green-50 p-6 rounded-2xl flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-6">
        <div class="flex-1 text-center md:text-left">
            <p class="text-green-900 font-semibold">Your Points</p>
            <p class="text-2xl font-bold text-green-700">{{ $currentPoints }} pts</p>
            <p class="text-gray-600 text-sm">Total earned: {{ $progressPoints }} pts | Spent: {{ $pointsSpent ?? 0 }} pts</p>
        </div>
        <div class="flex-1 text-center">
            <p class="text-green-900 font-semibold">Your Badge</p>
            <p class="text-xl mt-1">{{ $badgeLevel }}</p>
            @if($earnedBadges > 0)
                <div class="mt-2 flex justify-center space-x-1">
                    @for($i = 0; $i < $earnedBadges; $i++)
                        <span class="text-2xl">🏆</span>
                    @endfor
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
        <a href="#" class="bg-green-700 text-white px-6 py-3 rounded-lg hover:bg-green-800 transition text-center">Change Password</a>
        <a href="{{ route('user.vouchers') }}" class="border border-green-700 text-green-700 px-6 py-3 rounded-lg hover:bg-green-50 transition text-center">My Vouchers</a>
        <a href="{{ route('user.quests') }}" class="border border-green-700 text-green-700 px-6 py-3 rounded-lg hover:bg-green-50 transition text-center">My Quests</a>
    </div>
</div>
@endsection
