<table class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
    <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
        <tr>
            <th class="px-4 py-3 text-left font-semibold font-sans">#</th>
            <th class="px-4 py-3 text-left font-semibold font-sans">Name</th>
            <th class="px-4 py-3 text-left font-semibold font-sans">Email</th>
            <th class="px-4 py-3 text-left font-semibold font-sans">User Type</th>
            <th class="px-4 py-3 text-left font-semibold font-sans">Activity Status</th>
            <th class="px-4 py-3 text-left font-semibold font-sans">Verified by Email</th>
            <th class="px-4 py-3 text-left font-semibold font-sans">Registered</th>
            <th class="px-4 py-3 text-left font-semibold font-sans">Actions</th>
        </tr>
    </thead>

    <tbody id="usersTableBody">
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
                if ($lastActivity && \Carbon\Carbon::parse($lastActivity)->lt(\Carbon\Carbon::now()->subMonths(6))) {
                    $inactiveMessage = $user->is_activity ? 'Inactive for 6+ months' : 'Inactive';
                }
            @endphp

            <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2 font-medium">{{ $user->first_name }} {{ $user->middle_name }}
                    {{ $user->last_name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">
                    <span
                        class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $user->user_type === 'admin'
                                        ? 'bg-[#FFFBEB] text-[#D97706]'
                                        : ($user->user_type === 'user'
                                            ? 'bg-[#F0F7E6] text-[#4F6B3F]'
                                            : 'bg-[#EFF6FF] text-[#1E40AF]') }}">
                        {{ $user->user_type }}
                    </span>
                </td>

                <td class="px-4 py-2">
                    @if ($inactiveMessage)
                        <span
                            class="text-red-600 font-semibold cursor-pointer inactive-toggle px-2 py-1 rounded-full bg-red-50 text-xs"
                            data-user-id="{{ $user->user_id }}">
                            {{ $inactiveMessage }}
                        </span>
                    @else
                        <span
                            class="text-green-600 font-semibold px-2 py-1 rounded-full bg-green-50 text-xs">Active</span>
                    @endif
                </td>

                <td class="px-4 py-2">
                    @if ($user->is_verified)
                        <span
                            class="text-green-600 font-semibold px-2 py-1 rounded-full bg-green-50 text-xs">Verified</span>
                    @else
                        <span
                            class="text-red-600 font-semibold px-2 py-1 rounded-full bg-red-50 text-xs">Unverified</span>
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
                                'qr_code' => $user->qr_code,
                                'savedLibraries' => $user->savedLibraries->toArray(),
                                'savedEcoActions' => $user->savedEcoActions->toArray(),
                                'pointsHistory' => $user->pointsHistory->toArray(),
                                'userVouchers' => $user->userVouchers->toArray(),
                                'feedbacks' => $user->feedbacks->toArray(),
                            ];
                        @endphp
                        <button class="btn-action btn-view compact" onclick='openViewUserModal({!! json_encode($userData, JSON_HEX_APOS | JSON_HEX_QUOT) !!})'
                            title="View User">
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

{{ $users->links('vendor.pagination.bootstrap_5') }}
