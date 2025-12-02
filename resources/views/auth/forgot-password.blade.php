@extends('layouts.mainLayout')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow mt-40 text-sm">

    <h2 class="text-xl font-semibold mb-4">Forgot your password?</h2>

    @if (session('status'))
        <div class="text-green-600 text-sm mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" 
          x-data="{ loading: false }"
          @submit="
              if (loading) {
                  $event.preventDefault();
                  return;
              }
              loading = true;
          ">
        @csrf

        <label class="text-sm">Enter your email</label>
        <input type="email" name="email" required
               class="w-full border p-2 rounded mb-3">

        @error('email')
            <span class="text-red-600 text-xs">{{ $message }}</span>
        @enderror

        <button type="submit"
            class="w-full bg-[#b36b35] text-white px-4 py-2 rounded-full mt-2 hover:bg-[#a55f2d] transition relative"
            x-bind:disabled="loading">
            <span x-show="!loading">Send Reset Link</span>
            <span x-show="loading">Please wait, sending reset link...</span>
        </button>

    </form>

</div>

@endsection
