@extends('layouts.authLayout')

@section('content')
<div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-green-800 mb-6">Create an Account</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
            <input type="text" name="first_name" class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
            <input type="text" name="middle_name" class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
            <input type="text" name="last_name" class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none" required>
        </div>

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

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none"
                    placeholder="••••••••" required>
        </div>
        <div class="mb-4">
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            @error('g-recaptcha-response')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>


        <button type="submit"
                class="w-full bg-green-700 text-white font-semibold py-2 rounded-full hover:bg-green-800 transition">
            Sign Up
        </button>

        <p class="text-sm text-center text-gray-600 mt-4">
            Already have an account?
            <a href="/login" class="text-green-700 hover:underline">Login</a>
        </p>
    </form>
</div>
@endsection
