@extends('layouts.adminLayout')

@section('title', 'System Alerts')

@section('content')
<div class="pl-4 pr-4 pt-2 pb-4 text-[#3B3B3B] font-sans h-screen overflow-y-auto">

    <!-- ⚠️ Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">System Alerts</h1>
        <p class="text-[#6A8A52] mt-1 text-sm">Stay informed about critical and time-sensitive system notifications.</p>
    </div>

    <!-- 🔔 Filters & Actions -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <!-- Search -->
            <div class="relative w-72">
                <input 
                    type="text" 
                    placeholder="Search alerts..."
                    class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2 border border-[#7A8C4F] rounded-full 
                           focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]"
                >
                <svg 
                    class="absolute right-3 top-2.5 w-4 h-4 text-[#7A8C4F]" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2" 
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" 
                    />
                </svg>
            </div>

            <!-- Filter -->
            <select 
                class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-4 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]"
            >
                <option value="">All Priorities</option>
                <option value="high">High Priority</option>
                <option value="medium">Medium Priority</option>
            </select>
        </div>

        <!-- Mute Non-Critical Alerts -->
        <button class="flex items-center gap-2 bg-[#A46C47] hover:bg-[#8C5E3D] text-white font-medium px-5 py-2 rounded-full shadow transition">
            <i class="fa-solid fa-bell-slash"></i>
            Mute Non-Critical Alerts
        </button>
    </div>

    <!-- 🧩 Alerts List -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <!-- Pending Verifications -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold text-[#4F6B3F]">Pending User Verifications</h2>
                <p class="text-sm text-gray-600 mt-1">Unverified users for over 7 days.</p>
                <p class="text-xs text-gray-500 mt-2">⏱️ Last updated: 5 mins ago</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="text-xs bg-red-100 text-red-700 font-medium px-3 py-1 rounded-full">High</span>
                <button class="bg-[#7A8C4F] hover:bg-[#6B7B43] text-white px-4 py-1 rounded-full text-xs font-medium transition">Verify Users</button>
            </div>
        </div>

        <!-- Expiring Quests -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold text-[#4F6B3F]">Expiring Quests</h2>
                <p class="text-sm text-gray-600 mt-1">Some quests are ending in less than 48 hours.</p>
                <p class="text-xs text-gray-500 mt-2">🕒 Last updated: 30 mins ago</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="text-xs bg-yellow-100 text-yellow-700 font-medium px-3 py-1 rounded-full">Medium</span>
                <button class="bg-[#7A8C4F] hover:bg-[#6B7B43] text-white px-4 py-1 rounded-full text-xs font-medium transition">Review Quests</button>
            </div>
        </div>

        <!-- Expiring Vouchers -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold text-[#4F6B3F]">Expiring Vouchers</h2>
                <p class="text-sm text-gray-600 mt-1">Unused vouchers expiring in less than 3 days.</p>
                <p class="text-xs text-gray-500 mt-2">🎟️ Last updated: 2 hrs ago</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="text-xs bg-yellow-100 text-yellow-700 font-medium px-3 py-1 rounded-full">Medium</span>
                <button class="bg-[#7A8C4F] hover:bg-[#6B7B43] text-white px-4 py-1 rounded-full text-xs font-medium transition">Check Vouchers</button>
            </div>
        </div>

        <!-- High Invalid Submissions -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold text-[#4F6B3F]">High Invalid Submission Rate</h2>
                <p class="text-sm text-gray-600 mt-1">Over 40% invalid submissions on a quest.</p>
                <p class="text-xs text-gray-500 mt-2">🚩 Last updated: 1 hr ago</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="text-xs bg-red-100 text-red-700 font-medium px-3 py-1 rounded-full">High</span>
                <button class="bg-[#7A8C4F] hover:bg-[#6B7B43] text-white px-4 py-1 rounded-full text-xs font-medium transition">Review Submissions</button>
            </div>
        </div>

        <!-- QR Scan Failures -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold text-[#4F6B3F]">QR Scan Failures</h2>
                <p class="text-sm text-gray-600 mt-1">Multiple reused or expired QR scan attempts detected.</p>
                <p class="text-xs text-gray-500 mt-2">📱 Last updated: 10 mins ago</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="text-xs bg-red-100 text-red-700 font-medium px-3 py-1 rounded-full">High</span>
                <button class="bg-[#7A8C4F] hover:bg-[#6B7B43] text-white px-4 py-1 rounded-full text-xs font-medium transition">Investigate</button>
            </div>
        </div>
    </div>
</div>
@endsection
