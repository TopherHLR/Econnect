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
        <div class="flex flex-wrap items-center gap-4">
            <!-- Left Side: Search & Filter -->
            <div class="flex items-center gap-3">
                <!-- Search Input -->
                <div class="relative w-104">
                    <input type="text" placeholder="Search user or email..."
                        class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]">
                    <svg class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filter Dropdown -->
                <select
                    class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-4 
                   focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]">
                    <option value="">All Types</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="guest">Guest</option>
                </select>

                <!-- Verify Button -->
                <button onclick="openVerifyModal()" class="btn-eco btn-sand">
                    <i class="fa-solid fa-qrcode"></i>
                    <span>Verify User</span>
                </button>
            </div>
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
                        <th class="px-4 py-3 text-left font-semibold">Activity Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Verified</th>
                        <th class="px-4 py-3 text-left font-semibold">Registered</th>
                        <th class="px-4 py-3 text-left font-semibold">Actions</th>
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
                            <td class="px-4 py-2">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
                            </td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->user_type }}</td>

                            <td class="px-4 py-2">
                                @if ($inactiveMessage)
                                    <span class="text-red-600 font-semibold cursor-pointer inactive-toggle"
                                        data-user-id="{{ $user->user_id }}">
                                        {{ $inactiveMessage }}
                                    </span>
                                @else
                                    <span class="text-green-600 font-semibold">Active</span>
                                @endif

                            </td>


                            <td class="px-4 py-2">{{ $user->is_verified ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>

                            <td class="px-4 py-2 flex flex-wrap gap-1.5">
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
                                        'savedLibraries' => $user->savedLibraries->toArray(),
                                        'savedEcoActions' => $user->savedEcoActions->toArray(),
                                        'pointsHistory' => $user->pointsHistory->toArray(),
                                        'userVouchers' => $user->userVouchers->toArray(),
                                        'feedbacks' => $user->feedbacks->toArray(),
                                    ];
                                @endphp
                                <button class="btn-action btn-view" onclick='openViewUserModal({!! json_encode($userData, JSON_HEX_APOS | JSON_HEX_QUOT) !!})'>
                                    <i class="fas fa-eye"></i> View
                                </button>

                                <!-- Verify -->
                                @if (!$user->is_verified)
                                    <button class="btn-action btn-view" title="Verify User"
                                        onclick="alert('Verified {{ $user->first_name }}')">
                                        <i class="fas fa-check-circle"></i> Verify
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
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
                                // Update text (optional: also change color if needed)
                                span.textContent = 'Inactive';
                                span.classList.remove('text-red-600'); // optional
                                span.classList.add('text-gray-500'); // optional styling
                            }
                        })
                        .catch(err => console.error(err));
                });
            });
        });
    </script>

@endsection
@include('modal.verifyUserModal')
@include('modal.userModal')
