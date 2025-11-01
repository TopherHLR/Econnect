@extends('layouts.adminLayout')

@section('title', 'Admin Analytics')

@section('content')
<div class="pl-2 pr-4 pt-1 pb-4 text-[#3B3B3B] font-sans h-[100vh] overflow-y-auto">

    <!-- 📊 Header -->
    <div class="mb-5">
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">Admin Analytics</h1>
        <p class="text-[#6A8A52] mt-1 text-sm">Monitor overall platform activity and eco-performance insights.</p>
    </div>

    <!-- 🔍 Search and Filter -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <!-- Left: Search + Filter -->
        <div class="flex items-center gap-3">
            <!-- Search -->
            <div class="relative w-72">
                <input 
                    type="text" 
                    placeholder="Search by user or activity..."
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
                <option value="">All Categories</option>
                <option value="carbon">Carbon Reduction</option>
                <option value="recycling">Recycling</option>
                <option value="cleanups">Clean-ups</option>
            </select>
        </div>

        <!-- Right: Export Button -->
        <button class="flex items-center gap-2 bg-[#A46C47] hover:bg-[#8C5E3D] text-white font-medium px-5 py-2 rounded-full shadow transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
            </svg>
            Export Report
        </button>
    </div>

    <!-- 🧩 Analytics Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5">

        <!-- Eco-Actions Completed Over Time -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Eco-Actions Completed Over Time</h2>
            <div class="h-52 flex items-center justify-center text-[#7A8C4F] bg-[#F9FBF3] rounded-lg border border-[#E0E9D6]">
                [Chart visualization here]
            </div>
        </div>

        <!-- Top 10 Eco Actions -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Top 10 Eco Actions</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-[#4F3B2C]">
                    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold">Rank</th>
                            <th class="px-3 py-2 text-left font-semibold">Action</th>
                            <th class="px-3 py-2 text-left font-semibold">Users</th>
                            <th class="px-3 py-2 text-left font-semibold">Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                            <td class="px-3 py-2">1</td>
                            <td class="px-3 py-2">Plastic-Free Week</td>
                            <td class="px-3 py-2">420</td>
                            <td class="px-3 py-2 text-green-700 font-semibold">92%</td>
                        </tr>
                        <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                            <td class="px-3 py-2">2</td>
                            <td class="px-3 py-2">Community Clean-Up</td>
                            <td class="px-3 py-2">370</td>
                            <td class="px-3 py-2 text-green-700 font-semibold">88%</td>
                        </tr>
                        <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                            <td class="px-3 py-2">3</td>
                            <td class="px-3 py-2">Tree Planting Drive</td>
                            <td class="px-3 py-2">310</td>
                            <td class="px-3 py-2 text-green-700 font-semibold">85%</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-3 py-2 text-center text-[#7A8C4F]">...more actions...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Point Economy -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-2">Point Economy</h2>
            <p class="text-sm text-gray-600 mb-3">Points Earned vs Redeemed (Weekly)</p>
            <div class="bg-[#F4F6EB] h-44 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                [Line Graph Placeholder]
            </div>
        </div>

        <!-- Distribution of Point Sources -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Distribution of Point Sources</h2>
            <div class="bg-[#F4F6EB] h-44 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                [Pie Chart Placeholder]
            </div>
        </div>

        <!-- Quest Performance -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-2">Quest Performance</h2>
            <p class="text-sm text-gray-600 mb-2">Completion Rate per Quests</p>
            <div class="bg-[#F4F6EB] h-40 mb-2 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                [Bar Chart Placeholder]
            </div>
            <p class="text-xs text-gray-600">% Zero-Waste Challenge · Tree-Planting</p>
        </div>

        <!-- Invalid Submission Reasons -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-2">Invalid Submission Reasons</h2>
            <div class="bg-[#F4F6EB] h-40 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                [Word Cloud Placeholder]
            </div>
        </div>

        <!-- Export Panel (narrower width card) -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex flex-col justify-between max-w-xs">
            <div>
                <h2 class="text-lg font-semibold text-[#4F6B3F] mb-2">Export Panel</h2>
                <p class="text-sm text-gray-600 mb-4">Download analytics and reports.</p>
            </div>
            <div class="space-y-2">
                <button class="w-full py-2 bg-[#7A8C4F] text-white rounded-lg font-medium hover:bg-[#6B7B43] transition text-sm">
                    User Activity
                </button>
                <button class="w-full py-2 bg-[#8CA062] text-white rounded-lg font-medium hover:bg-[#7A8E56] transition text-sm">
                    Impact Report
                </button>
                <button class="w-full py-2 bg-[#A3B877] text-white rounded-lg font-medium hover:bg-[#91A368] transition text-sm">
                    Quest Stats
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
