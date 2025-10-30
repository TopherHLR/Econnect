@extends('layouts.accountLayout')

@section('account_content')
    <h1 class="text-2xl font-bold text-green-900 mb-6">My Account Settings</h1>

    <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded-lg">
            <p><span class="font-semibold text-green-900">Full Name:</span> {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</p>
            <p><span class="font-semibold text-green-900">Email:</span> {{ $user->email }}</p>
            <p><span class="font-semibold text-green-900">User Type:</span> {{ ucfirst($user->user_type) }}</p>
        </div>

        <div class="flex space-x-3">
            <a href="#" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition">Edit Profile</a>
            <a href="#" class="border border-green-700 text-green-700 px-4 py-2 rounded-lg hover:bg-green-50 transition">Change Password</a>
        </div>
    </div>
@endsection