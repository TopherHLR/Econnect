@extends('layouts.mainLayout')
@section('title', 'Quests')
@section('content')
    @if (Auth::check())
        @if (auth()->user()->user_type === 'verified_user')
            <!-- 🔹 Main Container -->
            <div class="min-h-screen bg-[#E2EBD7] p-4 md:p-10 text-[#4F6B3F]">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                    <!-- ========== LEFT COLUMN ========== -->
                    <div class="lg:col-span-4 hidden lg:block bg-[#F9F6EB] rounded-3xl shadow-md overflow-hidden p-8">

                        <!-- Main left column title -->
                        <div class="mb-6">
                            <h2 class="text-2xl font-serif font-bold text-[#5C7919] py-3 text-center"
                                style="font-family: var(--font-serif);">
                                My Quest Progress
                            </h2>

                            <!-- Search Box (applies to all sections) -->
                            <div class="mb-6">
                                <input type="text" id="questSearch" placeholder="Search all quests..."
                                    class="w-full px-4 py-3 rounded-xl border-2 border-[#C8D5BB] bg-white shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#4F6B3F] focus:border-[#4F6B3F]" />
                            </div>
                        </div>

                        <!-- Three side-by-side containers with fixed total height -->
                        <div class="flex gap-6" style="height: 670px;">

                            <!-- Left Container: Accepted Quests (Fixed height) -->
                            <div class="bg-white rounded-2xl shadow-md p-5 h-full flex flex-col">
                                <!-- Distinct title style -->
                                <div class="mb-5 border-b-2 border-[#da7a5f] pb-3">
                                    <h3 class="text-base font-semibold text-[#4F6B3F] flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-[#da7a5f]"></span>
                                        Accepted Quests
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1">Quests you're currently working on</p>
                                </div>

                                <!-- Accepted Quests List with scroll -->
                                <div class="flex-1 overflow-y-auto space-y-3">
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
                                                <div class="flex justify-between items-center bg-white p-3 rounded-xl shadow-sm border-l-4 border-[#da7a5f]
                                        hover:shadow-md transition cursor-pointer accepted-quest
                                        {{ $isDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : '' }}"
                                                    data-submission-id="{{ $submission->submission_id }}"
                                                    data-description="{{ $quest->description }}">

                                                    <span
                                                        class="text-sm font-medium text-[#4F6B3F]">{{ $quest->title }}</span>
                                                    <small class="text-gray-500 text-xs">{{ $daysLeft }}
                                                        {{ $dayLabel }}
                                                        left</small>

                                                    @if ($hintMessage)
                                                        <div class="mt-1.5 flex items-center space-x-1.5 text-amber-600">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor"
                                                                viewBox="0 0 20 20">
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
                            </div>
                            <!-- END Left Container -->

                            <!-- Right Container: Split into Completed & Rejected -->
                            <div class="flex-1 flex flex-col h-full">
                                <!-- Completed Quests Container (60% height) -->
                                <div class="bg-white rounded-2xl shadow-md p-5 mb-4 flex flex-col flex-[0.6] min-h-0">
                                    <div class="mb-4 border-b-2 border-green-500 pb-3">
                                        <h3 class="text-base font-semibold text-[#4F6B3F] flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                            Completed Quests
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1">Successfully finished quests</p>
                                    </div>

                                    <div class="flex-1 overflow-y-auto space-y-2">
                                        @foreach ($quests as $quest)
                                            @php
                                                $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                            @endphp

                                            @if ($submission && $submission->status === 'completed')
                                                <div class="flex justify-between items-center text-sm text-green-700 cursor-pointer completed-quest p-2 hover:bg-green-50 rounded-lg"
                                                    data-submission-id="{{ $submission->submission_id }}"
                                                    data-title="{{ $quest->title }}"
                                                    data-description="{{ $quest->description }}"
                                                    data-points="{{ $quest->points_reward }}"
                                                    data-date="{{ optional($submission->date_completed)->format('d/m/Y') }}">

                                                    <span class="flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                        {{ $quest->title }}
                                                    </span>

                                                    <small>{{ optional($submission->date_completed)->format('d/m/Y') }}</small>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <!-- END Completed Container -->

                                <!-- Rejected Quests Container (40% height) -->
                                <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col flex-[0.4] min-h-0">
                                    <div class="mb-5 border-b-2 border-red-400 pb-3">
                                        <h3 class="text-base font-semibold text-[#4F6B3F] flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-red-400"></span>
                                            Rejected Quests
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1">Quests that need revision</p>
                                    </div>

                                    <div class="flex-1 overflow-y-auto space-y-2">
                                        @foreach ($quests as $quest)
                                            @php
                                                $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                            @endphp

                                            @if ($submission && $submission->status === 'rejected')
                                                <div class="flex justify-between items-center text-sm text-red-500 cursor-pointer rejected-quest p-2 hover:bg-red-50 rounded-lg"
                                                    data-submission-id="{{ $submission->submission_id }}"
                                                    data-title="{{ $quest->title }}"
                                                    data-description="{{ $quest->description }}"
                                                    data-points="{{ $quest->points_reward }}"
                                                    data-date="{{ optional($submission->date_completed)->format('d/m/Y') }}">
                                                    <span class="flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                                        {{ $quest->title }}
                                                    </span>
                                                    <small>{{ optional($submission->date_completed)->format('d/m/Y') }}</small>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <!-- END Rejected Container -->
                            </div>

                            <!-- END Right Split Container -->
                        </div>
                        <!-- END Three side-by-side containers -->


                    </div>
                    <!-- MOBILE VIEW QUEST SIDEBAR -->
                    <!-- Mobile Quest Sidebar Overlay -->
                    <div id="mobileQuestOverlay"
                        class="lg:hidden fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300"
                        onclick="closeMobileQuestSidebar()"></div>
                    <!-- Mobile Quest Sidebar Panel -->
                    <div id="questSidebarMobile"
                        class="lg:hidden fixed left-0 top-13 md:top-0  h-full w-[85vw] max-w-sm bg-[#FCF9EF] z-[500]
                                transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl">

                        <!-- Header -->
                        <div
                            class="sticky top-0 bg-[#FCF9EF] p-4 flex items-center justify-between border-b border-[#5C7919]/30">
                            <h2 class="text-lg font-semibold text-[#5C7919]">My Quest Progress</h2>
                            <button onclick="closeMobileQuestSidebar()" class="p-2 rounded-full hover:bg-[#E0E9D6]">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="p-4 overflow-y-auto h-[calc(100%-4rem)] space-y-6">

                            <!-- SEARCH -->
                            <div>
                                <input type="text" id="questSearchMobile" placeholder="Search quests..."
                                    class="w-full px-4 py-3 rounded-xl border-2 border-[#C8D5BB] bg-white shadow-sm text-sm
                                focus:outline-none focus:ring-2 focus:ring-[#4F6B3F] focus:border-[#4F6B3F]" />
                            </div>

                            <!-- ========== ACCEPTED QUESTS ========== -->
                            <div>
                                <h3 class="text-base font-semibold text-[#4F6B3F] mb-2 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-[#da7a5f]"></span> Accepted Quests
                                </h3>

                                <div class="space-y-3">
                                    @foreach ($quests as $quest)
                                        @php
                                            $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                        @endphp
                                        @if ($submission && $submission->status === 'pending')
                                            <div class="bg-white p-3 rounded-xl shadow-sm border-l-4 border-[#da7a5f]">
                                                <div class="flex justify-between items-center">
                                                    <span
                                                        class="text-sm font-medium text-[#4F6B3F]">{{ $quest->title }}</span>
                                                    <small class="text-gray-500 text-xs">
                                                        {{ ceil(now()->diffInHours($quest->end_date) / 24) }} days left
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- ========== COMPLETED QUESTS ========== -->
                            <div>
                                <h3 class="text-base font-semibold text-[#4F6B3F] mb-2 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-green-500"></span> Completed Quests
                                </h3>

                                <div class="space-y-3">
                                    @foreach ($quests as $quest)
                                        @php
                                            $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                        @endphp
                                        @if ($submission && $submission->status === 'completed')
                                            <div class="bg-white p-3 rounded-xl shadow-sm">
                                                <div class="flex justify-between items-center">
                                                    <span
                                                        class="text-sm text-green-700 font-medium">{{ $quest->title }}</span>
                                                    <small class="text-xs text-gray-500">
                                                        {{ optional($submission->date_completed)->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- ========== REJECTED QUESTS ========== -->
                            <div>
                                <h3 class="text-base font-semibold text-[#4F6B3F] mb-2 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-red-400"></span> Rejected Quests
                                </h3>

                                <div class="space-y-3">
                                    @foreach ($quests as $quest)
                                        @php
                                            $submission = $quest->submissions->firstWhere('user_id', auth()->id());
                                        @endphp
                                        @if ($submission && $submission->status === 'rejected')
                                            <div class="bg-white p-3 rounded-xl shadow-sm">
                                                <div class="flex justify-between items-center">
                                                    <span
                                                        class="text-sm text-red-500 font-medium">{{ $quest->title }}</span>
                                                    <small class="text-xs text-gray-500">
                                                        {{ optional($submission->date_rejected)->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ========== RIGHT COLUMN ========== -->
                    <div
                        class="lg:col-span-8 lg:mt-0 mt-10 bg-[#FAF7EE] rounded-3xl shadow-md overflow-hidden p-4 sm:p-6 lg:p-8">

                        <!-- 🌱 Right Column Content -->
                        <div class="w-full h-full bg-white rounded-2xl shadow-sm p-4 sm:p-6 flex flex-col"
                            style="border: 1px solid rgba(139, 169, 123, 0.2);">

                            <!-- Top Bar -->
                            <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center mb-6">

                                <!-- Left: Title + Description -->
                                <div class="flex flex-col">
                                    <h1 class="text-xl sm:text-2xl font-serif font-bold text-[#5C7919]">
                                        Eco-Quests
                                    </h1>
                                    <p class="text-sm sm:text-base text-[#5C7919]/80 mt-1">
                                        Complete quests to nurture your eco-impact journey
                                    </p>
                                </div>

                                <!-- Controls -->
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full sm:w-auto">

                                    <!-- Search -->
                                    <div class="relative w-full sm:w-60">
                                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#8A9A7B]"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <input id="gridSearch" type="text" placeholder="Search quests..."
                                            class="pl-10 pr-4 py-2 rounded-xl border border-[#C8D5BB]/50 text-sm bg-white/70 
                        w-full focus:outline-none focus:ring-2 focus:ring-[#8A9A7B]/30">
                                    </div>

                                    <!-- Filter -->
                                    <select id="questFilter"
                                        class="w-full sm:w-auto px-4 py-2 rounded-xl border border-[#C8D5BB]/50 
                    text-sm bg-white/70 focus:outline-none focus:ring-2 focus:ring-[#8A9A7B]/30">
                                        <option value="all">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>

                                    <!-- Mobile Sidebar Button -->
                                    <button onclick="toggleMobileQuestSidebar()"
                                        class="lg:hidden p-3 rounded-xl bg-[#5C7919] text-white shadow-md hover:bg-[#4a5f2f] transition">
                                        Your Quests
                                    </button>
                                </div>
                            </div>

                            <!-- Quest Grid -->
                            <div class="max-w-full max-h-[600px] overflow-y-auto pr-2 flex-1 custom-scroll">
                                <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 gap-5">
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

                                            // Set badge image based on quest category (not quest size)
                                            $badgeImage = match ($quest->category) {
                                                'Big Quest' => Vite::asset('resources/images/badges/BIG.svg'),
                                                'Medium Quest' => Vite::asset('resources/images/badges/MEDIUM.svg'),
                                                'Small Quest' => Vite::asset('resources/images/badges/SMALL.svg'),
                                                default => Vite::asset('resources/images/badges/SMALL.svg'),
                                            };

                                            $isCompleted = $submission?->status === 'completed';
                                            $isRejected = $submission?->status === 'rejected';
                                            $isPending = $submission?->status === 'pending';
                                            $isExpired = $quest->end_date->isPast() && !$isCompleted;
                                            $isInactive = $isCompleted || $isExpired || $isRejected || $isPending;
                                            $isNotStarted = $quest->start_date->isFuture() && !$isCompleted;
                                            $daysLeft = $quest->end_date->isFuture()
                                                ? ceil(now()->diffInHours($quest->end_date) / 24)
                                                : 0;
                                            $isUrgent = $daysLeft <= 3 && $daysLeft > 0;
                                        @endphp

                                        @if ($quest->status === 'active')
                                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm transition-all duration-300 relative
                                                {{ $isInactive || $isNotStarted ? 'opacity-50 pointer-events-none' : 'hover:shadow-xl hover:-translate-y-1 cursor-pointer hover:shadow-[#8A9A7B]/20' }}
                                                border border-[#E8E4DA] eco-card"
                                                data-id="{{ $quest->quest_id }}" data-title="{{ $quest->title }}"
                                                data-description="{{ $quest->description }}"
                                                data-category="{{ $quest->category }}"
                                                data-points="{{ $quest->points_reward }}"
                                                data-status="{{ $quest->status }}"
                                                data-start-date="{{ $quest->start_date }}"
                                                data-end-date="{{ $quest->end_date }}">

                                                <!-- Status overlay for inactive/not started quests -->
                                                @if ($isInactive || $isNotStarted)
                                                    <div class="absolute top-3 right-3 z-20">
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-semibold border
                                            {{ $isCompleted
                                                ? 'bg-[#E8F5E9] text-[#2E7D32] border-[#C8E6C9]'
                                                : ($isExpired
                                                    ? 'bg-[#F5F5F5] text-[#616161] border-[#E0E0E0]'
                                                    : ($isRejected
                                                        ? 'bg-[#FFEBEE] text-[#C62828] border-[#FFCDD2]'
                                                        : ($isPending
                                                            ? 'bg-[#FFF8E1] text-[#F57C00] border-[#FFECB3]'
                                                            : ($isNotStarted
                                                                ? 'bg-[#E3F2FD] text-[#1565C0] border-[#BBDEFB]'
                                                                : '')))) }}">
                                                            @if ($isCompleted)
                                                                ✓
                                                            @elseif($isExpired)
                                                                ⌛
                                                            @elseif($isRejected)
                                                                ✗
                                                            @elseif($isPending)
                                                                ⏳
                                                            @elseif($isNotStarted)
                                                                🗓️
                                                            @endif
                                                        </span>
                                                    </div>

                                                    <div
                                                        class="absolute inset-0 bg-[#5A6B4A]/30 flex items-center justify-center z-10 rounded-2xl">
                                                        <span
                                                            class="text-white font-bold text-sm bg-[#5A6B4A]/80 px-4 py-2 rounded-xl">
                                                            @if ($isCompleted)
                                                                Completed
                                                            @elseif($isExpired)
                                                                Expired
                                                            @elseif($isRejected)
                                                                Rejected
                                                            @elseif($isPending)
                                                                Pending
                                                            @elseif($isNotStarted)
                                                                Starts {{ $quest->start_date->format('d/m/Y') }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif

                                                <!-- Sticker badge in top-left corner -->
                                                <div class="absolute -top-0 right-1  z-30">
                                                    @if ($badgeImage)
                                                        <img src="{{ $badgeImage }}" alt="Quest Badge"
                                                            class="h-20 w-20 object-contain drop-shadow-xl">
                                                    @endif
                                                </div>

                                                <!-- Quest Content -->
                                                <div class="pt-8 px-5 pb-5">
                                                    <!-- Title and Category Row -->
                                                    <div class="mb-3">
                                                        <h3
                                                            class="text-base font-bold text-[#3A4A2A] line-clamp-2 leading-tight mb-2">
                                                            {{ $quest->title }}
                                                        </h3>
                                                        <div class="flex items-center justify-between">
                                                            <span
                                                                class="px-3 py-1 rounded-full text-xs font-medium 
                                                        bg-[#F1EEE6] text-[#6B7D5A] border border-[#C8D5BB]/50">
                                                                <i class="fa-solid fa-seedling mr-1 text-xs"></i>
                                                                {{ $quest->category }}
                                                            </span>

                                                            <!-- Points badge -->
                                                            <div class="flex flex-col items-end">
                                                                <span
                                                                    class="text-lg font-bold text-[#8A9A7B] whitespace-nowrap">
                                                                    {{ $quest->points_reward }}
                                                                </span>
                                                                <span
                                                                    class="text-xs text-[#6B7D5A] font-medium">points</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="mb-4">
                                                        <p
                                                            class="text-sm text-[#6B7D5A] line-clamp-2 font-normal leading-relaxed mb-3">
                                                            {{ $quest->description }}
                                                        </p>

                                                        <!-- Urgent indicator -->
                                                        @if (!$isInactive && !$isNotStarted && $isUrgent)
                                                            <div
                                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gradient-to-r from-amber-50 to-amber-100/50 border border-amber-200">
                                                                <i class="fa-solid fa-bolt text-xs text-amber-600"></i>
                                                                <span class="text-xs font-semibold text-amber-700">
                                                                    {{ $daysLeft }} day{{ $daysLeft != 1 ? 's' : '' }}
                                                                    left
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Time and Requirements -->
                                                    <div class="pt-3 border-t border-[#E8E4DA]">
                                                        <div class="flex justify-between items-center">
                                                            <!-- Time left -->
                                                            <div class="flex items-center gap-2">
                                                                <div
                                                                    class="w-8 h-8 rounded-full bg-[#F1EEE6] flex items-center justify-center">
                                                                    <i
                                                                        class="fa-regular fa-clock text-[#8A9A7B] text-xs"></i>
                                                                </div>
                                                                <div class="flex flex-col">
                                                                    <span
                                                                        class="text-[10px] text-[#5A6B4A] font-medium uppercase tracking-wider opacity-75">Time
                                                                        left</span>
                                                                    <span class="text-sm font-semibold text-[#6B7D5A]">
                                                                        {{ $daysLeft }}
                                                                        day{{ $daysLeft != 1 ? 's' : '' }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Requirements -->
                                                            <div class="flex items-center gap-2">
                                                                <div
                                                                    class="w-8 h-8 rounded-full bg-[#F1EEE6] flex items-center justify-center">
                                                                    <i
                                                                        class="fa-solid fa-mountain text-[#8A9A7B] text-xs"></i>
                                                                </div>
                                                                <div class="flex flex-col items-end">
                                                                    <span
                                                                        class="text-[10px] text-[#5A6B4A] font-medium uppercase tracking-wider opacity-75">Requires</span>
                                                                    <span class="text-sm font-semibold text-[#6B7D5A]">
                                                                        {{ $quest->required_points }} pts
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Eco-friendly note -->
                            <div class="mt-6 pt-5 border-t border-[#E8E4DA]">
                                <div class="flex items-center justify-center gap-2 text-sm text-[#6B7D5A]/70">
                                    <i class="fa-solid fa-recycle text-[#8A9A7B]"></i>
                                    <span class="font-light">Each completed quest contributes to your eco-impact
                                        score</span>
                                    <i class="fa-solid fa-leaf text-[#8A9A7B]"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END RIGHT COLUMN -->

                </div>
            </div>
        @else
            <section class="min-h-screen">
                @include('partials.locked_view')
            </section>
        @endif
    @else
        <section class="min-h-screen">
            @include('partials.locked_view')
        </section>
    @endif

    <script>
        function toggleMobileQuestSidebar() {
            const sidebar = document.getElementById('questSidebarMobile');
            const overlay = document.getElementById('mobileQuestOverlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        function closeMobileQuestSidebar() {
            const sidebar = document.getElementById('questSidebarMobile');
            const overlay = document.getElementById('mobileQuestOverlay');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        const filterSelect = document.getElementById('questFilter');
        if (filterSelect) {
            filterSelect.addEventListener('change', () => {
                const selected = filterSelect.value;
                document.querySelectorAll('.eco-card').forEach(card => {
                    card.style.display =
                        selected === 'all' || card.dataset.category === selected ? 'block' : 'none';
                });
            });
        }

        const searchInput = document.getElementById('questSearch');
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                const q = searchInput.value.toLowerCase().trim();
                document.querySelectorAll('.accepted-quest, .completed-quest, .rejected-quest').forEach(row => {
                    const title = row.querySelector('span')?.textContent.toLowerCase() || '';
                    row.style.display = title.includes(q) ? 'flex' : 'none';
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('gridSearch');
            const questCards = document.querySelectorAll('.eco-card');

            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();

                questCards.forEach(card => {
                    const title = card.dataset.title.toLowerCase();
                    const description = card.dataset.description.toLowerCase();
                    const category = card.dataset.category.toLowerCase();

                    if (title.includes(query) || description.includes(query) || category.includes(
                            query)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

    @include('modal.userQuestModal')

@endsection
