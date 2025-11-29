@extends('layouts.adminLayout')

@section('title', 'Users')

@section('content')
<div class="space-y-6">
    <!-- Header Section with Quick Actions -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">User Management</h1>
            <p class="font-sans text-[#6A8A52] mt-1">Manage user accounts, verification, and activity status.</p>
        </div>
        
        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-2 justify-end">
            <button onclick="openVerifyModal()" class="btn-eco btn-mint compact" title="Verify User">
                <i class="fa-solid fa-qrcode"></i>
                <span class="hidden lg:inline">Verify User</span>
            </button>
            <button class="btn-eco btn-leaf compact" title="Export Users">
                <i class="fa-solid fa-download"></i>
                <span class="hidden xl:inline">Export</span>
            </button>
            <button class="btn-eco btn-sage compact" title="Bulk Actions">
                <i class="fa-solid fa-users"></i>
                <span class="hidden xl:inline">Bulk Actions</span>
            </button>
        </div>
    </div>
<!-- 🔍 TABLE HEADER WITH TITLE, ALERTS & SEARCH -->
<section class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7]">
    <div class="flex flex-col lg:flex-row gap-4 items-center">
        <!-- Table Title -->
        <div class="flex items-center gap-2 shrink-0">
            <i class="fa-solid fa-users text-[#7F8A4F] text-lg"></i>
            <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans whitespace-nowrap">
                User Accounts <span class="text-[#6A8A52]">({{ count($users) }})</span>
            </h2>
        </div>

        <!-- 🚨 URGENT ALERTS -->
        <div class="bg-[#FEF2F2] border border-[#FECACA] rounded-xl px-3 py-2 shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-[#DC2626] rounded-full animate-pulse"></div>
                <span class="font-semibold text-[#DC2626] text-sm whitespace-nowrap">5 pending</span>
            </div>
        </div>

        <!-- Search Input -->
        <div class="relative flex-1 min-w-[250px]">
            <input type="text" placeholder="Search user or email..."
                class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans">
            <svg class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Filter Dropdowns -->
        <div class="flex gap-2 shrink-0">
            <select class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-3 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans whitespace-nowrap">
                <option value="">All Types</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="guest">Guest</option>
            </select>

            <select class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-3 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans whitespace-nowrap">
                <option value="">All Status</option>
                <option value="verified">Verified</option>
                <option value="unverified">Unverified</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
