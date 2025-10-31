@extends('layouts.adminLayout')

@section('title', 'Quest Collection')

@section('content')
<div class="min-h-screen bg-[#E6ECD5] text-[#3B3B3B] font-sans py-12 px-8">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-semibold text-[#5A2E0E]">Quest Collection</h1>
    <p class="text-sm text-[#6D7058] mt-1">View and edit all saved sustainability quests.</p>

    <div class="flex flex-col md:flex-row gap-6 mt-8">
      <!-- Sidebar -->
      <div class="w-full md:w-1/4 bg-[#F6F9EE] border border-[#C8D2A4] rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-[#5A2E0E] mb-3">Active Quests:</h2>
        <ul class="space-y-1 text-[#5B6D2F] font-medium">
          <li>Tree Planting</li>
          <li>Plastic-Free Week</li>
          <li>Beach Clean-up</li>
        </ul>

        <hr class="my-4 border-[#B5C48B]">

        <div class="flex flex-col gap-3">
          <a href="{{ route('admin.quests') }}" 
             class="bg-[#5F6F2E] text-[#F6F9EE] py-2 rounded-lg text-center hover:bg-[#4C5B25] transition">
            Quest Dashboard
          </a>
          <button class="flex items-center justify-center gap-2 bg-[#E6ECD5] text-[#3B3B3B] py-2 rounded-lg hover:bg-[#D8E3C1] transition">
            <span class="text-lg font-bold">+</span> New Quest
          </button>
        </div>
      </div>

      <!-- Quest Cards -->
      <div class="flex-1 bg-[#F6F9EE] border border-[#C8D2A4] rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-[#5A2E0E] mb-4">Quest Collection</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="eco-card relative bg-[#EAF2D9] rounded-xl overflow-hidden border border-[#C8D2A4] shadow hover:scale-105 transition transform">
            <img src="{{ asset('images/quest-placeholder.jpg') }}" alt="Sample Quest" class="w-full h-28 object-cover">
            <button class="absolute top-2 right-2 bg-[#5F6F2E] text-white p-1.5 rounded-md shadow-md hover:bg-[#4C5B25] transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l3.536-3.536m0 0L18 2m-5.464 5.464L2 18v4h4L18 7.464z" />
              </svg>
            </button>
            <div class="p-4">
              <h3 class="text-[#3B3B3B] font-semibold text-sm">Beach Clean-Up</h3>
              <div class="flex justify-between items-center mt-2 text-xs">
                <span class="bg-[#E6ECD5] text-[#5A2E0E] px-2 py-1 rounded-md uppercase">Active</span>
                <span class="text-[#5F6F2E] font-semibold">150 pts</span>
              </div>
            </div>
          </div>

          <div class="eco-card relative bg-[#EAF2D9] rounded-xl overflow-hidden border border-[#C8D2A4] shadow hover:scale-105 transition transform">
            <img src="{{ asset('images/quest-placeholder.jpg') }}" alt="Sample Quest" class="w-full h-28 object-cover">
            <div class="p-4">
              <h3 class="text-[#3B3B3B] font-semibold text-sm">Water Conservation</h3>
              <div class="flex justify-between items-center mt-2 text-xs">
                <span class="bg-[#E6ECD5] text-[#5A2E0E] px-2 py-1 rounded-md uppercase">Pending</span>
                <span class="text-[#5F6F2E] font-semibold">100 pts</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
