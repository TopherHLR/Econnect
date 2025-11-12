@extends('layouts.accountLayout')

@section('account_content')
  
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
  <!-- Title + Subtitle -->
  <div class="flex flex-col mb-4 md:mb-0">
    <h1 class="text-3xl font-bold text-[#4F6B3F] flex items-center">
      Your Eco-Journey So Far
      <span class="ml-3 text-2xl">🌱</span>
    </h1>
    <p class="text-[#6B665E] mt-2 text-lg">Track your growth, achievements, and daily impact.</p>
  </div>

  <!-- Eco Points + Rank -->
  <div class="flex flex-col md:items-end space-y-3">
    <!-- Eco Points -->
    <div class="bg-gradient-to-r from-[#8B6E4A] to-[#9D845F] text-white rounded-full px-6 py-3 flex items-center space-x-3 font-bold shadow-lg">
      <span class="text-xl">🌿</span>
      <span class="text-xl">153 Eco Points</span>
    </div>

    <!-- Rank Badge -->
    <div class="bg-gradient-to-r from-[#F2E8D5] to-[#F8F2E6] text-[#4F6B3F] rounded-full px-5 py-2 font-semibold shadow-md border border-[#E8DBC7]">
      Rank: Eco Defender
    </div>
  </div>
</div>

<!-- Progress Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <!-- Tree Growth -->
  <div class="bg-gradient-to-br from-white to-[#F8F9F5] rounded-2xl p-6 shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02] text-center border border-[#ECF4E7]">
    <div class="relative flex justify-center items-center mb-4">
      <div class="relative w-28 h-28">
        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
          <!-- Background circle -->
          <circle cx="50" cy="50" r="40" stroke="#E8E6DC" stroke-width="8" fill="none" />
          <!-- Progress circle -->
          <circle cx="50" cy="50" r="40" stroke="#4F6B3F" stroke-width="8" fill="none" 
                  stroke-dasharray="251.2" stroke-dashoffset="200.96" stroke-linecap="round" />
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
          <span class="text-2xl font-bold text-[#4B3F2F]">20%</span>
        </div>
      </div>
    </div>
    <p class="mt-2 font-semibold text-lg text-[#4B3F2F]">Tree Growth</p>
    <p class="text-sm text-gray-600 mt-1">Keep watering your tree to grow!</p>
    <div class="mt-4 bg-[#ECF4E7] rounded-full h-2">
      <div class="bg-[#4F6B3F] h-2 rounded-full" style="width: 20%"></div>
    </div>
  </div>

  <!-- Eco-Actions Completed -->
  <div class="bg-gradient-to-br from-white to-[#F8F9F5] rounded-2xl p-6 shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02] text-center border border-[#E6F4EA]">
    <div class="relative flex justify-center items-center mb-4">
      <div class="relative w-28 h-28">
        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
          <!-- Background circle -->
          <circle cx="50" cy="50" r="40" stroke="#E8E6DC" stroke-width="8" fill="none" />
          <!-- Progress circle -->
          <circle cx="50" cy="50" r="40" stroke="#7CA86C" stroke-width="8" fill="none" 
                  stroke-dasharray="251.2" stroke-dashoffset="200.96" stroke-linecap="round" />
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
          <span class="text-2xl font-bold text-[#4B3F2F]">20%</span>
        </div>
      </div>
    </div>
    <p class="mt-2 font-semibold text-lg text-[#4B3F2F]">Eco-Actions Completed</p>
    <p class="text-sm text-gray-600 mt-1">You've completed 12 actions so far!</p>
    <div class="mt-4 bg-[#E6F4EA] rounded-full h-2">
      <div class="bg-[#7CA86C] h-2 rounded-full" style="width: 20%"></div>
    </div>
  </div>

  <!-- Quests Completed -->
  <div class="bg-gradient-to-br from-white to-[#F8F9F5] rounded-2xl p-6 shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02] text-center border border-[#E6F4EA]">
    <div class="relative flex justify-center items-center mb-4">
      <div class="relative w-28 h-28">
        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
          <!-- Background circle -->
          <circle cx="50" cy="50" r="40" stroke="#E8E6DC" stroke-width="8" fill="none" />
          <!-- Progress circle -->
          <circle cx="50" cy="50" r="40" stroke="#7CA86C" stroke-width="8" fill="none" 
                  stroke-dasharray="251.2" stroke-dashoffset="200.96" stroke-linecap="round" />
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
          <span class="text-2xl font-bold text-[#4B3F2F]">20%</span>
        </div>
      </div>
    </div>
    <p class="mt-2 font-semibold text-lg text-[#4B3F2F]">Quests Completed</p>
    <p class="text-sm text-gray-600 mt-1">2 out of 10 quests finished!</p>
    <div class="mt-4 bg-[#E6F4EA] rounded-full h-2">
      <div class="bg-[#7CA86C] h-2 rounded-full" style="width: 20%"></div>
    </div>
  </div>
