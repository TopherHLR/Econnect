@extends('layouts.mainLayout')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow mt-40 text-sm">

    <h2 class="text-xl font-semibold mb-4">Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}"
          x-data="{ loading: false }"
          @submit="
            if (loading) {
                alert('Please wait, resetting your password...');
                $event.preventDefault();
                return;
            }
            loading = true;
          ">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <label class="text-sm">Email</label>
        <input type="email" name="email" required class="w-full border p-2 rounded mb-3">

        <label class="text-sm">New Password</label>
        <input type="password" name="password" required class="w-full border p-2 rounded mb-3">

        <label class="text-sm">Confirm Password</label>
        <input type="password" name="password_confirmation" required class="w-full border p-2 rounded mb-3">

        <button type="submit"
            class="w-full bg-[#b36b35] text-white px-4 py-2 rounded-full mt-2 hover:bg-[#a55f2d] transition relative"
            x-bind:disabled="loading">
            <span x-show="!loading">Reset Password</span>
            <span x-show="loading">Please wait, resetting your password...</span>
        </button>

    </form>
</div>

@endsection
