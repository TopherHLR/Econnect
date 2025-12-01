@extends('layouts.adminLayout')

@section('title', 'Eco Library')

@section('content')
    @include('modal.viewLifestyleModal')
    <div class="space-y-6">
        <!-- Header with Stats -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="space-y-2">
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Eco Library</h1>
                <p class="font-sans text-[#6A8A52]">Manage eco-topics and eco-actions in one place.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                    <div class="text-2xl font-bold text-[#4F6B3F]">{{ $ecoTopics->count() }}</div>
                    <div class="text-sm text-[#6A8A52]">Eco Topics</div>
                </div>
                <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                    <div class="text-2xl font-bold text-[#4F6B3F]">{{ $ecoActions->count() }}</div>
                    <div class="text-sm text-[#6A8A52]">Eco Actions</div>
                </div>
            </div>
        </div>

        <!-- Control Bar -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center flex-1">
                    <!-- Toggle -->
                    <div class="relative flex items-center bg-[#5C7919] rounded-full p-1 w-40">
                        <div id="toggle-slider"
                            class="absolute left-1 top-1 w-[calc(50%-0.25rem)] h-[calc(100%-0.5rem)] bg-[#FCFFF6] rounded-full shadow-md transition-all duration-300">
                        </div>
                        <button id="topicsBtn"
                            class="relative z-10 flex-1 text-center text-sm font-medium py-2 text-[#5C7919]">Topics</button>
                        <button id="actionsBtn"
                            class="relative z-10 flex-1 text-center text-sm font-medium py-2 text-[#FCF9EF]">Actions</button>
                    </div>

                    <!-- Search -->
                    <div class="relative flex-1 min-w-[250px]">
                        <input type="text" placeholder="Search..." id="searchInput"
                            class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm">
                        <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F]"></i>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button id="addEcoItemBtn" class="btn-eco btn-leaf flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> <span>Add Eco Topic</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <!-- ECO TOPICS -->
            <div id="ecoTopicsSection">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-book text-[#7F8A4F] text-xl"></i>
                        <div>
                            <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Topics</h2>
                            <p class="text-sm text-[#6A8A52]">{{ $ecoTopics->count() }} topics</p>
                        </div>
                    </div>

                    <!-- Show Archived Button -->
                    <button id="toggleArchivedTopics"
                        class="px-4 py-2 bg-[#7F8A4F] text-white rounded-lg hover:bg-[#6A7A3F] text-sm transition">
                        Show Archived
                    </button>
                </div>

                <!-- Active Topics Table -->
                <table class="min-w-full">
                    <thead class="bg-[#FCF9EF]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Topic</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6EAD7]">
                        @forelse($ecoTopics as $topic)
                            <tr class="hover:bg-[#FAF8ED] group">
                                <td class="px-6 py-5">
                                    <img src="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : asset('images/default.jpg') }}"
                                        alt="{{ $topic->title }}" class="w-16 h-16 object-cover rounded-xl border">
                                </td>
                                <td class="px-6 py-5">
                                    <h3 class="font-semibold text-[#4F6B3F]">{{ $topic->title }}</h3>
                                    <p class="text-sm text-[#6A8A52] line-clamp-2">{{ $topic->description }}</p>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- View -->
                                        <button onclick='openViewModal({{ $topic->toJson() }}, "topic")'
                                            class="btn-action btn-view compact" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Edit -->
                                        <button class="btn-action btn-edit-eco compact"
                                            data-topic='@json($topic)'
                                            data-image="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : '' }}"
                                            title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <!-- Archive -->
                                        <form method="POST" action="{{ route('admin.libraries.archive', $topic) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Archive this topic? It will disappear from users.')"
                                                class="btn-action btn-archive compact" title="Archive Topic">
                                                <i class="fa-solid fa-box-archive"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-16 text-[#6A8A52]">No topics found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Archived Topics Table (Initially Hidden) -->
                <div id="archivedTopicsTable" class="mt-6 hidden">
                    <h3 class="text-lg font-semibold text-[#4F6B3F] mb-3">Archived Topics</h3>
                    <table class="min-w-full">
                        <thead class="bg-[#FCF9EF]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Image</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Topic</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E6EAD7]">
                            @forelse($archivedTopics as $topic)
                                <tr class="hover:bg-[#FAF8ED] group">
                                    <td class="px-6 py-5">
                                        <img src="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : asset('images/default.jpg') }}"
                                            alt="{{ $topic->title }}" class="w-16 h-16 object-cover rounded-xl border">
                                    </td>
                                    <td class="px-6 py-5">
                                        <h3 class="font-semibold text-[#4F6B3F]">{{ $topic->title }}</h3>
                                        <p class="text-sm text-[#6A8A52] line-clamp-2">{{ $topic->description }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <form method="POST"
                                            action="{{ route('admin.libraries.restore', $topic) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Restore this topic? It will reappear for users.')"
                                                class="btn-action btn-view compact" title="Restore Topic">
                                                <i class="fa-solid fa-box-open"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-16 text-[#6A8A52]">No archived topics</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ECO ACTIONS -->
            <div id="ecoActionsSection" class="hidden">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-seedling text-[#7F8A4F] text-xl"></i>
                        <div>
                            <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Actions</h2>
                            <p class="text-sm text-[#6A8A52]">{{ $ecoActions->count() }} actions</p>
                        </div>
                    </div>

                    <!-- Show Archived Button for Actions -->
                    <button id="toggleArchivedActions"
                        class="px-4 py-2 bg-[#7F8A4F] text-white rounded-lg hover:bg-[#6A7A3F] text-sm transition">
                        Show Archived
                    </button>
                </div>

                <!-- Active Actions Table -->
                <table id="activeActionsTable" class="min-w-full">
                    <thead class="bg-[#FCF9EF]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Action</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6EAD7]">
                        @forelse($ecoActions as $action)
                            <tr class="hover:bg-[#FAF8ED] group">
                                <td class="px-6 py-5">
                                    <img src="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : asset('images/default-action.jpg') }}"
                                        alt="{{ $action->title }}" class="w-16 h-16 object-cover rounded-xl border">
                                </td>
                                <td class="px-6 py-5">
                                    <h3 class="font-semibold text-[#4F6B3F]">{{ $action->title }}</h3>
                                    <p class="text-sm text-[#6A8A52] line-clamp-2">{{ $action->description }}</p>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick='openViewModal({{ $action->toJson() }}, "action")'
                                            class="btn-action btn-view compact">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit-eco-action compact"
                                            data-action='@json($action)'
                                            data-image="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : '' }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.actions.archive', $action) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Archive this action? It will disappear from users.')"
                                                class="btn-action btn-archive compact" title="Archive Action">
                                                <i class="fa-solid fa-box-archive"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-16 text-[#6A8A52]">No actions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Archived Actions Table (Initially Hidden) -->
                <div id="archivedActionsTable" class="mt-6 hidden">
                    <h3 class="text-lg font-semibold text-[#4F6B3F] mb-3">Archived Actions</h3>
                    <table class="min-w-full">
                        <thead class="bg-[#FCF9EF]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Image</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Action</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E6EAD7]">
                            @forelse($archivedActions as $action)
                                <tr class="hover:bg-[#FAF8ED] group">
                                    <td class="px-6 py-5">
                                        <img src="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : asset('images/default-action.jpg') }}"
                                            alt="{{ $action->title }}" class="w-16 h-16 object-cover rounded-xl border">
                                    </td>
                                    <td class="px-6 py-5">
                                        <h3 class="font-semibold text-[#4F6B3F]">{{ $action->title }}</h3>
                                        <p class="text-sm text-[#6A8A52] line-clamp-2">{{ $action->description }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <form method="POST" action="{{ route('admin.actions.restore', $action) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Restore this action? It will reappear for users.')"
                                                class="btn-action btn-view compact" title="Restore Action">
                                                <i class="fa-solid fa-box-open"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-16 text-[#6A8A52]">No archived actions</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Script (now also updates Add button text) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const topicsSection = document.getElementById('ecoTopicsSection');
            const actionsSection = document.getElementById('ecoActionsSection');
            const addBtn = document.getElementById('addEcoItemBtn');
            const slider = document.getElementById('toggle-slider');
            const topicsBtn = document.getElementById('topicsBtn');
            const actionsBtn = document.getElementById('actionsBtn');

            // Topics
            let activeTopicsTable = null;
            let archivedTopicsTable = null;
            let toggleTopicsBtn = null;

            // Actions
            let activeActionsTable = null;
            let archivedActionsTable = null;
            let toggleActionsBtn = null;

            // === TOPICS TOGGLE ===
            const setupTopicsToggle = () => {
                activeTopicsTable = document.querySelector('#ecoTopicsSection > table');
                archivedTopicsTable = document.getElementById('archivedTopicsTable');
                toggleTopicsBtn = document.getElementById('toggleArchivedTopics');

                if (!toggleTopicsBtn || !activeTopicsTable) return;

                const newBtn = toggleTopicsBtn.cloneNode(true);
                toggleTopicsBtn.replaceWith(newBtn);
                toggleTopicsBtn = newBtn;

                toggleTopicsBtn.addEventListener('click', () => {
                    const showingArchived = !archivedTopicsTable.classList.contains('hidden');
                    if (showingArchived) {
                        archivedTopicsTable.classList.add('hidden');
                        activeTopicsTable.classList.remove('hidden');
                        toggleTopicsBtn.textContent = 'Show Archived';
                    } else {
                        activeTopicsTable.classList.add('hidden');
                        archivedTopicsTable.classList.remove('hidden');
                        toggleTopicsBtn.textContent = 'Show Active';
                    }
                });
            };

            // === ACTIONS TOGGLE ===
            const setupActionsToggle = () => {
                activeActionsTable = document.getElementById('activeActionsTable');
                archivedActionsTable = document.getElementById('archivedActionsTable');
                toggleActionsBtn = document.getElementById('toggleArchivedActions');

                if (!toggleActionsBtn || !activeActionsTable) return;

                const newBtn = toggleActionsBtn.cloneNode(true);
                toggleActionsBtn.replaceWith(newBtn);
                toggleActionsBtn = newBtn;

                toggleActionsBtn.addEventListener('click', () => {
                    const showingArchived = !archivedActionsTable.classList.contains('hidden');
                    if (showingArchived) {
                        archivedActionsTable.classList.add('hidden');
                        activeActionsTable.classList.remove('hidden');
                        toggleActionsBtn.textContent = 'Show Archived';
                    } else {
                        activeActionsTable.classList.add('hidden');
                        archivedActionsTable.classList.remove('hidden');
                        toggleActionsBtn.textContent = 'Show Active';
                    }
                });
            };

            const switchTab = (tab) => {
                const isTopics = tab === 'topics';

                topicsSection.classList.toggle('hidden', !isTopics);
                actionsSection.classList.toggle('hidden', isTopics);

                slider.style.transform = isTopics ? 'translateX(0)' : 'translateX(100%)';
                topicsBtn.style.color = isTopics ? '#5C7919' : '#FCF9EF';
                actionsBtn.style.color = isTopics ? '#FCF9EF' : '#5C7919';

                addBtn.innerHTML = isTopics ?
                    '<i class="fa-solid fa-plus"></i> <span>Add Eco Topic</span>' :
                    '<i class="fa-solid fa-plus"></i> <span>Add Eco Action</span>';
                addBtn.onclick = isTopics ? openCreateEcoTopicModal : openEcoActionModal;

                if (isTopics) {
                    setupTopicsToggle();
                    // Reset to active topics
                    if (activeTopicsTable && archivedTopicsTable) {
                        activeTopicsTable.classList.remove('hidden');
                        archivedTopicsTable.classList.add('hidden');
                        toggleTopicsBtn && (toggleTopicsBtn.textContent = 'Show Archived');
                    }
                } else {
                    setupActionsToggle();
                    // Reset to active actions
                    if (activeActionsTable && archivedActionsTable) {
                        activeActionsTable.classList.remove('hidden');
                        archivedActionsTable.classList.add('hidden');
                        toggleActionsBtn && (toggleActionsBtn.textContent = 'Show Archived');
                    }
                }
            };

            topicsBtn.addEventListener('click', () => switchTab('topics'));
            actionsBtn.addEventListener('click', () => switchTab('actions'));

            // Initial load
            const urlTab = new URLSearchParams(window.location.search).get('tab');
            switchTab(urlTab === 'actions' ? 'actions' : 'topics');
        });
    </script>
@endsection
