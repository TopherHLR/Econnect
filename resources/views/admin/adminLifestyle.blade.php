@extends('layouts.adminLayout')

@section('title', 'Eco Library')

@section('content')
<div class="space-y-8">
  <!-- 🌿 Header -->
  <div class="space-y-2">
    <h1 class="text-3xl font-semibold text-[#4F6B3F]">Eco Library</h1>
    <p class="text-[#6A8C4F] text-sm">Manage eco-topics and eco-actions in one place.</p>
  </div>

  <!-- 🔄 Toggle + Search + Add Button -->
  <div class="flex flex-wrap items-center gap-4 mb-4">
    <!-- Toggle -->
    <div class="flex items-center bg-[#E0E9D6] border border-[#7A8C4F] rounded-full overflow-hidden">
      <button 
        id="toggleTopics"
        class="px-4 py-2 text-sm font-medium text-[#4F6B3F] bg-[#CFE1BC] rounded-l-full transition-all"
      >
        Eco Topics
      </button>
      <button 
        id="toggleActions"
        class="px-4 py-2 text-sm font-medium text-[#3B3B3B] hover:bg-[#DDE7CC] transition-all"
      >
        Eco Actions
      </button>
    </div>

    <!-- Search -->
    <div class="relative w-60">
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
        <a href="{{ url('/libraries/' . $topic->id) }}" 
           class="px-3 py-1.5 rounded-md text-xs font-medium text-[#4F3B2C] bg-gradient-to-br from-[#E0E5D8] to-[#BFD8B8] hover:from-[#D8E2CA] hover:to-[#B4D2A8] transition-all">
           <i class="fa-solid fa-eye"></i> View
        </a>
        <a href="{{ url('/admin/libraries/' . $topic->id) }}" 
           class="px-3 py-1.5 rounded-md text-xs font-medium text-[#4F6B3F] bg-gradient-to-br from-[#E0E5D8] to-[#D0DAC7] hover:from-[#D8E2CA] hover:to-[#C6D4B8] transition-all">
           <i class="fa-solid fa-pen"></i> Edit
        </a>
        <form method="POST" action="{{ url('/admin/libraries/' . $topic->id) }}">
          @csrf
          @method('DELETE')
          <button 
            type="submit"
            onclick="return confirm('Are you sure you want to delete this topic?')"
            class="px-3 py-1.5 rounded-md text-xs font-medium text-[#4F3B2C] bg-gradient-to-br from-[#D8B08C] to-[#C89E7B] hover:from-[#E0B996] hover:to-[#C89E7B] transition-all">
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
        <a href="{{ url('/actions/' . $action->id) }}" 
           class="px-3 py-1.5 rounded-md text-xs font-medium text-[#4F3B2C] bg-gradient-to-br from-[#E0E5D8] to-[#BFD8B8] hover:from-[#D8E2CA] hover:to-[#B4D2A8] transition-all">
           <i class="fa-solid fa-eye"></i> View
        </a>
        <a href="{{ url('/admin/actions/' . $action->id) }}" 
           class="px-3 py-1.5 rounded-md text-xs font-medium text-[#4F6B3F] bg-gradient-to-br from-[#E0E5D8] to-[#D0DAC7] hover:from-[#D8E2CA] hover:to-[#C6D4B8] transition-all">
           <i class="fa-solid fa-pen"></i> Edit
        </a>
        <form method="POST" action="{{ url('/admin/actions/' . $action->id) }}">
          @csrf
          @method('DELETE')
          <button 
            type="submit"
            onclick="return confirm('Are you sure you want to delete this action?')"
            class="px-3 py-1.5 rounded-md text-xs font-medium text-[#4F3B2C] bg-gradient-to-br from-[#D8B08C] to-[#C89E7B] hover:from-[#E0B996] hover:to-[#C89E7B] transition-all">
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
  const toggleTopics = document.getElementById('toggleTopics');
  const toggleActions = document.getElementById('toggleActions');
  const topicsSection = document.getElementById('ecoTopicsSection');
  const actionsSection = document.getElementById('ecoActionsSection');
  const addBtn = document.getElementById('addEcoItemBtn');

  toggleTopics.addEventListener('click', () => {
    topicsSection.classList.remove('hidden');
    actionsSection.classList.add('hidden');
    toggleTopics.classList.add('bg-[#CFE1BC]', 'text-[#4F6B3F]');
    toggleActions.classList.remove('bg-[#CFE1BC]', 'text-[#4F6B3F]');
    addBtn.innerHTML = '<i class="fa-solid fa-plus"></i> <span>Add Eco Topic</span>';
    addBtn.setAttribute('onclick', 'openEcoTopicModal()');
  });

  toggleActions.addEventListener('click', () => {
    topicsSection.classList.add('hidden');
    actionsSection.classList.remove('hidden');
    toggleActions.classList.add('bg-[#CFE1BC]', 'text-[#4F6B3F]');
    toggleTopics.classList.remove('bg-[#CFE1BC]', 'text-[#4F6B3F]');
    addBtn.innerHTML = '<i class="fa-solid fa-plus"></i> <span>Add Eco Action</span>';
    addBtn.setAttribute('onclick', 'openEcoActionModal()');
  });
</script>
@endsection
