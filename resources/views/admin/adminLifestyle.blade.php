@extends('layouts.adminLayout')

@section('title', 'Eco Library')

@section('content')
<div class="space-y-8">
  <!-- 🌿 Header -->
  <div class="space-y-2">
    <h1 class="text-3xl font-semibold text-[#4F6B3F]">Eco Library</h1>
    <p class="text-[#6A8C4F] text-sm">Manage eco-topics and eco-actions in one place.</p>
  </div>

  <!-- 🔄 Toggle + Search + Add Button - ALL IN ONE ROW -->
  <div class="flex flex-row items-center gap-4">
    <!-- iOS-style Toggle -->
    <div class="relative flex items-center bg-[#5C7919] rounded-full p-.5 w-40">
      <div id="toggle-slider"
          class="absolute left-1 top-1 w-[calc(50%-0.25rem)] h-[calc(100%-0.5rem)] bg-[#FCFFF6] rounded-full shadow-md transition-all duration-300 ease-in-out">
      </div>
      <button id="topicsBtn"
          class="relative z-10 flex-1 text-center text-sm font-medium text-[#5C7919] py-3"
          onclick="switchTab('topics')">Topics</button>
      <button id="actionsBtn"
          class="relative z-10 flex-1 text-center text-sm font-medium text-[#FCF9EF] py-3"
          onclick="switchTab('actions')">Actions</button>
    </div>

    <!-- Search -->
    <div class="relative w-80">
      <input 
        type="text" 
        placeholder="Search..."
        class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2 border border-[#7A8C4F] rounded-full 
               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]"
      >
      <svg 
        class="absolute right-3 top-2.5 w-4 h-4 text-[#7A8C4F]" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
    </div>

    <!-- Add Button -->
    <button 
      id="addEcoItemBtn"
      class="btn-eco btn-leaf flex items-center gap-2"
      onclick="openEcoTopicModal()"
    >
      <i class="fa-solid fa-plus"></i>
      <span>Add Eco Topic</span>
    </button>
  </div>

  <!-- 🪴 ECO TOPICS GRID -->
  <div id="ecoTopicsSection" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($ecoTopics as $topic)
    <div class="bg-[#FCF9EF] border border-[#D8E2CA] rounded-2xl shadow-sm p-4 hover:shadow-md transition-all">
      <div class="flex items-center gap-4">
        <img 
          src="{{ Vite::asset('resources/images/eco-library/' . ($topic->image ?? 'default.jpg')) }}" 
          alt="{{ $topic->title }}" 
          class="w-16 h-16 object-cover rounded-xl border border-[#C8D9B5]"
        >
        <div class="flex-1">
          <h3 class="font-semibold text-[#4F6B3F] text-base">{{ $topic->title }}</h3>
          <p class="text-xs text-gray-500 line-clamp-2 mt-1">{{ $topic->description }}</p>
        </div>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <!-- View Topic -->
        <a href="{{ url('/libraries/' . $topic->id) }}" class="btn-action btn-view">
          <i class="fa-solid fa-eye"></i> View
        </a>

        <!-- Edit Topic -->
        <a href="{{ url('/admin/libraries/' . $topic->id) }}" class="btn-action btn-edit">
          <i class="fa-solid fa-pen"></i> Edit
        </a>

        <!-- Delete Topic -->
        <form method="POST" action="{{ url('/admin/libraries/' . $topic->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit"
                  onclick="return confirm('Are you sure you want to delete this topic?')"
                  class="btn-action btn-delete">
            <i class="fa-solid fa-trash"></i> Delete
          </button>
        </form>
      </div>
    </div>
    @empty
    <p class="text-gray-400 italic">No topics found.</p>
    @endforelse
  </div>

  <!-- 🌱 ECO ACTIONS GRID -->
  <div id="ecoActionsSection" class="hidden grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($ecoActions as $action)
    <div class="bg-[#FCF9EF] border border-[#D8E2CA] rounded-2xl shadow-sm p-4 hover:shadow-md transition-all">
      <div class="flex items-center gap-4">
        <img 
          src="{{ Vite::asset('resources/images/eco-actions/' . ($action->image ?? 'default.jpg')) }}" 
          alt="{{ $action->title }}" 
          class="w-16 h-16 object-cover rounded-xl border border-[#C8D9B5]"
        >
        <div class="flex-1">
          <h3 class="font-semibold text-[#4F6B3F] text-base">{{ $action->title }}</h3>
          <p class="text-xs text-gray-500 line-clamp-2 mt-1">{{ $action->description }}</p>
        </div>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <!-- View Button -->
        <a href="{{ url('/actions/' . $action->id) }}" class="btn-action btn-view">
          <i class="fa-solid fa-eye"></i> View
        </a>

        <!-- Edit Button -->
        <a href="{{ url('/admin/actions/' . $action->id) }}" class="btn-action btn-edit">
          <i class="fa-solid fa-pen"></i> Edit
        </a>

        <!-- Delete Button -->
        <form method="POST" action="{{ url('/admin/actions/' . $action->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit"
                  onclick="return confirm('Are you sure you want to delete this action?')"
                  class="btn-action btn-delete">
            <i class="fa-solid fa-trash"></i> Delete
          </button>
        </form>
      </div>
    </div>
    @empty
    <p class="text-gray-400 italic">No actions found.</p>
    @endforelse
  </div>
</div>

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
  addBtn.innerHTML = isTopics
    ? '<i class="fa-solid fa-plus"></i> <span>Add Eco Topic</span>'
    : '<i class="fa-solid fa-plus"></i> <span>Add Eco Action</span>';
  addBtn.setAttribute('onclick', isTopics ? 'openEcoTopicModal()' : 'openEcoActionModal()');
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