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

<!-- Right: Export Dropdown -->
<div class="relative" x-data="{ open: false }">
    <button 
        @click="open = !open"
        class="btn-eco btn-clay"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
        </svg>
        <span>Export Report</span>
        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

            <!-- Dropdown Menu -->
            <div 
                x-show="open" 
                @click.away="open = false"
                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-[#E6EAD7] z-10"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
            >
                <div class="p-2 space-y-1">
                    <button class="w-full text-left px-3 py-2 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-md transition">
                        📊 User Activity Report
                    </button>
                    <button class="w-full text-left px-3 py-2 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-md transition">
                        🌱 Impact Analysis Report
                    </button>
                    <button class="w-full text-left px-3 py-2 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-md transition">
                        🎯 Quest Performance Stats
                    </button>
                    <button class="w-full text-left px-3 py-2 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-md transition">
                        📈 Eco-Actions Completion Data
                    </button>
                    <button class="w-full text-left px-3 py-2 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-md transition">
                        💰 Point Economy Analytics
                    </button>
                    <button class="w-full text-left px-3 py-2 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-md transition">
                        📋 Comprehensive Dashboard Export
                    </button>
                </div>
            </div>
        </div>
    </div>

     <!-- 🧩 Analytics Cards Grid - Horizontal Scroll -->
    <div class="mb-8 flex flex-col h-[calc(100vh-200px)]">
        <h3 class="text-xl font-semibold text-[#4F6B3F] mb-4">Key Metrics & Charts</h3>
        
        <!-- Horizontal Scroll Container - Takes remaining space -->
        <div class="overflow-x-auto pb-4 flex-1">
            <div class="flex gap-5 min-w-max h-full">
                
                <!-- Eco-Actions Completed Over Time -->
                <div class="w-[600px] bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex-shrink-0 h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Eco-Actions Completed Over Time</h2>
                    <div class="flex-1 flex items-center justify-center text-[#7A8C4F] bg-[#F9FBF3] rounded-lg border border-[#E0E9D6]">
                        [Line Chart: Eco-Actions Over Time]
                    </div>
                </div>

                <!-- Top 10 Eco Actions -->
                <div class="w-[600px] bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex-shrink-0 h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Top 10 Eco Actions</h2>
                    <div class="flex-1 overflow-y-auto">
                        <table class="w-full text-sm text-[#4F3B2C]">
                            <thead class="bg-[#E9ECDF] text-[#4F6B3F] sticky top-0">
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
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-3 py-2">4</td>
                                    <td class="px-3 py-2">Energy Saving Challenge</td>
                                    <td class="px-3 py-2">295</td>
                                    <td class="px-3 py-2 text-green-700 font-semibold">83%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-3 py-2">5</td>
                                    <td class="px-3 py-2">Water Conservation</td>
                                    <td class="px-3 py-2">280</td>
                                    <td class="px-3 py-2 text-green-700 font-semibold">81%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-3 py-2">6</td>
                                    <td class="px-3 py-2">Zero-Waste Lifestyle</td>
                                    <td class="px-3 py-2">265</td>
                                    <td class="px-3 py-2 text-green-700 font-semibold">79%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-3 py-2">7</td>
                                    <td class="px-3 py-2">Sustainable Commute</td>
                                    <td class="px-3 py-2">250</td>
                                    <td class="px-3 py-2 text-green-700 font-semibold">77%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-3 py-2">8</td>
                                    <td class="px-3 py-2">Eco-Friendly Shopping</td>
                                    <td class="px-3 py-2">235</td>
                                    <td class="px-3 py-2 text-green-700 font-semibold">75%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-3 py-2">9</td>
                                    <td class="px-3 py-2">Food Waste Reduction</td>
                                    <td class="px-3 py-2">220</td>
                                    <td class="px-3 py-2 text-green-700 font-semibold">73%</td>
                                </tr>
                                <tr class="hover:bg-[#F7F9F2] transition">
                                    <td class="px-3 py-2">10</td>
                                    <td class="px-3 py-2">Digital Carbon Footprint</td>
                                    <td class="px-3 py-2">205</td>
                                    <td class="px-3 py-2 text-green-700 font-semibold">70%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Point Economy -->
                <div class="w-[600px] bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex-shrink-0 h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-2">Point Economy</h2>
                    <p class="text-sm text-gray-600 mb-3">Points Earned vs Redeemed (Weekly)</p>
                    <div class="flex-1 bg-[#F4F6EB] rounded-lg flex items-center justify-center text-gray-400 text-xs">
                        [Dual Line Graph: Points Earned vs Redeemed]
                    </div>
                </div>

                <!-- Distribution of Point Sources -->
                <div class="w-[600px] bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex-shrink-0 h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Distribution of Point Sources</h2>
                    <div class="flex-1 bg-[#F4F6EB] rounded-lg flex items-center justify-center text-gray-400 text-xs">
                        [Pie Chart: Point Sources Distribution]
                    </div>
                </div>

                <!-- Quest Performance -->
                <div class="w-[600px] bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex-shrink-0 h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-2">Quest Performance</h2>
                    <p class="text-sm text-gray-600 mb-2">Completion Rate per Quests</p>
                    <div class="flex-1 bg-[#F4F6EB] mb-2 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                        [Bar Chart: Quest Completion Rates]
                    </div>
                    <p class="text-xs text-gray-600 mt-2">% Zero-Waste Challenge · Tree-Planting</p>
                </div>

                <!-- Invalid Submission Reasons -->
                <div class="w-[600px] bg-white rounded-xl shadow p-5 border border-[#E6EAD7] flex-shrink-0 h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-2">Invalid Submission Reasons</h2>
                    <div class="flex-1 bg-[#F4F6EB] rounded-lg flex items-center justify-center text-gray-400 text-xs">
                        [Word Cloud: Invalid Reasons]
                    </div>
                </div>

            </div>
        </div>

<!-- Navigation Buttons -->
<div class="flex justify-center gap-2 mt-4">
    <button onclick="scrollGraphs(-1)" class="btn-eco btn-olive">
        <span>Previous</span>
    </button>
    <button onclick="scrollGraphs(1)" class="btn-eco btn-olive">
        <span>Next</span>
    </button>
</div>
</div>

<style>
/* Custom scrollbar styling for horizontal scroll */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #7A8C4F;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #6B7B43;
}

/* Table scroll styling */
.h-52::-webkit-scrollbar {
    width: 6px;
}

.h-52::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.h-52::-webkit-scrollbar-thumb {
    background: #7A8C4F;
    border-radius: 3px;
}
</style>

<script>
// Optional: Add smooth scrolling and navigation indicators
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.overflow-x-auto');
    
    // Add navigation buttons (optional enhancement)
    const navButtons = `
        <div class="flex justify-center gap-2 mt-4">
            <button onclick="scrollGraphs(-1)" class="px-4 py-2 bg-[#7A8C4F] text-white rounded-full text-sm hover:bg-[#6B7B43] transition">Previous</button>
            <button onclick="scrollGraphs(1)" class="px-4 py-2 bg-[#7A8C4F] text-white rounded-full text-sm hover:bg-[#6B7B43] transition">Next</button>
        </div>
    `;
    
    // Uncomment below if you want navigation buttons
    // scrollContainer.parentNode.insertAdjacentHTML('afterend', navButtons);
});

function scrollGraphs(direction) {
    const container = document.querySelector('.overflow-x-auto');
    const scrollAmount = 650; // Adjust based on card width + gap
    container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}
</script>
@endsection