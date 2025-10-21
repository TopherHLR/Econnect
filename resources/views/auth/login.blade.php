@extends('layouts.authLayout')

@section('content')
<div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-green-800 mb-6">Login to Econnect</h2>

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none"
                   placeholder="you@example.com" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none"
                   placeholder="••••••••" required>
        </div>

        <button type="submit"
                class="w-full bg-green-700 text-white font-semibold py-2 rounded-full hover:bg-green-800 transition">
            Login
        </button>

        <p class="text-sm text-center text-gray-600 mt-4">
            Don’t have an account?
            <a href="{{ route('signup') }}" class="text-green-700 hover:underline">Sign up</a>
        </p>
    </form>
</div>
@endsection
