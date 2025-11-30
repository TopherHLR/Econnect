@extends('layouts.mainLayout')

@section('content')
    @if (Auth::check())
        <!-- 🔹 Main Container: Bigger & more spacious -->
        <div class="w-full max-w-screen-2xl mx-auto px-8 md:px-16 py-16 mt-12">

            <div class="bg-[#F7F3E7] rounded-4xl shadow-md border border-green-100 overflow-hidden p-8">
                @if (auth()->user()->user_type === 'verified_user')
                    <!-- 🌿 Top Container: Columns -->
                    <div class="flex flex-col md:flex-row gap-8">

                        <!-- ✅ Left Column: Accepted Challenges -->
                        <div
                            class="w-full md:w-1/4 bg-[#FCFFF6] rounded-2xl shadow-md p-4 max-h-[700px] overflow-y-auto flex flex-col justify-between">

                            <h2 class="text-lg font-semibold text-[#4F6B3F] py-3 rounded-xl text-center"
                                style="font-family: var(--font-serif);">
                                Accepted Quests
                            </h2>

                            <!-- Search Box -->
                            <div class="mb-4">
                                <input type="text" id="questSearch" placeholder="Search quests..."
                                    class="w-full px-3 py-2 rounded border border-gray-300 shadow-sm text-sm focus:outline-none focus:ring-1 focus:ring-green-500" />
                            </div>

                            <div class="space-y-3 flex-1">
                                @foreach ($quests as $quest)
                                    @php
                                        $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                    @endphp

                                    @if ($submission && $submission->status === 'pending')
                                        @php
                                            $daysLeft = $quest->end_date->isFuture()
                                                ? ceil(now()->diffInHours($quest->end_date) / 24)
                                                : 0;
                                            $hasProof =
                                                !empty($submission->proof_link) || !empty($submission->proof_image);
                                            $isDisabled = $daysLeft === 0 || $hasProof;
                                            $hintMessage =
                                                $daysLeft === 0
                                                    ? 'Quest expired'
                                                    : ($hasProof
                                                        ? 'Already submitted'
                                                        : '');
                                            $dayLabel = $daysLeft == 1 ? 'day' : 'days';
                                        @endphp

                                        <div class="flex flex-col">
                                            <div class="flex justify-between items-center bg-white p-3 rounded-2xl shadow-sm border-l-4 border-[#da7a5f] hover:shadow-md transition cursor-pointer accepted-quest {{ $isDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : '' }}"
                                                data-submission-id="{{ $submission->submission_id }}"
                                                data-description="{{ $quest->description }}">
                                                <span class="text-sm font-medium text-[#4F6B3F]">{{ $quest->title }}</span>
                                                <small class="text-gray-500 text-xs">{{ $daysLeft }} {{ $dayLabel }}
                                                    left</small>

                                                @if ($hintMessage)
                                                    <div class="mt-1.5 flex items-center space-x-1.5 text-amber-600">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 1.5a8.5 8.5 0 100 17 8.5 8.5 0 000-17zM9 13a1 1 0 102 0V9a1 1 0 10-2 0v4zm1-7a1 1 0 100-2 1 1 0 000 2z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-xs font-medium">{{ $hintMessage }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Completed Section -->
                            <div class="mt-6 border-t border-[#e0e0d6] pt-4 space-y-2">
                                <h3 class="text-sm font-semibold text-[#4F6B3F] mb-2">Completed Quests</h3>
                                @foreach ($quests as $quest)
                                    @php
                                        $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                    @endphp

                                    @if ($submission && $submission->status === 'completed')
                                        <div class="flex justify-between items-center text-sm text-green-700 cursor-pointer completed-quest"
                                            data-submission-id="{{ $submission->submission_id }}"
                                            data-title="{{ $quest->title }}" data-description="{{ $quest->description }}"
                                            data-points="{{ $quest->points_reward }}"
                                            data-date="{{ optional($submission->date_completed)->format('d/m/Y') }}">
                                            <span>✅ {{ $quest->title }}</span>
                                            <small>{{ optional($submission->date_completed)->format('d/m/Y') }}</small>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Rejected Section -->
                            <div class="mt-6 border-t border-[#e0e0d6] pt-4 space-y-2">
                                <h3 class="text-sm font-semibold text-[#4F6B3F] mb-2">Rejected Quests</h3>
                                @foreach ($quests as $quest)
                                    @php
                                        $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                    @endphp

                                    @if ($submission && $submission->status === 'rejected')
                                        <div class="flex justify-between items-center text-sm text-red-500 cursor-pointer rejected-quest"
                                            data-submission-id="{{ $submission->submission_id }}"
                                            data-description="{{ $quest->description }}">
                                            <span>❌ {{ $quest->title }}</span>
                                            <small>{{ optional($submission->date_rejected)->format('d/m/Y') }}</small>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>

                        <!-- 🌱 Right Column: Active Challenges -->
                        <div class="w-full md:w-3/4 bg-[#FCFFF6] rounded-2xl shadow-md p-6 flex flex-col">

                            <div class="flex justify-between items-center mb-6 gap-4">
                                <h2 class="px-6 py-2 text-[#4F6B3F] rounded-xl text-lg font-semibold text-center"
                                    style="font-family: var(--font-serif);">
                                    Active Eco-Quests
                                </h2>

                                <div class="flex items-center gap-2">
                                    <label for="questFilter" class="text-sm text-gray-700">Filter:</label>
                                    <select id="questFilter" class="px-3 py-1 rounded border border-gray-300 shadow-sm">
                                        <option value="all">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Grid of Challenges -->
                            <div class="max-w-full max-h-[600px] overflow-y-auto pr-2 flex-1 custom-scroll">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">

                                    @foreach ($quests as $quest)
                                        @php
                                            $user = auth()->user();
                                            $progressPoints = \App\Models\UserPointsHistory::where(
                                                'user_id',
                                                $user->user_id,
                                            )
                                                ->where('points_change', '>', 0)
                                                ->where('voided', false)
                                                ->sum('points_change');
                                            if ($progressPoints < $quest->required_points) {
                                                continue;
                                            }
                                            $submission = $quest->submissions->firstWhere('user_id', $user->user_id);

                                            $imagePath = match ($quest->category) {
                                                'Waste Management',
                                                'Upcycling / Creative Reuse',
                                                'Sustainable Mobility / Climate Action',
                                                'Community Cleanliness / Waste Reduction',
                                                'E-Waste / Digital Sustainability',
                                                'Biodiversity / Urban Greening',
                                                'Local Partnership / Eco Business Support',
                                                'Campus Greening / Waste Management'
                                                    => 'cat_images/sample.jpg',
                                                'Sustainable Lifestyle' => 'cat_images/sustainable.png',
                                                default => 'cat_images/sample.jpg',
                                            };

                                            $isCompleted = $submission?->status === 'completed';
                                            $isRejected = $submission?->status === 'rejected';
                                            $isPending = $submission?->status === 'pending';
                                            $isExpired = $quest->end_date->isPast() && !$isCompleted;
                                            $isInactive = $isCompleted || $isExpired || $isRejected || $isPending;
                                            $isNotStarted = $quest->start_date->isFuture() && !$isCompleted;
                                        @endphp

                                        @if ($quest->status === 'active')
                                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm transition relative
                                                {{ $isInactive || $isNotStarted ? 'opacity-50 pointer-events-none' : 'hover:shadow-md transform hover:-translate-y-1 cursor-pointer' }}
                                                eco-card"
                                                data-id="{{ $quest->quest_id }}" data-title="{{ $quest->title }}"
                                                data-description="{{ $quest->description }}"
                                                data-category="{{ $quest->category }}"
                                                data-points="{{ $quest->points_reward }}"
                                                data-status="{{ $quest->status }}"
                                                data-start-date="{{ $quest->start_date }}"
                                                data-end-date="{{ $quest->end_date }}">

                                                <!-- Overlay for statuses -->
                                                @if ($isInactive || $isNotStarted)
                                                    <div
                                                        class="absolute inset-0 bg-black/50 flex items-center justify-center z-10">
                                                        <span class="text-white font-semibold text-sm">
                                                            @if ($isCompleted)
                                                                Completed
                                                            @elseif($isExpired)
                                                                Expired
                                                            @elseif($isRejected)
                                                                Rejected
                                                            @elseif($isPending)
                                                                Pending
                                                            @elseif($isNotStarted)
                                                                Starts on {{ $quest->start_date->format('d/m/Y') }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif

                                                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $quest->title }}"
                                                    class="h-20 w-full object-cover rounded-t-2xl">

                                                <div
                                                    class="bg-gradient-to-t from-[#4a7144] to-[#6ea057] text-white p-3 flex flex-col justify-between rounded-b-2xl">
                                                    <div>
                                                        <h3 class="text-sm font-semibold truncate">{{ $quest->title }}</h3>
                                                        @php $daysLeft = $quest->end_date->isFuture() ? ceil(now()->diffInHours($quest->end_date)/24) : 0; @endphp
                                                        <p class="text-xs mt-1 opacity-100">Ends in {{ $daysLeft }}
                                                            days</p>
                                                    </div>
                                                    <p class="text-sm mt-2 font-bold">{{ $quest->points_reward }} pts 🌱
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                        </div> <!-- End Right Column -->

                    </div> <!-- End Top Container Columns -->
                @else
                    <div class="relative w-full">
                        <!-- 🌿 Main Container Blurred -->
                        <div
                            class="bg-[#F7F3E7] rounded-4xl shadow-md border border-green-100 overflow-hidden p-8 filter blur-sm pointer-events-none select-none">
                            <!-- Top Container Columns (blurred preview) -->
                            <div class="flex flex-col md:flex-row gap-8">
                                <!-- Left Column: Accepted Quests Preview -->
                                <div
                                    class="w-full md:w-1/4 bg-[#FCFFF6] rounded-2xl shadow-md p-4 flex flex-col gap-3 max-h-[700px] overflow-hidden">
                                    <h2 class="text-lg font-semibold text-[#4F6B3F] py-3 text-center">Accepted Quests</h2>
                                    <div class="space-y-2">
                                        @for ($i = 0; $i < 3; $i++)
                                            <div class="bg-white p-2 rounded-xl opacity-70"></div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Right Column: Active Quests Preview -->
                                <div
                                    class="w-full md:w-3/4 bg-[#FCFFF6] rounded-2xl shadow-md p-6 flex flex-col gap-3 max-h-[700px] overflow-hidden">
                                    <h2 class="text-lg font-semibold text-[#4F6B3F] text-center">Active Eco-Quests</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mt-3">
                                        @for ($i = 0; $i < 6; $i++)
                                            <div class="bg-white rounded-2xl h-36 opacity-70"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 🔒 Overlay Lock & Message on Top (Light Glass UI) -->
                        <div
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center z-20">
                            <div
                                class="bg-white/50 backdrop-blur-md border border-white/30 rounded-2xl p-8 shadow-lg flex flex-col items-center w-80 text-center">
                                <div class="text-6xl text-green-800 mb-4">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <h2 class="text-2xl font-semibold text-green-900 mb-2">Access Restricted</h2>
                                <p class="text-green-800 text-md">
                                    Only verified users can access Eco-Quests. Become a customer and scan your Account QR at
                                    your first in-store purchase.
                                </p>
                            </div>
                        </div>

                    </div>
                @endif

            </div> <!-- End Main Container -->

        </div>
    @else
        <div class="flex items-center justify-center min-h-96">
            <div class="text-center p-8 bg-[#FCF9EF] rounded-2xl shadow border border-[#C6D0B2] max-w-md">
                <div class="text-6xl text-[#7A8C4F] mb-4">
                    <i class="fas fa-lock"></i>
                </div>
                <h2 class="text-2xl font-semibold text-[#4E3A2E] mb-2">Access Restricted</h2>
                <p class="text-[#7A8C4F] mb-6">Please log in to access the Quests management system.</p>
            </div>
        </div>
    @endif

    <script>
        const filterSelect = document.getElementById('questFilter');
        filterSelect.addEventListener('change', () => {
            const selected = filterSelect.value;
            const cards = document.querySelectorAll('.eco-card');
            cards.forEach(card => {
                card.style.display = (selected === 'all' || card.dataset.category === selected) ? 'block' :
                    'none';
            });
        });

        const searchInput = document.getElementById('questSearch');
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase().trim();
            const questRows = document.querySelectorAll('.accepted-quest, .completed-quest, .rejected-quest');
            questRows.forEach(row => {
                const title = row.querySelector('span')?.textContent.toLowerCase() || '';
                row.style.display = title.includes(query) ? 'flex' : 'none';
            });
        });
    </script>

    @include('modal.userQuestModal')
@endsection
