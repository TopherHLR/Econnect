@extends('layouts.mainLayout')

@section('content')
    <div class="w-[90%] mx-auto px-12 py-12 mt-15">
        <div class="bg-[#F7F3E7] rounded-4xl shadow-sm border border-green-100 overflow-hidden p-8">
            <!-- Header -->
            <div class="flex items-center justify-between px-2 pt-2 mb-4">
                <h1 class="text-2xl font-serif font-semibold text-[#5C7919]">
                    Climate & Nature Awareness 🌍
                </h1>
            </div>

            <!-- Top Controls Row -->
            <div class="flex justify-between items-start gap-6 px-4 mb-8">
                <!-- Left Column -->
                <div class="flex flex-col flex-1">
                    <!-- Toggle + Search -->
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <!-- iOS-style Toggle -->
                        <div class="relative flex items-center bg-[#5C7919] rounded-full p-3 w-40">
                            <div id="toggle-slider"
                                class="absolute left-1 top-1 w-[calc(50%-0.25rem)] h-[calc(100%-0.5rem)] bg-[#FCFFF6] rounded-full shadow-md transition-all duration-300 ease-in-out">
                            </div>
                            <button id="topicsBtn"
                                class="relative z-10 flex-1 text-center text-sm font-medium text-[#5C7919]"
                                onclick="switchTab('topics')">Topics</button>
                            <button id="actionsBtn"
                                class="relative z-10 flex-1 text-center text-sm font-medium text-[#FCF9EF]"
                                onclick="switchTab('actions')">Actions</button>
                        </div>

                        <!-- Search + Category -->
                        <div class="flex items-center gap-2 flex-1">
                            @php
                                $categories = collect($ecoTopics)
                                    ->pluck('category')
                                    ->merge(collect($ecoActions)->pluck('category'))
                                    ->filter()
                                    ->unique()
                                    ->sort();
                            @endphp
                            <form method="GET" action="{{ route('lifestyle') }}" class="flex items-center gap-2 flex-1">
                                <div class="relative w-full max-w-70">
                                    <input type="text" name="search" placeholder="Search"
                                        value="{{ request('search') }}"
                                        class="bg-[#E0E9D6] w-full pl-3 pr-10 py-2 border border-[#7A8C4F] rounded-full focus:outline-[#7A8C4F] focus:ring-2 focus:ring-[#7A8C4F] text-sm">
                                    <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>

                                <select name="category" id="categoryDropdown"
                                    class="text-sm text-gray-600 bg-[#FCFFF6] border border-[#7A8C4F] rounded-full px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]">
                                    <option value="">All Categories ▾</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}"
                                            {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="hidden">Search</button>
                                <!-- optional if you want enter to submit -->
                            </form>


                            <!-- Category Dropdown -->
                            <select id="categoryDropdown"
                                class="text-sm text-gray-600 bg-[#FCFFF6] border border-[#7A8C4F] rounded-full px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]">
                                <option value="">All Categories ▾</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Scrollable Eco Content -->
                    <div id="ecoContent" class="space-y-4 w-full overflow-y-auto pr-2 custom-scroll max-h-[65vh]">
                        @foreach ($ecoTopics as $topic)
                            <div class="eco-card flex items-start gap-4 p-4 bg-[#FCF9EF] rounded-xl border border-green-100 hover:bg-[#FCFFF6] shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-[1.02] transition-all"
                                data-type="ecoTopic" data-id="{{ $topic->library_id }}"
                                data-category="{{ $topic->category }}">
                                <img src="{{ $topic->image ? Vite::asset('resources/images/eco-library/' . $topic->image) : Vite::asset('resources/images/default.png') }}"
                                    alt="{{ $topic->title }}" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-lg text-[#5C7919] mb-1 cursor-pointer hover:underline"
                                        onclick="openEcoModal('ecoTopic', {{ $topic->library_id }})">{{ $topic->title }}
                                    </h3>
                                    <p
                                        class="text-xs text-gray-500 leading-relaxed line-clamp-3 overflow-hidden text-ellipsis">
                                        {{ $topic->content }}
                                    </p>
                                </div>
                                <form action="{{ route('libraries.save', ['id' => $topic->library_id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="ecoTopic">
                                    <button type="submit"
                                        class="save-btn text-gray-400 hover:text-yellow-500 flex-shrink-0">
                                        <svg class="w-5 h-5 {{ Auth::user() && Auth::user()->savedLibraries()->where('library_id', $topic->library_id)->exists() ? 'text-yellow-500 fill-current' : 'text-gray-400' }}"
                                            viewBox="0 0 24 24"
                                            {{ Auth::user() && Auth::user()->savedLibraries()->where('library_id', $topic->library_id)->exists() ? 'fill="currentColor"' : 'fill="none" stroke="currentColor"' }}>
                                            <path
                                                {{ Auth::user() && Auth::user()->savedLibraries()->where('library_id', $topic->library_id)->exists() ? '' : 'stroke-linecap="round" stroke-linejoin="round" stroke-width="2"' }}
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- END Left Column -->

                <!-- Sidebar -->
                <div id="ecoSidebar"
                    class="w-[32rem] flex-shrink-0 bg-[#FCF9EF] rounded-xl p-6 border border-green-100 max-h-[80vh] overflow-y-auto overflow-x-hidden custom-scroll shadow-[0_8px_20px_#7A8C4F]/70">
                    <h2 class="text-lg font-semibold text-[#5C7919] mb-4" id="sidebarTitle">Saved Eco-topics</h2>
                    <div class="space-y-3" id="savedList">
                        @foreach ($savedTopics as $saved)
                            <div class="flex items-center justify-between p-2 bg-[#FCFFF6] rounded-lg border border-green-100 saved-item hover:scale-105 transition min-w-0"
                                data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                                data-category="{{ $saved->category }}">
                                <div class="flex items-center">
                                    <img src="{{ $saved->image ? Vite::asset('resources/images/eco-' . ($saved->type === 'ecoTopic' ? 'library' : 'actions') . '/' . $saved->image) : Vite::asset('resources/images/default.png') }}"
                                        alt="{{ $saved->title }}"
                                        class="w-10 h-10 object-cover rounded-md mr-3 flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                                            onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                            {{ $saved->title }}
                                        </h4>

                                    </div>
                                </div>
                                <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="unsave-btn text-yellow-500 hover:text-red-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- END Sidebar -->
            </div> <!-- END Top Controls Row -->

            <!-- Motivational Quote -->
            <div class="mt-6 text-center text-sm text-gray-500 italic">
                “You don’t have to know everything today — one tip at a time is enough.”
            </div>

            @include('modal.ecoDetailModal')
        </div>
    </div>

    <!-- Script -->
    <script>
        let currentTab = 'topics';
        let currentCategory = '';
        let currentItemId = null;
        let currentItemType = null;

        // 🌱 Apply category filter
        function applyCategoryFilter() {
            const contentItems = document.querySelectorAll('#ecoContent .eco-card');
            const savedItems = document.querySelectorAll('#savedList .saved-item');

            contentItems.forEach(item => {
                const category = item.dataset.category || '';
                item.style.display = currentCategory === '' || category === currentCategory ? 'flex' : 'none';
            });

            savedItems.forEach(item => {
                const category = item.dataset.category || '';
                item.style.display = currentCategory === '' || category === currentCategory ? 'flex' : 'none';
            });
        }

        // 🌱 Switch tab
        function switchTab(tab) {
            currentTab = tab;
            const slider = document.getElementById('toggle-slider');
            const topicsBtn = document.getElementById('topicsBtn');
            const actionsBtn = document.getElementById('actionsBtn');
            const content = document.getElementById('ecoContent');
            const sidebarTitle = document.getElementById('sidebarTitle');
            const savedList = document.getElementById('savedList');

            if (tab === 'topics') {
                slider.style.transform = 'translateX(0)';
                topicsBtn.style.color = '#7A8C4F';
                actionsBtn.style.color = '#FCF9EF';
                sidebarTitle.textContent = 'Saved Eco-topics';
                content.innerHTML = `@foreach ($ecoTopics as $topic)
                    <div class="eco-card flex items-start gap-4 p-4 bg-[#FCF9EF] rounded-xl border border-green-100 hover:bg-[#FCFFF6] shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-[1.02] transition-all"
                         data-type="ecoTopic"
                         data-id="{{ $topic->library_id }}"
                         data-category="{{ $topic->category }}">
                        <img src="{{ $topic->image ? Vite::asset('resources/images/eco-library/' . $topic->image) : Vite::asset('resources/images/default.png') }}"
                             alt="{{ $topic->title }}"
                             class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-lg text-[#5C7919] mb-1 cursor-pointer hover:underline"
                                onclick="openEcoModal('ecoTopic', {{ $topic->library_id }})">{{ $topic->title }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 overflow-hidden text-ellipsis">
                                {{ $topic->content }}
                            </p>
                        </div>
                        <form action="{{ route('libraries.save', ['id' => $topic->library_id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="ecoTopic">
                            <button type="submit" class="save-btn text-gray-400 hover:text-yellow-500 flex-shrink-0">
                                <svg class="w-5 h-5 {{ Auth::user() && Auth::user()->savedLibraries()->where('library_id', $topic->library_id)->exists() ? 'text-yellow-500 fill-current' : 'text-gray-400' }}"
                                     viewBox="0 0 24 24"
                                     {{ Auth::user() && Auth::user()->savedLibraries()->where('library_id', $topic->library_id)->exists() ? 'fill="currentColor"' : 'fill="none" stroke="currentColor"' }}>
                                    <path {{ Auth::user() && Auth::user()->savedLibraries()->where('library_id', $topic->library_id)->exists() ? '' : 'stroke-linecap="round" stroke-linejoin="round" stroke-width="2"' }}
                                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach`;
                savedList.innerHTML = `@foreach ($savedTopics as $saved)
                    @if ($saved->type === 'ecoTopic')
                    <div class="flex items-center justify-between p-2 bg-[#FCFFF6] rounded-lg border border-green-100 saved-item hover:scale-105 transition min-w-0"
                        data-type="{{ $saved->type }}"
                        data-id="{{ $saved->id }}"
                        data-category="{{ $saved->category }}">
                        <div class="flex items-center">
                            <img src="{{ $saved->image ? Vite::asset('resources/images/eco-library/' . $saved->image) : Vite::asset('resources/images/default.png') }}"
                                alt="{{ $saved->title }}"
                                class="w-10 h-10 object-cover rounded-md mr-3 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                                    onclick="openEcoModal('{{ $saved->type }}', {{ $saved->id }})">
                                    {{ $saved->title }}
                                </h4>
                            </div>
                        </div>
                        <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="unsave-btn text-yellow-500 hover:text-red-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif
                @endforeach`;
            } else {
                slider.style.transform = 'translateX(100%)';
                actionsBtn.style.color = '#7A8C4F';
                topicsBtn.style.color = '#FCF9EF';
                sidebarTitle.textContent = 'Saved Eco-actions';
                content.innerHTML = `@foreach ($ecoActions as $action)
                    <div class="eco-card flex items-start gap-4 p-4 bg-[#FCF9EF] rounded-xl border border-green-100 hover:bg-[#FCFFF6] shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-[1.02] transition-all"
                         data-type="ecoAction"
                         data-id="{{ $action->action_id }}"
                         data-category="{{ $action->category }}">
                        <img src="{{ $action->image ? Vite::asset('resources/images/eco-actions/' . $action->image) : Vite::asset('resources/images/default.png') }}"
                             alt="{{ $action->title }}"
                             class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-lg text-[#5C7919] mb-1 cursor-pointer hover:underline"
                                onclick="openEcoModal('ecoAction', {{ $action->action_id }})">{{ $action->title }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 overflow-hidden text-ellipsis">
                                {{ $action->description }}
                            </p>
                        </div>
                        <form action="{{ route('libraries.save', ['id' => $action->action_id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="ecoAction">
                            <button type="submit" class="save-btn text-gray-400 hover:text-yellow-500 flex-shrink-0">
                                <svg class="w-5 h-5 {{ Auth::user() && Auth::user()->savedEcoActions()->where('action_id', $action->action_id)->exists() ? 'text-yellow-500 fill-current' : 'text-gray-400' }}"
                                     viewBox="0 0 24 24"
                                     {{ Auth::user() && Auth::user()->savedEcoActions()->where('action_id', $action->action_id)->exists() ? 'fill="currentColor"' : 'fill="none" stroke="currentColor"' }}>
                                    <path {{ Auth::user() && Auth::user()->savedEcoActions()->where('action_id', $action->action_id)->exists() ? '' : 'stroke-linecap="round" stroke-linejoin="round" stroke-width="2"' }}
                                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach`;
                savedList.innerHTML = `@foreach ($savedTopics as $saved)
                    @if ($saved->type === 'ecoAction')
                    <div class="flex items-center justify-between p-2 bg-[#FCFFF6] rounded-lg border border-green-100 saved-item hover:scale-105 transition min-w-0"
                        data-type="{{ $saved->type }}"
                        data-id="{{ $saved->id }}"
                        data-category="{{ $saved->category }}">
                        <div class="flex items-center">
                            <img src="{{ $saved->image ? Vite::asset('resources/images/eco-actions/' . $saved->image) : Vite::asset('resources/images/default.png') }}"
                                alt="{{ $saved->title }}"
                                class="w-10 h-10 object-cover rounded-md mr-3 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                                    onclick="openEcoModal('{{ $saved->type }}', {{ $saved->id }})">
                                    {{ $saved->title }}
                                </h4>
                            </div>
                        </div>
                        <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="unsave-btn text-yellow-500 hover:text-red-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif
                @endforeach`;

            }

            applyCategoryFilter();
        }
        // ✅ Activate tab based on URL query
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');

            if (tab === 'actions' || tab === 'topics') {
                switchTab(tab); // call your existing function
            } else {
                switchTab('topics'); // default
            }
        });
        // 🌱 Category dropdown change
        document.getElementById('categoryDropdown').addEventListener('change', function() {
            currentCategory = this.value;
            applyCategoryFilter();
        });
    </script>
@endsection
