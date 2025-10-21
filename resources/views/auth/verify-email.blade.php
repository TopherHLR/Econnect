@extends('layouts.authLayout')

@section('content')
<div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-green-800 mb-6">Verify Your Email</h2>

    @if(session('info'))
        <p class="text-green-600 text-center mb-4">{{ session('info') }}</p>
    @endif

    <form method="POST" action="{{ route('verify.email.submit') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Enter Verification Code</label>
            <input type="text" name="code" class="w-full border-gray-300 rounded-lg px-3 py-2" required>
            @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="w-full bg-green-700 text-white font-semibold py-2 rounded-full hover:bg-green-800 transition">
            Verify & Create Account
        </button>
    </form>
</div>
@endsection
