@extends('layouts.mainLayout')

@section('content')
  @vite([
        'resources/css/ecoModal.css',
        'resources/js/ecoModal.js'])
<div class="max-w-6xl mx-auto px-12 py-12 mt-15">

  <div class="bg-[#F7F3E7] rounded-4xl shadow-sm border border-green-100 overflow-hidden p-8">

    <!-- Header -->
    <div class="flex items-center justify-between px-2 pt-2 mb-4">
      <h1 class="text-2xl font-serif font-semibold text-[#5C7919]">
        {{ $category->title ?? 'Climate & Nature Awareness 🌍' }}
      </h1>
    </div>

    <!-- Top Controls Row: Left Column + Sidebar -->
    <div class="flex justify-between items-start gap-6 px-4 mb-8">

      <!-- Left Column -->
      <div class="flex flex-col flex-1">

        <!-- Toggle + Search -->
        <div class="flex items-center justify-between gap-4 mb-6">
          <!-- iOS-style Toggle -->
          <div class="relative flex items-center bg-[#5C7919] rounded-full p-3 w-40">
            <div id="toggle-slider"
                 class="absolute left-1 top-1 w-[calc(50%-0.25rem)] h-[calc(100%-0.5rem)] bg-[#FCFFF6] rounded-full shadow-md transition-all duration-300 ease-in-out"></div>
            <button id="topicsBtn"
                    class="relative z-10 flex-1 text-center text-sm font-medium text-[#5C7919]"
                    onclick="switchTab('topics')">Topics</button>
            <button id="actionsBtn"
                    class="relative z-10 flex-1 text-center text-sm font-medium text-[#FCF9EF]"
                    onclick="switchTab('actions')">Actions</button>
          </div>

          <!-- Search + Category -->
          <div class="flex items-center gap-2 flex-1">
            <div class="relative w-full max-w-70">
              <input type="text" placeholder="Search"
                     class="bg-[#E0E9D6] w-full pl-3 pr-10 py-2 border border-[#7A8C4F] rounded-full focus:outline-[#7A8C4F] focus:ring-2 focus:ring-[#7A8C4F] text-sm">
              <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                   viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </div>

            <!-- Category Dropdown -->
            <select id="categoryDropdown"
                    class="text-sm text-gray-600 bg-[#FCFFF6] border border-[#7A8C4F] rounded-full px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]">
              <option value="">Category ▾</option>
              {{-- Later: fetch from DB --}}
              <option>Energy</option>
              <option>Waste</option>
              <option>Fashion</option>
            </select>
          </div>
        </div>

        <!-- Dynamic Eco Content -->
        <div id="ecoContent" class="space-y-4 w-145">
          {{-- Default: Eco Topics --}}
          @foreach($ecoTopics ?? [
            ['title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
            ['title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg'],
            ['title' => 'Checking the Quality of Air', 'image' => 'air.jpg']
          ] as $topic)
          <div class="eco-card flex items-center p-4 bg-[#FCF9EF] rounded-xl border border-green-100 transition-transform duration-300 ease-in-out cursor-pointer hover:bg-[#FCFFF6] shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-105"
               data-type="ecoTopic"
               data-id="{{ $loop->index }}">
            <img src="{{ Vite::asset('resources/images/eco-topics/' . $topic['image']) }}"
                 alt="{{ $topic['title'] }}"
                 class="w-16 h-16 object-cover rounded-lg mr-4">
            <div class="flex-1">
              <h3 class="font-semibold text-lg text-[#5C7919]">{{ $topic['title'] }}</h3>
              <p class="text-xs text-gray-500 mt-1 truncate">
                {{ $topic['description'] ?? 'Short description will appear here.' }}
              </p>
            </div>
            <button class="save-btn text-gray-400 hover:text-yellow-500" data-title="{{ $topic['title'] }}">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
              </svg>
            </button>
          </div>
          @endforeach
        </div>

      </div> <!-- END Left Column -->

      <!-- Sidebar -->
      <div id="ecoSidebar" class="w-[22rem] flex-shrink-0 bg-[#FCF9EF] rounded-xl p-6 border border-green-100
           max-h-[80vh] overflow-y-auto custom-scroll shadow-[0_8px_20px_#7A8C4F]/70">
        <h2 class="text-lg font-semibold text-[#5C7919] mb-4" id="sidebarTitle">Saved Eco-topics</h2>
        <div class="space-y-3" id="savedList">
          {{-- Saved items placeholder --}}
          @foreach($savedItems ?? [
            ['id' => 1, 'type' => 'topic', 'title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
            ['id' => 2, 'type' => 'topic', 'title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg'],
          ] as $saved)
          <div 
            class="flex items-center p-2 bg-[#FCFFF6] rounded-lg border border-green-100 saved-item cursor-pointer hover:scale-105 transition"
            data-id="{{ $saved['id'] }}"
            data-type="{{ $saved['type'] === 'topic' ? 'ecoTopic' : 'ecoAction' }}"
          >
            <img 
              src="{{ Vite::asset('resources/images/eco-topics/' . $saved['image']) }}"
              alt="{{ $saved['title'] }}"
              class="w-10 h-10 object-cover rounded-md mr-3"
            >
            <div class="flex-1">
              <h4 class="text-sm font-medium text-[#5C7919]">{{ $saved['title'] }}</h4>
            </div>

            @if($saved['type'] === 'action')
            <button class="text-green-600 hover:text-green-800 text-xs mr-2">Mark as Done</button>
            @endif

            <button class="unsave-btn text-yellow-500 hover:text-red-500" title="Unsave">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
              </svg>
            </button>
          </div>
          @endforeach
        </div>
      </div> <!-- END Sidebar -->

    </div> <!-- END Top Controls Row -->

    <!-- Motivational Quote -->
    <div class="mt-6 text-center text-sm text-gray-500 italic">
      “You don’t have to know everything today — one tip at a time is enough.”
    </div>

  </div>

</div>

<!-- Script -->
<script>
function switchTab(tab) {
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

    // DB fetch placeholder
    content.innerHTML = `
      @foreach($ecoTopics ?? [
        ['title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
        ['title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg'],
        ['title' => 'Checking the Quality of Air', 'image' => 'air.jpg']
      ] as $topic)
      <div class="eco-card flex items-center p-4 bg-[#FCF9EF] rounded-xl border border-green-100  hover:bg-[#FCFFF6] shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-105 transition cursor-pointer"
     data-type="ecoTopic"
     data-id="{{ $loop->index }}">
  <img src="{{ Vite::asset('resources/images/eco-topics/' . $topic['image']) }}"
       alt="{{ $topic['title'] }}"
       class="w-16 h-16 object-cover rounded-lg mr-4">
  <div class="flex-1">
    <h3 class="font-semibold text-lg text-[#5C7919]">{{ $topic['title'] }}</h3>
    <p class="text-xs text-gray-500 mt-1 truncate">
      {{ $topic['description'] ?? 'Short description will appear here.' }}
    </p>
  </div>
  <button class="save-btn text-gray-400 hover:text-yellow-500" data-title="{{ $topic['title'] }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
    </svg>
  </button>
</div>

      @endforeach
    `;

    savedList.innerHTML = `
      @foreach($savedTopics ?? [
        ['title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
        ['title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg']
      ] as $saved)
      <div class="eco-saved-card flex bg-[#FCFFF6] items-center p-2 rounded-lg border border-green-100 cursor-pointer hover:[#FCFFF6] hover:scale-105"
     data-type="ecoTopic"
     data-id="{{ $loop->index }}">
  <img src="{{ Vite::asset('resources/images/eco-topics/' . $saved['image']) }}"
       alt="{{ $saved['title'] }}"
       class="w-10 h-10 object-cover rounded-md mr-3">
  <div class="flex-1">
    <h4 class="text-sm font-medium text-[#5C7919]">{{ $saved['title'] }}</h4>
  </div>
  <button class="unsave-btn text-yellow-500 hover:text-red-500" title="Unsave">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
      <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
    </svg>
  </button>
</div>

      @endforeach
    `;
  } else {
  slider.style.transform = 'translateX(100%)';
  actionsBtn.style.color = '#7A8C4F';
  topicsBtn.style.color = '#FCF9EF';

    sidebarTitle.textContent = 'Saved Eco-actions';

    // DB fetch placeholder
    content.innerHTML = `
      @foreach($ecoActions ?? [
        ['title' => 'Recycle Properly', 'image' => 'plastic.jpg'],
        ['title' => 'Share Environmental Facts Online', 'image' => 'carbon.jpg'],
        ['title' => 'Commute or Walk', 'image' => 'air.jpg']
      ] as $action)
      <div class="eco-card flex items-center p-4 bg-[#FCF9EF] rounded-xl border border-green-100  hover:bg-[#FCFFF6] shadow-[0_8px_20px_#7A8C4F]/70 hover:scale-105 transition cursor-pointer"
     data-type="ecoAction"
     data-id="{{ $loop->index }}">
  <img src="{{ Vite::asset('resources/images/eco-topics/' . $action['image']) }}"
       alt="{{ $action['title'] }}"
       class="w-16 h-16 object-cover rounded-lg mr-4">
  <div class="flex-1">
    <h3 class="font-semibold text-lg text-[#5C7919]">{{ $action['title'] }}</h3>
    <p class="text-xs text-gray-500 mt-1 truncate">
      {{ $action['description'] ?? 'Short description will appear here.' }}
    </p>
  </div>
  <button class="save-btn text-gray-400 hover:text-yellow-500" data-title="{{ $topic['title'] }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
    </svg>
  </button>
</div>

      @endforeach
    `;

    savedList.innerHTML = `
      @foreach($savedActions ?? [
        ['title' => 'Recycle Properly', 'image' => 'plastic.jpg'],
        ['title' => 'Commute or Walk', 'image' => 'air.jpg']
      ] as $saved)
      <div class="saved-item flex items-center p-2 bg-[#FCFFF6] rounded-lg border border-green-100 cursor-pointer hover:[#FCFFF6] hover:scale-105"
     data-type="ecoAction"
     data-id="{{ $loop->index }}">
  <img src="{{ Vite::asset('resources/images/eco-topics/' . $saved['image']) }}"
       alt="{{ $saved['title'] }}"
       class="w-10 h-10 object-cover rounded-md mr-3">
  <div class="flex-1">
    <h4 class="text-sm font-medium text-[#5C7919]">{{ $saved['title'] }}</h4>
  </div>
  <button class="text-green-600 hover:text-green-800 text-xs mr-2">Mark as Done</button>
  <button class="unsave-btn text-yellow-500 hover:text-red-500" title="Unsave">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
      <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
    </svg>
  </button>
</div>

      @endforeach
    `;
  }
}

// 🧩 Event: Unsave
document.addEventListener('click', e => {
  if (e.target.closest('.unsave-btn')) {
    const item = e.target.closest('.unsave-btn').closest('div.flex');
    item.classList.add('opacity-50');
    setTimeout(() => item.remove(), 400);
    // 🔄 Future DB call to unsave
  }

  if (e.target.closest('.save-btn')) {
    const btn = e.target.closest('.save-btn');
    btn.innerHTML = `<svg class='w-5 h-5 text-yellow-500' fill='currentColor' viewBox='0 0 24 24'>
      <path d='M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z'/>
    </svg>`;
    // 🔄 Future DB call to save
  }
});
</script>
@include('modal.ecoDetailModal')
@endsection


