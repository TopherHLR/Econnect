@extends('layouts.adminLayout')

@section('title', 'Quests')

@section('content')
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
                    <ul class="space-y-2 mb-6">

                        <!-- Quest Collection -->
                        <li data-quest="collection" class="tab-eco cursor-pointer">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-layer-group text-[#7F8A4F]"></i>
                                <span>Quest Collection</span>
                            </div>
                        </li>
                        <hr class="border-[#E6EAD7] my-4">
                        <div class="max-h-[350px] overflow-y-auto pr-1">
                            <ul id="questList" class="space-y-2 mb-2 ">
                                @foreach ($questsList->whereIn('status', ['active', 'ending_soon']) as $quest)
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


                            <!-- Pagination buttons -->
                            <div id="questPagination" class="flex justify-center items-center gap-2 mt-2">
                                <button id="prevPage" class="px-2 py-1 border rounded text-xs">&laquo;</button>

                                <div id="pageNumbers" class="flex gap-2">
                                    @php
                                        $perPage = 5;
                                        $activeQuests = $questsList->whereIn('status', ['active', 'ending_soon']);
                                        $totalPages = ceil($activeQuests->count() / $perPage);
                                    @endphp

                                    @for ($i = 1; $i <= min(5, $totalPages); $i++)
                                        <button
                                            class="page-btn px-3 py-1 border rounded text-xs {{ $i === 1 ? 'bg-[#E9F0E1] font-semibold' : '' }}"
                                            data-page="{{ $i }}">
                                            {{ $i }}
                                        </button>
                                    @endfor
                                </div>

                                <button id="nextPage" class="px-2 py-1 border rounded text-xs">&raquo;</button>
                            </div>

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
                    @foreach ($questsList as $quest)
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
                            <div class="overflow-x-auto" id="table-data-participants">
                                <div class="text-center py-16 text-[#6A8A52]">
                                    <i class="fa-solid fa-spinner fa-spin text-4xl mb-4"></i>
                                    <p>Loading participants...</p>
                                </div>
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
                                        class="text-[#6A8A52]">({{ $questsList->where('status', '!=', 'archived')->count() }})</span>
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
                        <div class="overflow-x-auto" id="table-data">

                            @include('admin.partials.quest_collection_table')
                        </div>
                    </div>

                    <!-- Archived Quests Main Table -->
                    <div id="archiveMain" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-archive text-[#7F8A4F] text-lg"></i>
                                <h2 class="text-xl font-bold text-[#4F6B3F] font-serif">
                                    Archived Quests <span class="text-[#6A8A52]">({{ $archivedQuests->total() }})</span>
                                </h2>
                            </div>

                            <div class="relative flex-1 min-w-[250px] max-w-md">
                                <input type="text" placeholder="Search archived quests..." id="archive-search"
                                    class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans">
                                <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <!-- This div will be replaced entirely on pagination -->
                            <div id="archive-table-container">
                                @include('admin.partials.quest_archive_table', [
                                    'archivedQuests' => $archivedQuests,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // SELECT ALL TABS (Collection, Individual Quests, Archived)
            const allTabs = document.querySelectorAll('aside ul li.tab-eco[data-quest]');

            const questHeaders = document.querySelectorAll('[id^="questHeader-"]');
            const questTables = document.querySelectorAll('[id^="questTable-"]');
            const collectionHeader = document.getElementById('collectionHeader');
            const collectionTable = document.getElementById('collectionTable');
            const archiveMain = document.getElementById('archiveMain');

            // Hide all content areas
            const hideAllContent = () => {
                questHeaders.forEach(h => h.classList.add('hidden'));
                questTables.forEach(t => t.classList.add('hidden'));
                if (collectionHeader) collectionHeader.classList.add('hidden');
                if (collectionTable) collectionTable.classList.add('hidden');
                if (archiveMain) archiveMain.classList.add('hidden');
            };

            // Click handler for ALL sidebar tabs
            allTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const questId = tab.dataset.quest;
                    hideAllContent();
                    allTabs.forEach(t => t.classList.remove('bg-[#E9F0E1]', 'font-semibold'));
                    tab.classList.add('bg-[#E9F0E1]', 'font-semibold');

                    if (questId === 'collection') {
                        collectionHeader?.classList.remove('hidden');
                        collectionTable?.classList.remove('hidden');
                    } else if (questId === 'archived') {
                        archiveMain?.classList.remove('hidden');
                    } else {
                        // Show header and empty table container
                        const header = document.getElementById('questHeader-' + questId);
                        const container = document.getElementById('questTable-' + questId);
                        const tableDiv = container.querySelector('#table-data-participants');

                        header?.classList.remove('hidden');
                        container?.classList.remove('hidden');

                        // Load only if not already loaded
                        if (!container.dataset.loaded) {
                            tableDiv.innerHTML = `
                    <div class="text-center py-16 text-[#6A8A52]">
                        <i class="fa-solid fa-spinner fa-spin text-4xl mb-4"></i>
                        <p>Loading participants...</p>
                    </div>`;

                            // THIS IS THE ONLY CORRECT URL
                            fetch(`{{ route('adminQuests') }}?quest_id=${questId}`, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(r => r.text())
                                .then(html => {
                                    tableDiv.innerHTML = html;
                                    container.dataset.loaded = 'true';
                                })
                                .catch(err => {
                                    console.error(err);
                                    tableDiv.innerHTML =
                                        `<div class="text-red-600 text-center py-8">Failed to load participants</div>`;
                                });
                        }
                    }
                });
            });

            // Default: Open "Quest Collection" on page load
            const collectionTab = document.querySelector('li[data-quest="collection"]');
            if (collectionTab) {
                collectionTab.click();
            }
        });

        // ——————————————————————————————————————
        // PAGINATION FOR ACTIVE QUESTS LIST (Sidebar)
        // ——————————————————————————————————————
        document.addEventListener('DOMContentLoaded', () => {
            const questListItems = Array.from(document.querySelectorAll('#questList li'));
            const perPage = 5;
            const totalPages = Math.ceil(questListItems.length / perPage);

            const pageNumbersContainer = document.getElementById('pageNumbers');
            const prevBtn = document.getElementById('prevPage');
            const nextBtn = document.getElementById('nextPage');

            let currentPage = 1;
            let maxPageButtons = 5;

            const renderPageButtons = () => {
                pageNumbersContainer.innerHTML = '';

                // Determine the start and end page numbers to display
                let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
                let endPage = startPage + maxPageButtons - 1;

                if (endPage > totalPages) {
                    endPage = totalPages;
                    startPage = Math.max(1, endPage - maxPageButtons + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const btn = document.createElement('button');
                    btn.className =
                        `page-btn px-3 py-1 border rounded text-xs ${i === currentPage ? 'bg-[#E9F0E1] font-semibold' : ''}`;
                    btn.dataset.page = i;
                    btn.textContent = i;

                    btn.addEventListener('click', () => {
                        currentPage = i;
                        showPage(currentPage);
                        renderPageButtons();
                    });

                    pageNumbersContainer.appendChild(btn);
                }
            };

            const showPage = (page) => {
                const start = (page - 1) * perPage;
                const end = page * perPage;

                questListItems.forEach((item, i) => {
                    item.style.display = i >= start && i < end ? 'block' : 'none';
                });
            };

            prevBtn?.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                    renderPageButtons();
                }
            });

            nextBtn?.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                    renderPageButtons();
                }
            });

            // Initial render
            if (questListItems.length > 0) {
                showPage(currentPage);
                renderPageButtons();
            }
        });


        // ——————————————————————————————————————
        // SEARCH FILTERS (Participants & Collection)
        // ——————————————————————————————————————
        document.addEventListener('DOMContentLoaded', () => {
            // Participant search inside individual quest tables
            document.querySelectorAll('.table-search').forEach(input => {
                const tableId = input.dataset.tableId;
                const tbody = document.querySelector(`#${tableId} tbody`);

                if (!tbody) return;

                let noResultsRow = tbody.querySelector('.no-results');
                if (!noResultsRow) {
                    noResultsRow = document.createElement('tr');
                    noResultsRow.className = 'no-results';
                    noResultsRow.innerHTML =
                        `<td colspan="4" class="text-center py-8 text-[#6A8A52]">No participants found</td>`;
                    tbody.appendChild(noResultsRow);
                }

                const filterRows = () => {
                    const term = input.value.toLowerCase();
                    const rows = tbody.querySelectorAll('tr:not(.no-results)');
                    let visible = 0;

                    rows.forEach(row => {
                        const name = row.querySelector('.participant-name')?.textContent
                            .toLowerCase() || '';
                        if (name.includes(term)) {
                            row.style.display = '';
                            visible++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    noResultsRow.style.display = visible === 0 ? '' : 'none';
                };

                input.addEventListener('keyup', filterRows);
                filterRows(); // initial
            });

            // Collection table search
            const collectionSearch = document.querySelector('.collection-search');
            if (collectionSearch) {
                const tbody = document.querySelector('#collectionTable tbody');
                if (tbody) {
                    let noResultsRow = tbody.querySelector('.no-results');
                    if (!noResultsRow) {
                        noResultsRow = document.createElement('tr');
                        noResultsRow.className = 'no-results';
                        noResultsRow.innerHTML =
                            `<td colspan="9" class="text-center py-8 text-[#6A8A52]">No quests found</td>`;
                        tbody.appendChild(noResultsRow);
                    }

                    const filter = () => {
                        const term = collectionSearch.value.toLowerCase();
                        const rows = tbody.querySelectorAll('tr:not(.no-results)');
                        let visible = 0;

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            if (text.includes(term)) {
                                row.style.display = '';
                                visible++;
                            } else {
                                row.style.display = 'none';
                            }
                        });

                        noResultsRow.style.display = visible === 0 ? '' : 'none';
                    };

                    collectionSearch.addEventListener('keyup', filter);
                    filter();
                }
            }
        });

        // ——————————————————————————————————————
        // SUBMISSION STATUS UPDATE (AJAX)
        // ——————————————————————————————————————
        document.querySelectorAll('.submission-status').forEach(select => {
            select.addEventListener('change', async function() {
                const submissionId = this.dataset.submissionId;
                const newStatus = this.value;

                try {
                    const res = await fetch(`/submissions/${submissionId}/update-status`, {
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

                    const data = await res.json();
                    if (data.success) {
                        showMessage(`Status updated to "${newStatus}"`, 'success');
                    } else {
                        showMessage('Update failed', 'error');
                        this.value = this.dataset.previousValue || 'pending';
                    }
                } catch (err) {
                    console.error(err);
                    showMessage('Network error', 'error');
                }
            });

            // Store initial value for rollback on error
            select.dataset.previousValue = select.value;
        });

        // ——————————————————————————————————————
        // COLLECTION TABLE PAGINATION (Laravel default links)
        // ——————————————————————————————————————
        $(document).on('click', '#collectionTable .pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            $.get(url, function(data) {
                $('#table-data').html(data); // this is your collection table container
            });
        });
        // ——————————————————————————————————————
        // QUEST PARTICIPANTS PAGINATION
        // ——————————————————————————————————————
        // ——————————————————————————————————————
        // QUEST PARTICIPANTS PAGINATION (Individual Quests ONLY)
        // ——————————————————————————————————————
        $(document).on('click', '#questTables .pagination a', function(e) {
            e.preventDefault();

            // Find the closest quest table container
            const $questContainer = $(this).closest('[id^="questTable-"]');

            // If we're not inside a questTable- (e.g. in archived or collection), ignore
            if ($questContainer.length === 0) {
                return;
            }

            const questId = $questContainer.attr('id').split('-')[1];
            const url = this.href;

            $.get(url + (url.includes('?') ? '&' : '?') + 'quest_id=' + questId, function(data) {
                $('#questTable-' + questId + ' #table-data-participants').html(data);
            }).fail(function() {
                showMessage('Failed to load participants', 'error');
            });
        });

        // ——————————————————————————————————————
        // TOAST MESSAGE
        // ——————————————————————————————————————
        function showMessage(message, type = 'success') {
            // You can replace this with Toast, SweetAlert, or your own system
            const bg = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const div = document.createElement('div');
            div.className = `fixed top-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg z-50 ${bg} animate-pulse`;
            div.textContent = message;
            document.body.appendChild(div);
            setTimeout(() => div.remove(), 3000);
        }
        // ————————————————————————————————
        // ARCHIVE BUTTON (works on ALL pages, even after pagination)
        // ————————————————————————————————
        $(document).on('click', '.btn-archive', function(e) {
            e.preventDefault();

            const button = $(this);
            const questId = button.data('quest-id');
            const questRow = button.closest('tr');
            const questTitle = questRow.find('td').eq(1).text().trim(); // Title column

            if (!confirm(`Archive quest "${questTitle}"?`)) {
                return;
            }

            // Optional: disable button while processing
            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: `/quests/${questId}/archive`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Remove row from table
                        questRow.fadeOut(300, function() {
                            $(this).remove();
                        });

                        // Optional: Add to Archived Quests sidebar instantly
                        const archivedTab = $(`li[data-quest="archived"]`);
                        if (archivedTab.length) {
                            // Just refresh the count or show success
                            showMessage(`"${questTitle}" archived successfully!`, 'success');
                        }

                        // If you're on the last page and it becomes empty → go to previous page
                        if ($('#table-data tbody tr').length === 1) { // only "no data" row left
                            const prevLink = $('.pagination .page-item.active').prev(
                                '.page-item:not(.disabled)').find('a');
                            if (prevLink.length) prevLink[0].click();
                        }
                    } else {
                        showMessage('Failed to archive quest.', 'error');
                        button.prop('disabled', false).html(
                            '<i class="fas fa-archive"></i><span class="hidden sm:inline">Archive</span>'
                        );
                    }
                },
                error: function() {
                    showMessage('Server error. Try again.', 'error');
                    button.prop('disabled', false).html(
                        '<i class="fas fa-archive"></i><span class="hidden sm:inline">Archive</span>'
                    );
                }
            });
        });

        // Simple toast function (you can replace with SweetAlert/Toastify if you want)
        function showMessage(message, type = 'success') {
            const bg = type === 'success' ? 'bg-green-600' : 'bg-red-600';
            const div = $(
                `<div class="${bg} text-white px-6 py-3 rounded-lg shadow-lg fixed top-5 right-5 z-50 animate-pulse">${message}</div>`
            );
            $('body').append(div);
            setTimeout(() => div.fadeOut(() => div.remove()), 3000);
        }
        // ——————————————————————————————————————
        // ARCHIVED QUESTS PAGINATION — 
        // ——————————————————————————————————————
        $(document).on('click', '#archiveMain .pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href') + (this.href.includes('?') ? '&' : '?') + 'archived=1';

            $.get(url, function(data) {
                $('#archive-table-container').html(data);
            }).fail(function() {
                showMessage('Failed to load archived quests', 'error');
            });
        });

        // ——————————————————————————————————————
        // ARCHIVED SEARCH
        // ——————————————————————————————————————
        $(document).on('keyup', '#archive-search', function() {
            const term = $(this).val().toLowerCase();
            $('#archive-table-body tr').each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(term));
            });

            // Optional: show "no results" if all hidden
            const visible = $('#archive-table-body tr:visible').length;
            if (visible === 0 && term) {
                if ($('#archive-table-body .no-results-custom').length === 0) {
                    $('#archive-table-body').append(
                        '<tr class="no-results-custom"><td colspan="9" class="text-center py-8 text-[#6A8A52]">No matching archived quests</td></tr>'
                    );
                }
            } else {
                $('#archive-table-body .no-results-custom').remove();
            }
        });
    </script>
    @include('modal.createQuestModal')
@endsection
