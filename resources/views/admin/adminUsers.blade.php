@extends('layouts.adminLayout')

@section('title', 'Users')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">Users</h1>
        <p class="text-[#6A8A52] mt-1">Manage user accounts and verification status.</p>
    </div>

    <!-- Search and Actions -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <!-- Left Side: Search & Filter -->
        <div class="flex items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-104">
                <input 
                    type="text" 
                    placeholder="Search user or email..."
                    class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                           focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]"
                >
                <svg 
                    class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" 
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

            <!-- Filter Dropdown -->
            <select 
                class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-4 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]"
            >
                <option value="">All Types</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="guest">Guest</option>
            </select>
        </div>

        <!-- Right Side: Export Button -->
        <button class="flex items-center gap-2 bg-[#A46C47] hover:bg-[#8C5E3D] text-white font-medium px-5 py-2 rounded-full shadow transition">
            <!-- Export Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
            </svg>
            Export User List
        </button>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7]">
        <table class="min-w-full text-sm text-[#4F3B2C]">
            <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">#</th>
                    <th class="px-4 py-3 text-left font-semibold">Name</th>
                    <th class="px-4 py-3 text-left font-semibold">Email</th>
                    <th class="px-4 py-3 text-left font-semibold">User Type</th>
                    <th class="px-4 py-3 text-left font-semibold">Verified</th>
                    <th class="px-4 py-3 text-left font-semibold">Registered</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Shynne Martinez</td>
                    <td class="px-4 py-3">shynne@example.com</td>
                    <td class="px-4 py-3 capitalize">Admin</td>
                    <td class="px-4 py-3"><span class="text-green-700 font-semibold">Verified</span></td>
                    <td class="px-4 py-3">Oct 30, 2025</td>
                </tr>
                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                    <td class="px-4 py-3">2</td>
                    <td class="px-4 py-3">Liam Dela Cruz</td>
                    <td class="px-4 py-3">liamdc@example.com</td>
                    <td class="px-4 py-3 capitalize">User</td>
                    <td class="px-4 py-3"><span class="text-red-600 font-semibold">Unverified</span></td>
                    <td class="px-4 py-3">Oct 25, 2025</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
