@extends('layouts.adminLayout')

@section('title', 'Home')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">Home</h1>
        <p class="text-[#6A8A52] mt-1">12 new submissions awaiting validation.</p>
    </div>


  <!-- Top Buttons - Grouped by Function -->
    <div class="flex flex-wrap gap-4">
        <!-- 🟢 PRIMARY ACTIONS (Green Family) -->
        <button onclick="openQuestModal()" class="btn-eco btn-mint">
            <i class="fa-solid fa-circle-plus"></i>
            <span>Create New Quest</span>
        </button>

        <button onclick="openEcoTopicModal()" class="btn-eco btn-leaf">
            <i class="fa-solid fa-leaf"></i>
            <span>Add Eco Topic</span>
        </button>

        <button onclick="openEcoActionModal()" class="btn-eco btn-olive">
            <i class="fa-solid fa-hand-holding-heart"></i>
            <span>Add Eco Action</span>
        </button>

        <!-- 🟠 SECONDARY ACTIONS (Neutral Colors) -->
        <button onclick="openVerifyModal()" class="btn-eco btn-sand">
            <i class="fa-solid fa-qrcode"></i>
            <span>Verify User</span>
        </button>

        <!-- New Button: Scan User QR for Pending Quests -->
        <button onclick="openUserQrScannerModal()" class="btn-eco btn-leaf">
            <i class="fa-solid fa-user-check"></i>
            <span>Scan User QR</span>
        </button>

        <button class="btn-eco btn-sage">
            <i class="fa-solid fa-gear"></i>
            <span>System Settings</span>
        </button>

        <!-- 🟡 ALERT/ATTENTION ACTIONS (Clay/Warm Colors) -->
        <button class="btn-eco btn-clay">
            <i class="fa-solid fa-hourglass-half"></i>
            <span>Pending Submissions</span>
        </button>
    </div>



    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-[#4F6B3F]">

        <!-- Total Verified Users -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7]">
            <h3 class="text-lg font-semibold">Total Verified Users</h3>
            <div class="mt-3 flex items-center justify-between">
                <div class="text-4xl font-bold text-[#4F6B3F]">24</div>
                <div class="text-sm text-[#A46C47] font-medium">▲ +12% vs last week</div>
            </div>
            <p class="text-sm text-[#6A8A52] mt-2">/45</p>
        </div>

        <!-- Pending Submissions -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7]">
            <h3 class="text-lg font-semibold">Pending Submissions</h3>
            <p class="text-sm text-[#7A7A7A] mt-1 italic">
                “Behind every submission is someone choosing sustainability.”
            </p>
            <div class="mt-4 flex items-center justify-between">
                <div class="text-4xl font-bold">7</div>
                <p class="text-[#A46C47] text-sm">3 overdue</p>
            </div>
        </div>

        <!-- Active Quests -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7]">
            <h3 class="text-lg font-semibold">Active Quests</h3>
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm">
                    <span>LIVE:</span>
                    <span class="font-semibold text-[#4F6B3F]">3</span>
                </div>
                <div class="flex items-center justify-between text-sm mt-1">
                    <span>UPCOMING:</span>
                    <span class="font-semibold text-[#4F6B3F]">3</span>
                </div>
            </div>
            <div class="text-4xl font-bold text-[#4F6B3F] mt-3">8</div>
        </div>

        <!-- Vouchers Redeemed -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7]">
            <h3 class="text-lg font-semibold">Vouchers Redeemed</h3>
            <div class="mt-4 flex items-center justify-between">
                <div class="text-4xl font-bold text-[#4F6B3F]">17</div>
                <div class="text-sm text-[#A46C47] font-medium">▲ +5 vs last week</div>
            </div>
        </div>

        <!-- Average Daily Eco-Actions -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7] lg:col-span-1">
            <h3 class="text-lg font-semibold">Avg. Daily Eco-Actions Logged</h3>
            <p class="text-sm text-[#A46C47] mt-1">Average Eco-Actions per day</p>

            <!-- Graph -->
            <div class="mt-4">
                <div class="h-32 flex items-end space-x-3">
                    <div class="w-6 bg-[#D8B08C] h-6 rounded-t"></div>
                    <div class="w-6 bg-[#C9A37E] h-8 rounded-t"></div>
                    <div class="w-6 bg-[#B48E6A] h-10 rounded-t"></div>
                    <div class="w-6 bg-[#A17856] h-14 rounded-t"></div>
                    <div class="w-6 bg-[#8B6543] h-20 rounded-t"></div>
                    <div class="w-6 bg-[#755330] h-24 rounded-t"></div>
                </div>
            </div>

            <div class="mt-3 flex justify-between text-sm text-[#6A8A52]">
                <span>Daily Average over last 30 days</span>
                <span>1.5 vs last week → <strong>2.4</strong></span>
            </div>
        </div>

        <!-- Points Distributed -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7]">
            <h3 class="text-lg font-semibold">Points Distributed</h3>
            <div class="text-4xl font-bold mt-3 text-[#4F6B3F]">121 pts</div>
            <p class="text-sm text-[#6A8A52]">for the last 7 days</p>

            <!-- Mini chart -->
            <div class="mt-4 h-12 flex space-x-2">
                <div class="w-6 bg-[#C9A37E] h-8 rounded"></div>
                <div class="w-6 bg-[#A46C47] h-10 rounded"></div>
                <div class="w-6 bg-[#7F5C3A] h-12 rounded"></div>
            </div>
        </div>

        <!-- Feedback -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7]">
            <h3 class="text-lg font-semibold">ECOconnect New Feedbacks</h3>
            <div class="text-5xl font-bold text-[#4F6B3F] mt-4">2</div>
        </div>

        <!-- Quest Completion Funnel -->
        <div class="bg-white rounded-lg shadow p-5 border border-[#E6EAD7]">
            <h3 class="text-lg font-semibold">Quest Completion Funnel</h3>
            <div class="mt-4 space-y-2">
                <div class="bg-[#DCE8C9] px-3 py-2 rounded-full text-center font-medium">Plastic-Free Week</div>
                <div class="bg-[#E5EDDB] px-3 py-2 rounded-full text-center font-medium">Green Commute</div>
                <div class="bg-[#E5EDDB] px-3 py-2 rounded-full text-center font-medium">Tree Planting</div>
            </div>
        </div>

    </div>
</div>
@include('modal.createQuestModal')
@endsection