</div>

<!-- Stats Summary -->
<div class="bg-gradient-to-r from-[#FDFCF8] to-[#FCFFF6] rounded-2xl shadow-md p-6 grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 border border-[#F2E8D5]">
  <div class="bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-shadow duration-300">
    <p class="text-sm font-semibold text-[#4B3F2F] mb-2">Total Eco-Actions</p>
    <p class="text-3xl font-bold text-[#4F6B3F]">12</p>
  </div>
  <div class="bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-shadow duration-300">
    <p class="text-sm font-semibold text-[#4B3F2F] mb-2">Points Earned</p>
    <p class="text-3xl font-bold text-[#4F6B3F]">45</p>
  </div>
  <div class="bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-shadow duration-300">
    <p class="text-sm font-semibold text-[#4B3F2F] mb-2">Tree Taps</p>
    <p class="text-3xl font-bold text-[#4F6B3F]">8</p>
  </div>
</div>

<!-- Consistency Tracker -->
<div class="bg-gradient-to-r from-[#FDFCF8] to-[#FCFFF6] p-6 rounded-2xl shadow-md mb-8 border border-[#F2E8D5]">
  <div class="flex flex-col md:flex-row justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-[#4B3F2F]">Consistency Tracker</h2>
    <div class="mt-2 md:mt-0 bg-[#4F6B3F] text-white rounded-full px-4 py-1 text-sm font-medium">
      Current Streak: 6 days
    </div>
  </div>
  <p class="text-[#4B3F2F] mb-4 text-center md:text-left">You've been consistent for 6 days! Keep going 😊</p>
  <div class="flex items-center justify-center md:justify-start space-x-3 flex-wrap gap-3">
    <div class="w-12 h-12 bg-gradient-to-br from-[#4F6B3F] to-[#5A7A47] rounded-full flex justify-center items-center text-white text-xl shadow-md">🌿</div>
    <div class="w-12 h-12 bg-gradient-to-br from-[#4F6B3F] to-[#5A7A47] rounded-full flex justify-center items-center text-white text-xl shadow-md">🌿</div>
    <div class="text-[#4B3F2F] font-semibold bg-[#ECF4E7] px-3 py-1 rounded-lg">3 pts</div>
    <div class="rounded-full bg-gradient-to-br from-[#E8E6DC] to-[#F2F0E6] px-4 py-2 text-[#4B3F2F] font-semibold shadow-sm">D4</div>
    <div class="rounded-full bg-gradient-to-br from-[#E8E6DC] to-[#F2F0E6] px-4 py-2 text-[#4B3F2F] font-semibold shadow-sm">D5</div>
    <div class="rounded-full bg-gradient-to-br from-[#E8E6DC] to-[#F2F0E6] px-4 py-2 text-[#4B3F2F] font-semibold shadow-sm">D6</div>
    <div class="text-[#4B3F2F] font-semibold bg-[#ECF4E7] px-3 py-1 rounded-lg">7 pts</div>
  </div>
</div>

