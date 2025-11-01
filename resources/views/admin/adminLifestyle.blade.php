@extends('layouts.adminLayout')

@section('content')
@vite([
  'resources/css/ecoModal.css',
  'resources/js/ecoModal.js'
])

<!-- Header -->
<div class="flex items-center justify-between px-2 pt-2 mb-8">
    <h1 class="text-2xl font-serif font-semibold text-[#5C7919]">
        🌿 Eco Library (Admin View)
    </h1>
    <p class="text-sm text-gray-500 italic">Manage eco-topics and eco-actions here</p>
            <!-- 🌿 Feedback Notification -->
        @if (session('success'))
        <div id="feedback-toast"
            class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919] font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000 ease-in-out opacity-100">
            🌱 {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div id="error-toast"
            class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#fff5f5]/90 border border-[#d9534f]/40 text-[#d9534f] font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000 ease-in-out opacity-100">
            ❌ {{ session('error') }}
        </div>
        @endif
</div>
<!-- Eco Topics + Actions side by side -->
<div class="grid grid-cols-2 gap-10">

    <!-- LEFT: Eco Topics -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-serif font-semibold text-[#5C7919]">Eco Topics</h2>
            <button onclick="openEcoTopicModal()" class="btn-sunken bg-[#6C8E3C] hover:bg-[#5A7C30] text-white flex items-center">
                <i class="fa-solid fa-leaf mr-2"></i>Add Eco Topic
            </button>
        </div>

        <div class="space-y-4">
            @forelse($ecoTopics as $topic)
                <div class="flex items-center bg-[#FCF9EF] rounded-xl border border-green-100 p-4 hover:bg-[#FCFFF6] transition">
                    <img src="{{ Vite::asset('resources/images/eco-library/' . ($topic->image ?? 'default.jpg')) }}"
                        alt="{{ $topic->title }}"
                        class="w-16 h-16 object-cover rounded-lg mr-4">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg text-[#5C7919]">{{ $topic->title }}</h3>
                        <p class="text-xs text-gray-500 mt-1 truncate">{{ $topic->description }}</p>
                    </div>
                    <div class="flex flex-col items-end ml-4 space-y-2">
                        <a href="{{ url('/libraries/' . $topic->id) }}" class="text-xs text-blue-600 hover:underline">View</a>
                        <a href="{{ url('/admin/libraries/' . $topic->id) }}" class="text-xs text-yellow-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ url('/admin/libraries/' . $topic->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-400">No topics found.</p>
            @endforelse
        </div>
    </div>

    <!-- RIGHT: Eco Actions -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-serif font-semibold text-[#5C7919]">Eco Actions</h2>
            <button onclick="openEcoActionModal()" class="btn-sunken bg-[#89A64F] hover:bg-[#7A9442] text-white flex items-center">
                <i class="fa-solid fa-hand-holding-heart mr-2"></i>Add Eco Action
            </button>
        </div>

        <div class="space-y-4">
            @forelse($ecoActions as $action)
            <div class="flex items-center bg-[#FCF9EF] rounded-xl border border-green-100 p-4 hover:bg-[#FCFFF6] transition">
                <img src="{{ Vite::asset('resources/images/eco-actions/' . ($action->image ?? 'default.jpg')) }}"
                     alt="{{ $action->title }}"
                     class="w-16 h-16 object-cover rounded-lg mr-4">
                <div class="flex-1">
                    <h3 class="font-semibold text-lg text-[#5C7919]">{{ $action->title }}</h3>
                    <p class="text-xs text-gray-500 mt-1 truncate">{{ $action->description }}</p>
                </div>
                <div class="flex flex-col items-end ml-4 space-y-2">
                    <a href="{{ url('/admin/actions/' . $action->id) }}" class="text-xs text-blue-600 hover:underline">View</a>
                    <a href="{{ url('/admin/actions/' . $action->id) }}" class="text-xs text-yellow-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ url('/admin/actions/' . $action->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
            @empty
                <p class="text-gray-400">No actions found.</p>
            @endforelse
        </div>
    </div>
</div> <!-- END grid -->
@endsection
