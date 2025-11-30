@extends('layouts.adminLayout')

@section('title', 'Quests')

@section('content')
    <div class="space-y-6">
        <!-- Header Section with Quick Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Quest Management</h1>
                <p class="font-sans text-[#6A8A52] mt-1">Create, manage, and validate sustainability challenges.</p>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 justify-end">
                <button onclick="openQuestModal()" class="btn-eco btn-mint compact" title="Create New Quest">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span class="hidden lg:inline">New Quest</span>
                </button>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-6 w-full">
            <!-- SIDEBAR NAVIGATION -->
            <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] w-full lg:w-1/5">
                <aside class="w-full">
                    <!-- Active Quests Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">Active Quests</h2>
                    </div>

                    <!-- Quest Navigation - RESTORED UL/LI STRUCTURE -->
                    <ul id="questList" class="space-y-2 mb-6">

                        <!-- Quest Collection -->
                        <li data-quest="collection" class="tab-eco cursor-pointer">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-layer-group text-[#7F8A4F]"></i>
                                <span>Quest Collection</span>
                            </div>
                        </li>
                        <hr class="border-[#E6EAD7] my-4">
                        <div class="max-h-[350px] overflow-y-auto pr-1">
                            <ul id="questList" class="space-y-2 mb-6">

                                <!-- Active Quests - Only show active and ending_soon, exclude closed -->
                                @foreach ($quests->whereIn('status', ['active', 'ending_soon']) as $quest)
                                    <li data-quest="{{ $quest->quest_id }}"
                                        class="tab-eco cursor-pointer {{ $loop->first ? 'bg-[#E9F0E1] font-semibold' : '' }}">
                                        <div class="flex justify-between items-center">
                                            <span class="truncate">{{ $quest->title }}</span>
                                            @if ($quest->status === 'ending_soon')
                                                <span
                                                    class="text-xs bg-[#FEF3C7] text-[#D97706] px-2 py-1 rounded-full">Soon</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach

                                @if ($quests->whereIn('status', ['active', 'ending_soon'])->count() === 0)
                                    <li class="text-center py-4 text-[#6A8A52] text-sm">
                                        <i class="fa-solid fa-inbox mb-2 text-2xl opacity-50"></i>
                                        <div>No active quests</div>
                                    </li>
                                @endif


                            </ul>
                        </div>
                        <hr class="border-[#E6EAD7] my-4">
                        <!-- Archive Tab -->
                        <li data-quest="archived" class="tab-eco cursor-pointer">
                            <div class="flex justify-between items-center">
                                <span class="truncate">Archived Quests</span>
                            </div>
                        </li>

                    </ul>
                </aside>
            </div>
            <!-- MAIN CONTENT AREA -->
            <main class="flex-1 space-y-6 w-full lg:w-4/5">
                <!-- Quest Tables Container -->
                <div id="questTables" class="space-y-6">
                    <!-- Individual Quest Tables -->
                    @foreach ($quests as $quest)
                        <!-- Table Header Container -->
                        <div id="questHeader-{{ $quest->quest_id }}"
                            class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden }}">

                            <!-- Table Header with Alerts & Search -->
                            <div class="overflow-x-auto">
                                <div class="flex flex-col lg:flex-row gap-4 items-center">
                                    <!-- Table Title -->
                                    <div class="flex items-center gap-2 shrink-0">
                                        <i class="fa-solid fa-users text-[#7F8A4F] text-lg"></i>
                                        <h2 class="text-xl font-bold text-[#4F6B3F] font-serif whitespace-nowrap">
                                            {{ $quest->title }} <span
                                                class="text-[#6A8A52]">({{ $quest->submissions->count() }})</span>
                                        </h2>
                                    </div>

                                    <!-- 🚨 URGENT ALERTS -->
                                    <div class="bg-[#FEF2F2] border border-[#FECACA] rounded-xl px-3 py-2 shrink-0">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 bg-[#DC2626] rounded-full animate-pulse"></div>
                                            <span class="font-semibold text-[#DC2626] text-sm whitespace-nowrap">
                                                {{ $quest->submissions->where('status', 'pending')->count() }} pending
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Search Input -->
                                    <div class="relative flex-1 min-w-[250px]">
                                        <input type="text" placeholder="Search participants..."
                                            class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans table-search"
                                            data-table-id="questTable-{{ $quest->quest_id }}">
                                        <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
                                    </div>

                                    <!-- Filter Dropdowns -->
                                    <div class="flex gap-2 shrink-0">
                                        <select
                                            class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-3 
                                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans whitespace-nowrap">
                                            <option value="">All Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="completed">Completed</option>
                                            <option value="rejected">Rejected</option>
                                        </select>

                                        <select
                                            class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-3 
                                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans whitespace-nowrap">
                                            <option value="">Sort By</option>
                                            <option value="name">Name</option>
                                            <option value="date">Date</option>
                                            <option value="status">Status</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Table Container -->
                        <div id="questTable-{{ $quest->quest_id }}"
                            class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden }}">

                            <!-- Participants Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-[#4F3B2C] font-sans">
                                    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold w-16">#</th>
                                            <th class="px-4 py-3 text-left font-semibold">Participant</th>
                                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                                            <th class="px-4 py-3 text-left font-semibold">Checked By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quest->submissions as $index => $submission)
                                            <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition participant-row cursor-pointer"
                                                data-submission-id="{{ $submission->submission_id }}"
                                                data-user="{{ $submission->user->first_name }} {{ $submission->user->last_name }}"
                                                data-status="{{ $submission->status }}"
                                                data-proof-link="{{ $submission->proof_link }}"
                                                data-proof-image="{{ $submission->proof_image }}"
                                                data-verified-by-email="{{ $submission->verifier ? $submission->verifier->email : '' }}">

                                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 text-[#7A8C4F] hover:underline participant-name">
                                                    {{ $submission->user->first_name }} {{ $submission->user->last_name }}
                                                </td>

                                                <td class="px-4 py-3">
                                                <select
                                                    class="submission-status border border-[#7A8C4F] rounded-lg px-3 py-1.5 text-sm text-[#4F6B3F] bg-white focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]"
                                                    data-submission-id="{{ $submission->submission_id }}">
                                                    
                                                    <option value="pending"
                                                        {{ $submission->status === 'pending' ? 'selected' : '' }}>
                                                        {{ ($submission->status === 'pending' && $submission->image_proof && $submission->image_link) ? 'Submitted' : 'Pending' }}
                                                    </option>
                                                    
                                                    <option value="completed"
                                                        {{ $submission->status === 'completed' ? 'selected' : '' }}>
                                                        Completed
                                                    </option>
                                                    
                                                    <option value="rejected"
                                                        {{ $submission->status === 'rejected' ? 'selected' : '' }}>
                                                        Rejected
                                                    </option>
                                                </select>

                                                </td>

                                                <td class="px-4 py-3 text-[#4F6B3F]">
                                                    @if ($submission->status === 'completed' && $submission->verifier)
                                                        <span class="text-green-600 font-medium">Verified by
                                                            {{ $submission->verifier->first_name . ' ' . $submission->verifier->last_name }}</span>
                                                    @elseif ($submission->status === 'rejected' && $submission->verifier)
                                                        <span class="text-red-600 font-medium">Rejected by
                                                            {{ $submission->verifier->first_name . ' ' . $submission->verifier->last_name }}</span>
                                                    @else
                                                        <span class="text-gray-500">Not verified yet</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    <!-- Quest Collection Table Header -->
                    <div id="collectionHeader" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] ">
                        <!-- Table Header -->
                        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-layer-group text-[#7F8A4F] text-lg"></i>
                                <h2 class="text-xl font-bold text-[#4F6B3F] font-serif">
                                    Quest Collection <span
                                        class="text-[#6A8A52]">({{ $quests->where('status', '!=', 'archived')->count() }})</span>
                                </h2>
                            </div>

                            <!-- Search -->
                            <div class="relative flex-1 min-w-[250px] max-w-md">
                                <input type="text" placeholder="Search quests..."
                                    class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans collection-search"
                                    data-table-id="collectionTable">
                                <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Quest Collection Main Table -->
                    <div id="collectionTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] ">
                        <!-- Quest Collection Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-[#4F3B2C] font-sans">
                                <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold w-16">#</th>
                                        <th class="px-4 py-3 text-left font-semibold">Quest Title</th>
                                        <th class="px-4 py-3 text-left font-semibold">Description</th>
                                        <th class="px-4 py-3 text-left font-semibold">Category</th>
                                        <th class="px-4 py-3 text-left font-semibold">Points</th>
                                        <th class="px-4 py-3 text-left font-semibold">Start Date</th>
                                        <th class="px-4 py-3 text-left font-semibold">End Date</th>
                                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                                        <th class="px-4 py-3 text-left font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quests->where('status', '!=', 'archived') as $index => $quest)
                                        <tr data-quest-id="{{ $quest->quest_id }}"
                                            class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $quest->title }}</td>
                                            <td class="px-4 py-3 text-[#6A8A52]">{{ Str::limit($quest->description, 50) }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium bg-[#F0F7E6] text-[#4F6B3F]">
                                                    {{ $quest->category }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 font-semibold text-[#C37A49]">{{ $quest->points_reward }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ \Carbon\Carbon::parse($quest->start_date)->format('m/d/Y') }}</td>
                                            <td class="px-4 py-3">
                                                {{ \Carbon\Carbon::parse($quest->end_date)->format('m/d/Y') }}</td>
                                            <td class="px-4 py-3">
                                                <select
                                                    class="status-dropdown border border-[#7A8C4F] rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] 
                                        {{ $quest->status === 'active'
                                            ? 'text-green-600'
                                            : ($quest->status === 'ending_soon'
                                                ? 'text-orange-600'
                                                : 'text-gray-600') }}"
                                                    data-quest-id="{{ $quest->quest_id }}">
                                                    <option value="active"
                                                        {{ $quest->status === 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="ending_soon"
                                                        {{ $quest->status === 'ending_soon' ? 'selected' : '' }}>Ending
                                                        Soon</option>
                                                    <option value="closed"
                                                        {{ $quest->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <button class="btn-action btn-edit compact"
                                                        data-quest='@json($quest)' title="Edit Quest">
                                                        <i class="fas fa-edit"></i>
                                                        <span class="hidden sm:inline">Edit</span>
                                                    </button>
                                                    <button class="btn-action btn-archive compact"
                                                        data-quest-id="{{ $quest->quest_id }}" title="Archive Quest">
                                                        <i class="fas fa-archive"></i>
                                                        <span class="hidden sm:inline">Archive</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $quests->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    </div>
                    <!-- Archived Quests Main Table -->
                    <div id="archiveMain" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-[#4F3B2C] font-sans">
                                <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold w-16">#</th>
                                        <th class="px-4 py-3 text-left font-semibold">Quest Title</th>
                                        <th class="px-4 py-3 text-left font-semibold">Description</th>
                                        <th class="px-4 py-3 text-left font-semibold">Category</th>
                                        <th class="px-4 py-3 text-left font-semibold">Points</th>
                                        <th class="px-4 py-3 text-left font-semibold">Start Date</th>
                                        <th class="px-4 py-3 text-left font-semibold">End Date</th>
                                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quests->where('status', 'archived') as $index => $quest)
                                        <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $quest->title }}</td>
                                            <td class="px-4 py-3 text-[#6A8A52]">{{ Str::limit($quest->description, 50) }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-medium bg-[#F0F7E6] text-[#4F6B3F]">
                                                    {{ $quest->category }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 font-semibold text-[#C37A49]">{{ $quest->points_reward }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ \Carbon\Carbon::parse($quest->start_date)->format('m/d/Y') }}</td>
                                            <td class="px-4 py-3">
                                                {{ \Carbon\Carbon::parse($quest->end_date)->format('m/d/Y') }}</td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="text-gray-600 font-medium">{{ ucfirst($quest->status) }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <form action="{{ route('quests.recover', $quest->quest_id) }}"
                                                        method="POST" onsubmit="return confirm('Recover this quest?')">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-green-600 hover:text-green-800 font-semibold text-sm">
                                                            Recover
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($quests->where('status', 'archived')->count() === 0)
                                        <tr>
                                            <td colspan="9" class="text-center py-4 text-[#6A8A52] text-sm">
                                                <i class="fa-solid fa-inbox mb-2 text-2xl opacity-50"></i>
                                                <div>No archived quests</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </main>

            <style>
                /* RESTORED TAB STYLING */
                .tab-eco {
                    @apply px-4 py-3 rounded-xl text-[#4F6B3F] hover:bg-[#E9F0E1] transition-all duration-200 cursor-pointer;
                }

                .tab-eco.bg-\[\#E9F0E1\] {
                    @apply bg-[#E9F0E1] font-semibold;
                }

                /* Compact Action Buttons */
                .btn-action.compact {
                    @apply px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-200;
                }

                .btn-edit {
                    @apply bg-[#EFF6FF] text-[#1E40AF] hover:bg-[#DBEAFE];
                }

                .btn-archive {
                    @apply bg-[#FEF2F2] text-[#DC2626] hover:bg-[#FECACA];
                }

                /* Responsive Design */
                @media (max-width: 1024px) {
                    .btn-action.compact span {
                        display: none;
                    }

                    .btn-action.compact {
                        @apply px-2 py-2;
                    }
                }

                @media (max-width: 768px) {
                    .flex-col.lg\:flex-row {
                        flex-direction: column;
                    }

                    .w-full.lg\:w-1\/4 {
                        width: 100%;
                        max-width: none;
                    }
                }
            </style>

            <!-- JS for dynamic quest table switching -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const questListItems = document.querySelectorAll('#questList li');

                    // Highlight Quest Collection tab
                    questListItems.forEach(li => li.classList.remove('bg-[#E9F0E1]', 'font-semibold'));
                    const collectionTab = document.querySelector('#questList li[data-quest="collection"]');
                    if (collectionTab) collectionTab.classList.add('bg-[#E9F0E1]', 'font-semibold');
                });

                // Show collection table by default
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('collectionTable').classList.remove('hidden');
                });

                document.addEventListener('DOMContentLoaded', () => {
                    const questListItems = document.querySelectorAll('#questList li');
                    const questTables = document.querySelectorAll('[id^="questTable-"]');
                    const questHeaders = document.querySelectorAll('[id^="questHeader-"]');
                    const collectionHeader = document.getElementById('collectionHeader');
                    const collectionTable = document.getElementById('collectionTable');
                    const archiveMain = document.getElementById('archiveMain'); // Archived quests table

                    questListItems.forEach(item => {
                        item.addEventListener('click', () => {
                            const selectedId = item.dataset.quest;

                            // Hide all quest tables and headers
                            questTables.forEach(table => table.classList.add('hidden'));
                            questHeaders.forEach(header => header.classList.add('hidden'));
                            collectionHeader.classList.add('hidden');
                            collectionTable.classList.add('hidden');
                            if (archiveMain) archiveMain.classList.add('hidden'); // hide archive table

                            if (selectedId === 'collection') {
                                collectionHeader.classList.remove('hidden');
                                collectionTable.classList.remove('hidden');
                            } else if (selectedId === 'archived') {
                                // Show archive table
                                if (archiveMain) archiveMain.classList.remove('hidden');
                            } else {
                                // Show selected quest header and table
                                const selectedHeader = document.getElementById('questHeader-' + selectedId);
                                const selectedTable = document.getElementById('questTable-' + selectedId);

                                if (selectedHeader) selectedHeader.classList.remove('hidden');
                                if (selectedTable) selectedTable.classList.remove('hidden');
                            }

                            // Highlight active tab
                            questListItems.forEach(li => li.classList.remove('bg-[#E9F0E1]',
                                'font-semibold'));
                            item.classList.add('bg-[#E9F0E1]', 'font-semibold');
                        });
                    });
                });


                document.addEventListener('DOMContentLoaded', () => {

                    // Status update via AJAX
                    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
                        dropdown.addEventListener('change', (e) => {
                            const questId = e.target.dataset.questId;
                            const status = e.target.value;

                            fetch(`/quests/${questId}/status`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        status
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        showMessage(data.success, 'success');
                                    }
                                })
                                .catch(err => console.error(err));
                        });
                    });

                });

                document.addEventListener('DOMContentLoaded', () => {
                    const archiveMenu = document.getElementById('archiveDropdownMenu');

                    document.querySelectorAll('.btn-archive').forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();
                            const questId = button.dataset.questId;
                            const questTitle = button.closest('tr').querySelector('td:nth-child(2)')
                                .innerText;

                            if (!confirm('Are you sure you want to archive this quest?')) return;

                            fetch(`/quests/${questId}/archive`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        // Remove the row from the table
                                        const row = button.closest('tr');
                                        if (row) row.remove();

                                        // Add the quest to the archive dropdown
                                        const li = document.createElement('li');
                                        li.className =
                                            "flex justify-between items-center px-4 py-2 hover:bg-[#E9F0E1] text-[#4E3A2E]";
                                        li.innerHTML = `
                                                        <span class="cursor-pointer" data-quest="questTable-${questId}">${questTitle}</span>
                                                        <form onsubmit="return confirm('Recover this quest?')" class="ml-2" data-quest-id="${questId}">
                                                            <button type="button" class="text-green-600 hover:text-green-800 font-semibold text-sm btn-recover">Recover</button>
                                                        </form>
                                                    `;
                                        archiveMenu.appendChild(li);

                                        // Add recover button functionality
                                        li.querySelector('.btn-recover').addEventListener('click', () =>
                                            recoverQuest(questId, li)
                                        );

                                        // ✅ Show success toast
                                        showMessage('Quest archived successfully!', 'success');
                                    }
                                })

                                .catch(err => console.error(err));
                        });
                    });
                    // Recover function
                    function recoverQuest(questId, liElement) {
                        if (!confirm('Recover this quest?')) return;

                        fetch(`/quests/${questId}/recover2`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    liElement.remove(); // Remove from archive dropdown

                                    // Optional: refresh table or re-add to active quests table
                                    showMessage('Quest recovered successfully!', 'success');
                                    location.reload(); // or dynamically re-add row if you prefer
                                }
                            })

                    }
                });

                document.addEventListener('DOMContentLoaded', () => {
                    const searchInputs = document.querySelectorAll('.table-search');

                    searchInputs.forEach(input => {
                        const tableId = input.dataset.tableId;
                        const tableBody = document.querySelector(`#${tableId} tbody`);

                        // Create a "No participants found" row
                        let emptyRow = document.createElement('tr');
                        emptyRow.classList.add('no-results');
                        emptyRow.innerHTML =
                            `<td colspan="3" class="px-4 py-2 text-center text-[#7A8C4F]">No participants found</td>`;
                        tableBody.appendChild(emptyRow);

                        const updateVisibility = () => {
                            const filter = input.value.toLowerCase();
                            const rows = Array.from(tableBody.querySelectorAll('tr:not(.no-results)'));
                            let anyVisible = false;

                            if (rows.length === 0) {
                                // If no rows exist in the table, show the empty row
                                emptyRow.style.display = '';
                                return;
                            }

                            rows.forEach(row => {
                                const participantCell = row.cells[1];
                                const participantText = participantCell ? participantCell.textContent
                                    .toLowerCase() : '';

                                if (participantText.includes(filter)) {
                                    row.style.display = '';
                                    anyVisible = true;
                                } else {
                                    row.style.display = 'none';
                                }
                            });

                            emptyRow.style.display = anyVisible ? 'none' : '';
                        };

                        // Run on keyup
                        input.addEventListener('keyup', updateVisibility);

                        // Run on page load to handle empty tables
                        updateVisibility();
                    });
                });

                document.addEventListener('DOMContentLoaded', () => {
                    // Collection search
                    const collectionInput = document.querySelector('.collection-search');
                    if (collectionInput) {
                        const tableId = collectionInput.dataset.tableId;
                        const tableBody = document.querySelector(`#${tableId} tbody`);

                        // Create "No quests found" row
                        let emptyRow = document.createElement('tr');
                        emptyRow.classList.add('no-results');
                        emptyRow.innerHTML =
                            `<td colspan="9" class="px-4 py-2 text-center text-[#7A8C4F]">No quests found</td>`;
                        tableBody.appendChild(emptyRow);

                        const updateVisibility = () => {
                            const filter = collectionInput.value.toLowerCase();
                            const rows = Array.from(tableBody.querySelectorAll('tr:not(.no-results)'));
                            let anyVisible = false;

                            if (rows.length === 0) {
                                emptyRow.style.display = '';
                                return;
                            }

                            rows.forEach(row => {
                                const rowText = Array.from(row.cells)
                                    .map(cell => cell.textContent.toLowerCase())
                                    .join(' ');
                                if (rowText.includes(filter)) {
                                    row.style.display = '';
                                    anyVisible = true;
                                } else {
                                    row.style.display = 'none';
                                }
                            });

                            emptyRow.style.display = anyVisible ? 'none' : '';
                        };

                        collectionInput.addEventListener('keyup', updateVisibility);
                        updateVisibility(); // Run on load
                    }
                });
                document.querySelectorAll('.submission-status').forEach(select => {
                    select.addEventListener('change', async (e) => {
                        const submissionId = e.target.dataset.submissionId;
                        const newStatus = e.target.value;

                        try {
                            const response = await fetch(`/submissions/${submissionId}/update-status`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content
                                },
                                body: JSON.stringify({
                                    status: newStatus
                                })
                            });

                            const data = await response.json();
                            if (data.success) {
                                // alert(`Status updated to "${newStatus}"`);
                                showMessage(`Status updated to "${newStatus}"`, 'success');
                            } else {
                                showMessage('Failed to update status.', 'error');
                            }
                        } catch (err) {
                            console.error(err);
                            alert('An error occurred.');
                        }
                    });
                });
            </script>
            @include('modal.createQuestModal')
        @endsection
