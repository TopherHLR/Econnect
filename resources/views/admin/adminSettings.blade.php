@extends('layouts.adminLayout')

@section('title', 'System Settings')

@section('content')
<div class="pl-4 pr-4 pt-2 pb-4 text-[#3B3B3B] font-sans overflow-y-auto">

    <!-- ⚙️ Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">System Settings</h1>
        <p class="text-[#6A8A52] mt-1 text-sm">Configure system-wide preferences, admin access, and platform rules.</p>
    </div>

    <!-- 🧩 Settings Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- 🌿 Platform Settings -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Platform Settings</h2>

            <!-- Daily Tap Limit -->
            <div class="mb-4">
                <label class="block text-sm text-[#3B3B3B] font-medium mb-1">Daily Tap Limit</label>
                <input 
                    type="number" 
                    value="100"
                    class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none"
                >
            </div>

            <!-- Consolation Points Rule -->
            <div class="mb-4">
                <label class="block text-sm text-[#3B3B3B] font-medium mb-1">Consolation Points Rule</label>
                <input 
                    type="text" 
                    value="1 pt after 3 invalid streaks"
                    class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none"
                >
            </div>

            <!-- Default Quest Categories -->
            <div class="mb-4">
                <label class="block text-sm text-[#3B3B3B] font-medium mb-1">Default Quest Categories</label>
                <div class="flex flex-wrap gap-2 mb-2">
                    <span class="bg-[#E0E9D6] text-[#4F6B3F] px-3 py-1 rounded-full text-xs">Recycling</span>
                    <span class="bg-[#E0E9D6] text-[#4F6B3F] px-3 py-1 rounded-full text-xs">Carbon Reduction</span>
                    <span class="bg-[#E0E9D6] text-[#4F6B3F] px-3 py-1 rounded-full text-xs">Clean-Ups</span>
                </div>
                <input 
                    type="text" 
                    placeholder="Add new category..."
                    class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none"
                >
            </div>

            <div class="flex justify-end">
                <button class="btn-eco btn-mint">
                    <i class="fa-solid fa-save"></i>
                    <span>Save Platform Settings</span>
                </button>
            </div>
        </div>

        <!-- 🔔 Notification Preferences -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Notification Preferences</h2>

            <div class="space-y-3">
                <label class="flex items-center gap-3 text-sm text-[#3B3B3B]">
                    <input type="checkbox" checked class="accent-[#7A8C4F]">
                    Email alerts for new submissions
                </label>
                <label class="flex items-center gap-3 text-sm text-[#3B3B3B]">
                    <input type="checkbox" checked class="accent-[#7A8C4F]">
                    Email alerts for system errors
                </label>
                <label class="flex items-center gap-3 text-sm text-[#3B3B3B]">
                    <input type="checkbox" checked class="accent-[#7A8C4F]">
                    Email alerts for low voucher stock
                </label>
            </div>

            <div class="flex justify-end mt-4">
                <button class="btn-eco btn-mint">
                    <i class="fa-solid fa-bell"></i>
                    <span>Update Notifications</span>
                </button>
            </div>
        </div>

        <!-- 🔒 Data & Privacy -->
        <div class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
            <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Data & Privacy</h2>
            <p class="text-sm text-gray-600 mb-4">Manage data retention and privacy compliance (GDPR).</p>

            <div class="flex flex-wrap gap-3">
                <button class="btn-eco btn-olive">
                    <i class="fa-solid fa-download"></i>
                    <span>Download All Data</span>
                </button>

                <button 
                    onclick="confirm('Are you sure you want to clear all audit logs? This action cannot be undone.')"
                    class="btn-eco btn-clay">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Clear Audit Logs</span>
                </button>
            </div>

            <div class="mt-5 border-t border-[#E6EAD7] pt-4">
                <p class="text-sm text-gray-600 mb-2 font-medium">🔐 Security Verification</p>
                <p class="text-xs text-gray-500 mb-3">Sensitive actions require password re-authentication.</p>
                <input 
                    type="password" 
                    placeholder="Enter admin password..."
                    class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none mb-3"
                >
                <button class="btn-eco btn-mint">
                    <i class="fa-solid fa-shield-alt"></i>
                    <span>Re-Authenticate</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection