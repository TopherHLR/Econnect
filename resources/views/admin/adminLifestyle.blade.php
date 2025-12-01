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
                <div class="flex items-center gap-3 mb-6">
                    <i class="fa-solid fa-book text-[#7F8A4F] text-xl"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Topics</h2>
                        <p class="text-sm text-[#6A8A52]">{{ $ecoTopics->count() }} topics</p>
                    </div>
                </div>

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

                                        <!-- ARCHIVE (Soft Delete) -->
                                        <!-- ARCHIVE BUTTON -->
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
            </div>

            <!-- ECO ACTIONS -->
            <div id="ecoActionsSection" class="hidden">
                <div class="flex items-center gap-3 mb-6">
                    <i class="fa-solid fa-seedling text-[#7F8A4F] text-xl"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Actions</h2>
                        <p class="text-sm text-[#6A8A52]">{{ $ecoActions->count() }} actions</p>
                    </div>
                </div>

                <table class="min-w-full">
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

                                        <!-- View -->
                                        <button onclick='openViewModal({{ $action->toJson() }}, "action")'
                                            class="btn-action btn-view compact">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Edit -->
                                        <button class="btn-action btn-edit-eco-action compact"
                                            data-action='@json($action)'
                                            data-image="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : '' }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <!-- ARCHIVE -->
                                        <!-- ARCHIVE BUTTON -->
                                        <form method="POST" action="{{ route('admin.actions.archive', $action) }}"
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
                                <td colspan="3" class="text-center py-16 text-[#6A8A52]">No actions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Toggle Script (now also updates Add button text) -->
    <script>
        const topicsSection = document.getElementById('ecoTopicsSection');
        const actionsSection = document.getElementById('ecoActionsSection');
        const addBtn = document.getElementById('addEcoItemBtn');
        const slider = document.getElementById('toggle-slider');
        const topicsBtn = document.getElementById('topicsBtn');
        const actionsBtn = document.getElementById('actionsBtn');

        const switchTab = tab => {
            const isTopics = tab === 'topics';

            // Sections
            topicsSection.classList.toggle('hidden', !isTopics);
            actionsSection.classList.toggle('hidden', isTopics);

            // Slider animation
            slider.style.transform = isTopics ? 'translateX(0)' : 'translateX(100%)';

            // Button colors
            topicsBtn.style.color = isTopics ? '#5C7919' : '#FCF9EF';
            actionsBtn.style.color = isTopics ? '#FCF9EF' : '#5C7919';

            // Add button
            addBtn.innerHTML = isTopics ?
                '<i class="fa-solid fa-plus"></i> <span>Add Eco Topic</span>' :
                '<i class="fa-solid fa-plus"></i> <span>Add Eco Action</span>';
            addBtn.setAttribute('onclick', isTopics ? 'openCreateEcoTopicModal()' : 'openEcoActionModal()');
        };

        // Event listeners
        topicsBtn.addEventListener('click', () => switchTab('topics'));
        actionsBtn.addEventListener('click', () => switchTab('actions'));

        // Activate tab from URL
        document.addEventListener('DOMContentLoaded', () => {
            const tab = new URLSearchParams(window.location.search).get('tab');
            switchTab(tab === 'actions' ? 'actions' : 'topics');
        });
    </script>
@endsection

