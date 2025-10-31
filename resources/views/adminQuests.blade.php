@extends('layouts.adminLayout')

@section('title', 'Quests')

@section('content')
<div class="min-h-screen bg-[#E6ECD5] text-[#3B3B3B] font-sans py-12 px-8">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-semibold text-[#5A2E0E]">Quests</h1>
    <p class="text-sm text-[#6D7058] mt-1">Create, manage, and validate sustainability challenges.</p>

    <div class="flex flex-col md:flex-row gap-6 mt-8">
      <!-- ✅ Sidebar -->
      <div class="w-full md:w-1/4 bg-[#F6F9EE] border border-[#C8D2A4] rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-[#5A2E0E] mb-3">Active Quests:</h2>
        <ul class="space-y-1 text-[#5B6D2F] font-medium">
          <li class="hover:text-[#3C4E1A] transition">Reduce Plastic Use</li>
          <li class="hover:text-[#3C4E1A] transition">Plant a Tree</li>
          <li class="text-[#6D7058] italic">Join Clean-Up Drive</li>
        </ul>

        <hr class="my-4 border-[#B5C48B]">
<div class="flex flex-col gap-3">
  <!-- ✅ Link to Quest Collection -->
  <a href="{{ route('admin.questCollection') }}" 
     class="bg-[#5F6F2E] text-[#F6F9EE] py-2 rounded-lg text-center hover:bg-[#4C5B25] transition">
    Quest Collection
  </a>

  <!-- ➕ Button for creating new quests -->
  <button class="flex items-center justify-center gap-2 bg-[#E6ECD5] text-[#3B3B3B] py-2 rounded-lg hover:bg-[#D8E3C1] transition">
    <span class="text-lg font-bold">+</span> New Quest
  </button>
</div>



      <!-- 📋 Main Content -->
      <div class="flex-1 bg-[#F6F9EE] border border-[#C8D2A4] rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-[#5A2E0E] mb-4">Database goes here:</h2>

        <div class="bg-[#F9FBEF] border border-[#C8D2A4] rounded-xl min-h-[400px] flex items-center justify-center text-[#6D7058] italic">
          <span>No data available yet</span>
        </div>

        <div class="flex justify-end mt-6">
          <button class="flex items-center gap-2 bg-[#5F6F2E] text-[#F6F9EE] px-4 py-2 rounded-lg shadow-md hover:bg-[#4C5B25] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
            </svg>
            Export Quest List
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
