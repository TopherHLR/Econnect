@extends('layouts.accountLayout')

@section('account_content')
<div class="min-h-screen bg-[#f0f5ef] flex justify-center items-center p-8">
  <div class="bg-[#f9f8f4] w-full max-w-5xl rounded-3xl shadow-md p-10 space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-[#4b3f2f] flex items-center">
        Your Eco-Journey So Far
        <span class="ml-2 text-green-600">🌱</span>
      </h1>
      <div class="bg-[#a86f46] text-white rounded-full px-5 py-2 flex items-center space-x-2">
        <span>🌿</span>
        <span class="font-semibold text-lg">13 pts</span>
      </div>
    </div>
    <p class="text-[#6b665e]">Track your growth, achievements, and daily impact.</p>

    <!-- Progress Circles -->
    <div class="grid grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <div class="relative inline-block">
          <div class="w-20 h-20 rounded-full border-[10px] border-green-500 flex items-center justify-center">
            <span class="text-xl font-semibold text-[#4b3f2f]">10%</span>
          </div>
        </div>
        <p class="mt-3 font-medium text-[#4b3f2f]">Tree Growth</p>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <div class="relative inline-block">
          <div class="w-20 h-20 rounded-full border-[10px] border-green-400 flex items-center justify-center">
            <span class="text-xl font-semibold text-[#4b3f2f]">20%</span>
          </div>
        </div>
        <p class="mt-3 font-medium text-[#4b3f2f]">Eco-Actions Completed</p>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <div class="relative inline-block">
          <div class="w-20 h-20 rounded-full border-[10px] border-green-400 flex items-center justify-center">
            <span class="text-xl font-semibold text-[#4b3f2f]">20%</span>
          </div>
        </div>
        <p class="mt-3 font-medium text-[#4b3f2f]">Quests Completed</p>
      </div>
    </div>

    <!-- Consistency -->
    <div class="bg-[#fdfcf8] p-5 rounded-2xl shadow-sm flex flex-col items-center">
      <p class="text-[#4b3f2f] mb-3 font-medium">You've been consistent for 6 days! Keep going 😊</p>
      <div class="flex items-center space-x-4">
        <div class="w-10 h-10 bg-green-500 rounded-full flex justify-center items-center text-white text-xl">🌿</div>
        <div class="w-10 h-10 bg-green-500 rounded-full flex justify-center items-center text-white text-xl">🌿</div>
        <div class="text-[#4b3f2f] font-semibold">3 pts</div>
        <div class="rounded-full bg-[#e8e6dc] px-3 py-1 text-[#4b3f2f] font-semibold">D4</div>
        <div class="rounded-full bg-[#e8e6dc] px-3 py-1 text-[#4b3f2f] font-semibold">D5</div>
        <div class="rounded-full bg-[#e8e6dc] px-3 py-1 text-[#4b3f2f] font-semibold">D6</div>
        <div class="text-[#4b3f2f] font-semibold">7 pts</div>
      </div>
    </div>

    <!-- Badges -->
    <div class="bg-[#a86f46] rounded-2xl p-6 text-white">
      <div class="grid grid-cols-3 gap-6">
        <div class="bg-white text-[#4b3f2f] rounded-full h-28 flex flex-col justify-center items-center">
          <p class="font-semibold">Mindful Mover</p>
          <span>☀️</span>
        </div>
        <div class="bg-white text-[#4b3f2f] rounded-full h-28 flex flex-col justify-center items-center">
          <p class="font-semibold">Eco Warrior</p>
          <span>💧</span>
        </div>
        <div class="bg-white text-[#4b3f2f] rounded-full h-28 flex flex-col justify-center items-center">
          <p class="font-semibold">Tree Tender</p>
          <span>🌿</span>
        </div>
      </div>
    </div>

    <!-- History -->
    <div class="bg-[#fdfcf8] p-5 rounded-2xl shadow-sm">
      <h2 class="text-xl font-semibold text-[#4b3f2f] mb-3">History</h2>
      <div class="text-[#6b665e] font-medium">
        <p>Title | Date | Eco-points | Badge</p>
      </div>
      <div class="text-center text-gray-400 mt-4 italic">No history yet</div>
    </div>

    <!-- Footer -->
    <p class="text-center text-[#6b665e] italic mt-6">
      Your small choices build a greener world.
    </p>

  </div>
</div>
@endsection
