@extends('layouts.adminLayout')

@section('title', 'Quests')

@section('content')
    @include('modal.userQuestModal')
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
                            <ul id="questList" class="space-y-2 mb-2">
                                @foreach ($questsList->whereIn('status', ['active', 'ending_soon']) as $quest)
                                    <li data-quest="{{ $quest->quest_id }}"
                                        class="tab-eco cursor-pointer {{ $loop->first ? 'bg-[#E9F0E1] font-semibold' : '' }}">
                                        <div class="flex justify-between items-center">
                                            <span class="truncate">{{ $quest->title }}</span>

                                            <div class="flex items-center gap-2">
                                                @if ($quest->status === 'ending_soon')
                                                    <span
                                                        class="text-xs bg-[#FEF3C7] text-[#D97706] px-2 py-1 rounded-md">Soon</span>
                                                @endif

                                                @if ($quest->submissions->where('status', 'pending')->count() > 0)
                                                    <div
                                                        class="flex items-center gap-1.5 px-2 py-.5 rounded-full bg-rose-100 border border-rose-300 text-rose-700 text-xs font-semibold">
                                                        <div class="relative">
                                                            <div
                                                                class="w-1 h-1 bg-rose-500 rounded-full animate-ping absolute">
                                                            </div>
                                                            <div class="w-1 h-1 bg-rose-500 rounded-full"></div>
                                                        </div>
                                                        <span>{{ $quest->submissions->where('status', 'pending')->count() }}
                                                            pending</span>
                                                    </div>
                                                @endif
                                            </div>
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
                                <button id="prevPage" class="px-2 py-1 border rounded-md text-xs">&laquo;</button>

                                <div id="pageNumbers" class="flex gap-2">
                                    @php
                                        $perPage = 5;
                                        $activeQuests = $questsList->whereIn('status', ['active', 'ending_soon']);
                                        $totalPages = ceil($activeQuests->count() / $perPage);
                                    @endphp

                                    @for ($i = 1; $i <= min(5, $totalPages); $i++)
                                        <button
                                            class="page-btn px-3 py-1 border rounded-md text-xs {{ $i === 1 ? 'bg-[#E9F0E1] font-semibold' : '' }}"
                                            data-page="{{ $i }}">
                                            {{ $i }}
                                        </button>
                                    @endfor
                                </div>

                                <button id="nextPage" class="px-2 py-1 border rounded-md text-xs">&raquo;</button>
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
                                            class="status-filter bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans whitespace-nowrap">
                                            <option value="">All Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="completed">Completed</option>
                                            <option value="rejected">Rejected</option>
                                        </select>

                                        <select
                                            class="sort-by bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans whitespace-nowrap">
                                            <option value="name-asc">Name (A to Z)</option>
                                            <option value="name-desc">Name (Z to A)</option>
                                            <option value="date-desc" selected>Date (Newest First)</option>
                                            <option value="date-asc">Date (Oldest First)</option>
                                            <option value="status-pending">Status: Pending First</option>
                                            <option value="status-completed">Status: Completed First</option>
                                            <option value="status-rejected">Status: Rejected First</option>
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
        // ——————————————————————————————————————
        // FINAL STATUS CHANGE – WORKS WITH YOUR ROUTE & CONTROLLER
        // ——————————————————————————————————————
        document.addEventListener('change', function(e) {
            if (!e.target.matches('.submission-status')) return;

            const select = e.target;
            const submissionId = select.dataset.submissionId;
            const newStatus = select.value;
            const oldStatus = select.dataset.currentStatus || 'pending';
            const row = select.closest('tr');

            // Prevent double submission
            if (select.disabled) return;
            select.disabled = true;
            select.classList.add('opacity-60', 'cursor-not-allowed');

            fetch(`/submissions/${submissionId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Server error');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showMessage('Status updated successfully!', 'success');

                        // Update current status
                        select.dataset.currentStatus = newStatus;
                        row.dataset.status = newStatus;

                        // Update "Checked By" column
                        const checkedCell = row.cells[3]; // 4th column
                        if (newStatus === 'completed' || newStatus === 'rejected') {
                            const action = newStatus === 'completed' ? 'Verified' : 'Rejected';
                            const color = newStatus === 'completed' ? 'text-green-600' : 'text-red-600';
                            checkedCell.innerHTML = `
                    <span class="${color} font-medium">
                        ${action} by {{ auth()->user()->first_name }}
                    </span>`;
                        } else {
                            checkedCell.innerHTML = '<span class="text-gray-500">Not processed</span>';
                        }

                        // Rebuild the <select> options correctly
                        const hasProof = !!row.dataset.proofLink || !!row.dataset.proofImage;

                        select.innerHTML = `
                            <option value="pending" ${newStatus === 'pending' && !hasProof ? 'selected' : ''}>
                                Pending
                            </option>
                            ${newStatus === 'pending' && hasProof ? `
                                                                    <option value="pending" selected class="font-medium text-amber-700">
                                                                        Submitted (Has Proof)
                                                                    </option>` : ''}
                            <option value="completed" ${newStatus === 'completed' ? 'selected' : ''} class="font-medium text-green-700">
                                Completed
                            </option>
                            <option value="rejected" ${newStatus === 'rejected' ? 'selected' : ''} class="font-medium text-red-700">
                                Rejected
                            </option>
                        `;
                    } else {
                        throw new Error(data.message || 'Update failed');
                    }
                })
                .catch(err => {
                    console.error('Status update failed:', err);
                    showMessage('Failed to update status', 'error');
                    select.value = oldStatus; // revert selection
                })
                .finally(() => {
                    select.disabled = false;
                    select.classList.remove('opacity-60', 'cursor-not-allowed');
                });
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
        // ——————————————————————————————————————
        // INSTANT SEARCH + FILTER + SORT (FIXED VERSION — WORKS ON ALL QUESTS!)
        // ——————————————————————————————————————
        document.addEventListener('DOMContentLoaded', () => {
            console.log('%c[Quest Participants] Instant filter/sort script loaded',
                'color: #4F6B3F; font-weight: bold');

            const applyFiltersAndSorting = (tableContainer) => {
                console.log('%cApplying filters & sorting to container:', 'color: #7A8C4F', tableContainer.id);

                const tbody = tableContainer.querySelector('tbody');
                if (!tbody) {
                    console.warn('No <tbody> found in container', tableContainer.id);
                    return;
                }

                const questId = tableContainer.id.split('-')[1];
                const header = document.getElementById('questHeader-' + questId);
                if (!header) {
                    console.warn('Header not found for quest ID:', questId);
                    return;
                }

                const searchInput = header.querySelector('.table-search');
                const statusFilter = header.querySelector('.status-filter');
                const sortBy = header.querySelector('.sort-by');

                console.log('Found controls →', {
                    searchInput: !!searchInput,
                    statusFilter: !!statusFilter,
                    sortBy: !!sortBy
                });

                // No results row
                let noResults = tbody.querySelector('.no-results');
                if (!noResults) {
                    noResults = document.createElement('tr');
                    noResults.className = 'no-results';
                    noResults.innerHTML = `<td colspan="4" class="text-center py-16 text-[#6A8A52]">
                    <i class="fa-solid fa-inbox text-4xl opacity-30 mb-4 block"></i>
                    <div>No participants found</div>
                </td>`;
                    tbody.appendChild(noResults);
                }

                const update = () => {
                    const term = (searchInput?.value || '').toLowerCase().trim();
                    const statusVal = statusFilter?.value || '';
                    const sortVal = sortBy?.value || 'date-desc';

                    console.groupCollapsed(
                        `%cUpdate triggered → term:"${term}" | filter:${statusVal} | sort:${sortVal}`,
                        'color: #4F6B3F');

                    const rows = Array.from(tbody.querySelectorAll('tr:not(.no-results)'));
                    console.log(`Found ${rows.length} participant rows`);

                    // Debug each row's important data attributes
                    rows.forEach((row, i) => {
                        if (i < 5 || rows.length <= 10) { // log first 5 or all if few
                            console.log(`Row ${i+1}:`, {
                                name: row.querySelector('.participant-name')?.textContent
                                    .trim(),
                                status: row.dataset.status,
                                submittedAt: row.dataset.submittedAt
                            });
                        }
                    });

                    const filteredAndSorted = rows
                        .filter(row => {
                            const name = (row.querySelector('.participant-name')?.textContent || '')
                                .toLowerCase();
                            const status = row.dataset.status || 'pending';
                            const matchSearch = name.includes(term);
                            const matchFilter = !statusVal || status === statusVal;
                            console.log(
                                `Filter check → name:"${name}" status:"${status}" → search:${matchSearch} filter:${matchFilter}`
                            );
                            return matchSearch && matchFilter;
                        })
                        .sort((a, b) => {
                            const nameA = (a.querySelector('.participant-name')?.textContent || '')
                                .trim();
                            const nameB = (b.querySelector('.participant-name')?.textContent || '')
                                .trim();
                            const statusA = a.dataset.status || 'pending';
                            const statusB = b.dataset.status || 'pending';
                            const dateA = new Date(a.dataset.submittedAt || '1970-01-01');
                            const dateB = new Date(b.dataset.submittedAt || '1970-01-01');

                            let result = 0;

                            switch (sortVal) {
                                case 'name-asc':
                                    result = nameA.localeCompare(nameB);
                                    console.log('Sorting name A→Z', nameA, 'vs', nameB, '→', result);
                                    break;
                                case 'name-desc':
                                    result = nameB.localeCompare(nameA);
                                    break;
                                case 'date-desc':
                                    result = dateB - dateA;
                                    break;
                                case 'date-asc':
                                    result = dateA - dateB;
                                    break;
                                case 'status-pending':
                                    result = statusA === statusB ? (dateB - dateA) : (statusA ===
                                        'pending' ? -1 : 1);
                                    console.log('Sorting Pending First →', statusA, 'vs', statusB, '→',
                                        result);
                                    break;
                                case 'status-completed':
                                    result = statusA === statusB ? (dateB - dateA) : (statusA ===
                                        'completed' ? -1 : 1);
                                    break;
                                case 'status-rejected':
                                    result = statusA === statusB ? (dateB - dateA) : (statusA ===
                                        'rejected' ? -1 : 1);
                                    break;
                                default:
                                    console.warn('Unknown sort value:', sortVal);
                                    result = 0;
                            }
                            return result;
                        });

                    console.log(`After filter+sort → ${filteredAndSorted.length} rows remain`);

                    // Apply visibility
                    rows.forEach(r => r.style.display = 'none');

                    // This is the magic: moving rows reorders them visually
                    filteredAndSorted.forEach(row => {
                        tbody.appendChild(row);
                        row.style.display = '';
                    });

                    noResults.style.display = filteredAndSorted.length === 0 ? '' : 'none';

                    console.log(`Successfully reordered and displayed ${filteredAndSorted.length} rows`);
                    console.groupEnd();
                };

                // Attach listeners safely
                [searchInput, statusFilter, sortBy].forEach(el => {
                    if (el) {
                        el.removeEventListener('input', update);
                        el.removeEventListener('change', update);
                        el.addEventListener('input', update);
                        el.addEventListener('change', update);
                        console.log('Listener attached to', el);
                    }
                });

                // First run
                update();
            };

            // Apply to already loaded tables
            const initialContainers = document.querySelectorAll('[id^="questTable-"]');
            console.log(`Found ${initialContainers.length} quest tables on page load`);
            initialContainers.forEach(applyFiltersAndSorting);

            // Re-apply after AJAX load (your existing fetch override)
            const originalFetch = window.fetch;
            window.fetch = function(...args) {
                return originalFetch.apply(this, args).then(response => {
                    response.clone().text().then(text => {
                        if (text.includes('participant-name')) {
                            console.log('%cAJAX participant table loaded – re-applying filters',
                                'color: #D97706');
                            setTimeout(() => {
                                document.querySelectorAll('[id^="questTable-"]')
                                    .forEach(container => {
                                        if (container.querySelector(
                                                '.participant-name')) {
                                            applyFiltersAndSorting(container);
                                        }
                                    });
                            }, 100);
                        }
                    });
                    return response;
                });
            };

            // Also catch jQuery pagination loads
            $(document).ajaxComplete(function(event, xhr, settings) {
                if (settings.url && settings.url.includes('quest_id=')) {
                    console.log('%cPagination AJAX completed – re-applying filters', 'color: #7A8C4F');
                    setTimeout(() => {
                        document.querySelectorAll('[id^="questTable-"]').forEach(
                            applyFiltersAndSorting);
                    }, 100);
                }
            });
        });
    </script>
    @include('modal.createQuestModal')
@endsection