<!-- Badges Section -->
<div class="bg-gradient-to-br from-[#F2E8D5] to-[#F8F2E6] rounded-3xl p-6 shadow-md mb-8 border border-[#E8DBC7]">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#4F6B3F]">Your Badges</h2>
    <span class="text-[#6B665E] text-sm">3 of 12 unlocked</span>
  </div>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
    <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow hover:scale-105 transform transition duration-300 border border-[#F2E8D5]">
      <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-[#8B6E4A] to-[#9D845F] text-white text-3xl shadow-md mb-3">
        ☀️
      </div>
      <p class="text-sm font-semibold text-[#4B3F2F] text-center">Mindful Mover</p>
      <p class="text-xs text-gray-500 mt-1">Earned: Nov 5</p>
    </div>
    <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow hover:scale-105 transform transition duration-300 border border-[#F2E8D5]">
      <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-[#7CA86C] to-[#8BB87A] text-white text-3xl shadow-md mb-3">
        💧
      </div>
      <p class="text-sm font-semibold text-[#4B3F2F] text-center">Eco Warrior</p>
      <p class="text-xs text-gray-500 mt-1">Earned: Nov 3</p>
    </div>
    <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow hover:scale-105 transform transition duration-300 border border-[#F2E8D5]">
      <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-[#4F6B3F] to-[#5A7A47] text-white text-3xl shadow-md mb-3">
        🌿
      </div>
      <p class="text-sm font-semibold text-[#4B3F2F] text-center">Tree Tender</p>
      <p class="text-xs text-gray-500 mt-1">Earned: Oct 28</p>
    </div>
    <!-- Locked badges -->
    <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow border border-[#F2E8D5] opacity-60">
      <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 text-3xl shadow-md mb-3">
        🌎
      </div>
      <p class="text-sm font-semibold text-gray-400 text-center">Global Guardian</p>
      <p class="text-xs text-gray-400 mt-1">Locked</p>
    </div>
    <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow border border-[#F2E8D5] opacity-60">
      <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 text-3xl shadow-md mb-3">
        ♻️
      </div>
      <p class="text-sm font-semibold text-gray-400 text-center">Recycling Hero</p>
      <p class="text-xs text-gray-400 mt-1">Locked</p>
    </div>
    <div class="flex flex-col items-center bg-white rounded-2xl p-4 shadow border border-[#F2E8D5] opacity-60">
      <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gray-200 text-gray-400 text-3xl shadow-md mb-3">
        🚶
      </div>
      <p class="text-sm font-semibold text-gray-400 text-center">Carbon Walker</p>
      <p class="text-xs text-gray-400 mt-1">Locked</p>
    </div>
  </div>
</div>

<!-- Recent Activity / Quests Progress -->
<div class="bg-gradient-to-br from-[#FCFFF6] to-[#FDFCF8] rounded-2xl shadow-md p-6 mb-8 border border-[#ECF4E7]">
  <h2 class="text-xl font-semibold text-[#4B3F2F] mb-4">Recent Quest Submissions</h2>
  <div class="space-y-4">
    <div class="flex justify-between items-center bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300 border border-[#F2E8D5]">
      <div>
        <p class="font-semibold text-[#4B3F2F]">Plastic-Free Lunch Challenge</p>
        <p class="text-sm text-gray-500 mt-1">Submitted: Nov 10, 2025</p>
      </div>
      <div class="bg-amber-100 text-amber-800 rounded-full px-3 py-1 text-sm font-medium">Pending</div>
    </div>
    <div class="flex justify-between items-center bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300 border border-[#F2E8D5]">
      <div>
        <p class="font-semibold text-[#4B3F2F]">Digital Declutter Challenge</p>
        <p class="text-sm text-gray-500 mt-1">Submitted: Nov 09, 2025</p>
      </div>
      <div class="bg-green-100 text-green-800 rounded-full px-3 py-1 text-sm font-medium">Completed</div>
    </div>
    <div class="flex justify-between items-center bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300 border border-[#F2E8D5]">
      <div>
        <p class="font-semibold text-[#4B3F2F]">Community Garden Cleanup</p>
        <p class="text-sm text-gray-500 mt-1">Submitted: Nov 07, 2025</p>
      </div>
      <div class="bg-green-100 text-green-800 rounded-full px-3 py-1 text-sm font-medium">Completed</div>
    </div>
  </div>
</div>

<!-- History Table -->
<div class="bg-gradient-to-br from-[#FDFCF8] to-[#FCFFF6] p-6 rounded-2xl shadow-md mb-8 border border-[#F2E8D5]">
  <h2 class="text-xl font-semibold text-[#4B3F2F] mb-4">Recent Activity History</h2>
  <div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-[#4B3F2F]">
      <thead>
        <tr class="border-b-2 border-[#E8E6DC]">
          <th class="pb-3 font-semibold">Title</th>
          <th class="pb-3 font-semibold">Date</th>
          <th class="pb-3 font-semibold">Eco-points</th>
          <th class="pb-3 font-semibold">Badge</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-b border-[#F2E8D5] hover:bg-[#FCFFF6] transition-colors duration-200">
          <td class="py-3 font-medium">Plastic-Free Lunch Challenge</td>
          <td class="py-3">Nov 10, 2025</td>
          <td class="py-3 font-semibold text-[#4F6B3F]">10</td>
          <td class="py-3">
            <span class="bg-[#F2E8D5] text-[#4B3F2F] rounded-full px-2 py-1 text-xs">Mindful Mover</span>
          </td>
        </tr>
        <tr class="border-b border-[#F2E8D5] hover:bg-[#FCFFF6] transition-colors duration-200">
          <td class="py-3 font-medium">Digital Declutter Challenge</td>
          <td class="py-3">Nov 09, 2025</td>
          <td class="py-3 font-semibold text-[#4F6B3F]">5</td>
          <td class="py-3">
            <span class="bg-[#F2E8D5] text-[#4B3F2F] rounded-full px-2 py-1 text-xs">Eco Warrior</span>
          </td>
        </tr>
        <tr class="border-b border-[#F2E8D5] hover:bg-[#FCFFF6] transition-colors duration-200">
          <td class="py-3 font-medium">Community Garden Cleanup</td>
          <td class="py-3">Nov 07, 2025</td>
          <td class="py-3 font-semibold text-[#4F6B3F]">7</td>
          <td class="py-3">
            <span class="bg-[#F2E8D5] text-[#4B3F2F] rounded-full px-2 py-1 text-xs">Tree Tender</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Footer -->
<div class="text-center py-6">
  <p class="text-[#6B665E] italic text-lg">
    "Your small choices build a greener world."
  </p>
  <div class="flex justify-center mt-4 space-x-4 text-2xl">
    <span>🌍</span>
    <span>🌱</span>
    <span>💚</span>
  </div>
</div>

@endsection