@extends('layouts.adminLayout')

@section('title', 'Eco Library')

@section('content')
    <div class="space-y-6">
        <!-- 🌿 Header with Stats -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="space-y-2">
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Eco Library</h1>
                <p class="font-sans text-[#6A8A52]">Manage eco-topics and eco-actions in one place.</p>
            </div>

            <!-- Quick Stats -->
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

        <!-- 🔄 Control Bar -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <!-- Toggle + Search Group -->
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center flex-1">
                    <!-- iOS-style Toggle -->
                    <div class="relative flex items-center bg-[#5C7919] rounded-full p-1 w-40">
                        <div id="toggle-slider"
                            class="absolute left-1 top-1 w-[calc(50%-0.25rem)] h-[calc(100%-0.5rem)] bg-[#FCFFF6] rounded-full shadow-md transition-all duration-300 ease-in-out">
                        </div>
                        <button id="topicsBtn"
                            class="relative z-10 flex-1 text-center text-sm font-medium text-[#5C7919] py-2"
                            onclick="switchTab('topics')">Topics</button>
                        <button id="actionsBtn"
                            class="relative z-10 flex-1 text-center text-sm font-medium text-[#FCF9EF] py-2"
                            onclick="switchTab('actions')">Actions</button>
                    </div>

                    <!-- Search -->
                    <div class="relative flex-1 min-w-[250px]">
                        <input type="text" placeholder="Search..."
                            class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans"
                            id="searchInput">
                        <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
                    </div>
                </div>

                <!-- Action Buttons Group -->
                <div class="flex gap-2 shrink-0">
                    <button id="addEcoItemBtn" class="btn-eco btn-leaf flex items-center gap-2"
                        onclick="openCreateEcoTopicModal()">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Topic</span>
                    </button>

                    <button class="btn-eco btn-sage compact" title="Quick Actions">
                        <i class="fa-solid fa-bolt"></i>
                        <span class="hidden sm:inline">Actions</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 📚 Content Grid -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <!-- 🪴 ECO TOPICS GRID -->
            <div id="ecoTopicsSection">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-book text-[#7F8A4F] text-xl"></i>
                        <div>
                            <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Topics</h2>
                            <p class="text-sm text-[#6A8A52]">{{ $ecoTopics->count() }} topics available</p>
                        </div>
                    </div>
                </div>

                <table class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
                    <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase tracking-wider">
                                Image</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase tracking-wider">
                                Topic</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6EAD7]">
                        @forelse($ecoTopics as $topic)
                            <tr class="hover:bg-[#FAF8ED] transition-colors duration-200 group">
                                <!-- Image -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <img src="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : asset('images/default.jpg') }}"
                                        alt="{{ $topic->title }}"
                                        class="w-16 h-16 object-cover rounded-xl border border-[#C8D9B5]">
                                </td>

                                <!-- Title + Description -->
                                <td class="px-6 py-5">
                                    <h3 class="font-semibold text-[#4F6B3F] text-base leading-tight mb-1">
                                        {{ $topic->title }}
                                    </h3>
                                    <p class="text-sm text-[#6A8A52] line-clamp-2">
                                        {{ $topic->description }}
                                    </p>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-5 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2">

                                        <!-- View Topic -->
                                        <a href="{{ url('/libraries/' . $topic->id) }}" class="btn-action btn-view compact"
                                            title="View Topic">
                                            <i class="fa-solid fa-eye"></i>
                                            <span class="hidden xs:inline">View</span>
                                        </a>

                                        <!-- Edit Topic -->
                                        <a href="javascript:void(0)" class="btn-action btn-edit-eco compact"
                                            data-topic='@json($topic, JSON_HEX_APOS | JSON_HEX_QUOT)'
                                            data-image="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : '' }}"
                                            title="Edit Topic">
                                            <i class="fa-solid fa-pen"></i>
                                            <span class="hidden xs:inline">Edit</span>
                                        </a>

                                        <!-- Delete Topic -->
                                        <form method="POST" action="{{ url('/admin/libraries/' . $topic->id) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this topic?')"
                                                class="btn-action btn-archive compact" title="Delete Topic">
                                                <i class="fa-solid fa-trash"></i>
                                                <span class="hidden xs:inline">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-16">
                                    <div class="py-8">
                                        <i class="fa-solid fa-book-open text-5xl text-[#D8E2CA] mb-4"></i>
                                        <p class="text-[#6A8A52] text-lg font-medium">No topics found</p>
                                        <p class="text-sm text-[#7A8C4F] mt-1">Create your first eco topic to get started
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🌱 ECO ACTIONS GRID -->
            <div id="ecoActionsSection" class="hidden">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-seedling text-[#7F8A4F] text-xl"></i>
                        <div>
                            <h2 class="text-xl font-semibold text-[#4F6B3F]">Eco Actions</h2>
                            <p class="text-sm text-[#6A8A52]">{{ $ecoActions->count() }} actions available</p>
                        </div>
                    </div>
                </div>

                <table class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
                    <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase tracking-wider">
                                Image
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase tracking-wider">
                                Action
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E6EAD7]">

                        @forelse($ecoActions as $action)
                            <tr class="hover:bg-[#FAF8ED] transition-colors duration-200 group">
                                <!-- Image -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <img src="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : asset('images/default-action.jpg') }}"
                                        alt="{{ $action->title }}"
                                        class="w-16 h-16 object-cover rounded-xl border border-[#C8D9B5]">
                                </td>

                                <!-- Title + Description -->
                                <td class="px-6 py-5">
                                    <h3 class="font-semibold text-[#4F6B3F] text-base leading-tight mb-1">
                                        {{ $action->title }}
                                    </h3>
                                    <p class="text-sm text-[#6A8A52] line-clamp-2">
                                        {{ $action->description }}
                                    </p>
                                </td>

                                <!-- Action Buttons (View | Edit | Delete) -->
                                <td class="px-6 py-5 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2">

                                        <!-- View -->
                                        <a href="{{ url('/actions/' . $action->id) }}"
                                            class="btn-action btn-view compact" title="View Action">
                                            <i class="fa-solid fa-eye"></i>
                                            <span class="hidden xs:inline">View</span>
                                        </a>

                                        <!-- Edit (dengan data JSON tetap utuh) -->
                                        <a href="javascript:void(0)" class="btn-action btn-edit-eco-action compact"
                                            data-action='@json($action, JSON_HEX_APOS | JSON_HEX_QUOT)'
                                            data-image="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : '' }}"
                                            title="Edit Action">
                                            <i class="fa-solid fa-pen"></i>
                                            <span class="hidden xs:inline">Edit</span>
                                        </a>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ url('/admin/actions/' . $action->id) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this action?')"
                                                class="btn-action btn-archive compact" title="Delete Action">
                                                <i class="fa-solid fa-trash"></i>
                                                <span class="hidden xs:inline">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-16">
                                    <div class="py-8">
                                        <i class="fa-solid fa-seedling text-5xl text-[#D8E2CA] mb-4"></i>
                                        <p class="text-[#6A8A52] text-lg font-medium">No actions found</p>
                                        <p class="text-sm text-[#7A8C4F] mt-1">Create your first eco action to get started
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Button Styles */
        .btn-eco {
            @apply px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .btn-leaf {
            @apply bg-[#6A8A52] text-white hover:bg-[#5C7919] focus:ring-[#6A8A52];
        }

        .btn-sage {
            @apply bg-[#7A8C4F] text-white hover:bg-[#6A7A45] focus:ring-[#7A8C4F];
        }

        .btn-action {
            @apply px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1;
        }

        .btn-view {
            @apply bg-[#F0F7E6] text-[#4F6B3F] hover:bg-[#E9F0E1] focus:ring-[#4F6B3F];
        }

        .btn-edit {
            @apply bg-[#EFF6FF] text-[#1E40AF] hover:bg-[#DBEAFE] focus:ring-[#1E40AF];
        }

        .btn-archive {
            @apply bg-[#FEF2F2] text-[#DC2626] hover:bg-[#FECACA] focus:ring-[#DC2626];
        }

        .compact {
            @apply px-2.5 py-1.5;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .btn-action span {
                display: none;
            }

            .btn-action {
                @apply px-2 py-2;
            }
        }
    </style>

    <!-- 🌿 Toggle Script -->
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
