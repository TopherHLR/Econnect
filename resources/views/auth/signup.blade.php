@extends('layouts.authLayout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#f7f8f3] to-[#e8eedf]">
  <div class="relative flex w-[800px] h-[500px] bg-[#f8f9f4] rounded-xl overflow-hidden shadow-xl">

    <!-- 🌿 Left Panel - Create Account -->
    <div class="w-1/2 p-10 flex flex-col justify-center relative z-10 bg-[#f8f9f4]">
      <h2 class="text-3xl font-semibold text-[#c37029] mb-6 font-serif">Create Account</h2>

      <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs tracking-wide text-gray-600 mb-1 uppercase">First Name</label>
          <input type="text" name="first_name" required
            class="w-full bg-transparent border-b border-[#758a52] focus:border-green-700 outline-none py-1 text-sm text-gray-800" />
        </div>

        <div>
          <label class="block text-xs tracking-wide text-gray-600 mb-1 uppercase">Middle Name</label>
          <input type="text" name="middle_name"
            class="w-full bg-transparent border-b border-[#758a52] focus:border-green-700 outline-none py-1 text-sm text-gray-800" />
        </div>

        <div>
          <label class="block text-xs tracking-wide text-gray-600 mb-1 uppercase">Last Name</label>
          <input type="text" name="last_name" required
            class="w-full bg-transparent border-b border-[#758a52] focus:border-green-700 outline-none py-1 text-sm text-gray-800" />
        </div>

        <div>
          <label class="block text-xs tracking-wide text-gray-600 mb-1 uppercase">Email</label>
          <input type="email" name="email" placeholder="you@example.com" required
            class="w-full bg-transparent border-b border-[#758a52] focus:border-green-700 outline-none py-1 text-sm text-gray-800" />
        </div>

        <div>
          <label class="block text-xs tracking-wide text-gray-600 mb-1 uppercase">Password</label>
          <input type="password" name="password" placeholder="••••••••" required
            class="w-full bg-transparent border-b border-[#758a52] focus:border-green-700 outline-none py-1 text-sm text-gray-800" />
        </div>

        <div>
          <label class="block text-xs tracking-wide text-gray-600 mb-1 uppercase">Confirm Password</label>
          <input type="password" name="password_confirmation" placeholder="••••••••" required
            class="w-full bg-transparent border-b border-[#758a52] focus:border-green-700 outline-none py-1 text-sm text-gray-800" />
        </div>

        <div class="pt-4">
          <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
          @error('g-recaptcha-response')
            <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit"
          class="mt-4 w-full bg-[#b36b35] hover:bg-[#a55f2d] text-white font-semibold py-2 rounded-full transition">
          SIGN UP
        </button>

        <div class="flex justify-center gap-4 mt-3 text-2xl text-[#5a6b3e]">
          <i class="fab fa-facebook-f cursor-pointer hover:text-green-700 transition"></i>
          <i class="fab fa-google cursor-pointer hover:text-green-700 transition"></i>
        </div>

        <p class="text-sm text-center text-gray-600 mt-4">
          Already have an account?
          <a href="#" id="login-btn" class="text-green-700 hover:underline">Login</a>
        </p>
      </form>
    </div>

    <!-- 🌱 Right Panel - Login Info (Swipe-ready) -->
    <div
      id="login-panel"
      class="w-1/2 bg-gradient-to-b from-[#99b072] to-[#7d9656] text-white flex flex-col items-center justify-center transition-all duration-700 ease-in-out rounded-l-[60px]">
      <h2 class="text-4xl font-bold mb-4 font-serif">Hello!</h2>
      <p class="text-center text-lg px-6 mb-8 opacity-90">You’re one step away from caring!</p>
      <button
        class="bg-[#5a6b3e] hover:bg-[#4a5b33] text-white font-semibold py-2 px-10 rounded-full shadow-md transition">
        LOGIN
      </button>
    </div>

  </div>
</div>

@endsection
