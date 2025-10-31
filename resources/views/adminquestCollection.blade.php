@extends('layouts.adminLayout')

@section('title', 'Quest Collection')

@section('content')
<div class="space-y-8">
    <!-- 🌿 Header -->
    <div>
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">Quest Collection</h1>
        <p class="text-[#6A8A52] mt-1">View and edit all saved sustainability quests.</p>
    </div>

    <!-- 🌱 Layout Wrapper -->
    <div class="flex flex-col md:flex-row gap-8">
        <!-- ✅ Sidebar -->
        <aside class="w-full md:w-1/3 max-w-sm mx-auto bg-[#FCF9EF] rounded-2xl p-6 shadow-[0_8px_20px_#7A8C4F]/40 border border-green-100">
            <!-- Active Quests -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Active Quests</h2>
                <button class="bg-[#7A8C4F] hover:bg-[#90A955] text-white font-semibold py-1.5 px-3 rounded-lg shadow-md transition">
                    + New
                </button>
            </div>

            <!-- Quest List -->
            <ul class="space-y-2 mb-6">
                <li class="p-3 bg-[#FFFFFF] border border-green-100 rounded-xl hover:scale-[1.02] transition transform shadow-sm cursor-pointer">
                    Tree Planting
                </li>
                <li class="p-3 bg-[#FFFFFF] border border-green-100 rounded-xl hover:scale-[1.02] transition transform shadow-sm cursor-pointer">
                    Plastic-Free Week
                </li>
                <li class="p-3 bg-[#FFFFFF] border border-green-100 rounded-xl hover:scale-[1.02] transition transform shadow-sm cursor-pointer italic text-[#6D7058]">
                    Beach Clean-up
                </li>
            </ul>

            <hr class="border-[#E6EAD7] mb-6">

            <!-- Navigation -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('adminQuests') }}" 
                   class="bg-[#4F6B3F] text-[#F6F9EE] py-2 rounded-lg text-center hover:bg-[#3E5730] transition font-medium shadow">
                    Quest Dashboard
                </a>
            </div>
        </aside>

        <!-- 📚 Quest Collection Main -->
        <main class="flex-1 space-y-6">
            <!-- Header Row -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-[#4F6B3F]">Quest Collection</h2>
                <button class="flex items-center gap-2 bg-[#4F6B3F] text-[#F6F9EE] px-5 py-2 rounded-full shadow hover:bg-[#3E5730] transition font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    Export Collection
                </button>
            </div>

            <!-- 🌿 Quest Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Quest Card -->
                <div class="eco-card relative border border-[#E6EAD7] rounded-xl overflow-hidden bg-white shadow hover:scale-105 transition transform hover:shadow-[0_8px_20px_#7A8C4F]/50 cursor-pointer">
                    <img src="{{ asset('images/quest-placeholder.jpg') }}" alt="Beach Clean-Up" class="w-full h-28 object-cover">
                    <button class="absolute top-2 right-2 bg-[#4F6B3F] text-white p-1.5 rounded-md shadow hover:bg-[#3E5730] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536M9 11l3.536-3.536m0 0L18 2m-5.464 5.464L2 18v4h4L18 7.464z" />
                        </svg>
                    </button>
                    <div class="p-4">
                        <h3 class="text-[#3B3B3B] font-semibold text-sm">Beach Clean-Up</h3>
                        <div class="flex justify-between items-center mt-2 text-xs">
                            <span class="bg-[#E0E5D8] text-[#4F6B3F] px-2 py-1 rounded-md uppercase">Active</span>
                            <span class="text-[#4F6B3F] font-semibold">150 pts</span>
                        </div>
                    </div>
                </div>

                <!-- Quest Card -->
                <div class="eco-card relative border border-[#E6EAD7] rounded-xl overflow-hidden bg-white shadow hover:scale-105 transition transform hover:shadow-[0_8px_20px_#7A8C4F]/50 cursor-pointer">
                    <img src="{{ asset('images/quest-placeholder.jpg') }}" alt="Water Conservation" class="w-full h-28 object-cover">
                    <div class="p-4">
                        <h3 class="text-[#3B3B3B] font-semibold text-sm">Water Conservation</h3>
                        <div class="flex justify-between items-center mt-2 text-xs">
                            <span class="bg-[#E0E5D8] text-[#4F6B3F] px-2 py-1 rounded-md uppercase">Pending</span>
                            <span class="text-[#4F6B3F] font-semibold">100 pts</span>
                        </div>
                    </div>
                </div>

                <!-- Quest Card -->
                <div class="eco-card relative border border-[#E6EAD7] rounded-xl overflow-hidden bg-white shadow hover:scale-105 transition transform hover:shadow-[0_8px_20px_#7A8C4F]/50 cursor-pointer">
                    <img src="{{ asset('images/quest-placeholder.jpg') }}" alt="Tree Planting" class="w-full h-28 object-cover">
                    <div class="p-4">
                        <h3 class="text-[#3B3B3B] font-semibold text-sm">Tree Planting</h3>
                        <div class="flex justify-between items-center mt-2 text-xs">
                            <span class="bg-[#E0E5D8] text-[#4F6B3F] px-2 py-1 rounded-md uppercase">Active</span>
                            <span class="text-[#4F6B3F] font-semibold">200 pts</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
