@extends('layouts.mainLayout')

@section('content')
<div class="min-h-screen bg-[#f0f5ef] flex justify-center items-center p-8">
  <div class="bg-[#f9f8f4] w-full max-w-5xl rounded-3xl shadow-md p-10 space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-[#4b3f2f] flex items-center">
        Celebrate Your Effort 🎉
      </h1>
      <div class="bg-[#a86f46] text-white rounded-full px-5 py-2 flex items-center space-x-2">
        <span>🌿</span>
        <span class="font-semibold text-lg">13 pts</span>
      </div>
    </div>
    <p class="text-[#6b665e]">Redeem your eco-points for digital rewards and recognition.</p>

    <!-- Main Layout -->
    <div class="grid grid-cols-3 gap-6">
      
      <!-- Rewards Section -->
      <div class="col-span-2 grid grid-cols-2 gap-6">
        <!-- Reward Card -->
        <div class="bg-[#9bb48b] rounded-2xl text-white p-6 flex flex-col justify-between shadow-sm">
          <h2 class="text-2xl font-bold leading-snug">One free coffee</h2>
          <div class="flex justify-between items-center mt-4">
            <button class="bg-[#d1703d] text-white px-4 py-2 rounded-md text-sm font-semibold">REDEEM</button>
            <span class="text-[#4b3f2f] font-semibold bg-[#f9f8f4] rounded-full px-3 py-1">60 pts</span>
          </div>
        </div>

        <div class="bg-[#9bb48b] rounded-2xl text-white p-6 flex flex-col justify-between shadow-sm">
          <h2 class="text-2xl font-bold leading-snug">One free coffee</h2>
          <div class="flex justify-between items-center mt-4">
            <button class="bg-[#d1703d] text-white px-4 py-2 rounded-md text-sm font-semibold">REDEEM</button>
            <span class="text-[#4b3f2f] font-semibold bg-[#f9f8f4] rounded-full px-3 py-1">60 pts</span>
          </div>
        </div>

        <div class="bg-[#9bb48b] rounded-2xl text-white p-6 flex flex-col justify-between shadow-sm">
          <h2 class="text-2xl font-bold leading-snug">10% total discount</h2>
          <div class="flex justify-between items-center mt-4">
            <button class="bg-[#d1703d] text-white px-4 py-2 rounded-md text-sm font-semibold">REDEEM</button>
            <span class="text-[#4b3f2f] font-semibold bg-[#f9f8f4] rounded-full px-3 py-1">100 pts</span>
          </div>
        </div>

        <div class="bg-[#9bb48b] rounded-2xl text-white p-6 flex flex-col justify-between shadow-sm">
          <h2 class="text-2xl font-bold leading-snug">One free coffee</h2>
          <div class="flex justify-between items-center mt-4">
            <button class="bg-[#d1703d] text-white px-4 py-2 rounded-md text-sm font-semibold">REDEEM</button>
            <span class="text-[#4b3f2f] font-semibold bg-[#f9f8f4] rounded-full px-3 py-1">60 pts</span>
          </div>
        </div>

        <div class="bg-[#9bb48b] rounded-2xl text-white p-6 flex flex-col justify-between shadow-sm">
          <h2 class="text-2xl font-bold leading-snug">One free coffee</h2>
          <div class="flex justify-between items-center mt-4">
            <button class="bg-[#d1703d] text-white px-4 py-2 rounded-md text-sm font-semibold">REDEEM</button>
            <span class="text-[#4b3f2f] font-semibold bg-[#f9f8f4] rounded-full px-3 py-1">60 pts</span>
          </div>
        </div>

        <div class="bg-[#9bb48b] rounded-2xl text-white p-6 flex flex-col justify-between shadow-sm">
          <h2 class="text-2xl font-bold leading-snug">One free coffee</h2>
          <div class="flex justify-between items-center mt-4">
            <button class="bg-[#d1703d] text-white px-4 py-2 rounded-md text-sm font-semibold">REDEEM</button>
            <span class="text-[#4b3f2f] font-semibold bg-[#f9f8f4] rounded-full px-3 py-1">60 pts</span>
          </div>
        </div>
      </div>

      <!-- My Vouchers Section -->
      <div class="bg-[#fdfcf8] rounded-2xl shadow-sm p-6 flex flex-col">
        <h2 class="text-lg font-semibold text-[#4b3f2f] mb-4">My Vouchers</h2>
        <div class="space-y-4">
          <div class="bg-[#9bb48b] text-white rounded-lg py-3 text-center font-medium">One free coffee</div>
          <div class="bg-[#9bb48b] text-white rounded-lg py-3 text-center font-medium">One free coffee</div>
          <div class="bg-[#9bb48b] text-white rounded-lg py-3 text-center font-medium">One free coffee</div>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection
