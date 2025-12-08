@extends('layouts.mainLayout')
@section('title', 'lifestyle')
@section('content')
    <div class="min-h-screen  bg-[#E2EBD7] p-4 md:p-10 text-[#4F6B3F]">
        <div class="bg-[#F7F3E7] mt-2 rounded-2xl sm:rounded-4xl shadow-sm overflow-hidden p-4 sm:p-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-2 pt-2 mb-4">
                <h1 class="text-4xl ml-5 font-serif font-bold text-[#4F6B3F]">Lifestyle</h1>
                <div class="hidden sm:block h-8 w-px bg-[#8A9A7B]/50"></div>
                <p class="font-sans text-[#6A8A52] sm:mt-0 mt-1">
                    Mindful living through habits, choices, and daily experiences.
                </p>
                {{-- Mobile Saved Button in Header --}}
                @auth
                    <button onclick="toggleMobileSaved()"
                        class="lg:hidden flex  justify-center items-center gap-2 px-3 py-2 bg-[#5C7919] text-[#FCFFF6] rounded-full text-sm font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Saved
                    </button>
                @endauth
            </div>

            {{-- Top Controls Row – stacked on mobile --}}
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-6 px-2 sm:px-4 mb-6 sm:mb-8">

                {{-- LEFT COLUMN (topics / actions list) --}}
                <div class="flex flex-col w-full lg:flex-1">

                    {{-- Toggle + Search --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">

                        {{-- iOS-style Toggle --}}
                        <div class="relative flex items-center bg-[#5C7919] rounded-xl p-1 w-full sm:w-40">
                            <div id="toggle-slider"
                                class="absolute left-1 top-1 w-[calc(50%-0.25rem)] h-[calc(100%-0.5rem)] bg-white rounded-xl shadow-md transition-all duration-300 ease-in-out">
                            </div>
                            <button id="topicsBtn"
                                class="relative z-10 flex-1 text-center text-sm font-medium text-[#5C7919] py-"
                                onclick="switchTab('topics')">Topics</button>
                            <button id="actionsBtn"
                                class="relative z-10 flex-1 text-center text-sm font-medium text-[#FCF9EF] py-2"
                                onclick="switchTab('actions')">Actions</button>
                        </div>

                        {{-- Search + Category --}}
                        <div class="flex flex-col sm:flex-row gap-3 w-full">
                            @php
                                $categories = collect($ecoTopics)
                                    ->pluck('category')
                                    ->merge(collect($ecoActions)->pluck('category'))
                                    ->filter()
                                    ->unique()
                                    ->sort();
                            @endphp

                            <div class="relative w-full">
                                <input type="text" id="liveSearchInput" placeholder="Search topics & actions..."
                                    value="{{ request('search') }}"
                                    class="bg-[#E0E9D6] w-full pl-3 pr-10 py-2.5 border border-[#7A8C4F] rounded-xl focus:outline-[#7A8C4F] focus:ring-2 focus:ring-[#7A8C4F] text-sm"
                                    autocomplete="off">
                                <svg class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <select name="category" id="categoryDropdown"
                                class="text-sm text-gray-600 bg-white border border-[#7A8C4F] rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] w-full sm:w-auto">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"
                                        {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Scrollable Eco Content --}}
  {{-- Scrollable Eco Content - FIXED FOR MOBILE --}}
<div id="ecoContent"
    class="space-y-4 w-full max-h-[55vh] sm:max-h-[65vh] overflow-y-auto touch-scroll">
    @foreach ($ecoTopics as $topic)
                            <div class="eco-card flex flex-col sm:flex-row items-start gap-4 p-4 bg-[#FCF9EF] rounded-xl  hover:bg-white shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-[1.02] transform-gpu transition-all"
                                data-type="ecoTopic" data-id="{{ $topic->library_id }}"
                                data-category="{{ $topic->category }}">
                                <img src="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : asset('storage/default.png') }}"
                                    alt="{{ $topic->title }}" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-base sm:text-lg text-[#5C7919] mb-1 cursor-pointer hover:underline"
                                        onclick="openEcoModal('ecoTopic', {{ $topic->library_id }})">{{ $topic->title }}
                                    </h3>
                                    <p
                                        class="text-xs text-gray-500 leading-relaxed line-clamp-3 overflow-hidden text-ellipsis">
                                        {{ $topic->content }}</p>
                                </div>
                                @auth
                                    <form action="{{ route('libraries.save', ['id' => $topic->library_id]) }}" method="POST"
                                        class="mt-2 sm:mt-0">
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
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- END LEFT COLUMN --}}

                {{-- Sidebar / Saved Items Panel --}}
                @auth
                    {{-- Desktop Sidebar --}}
                    <div id="ecoSidebarDesktop"
                        class="hidden lg:block w-full lg:w-[32rem] flex-shrink-0 bg-[#FCF9EF] rounded-xl p-6 min-h-[70vh] overflow-y-auto custom-scroll shadow-[0_8px_10px_#7A8C4F]/60">
                        <h2 class="text-2xl font-serif font-bold text-[#5C7919] mb-4" id="sidebarTitle">Saved Eco-topics</h2>
                        <div class="space-y-3" id="savedList">
                            @php
                                $savedTopicsCount = count($savedTopics);
                                $savedEcoTopicsCount = count($savedTopics->where('type', 'ecoTopic'));
                                $savedEcoActionsCount = count($savedTopics->where('type', 'ecoAction'));
                            @endphp

                            {{-- Check if current tab is Topics or Actions --}}
                            @if (($currentTab ?? 'topics') === 'topics')
                                {{-- For Eco-topics --}}
                                @if ($savedEcoTopicsCount === 0)
                                    <div class="text-center py-8 h-full flex flex-col items-center justify-center">
                                        <div
                                            class="mx-auto w-20 h-20 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-[#7A8C4F]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-gray-600 font-medium mb-2">No saved topics yet</h3>
                                        <p class="text-sm text-gray-500 mb-4">Start exploring and save your favorite eco topics!
                                        </p>
                                        <div class="bg-[#F0F5E9] p-4 rounded-lg w-full">
                                            <p class="text-xs text-[#5C7919] italic">💡 Tip: Browse topics and click the
                                                bookmark icon to save them here</p>
                                        </div>
                                    </div>
                                @elseif($savedEcoTopicsCount < 4)
                                    {{-- Show saved topics with filler encouragement --}}
                                    @foreach ($savedTopics as $saved)
                                        @if ($saved->type === 'ecoTopic')
                                            <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item hover:scale-[1.02] transition min-w-0"
                                                data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                                                data-category="{{ $saved->category }}">
                                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                                    <img src="{{ $saved->image ? asset('storage/eco-' . ($saved->type === 'ecoTopic' ? 'library' : 'actions') . '/' . $saved->image) : asset('storage/default.png') }}"
                                                        alt="{{ $saved->title }}"
                                                        class="w-10 h-10 object-cover rounded-md flex-shrink-0">
                                                    <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                                                        onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                        {{ $saved->title }}
                                                    </h4>
                                                </div>
                                                <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="unsave-btn text-yellow-500 hover:text-red-500 ml-2">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    {{-- 4 or more saved topics - just show the list with scroll --}}
                                    @foreach ($savedTopics as $saved)
                                        @if ($saved->type === 'ecoTopic')
                                            <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item hover:scale-[1.02] transition min-w-0"
                                                data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                                                data-category="{{ $saved->category }}">
                                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                                    <img src="{{ $saved->image ? asset('storage/eco-' . ($saved->type === 'ecoTopic' ? 'library' : 'actions') . '/' . $saved->image) : asset('storage/default.png') }}"
                                                        alt="{{ $saved->title }}"
                                                        class="w-10 h-10 object-cover rounded-md flex-shrink-0">
                                                    <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                                                        onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                        {{ $saved->title }}
                                                    </h4>
                                                </div>
                                                <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="unsave-btn text-yellow-500 hover:text-red-500 ml-2">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                {{-- For Eco-actions --}}
                                @if ($savedEcoActionsCount === 0)
                                    <div class="text-center py-8 h-full flex flex-col items-center justify-center">
                                        <div
                                            class="mx-auto w-20 h-20 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-[#7A8C4F]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-gray-600 font-medium mb-2">No saved actions yet</h3>
                                        <p class="text-sm text-gray-500 mb-4">Discover and save actionable eco tips!</p>
                                        <div class="bg-[#F0F5E9] p-4 rounded-lg w-full">
                                            <p class="text-xs text-[#5C7919] italic">💡 Tip: Browse actions and click the
                                                bookmark icon to save them here</p>
                                        </div>
                                    </div>
                                @elseif($savedEcoActionsCount < 4)
                                    {{-- Show saved actions with filler encouragement --}}
                                    @foreach ($savedTopics as $saved)
                                        @if ($saved->type === 'ecoAction')
                                            <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item hover:scale-[1.02] transition min-w-0"
                                                data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                                                data-category="{{ $saved->category }}">
                                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                                    <img src="{{ $saved->image ? asset('storage/eco-actions/' . $saved->image) : asset('storage/default.png') }}"
                                                        alt="{{ $saved->title }}"
                                                        class="w-10 h-10 object-cover rounded-md flex-shrink-0">
                                                    <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                                                        onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                        {{ $saved->title }}
                                                    </h4>
                                                </div>
                                                <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="unsave-btn text-yellow-500 hover:text-red-500 ml-2">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    {{-- 4 or more saved actions - just show the list with scroll --}}
                                    @foreach ($savedTopics as $saved)
                                        @if ($saved->type === 'ecoAction')
                                            <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item hover:scale-[1.02] transition min-w-0"
                                                data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                                                data-category="{{ $saved->category }}">
                                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                                    <img src="{{ $saved->image ? asset('storage/eco-actions/' . $saved->image) : asset('storage/default.png') }}"
                                                        alt="{{ $saved->title }}"
                                                        class="w-10 h-10 object-cover rounded-md flex-shrink-0">
                                                    <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                                                        onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                        {{ $saved->title }}
                                                    </h4>
                                                </div>
                                                <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="unsave-btn text-yellow-500 hover:text-red-500 ml-2">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Mobile Sidebar Overlay --}}
                    <div id="mobileOverlayLifestyle"
                        class="lg:hidden fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300"
                        onclick="closeMobileSaved()"></div>

                    {{-- Mobile Sidebar Panel --}}
                    <div id="ecoSidebarMobile"
                        class="lg:hidden fixed left-0 top-0 h-full w-[85vw] max-w-sm bg-[#FCF9EF] z-[1200] transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl">

                        {{-- Mobile Header --}}
                        <div class="sticky top-0 bg-[#FCF9EF] p-4 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-[#5C7919]" id="mobileSidebarTitle">Saved Eco-topics</h2>
                            <button onclick="closeMobileSaved()" class="p-2 rounded-full hover:bg-[#E0E9D6]">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <hr class="border-[#5C7919]">

                        {{-- Mobile Content --}}
                        <div class="p-4 overflow-y-auto h-[calc(100%-4rem)]">
                            <div class="space-y-3" id="mobileSavedList">
                                @php
                                    $savedTopicsCount = count($savedTopics);
                                    $savedEcoTopicsCount = count($savedTopics->where('type', 'ecoTopic'));
                                    $savedEcoActionsCount = count($savedTopics->where('type', 'ecoAction'));
                                @endphp

                                {{-- Check if current tab is Topics or Actions --}}
                                @if (($currentTab ?? 'topics') === 'topics')
                                    {{-- For Eco-topics --}}
                                    @if ($savedEcoTopicsCount === 0)
                                        <div class="text-center py-8">
                                            <div
                                                class="mx-auto w-16 h-16 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-[#7A8C4F]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-gray-600 font-medium mb-2">No saved topics yet</h3>
                                            <p class="text-sm text-gray-500">Save topics to see them here</p>
                                        </div>
                                    @elseif($savedEcoTopicsCount < 4)
                                        {{-- Show saved topics with filler encouragement --}}
                                        @foreach ($savedTopics as $saved)
                                            @if ($saved->type === 'ecoTopic')
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item active:scale-[0.98] transition"
                                                    data-type="{{ $saved->type ?? 'ecoTopic' }}"
                                                    data-id="{{ $saved->id }}" data-category="{{ $saved->category }}">
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        <img src="{{ $saved->image ? asset('storage/eco-' . ($saved->type === 'ecoTopic' ? 'library' : 'actions') . '/' . $saved->image) : asset('storage/default.png') }}"
                                                            alt="{{ $saved->title }}"
                                                            class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="text-sm font-medium text-[#5C7919] truncate"
                                                                onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                                {{ $saved->title }}
                                                            </h4>
                                                            <p class="text-xs text-gray-500 truncate">
                                                                {{ $saved->category ?? 'Uncategorized' }}</p>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="unsave-btn text-yellow-500 hover:text-red-500 p-1">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        {{-- 4 or more saved topics - just show the list --}}
                                        @foreach ($savedTopics as $saved)
                                            @if ($saved->type === 'ecoTopic')
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item active:scale-[0.98] transition"
                                                    data-type="{{ $saved->type ?? 'ecoTopic' }}"
                                                    data-id="{{ $saved->id }}" data-category="{{ $saved->category }}">
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        <img src="{{ $saved->image ? asset('storage/eco-' . ($saved->type === 'ecoTopic' ? 'library' : 'actions') . '/' . $saved->image) : asset('storage/default.png') }}"
                                                            alt="{{ $saved->title }}"
                                                            class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="text-sm font-medium text-[#5C7919] truncate"
                                                                onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                                {{ $saved->title }}
                                                            </h4>
                                                            <p class="text-xs text-gray-500 truncate">
                                                                {{ $saved->category ?? 'Uncategorized' }}</p>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="unsave-btn text-yellow-500 hover:text-red-500 p-1">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @else
                                    {{-- For Eco-actions --}}
                                    @if ($savedEcoActionsCount === 0)
                                        <div class="text-center py-8">
                                            <div
                                                class="mx-auto w-16 h-16 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-[#7A8C4F]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-gray-600 font-medium mb-2">No saved actions yet</h3>
                                            <p class="text-sm text-gray-500">Save actions to see them here</p>
                                        </div>
                                    @elseif($savedEcoActionsCount < 4)
                                        {{-- Show saved actions with filler encouragement --}}
                                        @foreach ($savedTopics as $saved)
                                            @if ($saved->type === 'ecoAction')
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item active:scale-[0.98] transition"
                                                    data-type="{{ $saved->type ?? 'ecoTopic' }}"
                                                    data-id="{{ $saved->id }}" data-category="{{ $saved->category }}">
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        <img src="{{ $saved->image ? asset('storage/eco-actions/' . $saved->image) : asset('storage/default.png') }}"
                                                            alt="{{ $saved->title }}"
                                                            class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="text-sm font-medium text-[#5C7919] truncate"
                                                                onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                                {{ $saved->title }}
                                                            </h4>
                                                            <p class="text-xs text-gray-500 truncate">
                                                                {{ $saved->category ?? 'Uncategorized' }}</p>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="unsave-btn text-yellow-500 hover:text-red-500 p-1">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endforeach

                                        {{-- Filler encouragement --}}
                                        <div
                                            class="bg-gradient-to-r from-[#F0F5E9] to-[#E8F0E1] p-4 rounded-lg border-2 border-dashed border-[#7A8C4F]/30 mt-4">
                                            <div class="text-center">
                                                <div
                                                    class="w-10 h-10 bg-[#7A8C4F]/20 rounded-full flex items-center justify-center mx-auto mb-2">
                                                    <svg class="w-5 h-5 text-[#5C7919]" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                                                    </svg>
                                                </div>
                                                <h4 class="font-medium text-[#5C7919] text-sm mb-1">Save
                                                    {{ 4 - $savedEcoActionsCount }} more!</h4>
                                                <p class="text-xs text-gray-600">Build your actionable eco tips collection</p>
                                            </div>
                                        </div>
                                    @else
                                        {{-- 4 or more saved actions - just show the list --}}
                                        @foreach ($savedTopics as $saved)
                                            @if ($saved->type === 'ecoAction')
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item active:scale-[0.98] transition"
                                                    data-type="{{ $saved->type ?? 'ecoTopic' }}"
                                                    data-id="{{ $saved->id }}" data-category="{{ $saved->category }}">
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        <img src="{{ $saved->image ? asset('storage/eco-actions/' . $saved->image) : asset('storage/default.png') }}"
                                                            alt="{{ $saved->title }}"
                                                            class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="text-sm font-medium text-[#5C7919] truncate"
                                                                onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                                                {{ $saved->title }}
                                                            </h4>
                                                            <p class="text-xs text-gray-500 truncate">
                                                                {{ $saved->category ?? 'Uncategorized' }}</p>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="unsave-btn text-yellow-500 hover:text-red-500 p-1">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endauth
            </div> {{-- This closes the flex container --}}

            {{-- Motivational Quote (centered) --}}
            <div class="mt-6 text-center text-sm text-gray-500 italic">
                "You don't have to know everything today — one tip at a time is enough."
            </div>

            @include('modal.ecoDetailModal')
        </div>
    </div>
    <!-- Script -->

  
    <script>
        // Mobile sidebar functions
        function toggleMobileSaved() {
            const mobileSidebar = document.getElementById('ecoSidebarMobile');
            const overlay = document.getElementById('mobileOverlayLifestyle');

            mobileSidebar.classList.toggle('-translate-x-full'); // off-screen left
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        function closeMobileSaved() {
            const mobileSidebar = document.getElementById('ecoSidebarMobile');
            const overlay = document.getElementById('mobileOverlayLifestyle');

            mobileSidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeMobileSaved();
            }
        });

        // Close sidebar when clicking outside on mobile
        document.getElementById('mobileOverlayLifestyle')?.addEventListener('click', closeMobileSaved)
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

            // Clear search input and reset category filter on tab switch
            const searchInput = document.getElementById('liveSearchInput');
            const categoryDropdown = document.getElementById('categoryDropdown');

            if (searchInput) {
                searchInput.value = ''; // Clear search
            }
            if (categoryDropdown) {
                categoryDropdown.value = ''; // Reset to "All Categories"
            }

            currentCategory = ''; // Reset internal category filter
            const slider = document.getElementById('toggle-slider');
            const topicsBtn = document.getElementById('topicsBtn');
            const actionsBtn = document.getElementById('actionsBtn');
            const content = document.getElementById('ecoContent');
            const sidebarTitle = document.getElementById('sidebarTitle');
            const savedList = document.getElementById('savedList');
            const mobileSidebarTitle = document.getElementById('mobileSidebarTitle');
            const mobileSavedList = document.getElementById('mobileSavedList');

            if (tab === 'topics') {
                slider.style.transform = 'translateX(0)';
                topicsBtn.style.color = '#7A8C4F';
                actionsBtn.style.color = '#FCF9EF';

                // Update both desktop and mobile sidebar titles
                if (sidebarTitle) sidebarTitle.textContent = 'Saved Eco-topics';
                if (mobileSidebarTitle) mobileSidebarTitle.textContent = 'Saved Eco-topics';

                // Update main content
                content.innerHTML = `@foreach ($ecoTopics as $topic)
            <div class="eco-card flex flex-col sm:flex-row items-start gap-4 p-4 bg-[#FCF9EF] rounded-xl  hover:bg-white shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-[1.02] transform-gpu transition-all"
                data-type="ecoTopic" data-id="{{ $topic->library_id }}"
                data-category="{{ $topic->category }}">
                <img src="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : asset('storage/default.png') }}"
                    alt="{{ $topic->title }}" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-base sm:text-lg text-[#5C7919] mb-1 cursor-pointer hover:underline"
                        onclick="openEcoModal('ecoTopic', {{ $topic->library_id }})">{{ $topic->title }}
                    </h3>
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 overflow-hidden text-ellipsis">
                        {{ $topic->content }}</p>
                </div>
                @auth
                    <form action="{{ route('libraries.save', ['id' => $topic->library_id]) }}" method="POST"
                        class="mt-2 sm:mt-0">
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
                @endauth
            </div>
        @endforeach`;

                // Update desktop saved list
                savedList.innerHTML = `@foreach ($savedTopics as $saved)
            @if ($saved->type === 'ecoTopic')
            <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item hover:scale-[1.02] transition min-w-0"
                data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                data-category="{{ $saved->category }}">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <img src="{{ $saved->image ? asset('storage/eco-' . ($saved->type === 'ecoTopic' ? 'library' : 'actions') . '/' . $saved->image) : asset('storage/default.png') }}"
                        alt="{{ $saved->title }}" class="w-10 h-10 object-cover rounded-md flex-shrink-0">
                    <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                        onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                        {{ $saved->title }}
                    </h4>
                </div>
                <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="unsave-btn text-yellow-500 hover:text-red-500 ml-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </button>
                </form>
            </div>
            @endif
        @endforeach`;

                // Add empty state if no saved topics
                const savedTopicsCount = @json(count($savedTopics->where('type', 'ecoTopic')));
                if (savedTopicsCount === 0) {
                    savedList.innerHTML = `
                    <div class="text-center py-8 h-full flex flex-col items-center justify-center">
                        <div class="mx-auto w-20 h-20 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-[#7A8C4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </div>
                        <h3 class="text-gray-600 font-medium mb-2">No saved topics yet</h3>
                        <p class="text-sm text-gray-500 mb-4">Start exploring and save your favorite eco topics!</p>
                        <div class="bg-[#F0F5E9] p-4 rounded-lg w-full">
                            <p class="text-xs text-[#5C7919] italic">💡 Tip: Browse topics and click the bookmark icon to save them here</p>
                        </div>
                    </div>`;
                }

                // Update mobile saved list
                if (mobileSavedList) {
                    mobileSavedList.innerHTML = `@foreach ($savedTopics as $saved)
                @if ($saved->type === 'ecoTopic')
                <div class="flex items-center justify-between p-3 bg-white rounded-lg  saved-item active:scale-[0.98] transition"
                    data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                    data-category="{{ $saved->category }}">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <img src="{{ $saved->image ? asset('storage/eco-' . ($saved->type === 'ecoTopic' ? 'library' : 'actions') . '/' . $saved->image) : asset('storeage/default.png') }}"
                            alt="{{ $saved->title }}"
                            class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-[#5C7919] truncate"
                                onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                {{ $saved->title }}
                            </h4>
                            <p class="text-xs text-gray-500 truncate">
                                {{ $saved->category ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="unsave-btn text-yellow-500 hover:text-red-500 p-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </button>
                    </form>
                </div>
                @endif
            @endforeach
            
            @if (count($savedTopics->where('type', 'ecoTopic')) === 0)
                <div class="text-center py-8">
                    <div class="mx-auto w-16 h-16 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-[#7A8C4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 font-medium mb-2">No saved topics yet</h3>
                    <p class="text-sm text-gray-500">Save topics to see them here</p>
                </div>
            @endif`;
                }
            } else {
                slider.style.transform = 'translateX(100%)';
                actionsBtn.style.color = '#7A8C4F';
                topicsBtn.style.color = '#FCF9EF';

                // Update both desktop and mobile sidebar titles
                if (sidebarTitle) sidebarTitle.textContent = 'Saved Eco-actions';
                if (mobileSidebarTitle) mobileSidebarTitle.textContent = 'Saved Eco-actions';

                // Update main content
                content.innerHTML = `@foreach ($ecoActions as $action)
            <div class="eco-card flex flex-col sm:flex-row items-start gap-4 p-4 bg-[#FCF9EF] rounded-xl  hover:bg-white shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-[1.02] transform-gpu transition-all"
                data-type="ecoAction"
                data-id="{{ $action->action_id }}"
                data-category="{{ $action->category }}">
                <img src="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : asset('storage/default.png') }}"
                    alt="{{ $action->title }}"
                    class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-base sm:text-lg text-[#5C7919] mb-1 cursor-pointer hover:underline"
                        onclick="openEcoModal('ecoAction', {{ $action->action_id }})">{{ $action->title }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 overflow-hidden text-ellipsis">
                        {{ $action->description }}
                    </p>
                </div>
                @auth
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
                @endauth
            </div>
        @endforeach`;

                // Update desktop saved list
                savedList.innerHTML = `@foreach ($savedTopics as $saved)
            @if ($saved->type === 'ecoAction')
            <div class="flex items-center justify-between p-3 bg-white rounded-lg saved-item hover:scale-[1.02] transition min-w-0"
                data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                data-category="{{ $saved->category }}">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <img src="{{ $saved->image ? asset('storage/eco-actions/' . $saved->image) : asset('storage/default.png') }}"
                        alt="{{ $saved->title }}" class="w-10 h-10 object-cover rounded-md flex-shrink-0">
                    <h4 class="text-sm font-medium text-[#5C7919] truncate cursor-pointer hover:underline"
                        onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                        {{ $saved->title }}
                    </h4>
                </div>
                <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="unsave-btn text-yellow-500 hover:text-red-500 ml-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </button>
                </form>
            </div>
            @endif
        @endforeach`;

                // Add empty state if no saved actions
                const savedActionsCount = @json(count($savedTopics->where('type', 'ecoAction')));
                if (savedActionsCount === 0) {
                    savedList.innerHTML = `
                    <div class="text-center py-8 h-full flex flex-col items-center justify-center">
                        <div class="mx-auto w-20 h-20 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-[#7A8C4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </div>
                        <h3 class="text-gray-600 font-medium mb-2">No saved actions yet</h3>
                        <p class="text-sm text-gray-500 mb-4">Discover and save actionable eco tips!</p>
                        <div class="bg-[#F0F5E9] p-4 rounded-lg w-full">
                            <p class="text-xs text-[#5C7919] italic">💡 Tip: Browse actions and click the bookmark icon to save them here</p>
                        </div>
                    </div>`;
                }

                // Update mobile saved list
                if (mobileSavedList) {
                    mobileSavedList.innerHTML = `@foreach ($savedTopics as $saved)
                @if ($saved->type === 'ecoAction')
                <div class="flex items-center justify-between p-3 bg-white rounded-lg  saved-item active:scale-[0.98] transition"
                    data-type="{{ $saved->type ?? 'ecoTopic' }}" data-id="{{ $saved->id }}"
                    data-category="{{ $saved->category }}">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <img src="{{ $saved->image ? asset('storage/eco-actions/' . $saved->image) : asset('storeage/default.png') }}"
                            alt="{{ $saved->title }}"
                            class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-[#5C7919] truncate"
                                onclick="openEcoModal('{{ $saved->type ?? 'ecoTopic' }}', {{ $saved->id }})">
                                {{ $saved->title }}
                            </h4>
                            <p class="text-xs text-gray-500 truncate">
                                {{ $saved->category ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('libraries.unsave', ['id' => $saved->id]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="unsave-btn text-yellow-500 hover:text-red-500 p-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </button>
                    </form>
                </div>
                @endif
            @endforeach
            
            @if (count($savedTopics->where('type', 'ecoAction')) === 0)
                <div class="text-center py-8">
                    <div class="mx-auto w-16 h-16 bg-[#E0E9D6] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-[#7A8C4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 font-medium mb-2">No saved actions yet</h3>
                    <p class="text-sm text-gray-500">Save actions to see them here</p>
                </div>
            @endif`;
                }
            }

            applyCategoryFilter();
        }
        // ✅ Activate tab based on URL query
        // Live Search + Category Filter (Instant Results)
        let searchTimeout;

        document.getElementById('liveSearchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performLiveSearch();
            }, 300); // Wait 300ms after user stops typing
        });

        document.getElementById('categoryDropdown').addEventListener('change', function() {
            currentCategory = this.value;
            performLiveSearch(); // Also trigger search when category changes
        });

        // Main live search function
        function performLiveSearch() {
            const query = document.getElementById('liveSearchInput').value.trim().toLowerCase();
            currentCategory = document.getElementById('categoryDropdown').value;

            const cards = document.querySelectorAll('#ecoContent .eco-card');
            const savedItems = document.querySelectorAll('#savedList .saved-item');

            let visibleCount = 0;

            // Filter main content cards
            cards.forEach(card => {
                const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const description = card.querySelector('p')?.textContent.toLowerCase() || '';
                const category = card.dataset.category || '';

                const matchesSearch = title.includes(query) || description.includes(query);
                const matchesCategory = currentCategory === '' || category === currentCategory;

                if (matchesSearch && matchesCategory) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Filter saved items (only if sidebar exists)
            if (savedItems.length > 0) {
                savedItems.forEach(item => {
                    const title = item.querySelector('h4')?.textContent.toLowerCase() || '';
                    const category = item.dataset.category || '';

                    const matchesSearch = title.includes(query);
                    const matchesCategory = currentCategory === '' || category === currentCategory;

                    item.style.display = (matchesSearch && matchesCategory) ? 'flex' : 'none';
                });
            }

            // Optional: Show "No results" message
            const noResults = document.getElementById('noResultsMessage');
            if (visibleCount === 0 && cards.length > 0) {
                if (!noResults) {
                    const msg = document.createElement('div');
                    msg.id = 'noResultsMessage';
                    msg.className = 'text-center text-gray-500 py-8 text-sm italic';
                    msg.textContent = 'No results found. Try different keywords or category.';
                    document.getElementById('ecoContent').appendChild(msg);
                }
            } else if (noResults) {
                noResults.remove();
            }
        }
        // 🌱 Category dropdown change
        document.getElementById('categoryDropdown').addEventListener('change', function() {
            currentCategory = this.value;
            applyCategoryFilter();
        });
    </script>
    @endsection