</section>

    <!-- 👥 USERS TABLE -->
    <div class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] overflow-x-auto">
        <table class="min-w-full text-sm text-[#4F3B2C] font-sans">
            <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold font-sans">#</th>
                    <th class="px-4 py-3 text-left font-semibold font-sans">Name</th>
                    <th class="px-4 py-3 text-left font-semibold font-sans">Email</th>
                    <th class="px-4 py-3 text-left font-semibold font-sans">User Type</th>
                    <th class="px-4 py-3 text-left font-semibold font-sans">Activity Status</th>
                    <th class="px-4 py-3 text-left font-semibold font-sans">Verified</th>
                    <th class="px-4 py-3 text-left font-semibold font-sans">Registered</th>
                    <th class="px-4 py-3 text-left font-semibold font-sans">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $index => $user)
                    @php
                        // Calculate last activity date
                        $lastActivityDates = collect();

                        // Collect dates from different user activities
                        if ($user->pointsHistory->count()) {
                            $lastActivityDates->push($user->pointsHistory->max('created_at'));
                        }
                        if ($user->savedLibraries->count()) {
                            $lastActivityDates->push($user->savedLibraries->max('saved_at'));
                        }
                        if ($user->savedEcoActions->count()) {
                            $lastActivityDates->push($user->savedEcoActions->max('log_date'));
                        }
                        if ($user->userVouchers->count()) {
                            $lastActivityDates->push($user->userVouchers->max('redeemed_date'));
                        }

                        // Determine last activity
                        $lastActivity = $lastActivityDates->count() ? $lastActivityDates->max() : null;

                        // Check if inactive (6 months or more)
                        $inactiveMessage = '';
                        if (
                            $lastActivity &&
                            \Carbon\Carbon::parse($lastActivity)->lt(\Carbon\Carbon::now()->subMinutes(6))
                        ) {
                            $inactiveMessage = $user->is_activity ? 'Inactive for 6+ months' : 'Inactive';
                        }
                    @endphp

                    <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 font-medium">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $user->user_type === 'admin' ? 'bg-[#FFFBEB] text-[#D97706]' : 
                                   ($user->user_type === 'user' ? 'bg-[#F0F7E6] text-[#4F6B3F]' : 
                                   'bg-[#EFF6FF] text-[#1E40AF]') }}">
                                {{ $user->user_type }}
                            </span>
                        </td>

                        <td class="px-4 py-2">
                            @if ($inactiveMessage)
                                <span class="text-red-600 font-semibold cursor-pointer inactive-toggle px-2 py-1 rounded-full bg-red-50 text-xs"
                                    data-user-id="{{ $user->user_id }}">
                                    {{ $inactiveMessage }}
                                </span>
                            @else
                                <span class="text-green-600 font-semibold px-2 py-1 rounded-full bg-green-50 text-xs">Active</span>
                            @endif
                        </td>

                        <td class="px-4 py-2">
                            @if($user->is_verified)
                                <span class="text-green-600 font-semibold px-2 py-1 rounded-full bg-green-50 text-xs">Verified</span>
                            @else
                                <span class="text-red-600 font-semibold px-2 py-1 rounded-full bg-red-50 text-xs">Unverified</span>
                            @endif
                        </td>
                        
                        <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>

                        <td class="px-4 py-2">
                            <div class="flex flex-wrap gap-1.5">
                                <!-- View Button -->
                                @php
                                    $userData = [
                                        'first_name' => $user->first_name,
                                        'middle_name' => $user->middle_name,
                                        'last_name' => $user->last_name,
                                        'email' => $user->email,
                                        'user_type' => $user->user_type,
                                        'is_verified' => $user->is_verified ? 1 : 0,
                                        'created_at' => $user->created_at->format('Y-m-d H:i'),
                                        'qr_code'         => $user->qr_code,
                                        'savedLibraries' => $user->savedLibraries->toArray(),
                                        'savedEcoActions' => $user->savedEcoActions->toArray(),
                                        'pointsHistory' => $user->pointsHistory->toArray(),
                                        'userVouchers' => $user->userVouchers->toArray(),
                                        'feedbacks' => $user->feedbacks->toArray(),
                                    ];
                                @endphp
                                <button class="btn-action btn-view compact" onclick='openViewUserModal({!! json_encode($userData, JSON_HEX_APOS | JSON_HEX_QUOT) !!})' title="View User">
                                    <i class="fas fa-eye"></i>
                                    <span class="hidden sm:inline">View</span>
                                </button>

                                @if (!$user->is_verified)
                                    <button class="btn-action btn-mint compact" title="Verify User"
                                        onclick="alert('Verify {{ $user->first_name }}')">
                                        <i class="fas fa-check-circle"></i>
                                        <span class="hidden sm:inline">Verify</span>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Compact button styles for table actions */
    .btn-action.compact {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
        gap: 0.3rem;
    }
    
    /* Responsive table */
    @media (max-width: 768px) {
        .btn-action.compact span {
            display: none;
        }
        
        .btn-action.compact {
            padding: 0.5rem;
            min-width: 2.5rem;
        }
        
        table {
            font-size: 0.875rem;
        }
        
        th, td {
            padding: 0.5rem 0.25rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.inactive-toggle').forEach(el => {
            el.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const span = this;

                fetch(`/user/${userId}/set-inactive`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            span.textContent = 'Inactive';
                            span.classList.remove('text-red-600', 'bg-red-50');
                            span.classList.add('text-gray-500', 'bg-gray-100');
                        }
                    })
                    .catch(err => console.error(err));
            });
        });
    });
    
    function handlePendingVerifications() {
        // Filter to show only unverified users
        alert('Showing unverified users for review...');
        // Implementation for filtering unverified users
    }
</script>

@endsection

@include('modal.userModal')