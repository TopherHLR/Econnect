@extends('layouts.adminLayout')

@section('title', 'Eco Library')

@section('content')

    @include('modal.viewLifestyleModal')
    <div class="space-y-6">
        <!-- Header with Stats -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Eco Library</h1>
                <p class="font-sans text-[#6A8A52] mt-1">Manage eco-topics and eco-actions in one place.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                    <div class="text-2xl font-bold text-[#4F6B3F]">{{ $ecoTopicsList->count() }}</div>
                    <div class="text-sm text-[#6A8A52]">Eco Topics</div>
                </div>
                <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                    <div class="text-2xl font-bold text-[#4F6B3F]">{{ $ecoActionsList->count() }}</div>
                    <div class="text-sm text-[#6A8A52]">Eco Actions</div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 w-full">
            <!-- SIDEBAR -->
            <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] w-full lg:w-1/5">
                <aside>
                    <h2 class="text-xl font-semibold text-[#4F6B3F] mb-6">Library Sections</h2>
                    <div class="space-y-2">
                        <button data-section="topics"
                            class="tab-eco w-full text-left cursor-pointer flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-book text-[#7F8A4F]"></i>
                                <span>Eco Topics</span>
                            </div>
                            <span
                                class="text-xs text-[#6A8A52] bg-[#E0E9D6] px-2 py-0.5 rounded-full">{{ $ecoTopicsList->count() }}</span>
                        </button>

                        <button data-section="actions"
                            class="tab-eco w-full text-left cursor-pointer flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-seedling text-[#7F8A4F]"></i>
                                <span>Eco Actions</span>
                            </div>
                            <span
                                class="text-xs text-[#6A8A52] bg-[#E0E9D6] px-2 py-0.5 rounded-full">{{ $ecoActionsList->count() }}</span>
                        </button>

                        <button data-section="archived-topics"
                            class="tab-eco w-full text-left cursor-pointer flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-box-archive text-[#7F8A4F]"></i>
                                <span>Archived Topics</span>
                            </div>
                            <span
                                class="text-xs text-[#6A8A52] bg-[#E0E9D6] px-2 py-0.5 rounded-full">{{ $archivedTopicsList->count() }}</span>
                        </button>

                        <button data-section="archived-actions"
                            class="tab-eco w-full text-left cursor-pointer flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-box-archive text-[#7F8A4F]"></i>
                                <span>Archived Actions</span>
                            </div>
                            <span
                                class="text-xs text-[#6A8A52] bg-[#E0E9D6] px-2 py-0.5 rounded-full">{{ $archivedActionsList->count() }}</span>
                        </button>
                    </div>
                </aside>
            </div>

            <!-- MAIN CONTENT -->
            <main class="flex-1 space-y-6 w-full lg:w-4/5">
                <!-- Search + Add Button -->
                <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
                    <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                        <div class="relative flex-1 min-w-[250px]">
                            <input type="text" placeholder="Search topics, actions or archived items..."
                                class="bg-[#E0E9D6] w-full pl-4 pr-12 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm table-search">
                            <button type="button" id="clearSearch"
                                class="hidden absolute right-3 top-2.5 text-[#7A8C4F] hover:text-[#4F6B3F]">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>
                        <button id="addEcoItemBtn" class="btn-eco btn-leaf flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> <span>Add Eco Topic</span>
                        </button>
                    </div>
                </div>

                <!-- ECO TOPICS -->
                <div id="topicsTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-book text-[#7F8A4F] text-xl"></i>
                        <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Topics <span
                                class="text-[#6A8A52]">({{ $ecoTopicsList->count() }})</span></h2>
                    </div>
                    <div id="topicsTablePagi">
                        <div class="overflow-x-auto" id="table-data-topics">
                            @include('admin.partials.topics_table')
                        </div>
                    </div>
                </div>

                <!-- ECO ACTIONS -->
                <div id="actionsTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-seedling text-[#7F8A4F] text-xl"></i>
                        <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Actions <span
                                class="text-[#6A8A52]">({{ $ecoActionsList->count() }})</span></h2>
                    </div>
                    <div id="actionsTablePagi">
                        <div class="overflow-x-auto" id="table-data-actions">
                            @include('admin.partials.actions_table')
                        </div>
                    </div>
                </div>

                <!-- ARCHIVED TOPICS -->
                <div id="archivedTopicsTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-box-archive text-[#7F8A4F] text-xl"></i>
                        <h2 class="text-xl font-semibold text-[#4F6B3F]">Archived Topics <span
                                class="text-[#6A8A52]">({{ $archivedTopicsList->count() }})</span></h2>
                    </div>
                    <div id="topicsArchiveTablePagi">
                        <div class="overflow-x-auto" id="table-data-topics-archive">
                            @include('admin.partials.topics_archive_table')
                        </div>
                    </div>

                </div>

                <!-- ARCHIVED ACTIONS -->
                <div id="archivedActionsTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-box-archive text-[#7F8A4F] text-xl"></i>
                        <h2 class="text-xl font-semibold text-[#4F6B3F]">Archived Actions <span
                                class="text-[#6A8A52]">({{ $archivedActionsList->count() }})</span></h2>
                    </div>
                    <div id="actionsArchiveTablePagi">
                        <div class="overflow-x-auto" id="table-data-actions-archive">
                            @include('admin.partials.actions_archive_table')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addBtn = document.getElementById('addEcoItemBtn');
            const searchInput = document.querySelector('.table-search');
            const clearBtn = document.getElementById('clearSearch');

            // Update Add button based on active tab
            const updateAddButton = () => {
                const activeSection = document.querySelector('[data-section].tab-eco-active')?.dataset
                    .section || 'topics';
                if (['actions', 'archived-actions'].includes(activeSection)) {
                    addBtn.innerHTML = '<i class="fa-solid fa-plus"></i> <span>Add Eco Action</span>';
                    addBtn.onclick = () => openEcoActionModal?.();
                } else {
                    addBtn.innerHTML = '<i class="fa-solid fa-plus"></i> <span>Add Eco Topic</span>';
                    addBtn.onclick = () => openCreateEcoTopicModal?.();
                }
            };

            // Tab switching
            document.querySelectorAll('[data-section]').forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active tab
                    document.querySelectorAll('[data-section]').forEach(b => b.classList.remove(
                        'tab-eco-active'));
                    btn.classList.add('tab-eco-active');

                    // Hide all sections
                    document.getElementById('topicsTable').classList.add('hidden');
                    document.getElementById('actionsTable').classList.add('hidden');
                    document.getElementById('archivedTopicsTable').classList.add('hidden');
                    document.getElementById('archivedActionsTable').classList.add('hidden');

                    // Show correct one
                    const section = btn.dataset.section;
                    if (section === 'topics') document.getElementById('topicsTable').classList
                        .remove('hidden');
                    if (section === 'actions') document.getElementById('actionsTable').classList
                        .remove('hidden');
                    if (section === 'archived-topics') document.getElementById(
                        'archivedTopicsTable').classList.remove('hidden');
                    if (section === 'archived-actions') document.getElementById(
                        'archivedActionsTable').classList.remove('hidden');

                    updateAddButton();
                    if (searchInput.value) performSearch();
                });
            });

            // Global search
            const performSearch = () => {
                const query = searchInput.value.trim().toLowerCase();
                document.querySelectorAll(
                        '#topicsTable tr, #actionsTable tr, #archivedTopicsTable tr, #archivedActionsTable tr')
                    .forEach(row => {
                        if (!row.cells || row.cells.length < 2) return;
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(query) ? '' : 'none';
                    });
            };

            searchInput.addEventListener('input', performSearch);
            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                clearBtn.classList.add('hidden');
                performSearch();
            });
            searchInput.addEventListener('input', () => {
                clearBtn.classList.toggle('hidden', !searchInput.value);
            });
            // Topics (Active)
            $(document).on('click', '#topicsTablePagi .pagination a', function(e) {
                e.preventDefault();
                $.get(this.href, {
                    type: 'topics'
                }, function(data) {
                    $('#table-data-topics').html(data);
                    performSearch();
                });
            });

            // Archived Topics
            $(document).on('click', '#topicsArchiveTablePagi .pagination a', function(e) {
                e.preventDefault();
                $.get(this.href, {
                    type: 'archived-topics'
                }, function(data) {
                    $('#table-data-topics-archive').html(data);
                    performSearch();
                });
            });

            // Actions
            $(document).on('click', '#actionsTablePagi .pagination a', function(e) {
                e.preventDefault();
                $.get(this.href, {
                    type: 'actions'
                }, function(data) {
                    $('#table-data-actions').html(data);
                    performSearch();
                });
            });
            // Actions
            $(document).on('click', '#actionsArchiveTablePagi .pagination a', function(e) {
                e.preventDefault();
                $.get(this.href, {
                    type: 'archived-actions'
                }, function(data) {
                    $('#table-data-actions-archive').html(data);
                    performSearch();
                });
            });

            // Default: Open Topics tab
            document.querySelector('[data-section="topics"]').classList.add('tab-eco-active');
            document.getElementById('topicsTable').classList.remove('hidden');
            updateAddButton();
        });

        document.querySelectorAll('.btn-view-eco').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = JSON.parse(btn.dataset.item);
                item.image_url = btn.dataset.image || '';
                openViewModal(item, "topic");
            });
        });
        document.querySelectorAll('.btn-view-eco-action').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = JSON.parse(btn.dataset.action);
                item.image_url = btn.dataset.image || '';
                openViewModal(item, btn.dataset.type);
            });
        });
    </script>
@endsection
