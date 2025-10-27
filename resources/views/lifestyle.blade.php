@extends('layouts.mainLayout')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8 mt-12">

  <div class="bg-white rounded-2xl shadow-sm border border-green-100 overflow-hidden">
    <!-- Header -->
    <div class="flex items-center justify-between px-6 pt-6 mb-4">
      <h1 class="text-2xl font-serif font-semibold text-[#5C7919]">
        Climate & Nature Awareness 🌍
      </h1>
    </div>

    <!-- Top Controls: Toggle + Search + Saved Sidebar -->
    <div class="flex justify-between items-start gap-6 px-4 mb-8">
      <div class="flex flex-col flex-1">
        <!-- Toggle + Search Row -->
        <div class="flex items-center justify-between gap-4 mb-6">
          <!-- iOS-style Toggle -->
          <div class="relative flex items-center bg-green-50 rounded-full p-3 w-40">
            <div id="toggle-slider" 
                 class="absolute left-1 top-1 w-[calc(50%-0.25rem)] h-[calc(100%-0.5rem)] bg-white rounded-full shadow-md transition-all duration-300 ease-in-out">
            </div>
            <button id="topicsBtn" 
                    class="relative z-10 flex-1 text-center text-sm font-medium text-[#5C7919] transition-colors"
                    onclick="switchTab('topics')">
              Topics
            </button>
            <button id="actionsBtn" 
                    class="relative z-10 flex-1 text-center text-sm font-medium text-gray-500 transition-colors"
                    onclick="switchTab('actions')">
              Actions
            </button>
          </div>

          <!-- Search Bar -->
          <div class="flex items-center gap-2 flex-1">
            <div class="relative w-full max-w-72">
              <input type="text" placeholder="Search" 
                     class="w-full pl-3 pr-10 py-2 border border-green-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-300 text-sm">
              <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <select class="text-sm text-gray-600 bg-green-50 border border-green-200 rounded-full px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-green-300">
              <option>Category ▾</option>
              <option>Energy</option>
              <option>Waste</option>
              <option>Fashion</option>
            </select>
          </div>
        </div>

        <!-- Main Content -->
        <div id="ecoContent" class="space-y-4">
          <!-- Default: Topics -->
          @foreach([
            ['title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
            ['title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg'],
            ['title' => 'Checking the Quality of Air', 'image' => 'air.jpg']
          ] as $topic)
            <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-100 hover:shadow transition">
              <img src="{{ Vite::asset('resources/images/eco-topics/' . $topic['image']) }}" 
                   alt="{{ $topic['title'] }}"
                   class="w-16 h-16 object-cover rounded-lg mr-4">
              <div class="flex-1">
                <h3 class="font-semibold text-lg text-[#5C7919]">{{ $topic['title'] }}</h3>
                <p class="text-xs text-gray-500 mt-1 truncate">
                  {{ str_repeat('ksdfhdnmlklskjdhcbxjnmkdsle... ', 2) }}
                </p>
              </div>
              <button class="text-gray-400 hover:text-yellow-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
              </button>
            </div>
          @endforeach
        </div>

        <!-- Quote -->
        <div class="mt-8 text-center text-sm text-gray-500 italic">
          “You don’t have to know everything today — one tip at a time is enough.”
        </div>
      </div>

      <!-- Sidebar -->
     <div id="ecoSidebar" 
     class="w-[22rem] flex-shrink-0 bg-green-50 rounded-xl p-6 border border-green-100 
            max-h-[80vh] overflow-y-auto custom-scroll">

        <h2 class="text-lg font-semibold text-[#5C7919] mb-4">Saved Eco-topics</h2>
        <div class="space-y-3" id="savedList">
          @foreach([
            ['title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
            ['title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg'],
            ['title' => 'Checking the Quality of Air', 'image' => 'air.jpg']
          ] as $saved)
            <div class="flex items-center p-2 bg-white rounded-lg border border-green-100">
              <img src="{{ Vite::asset('resources/images/eco-topics/' . $saved['image']) }}" 
                   alt="{{ $saved['title'] }}"
                   class="w-10 h-10 object-cover rounded-md mr-3">
              <div class="flex-1">
                <h4 class="text-sm font-medium text-[#5C7919]">{{ $saved['title'] }}</h4>
              </div>
              <button class="text-gray-400 hover:text-yellow-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
              </button>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Smooth Toggle Script -->
<script>
function switchTab(tab) {
  const slider = document.getElementById('toggle-slider');
  const topicsBtn = document.getElementById('topicsBtn');
  const actionsBtn = document.getElementById('actionsBtn');
  const content = document.getElementById('ecoContent');
  const sidebar = document.getElementById('ecoSidebar');
  const savedList = document.getElementById('savedList');

  if (tab === 'topics') {
    slider.style.transform = 'translateX(0)';
    topicsBtn.classList.add('text-[#5C7919]');
    topicsBtn.classList.remove('text-gray-500');
    actionsBtn.classList.add('text-gray-500');
    actionsBtn.classList.remove('text-[#5C7919]');

    // Change Sidebar Title
    sidebar.querySelector('h2').textContent = 'Saved Eco-topics';

    // Reset Saved List
    savedList.innerHTML = `
      @foreach([
        ['title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
        ['title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg'],
        ['title' => 'Checking the Quality of Air', 'image' => 'air.jpg']
      ] as $saved)
      <div class="flex items-center p-2 bg-white rounded-lg border border-green-100">
        <img src="{{ Vite::asset('resources/images/eco-topics/' . $saved['image']) }}" 
             alt="{{ $saved['title'] }}"
             class="w-10 h-10 object-cover rounded-md mr-3">
        <div class="flex-1">
          <h4 class="text-sm font-medium text-[#5C7919]">{{ $saved['title'] }}</h4>
        </div>
        <button class="text-yellow-500 hover:text-yellow-600" title="Unsave">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
      </svg>
    </button>
      </div>
      @endforeach
    `;

    // Replace Main Content with Topics
    content.innerHTML = `
      @foreach([
        ['title' => 'The Impact of Plastic', 'image' => 'plastic.jpg'],
        ['title' => 'Understand Carbon Emissions', 'image' => 'carbon.jpg'],
        ['title' => 'Checking the Quality of Air', 'image' => 'air.jpg']
      ] as $topic)
        <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-100 hover:shadow transition">
          <img src="{{ Vite::asset('resources/images/eco-topics/' . $topic['image']) }}" 
               alt="{{ $topic['title'] }}"
               class="w-16 h-16 object-cover rounded-lg mr-4">
          <div class="flex-1">
            <h3 class="font-semibold text-lg text-[#5C7919]">{{ $topic['title'] }}</h3>
            <p class="text-xs text-gray-500 mt-1 truncate">
              {{ str_repeat('ksdfhdnmlklskjdhcbx... ', 2) }}
            </p>
          </div>
          <button class="text-gray-400 hover:text-yellow-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
          </button>
        </div>
      @endforeach
    `;
  } else {
    // ACTIONS MODE
    slider.style.transform = 'translateX(100%)';
    actionsBtn.classList.add('text-[#5C7919]');
    actionsBtn.classList.remove('text-gray-500');
    topicsBtn.classList.add('text-gray-500');
    topicsBtn.classList.remove('text-[#5C7919]');

    sidebar.querySelector('h2').textContent = 'Saved Eco-actions';
savedList.innerHTML = `
<!-- ♻️ Recycle Properly -->
<div class="flex items-center justify-between p-2 bg-white rounded-lg border border-green-100">
  <div class="flex items-center min-w-0">
    <img src="{{ Vite::asset('resources/images/eco-topics/plastic.jpg') }}" 
         class="w-10 h-10 object-cover rounded-md mr-3">
    <h4 class="text-[13px] font-medium text-[#5C7919] truncate">
      Recycle Properly
    </h4>
  </div>

  <div class="flex items-center gap-2 flex-shrink-0">
    <button class="mark-done-btn text-[10px] font-medium px-3 py-1.5 rounded-full 
                   bg-[#5C7919]/10 text-[#5C7919] hover:bg-[#5C7919]/20 transition">
      Mark as done
    </button>
    <button class="text-yellow-500 hover:text-yellow-600" title="Unsave">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
      </svg>
    </button>
  </div>
</div>

<!-- 🌍 Share Environmental Facts Online -->
<div class="flex items-center justify-between p-2 bg-white rounded-lg border border-green-100">
  <div class="flex items-center min-w-0">
    <img src="{{ Vite::asset('resources/images/eco-topics/carbon.jpg') }}" 
         class="w-10 h-10 object-cover rounded-md mr-3">
    <h4 class="text-[13px] font-medium text-[#5C7919] truncate">
      Share Environmental Facts Online
    </h4>
  </div>

  <div class="flex items-center gap-2 flex-shrink-0">
    <button class="mark-done-btn text-[10px] font-medium px-3 py-1.5 rounded-full 
                   bg-[#5C7919]/10 text-[#5C7919] hover:bg-[#5C7919]/20 transition">
      Mark as done
    </button>
    <button class="text-yellow-500 hover:text-yellow-600" title="Unsave">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
      </svg>
    </button>
  </div>
</div>

<!-- 🚶 Commute or Walk -->
<div class="flex items-center justify-between p-2 bg-white rounded-lg border border-green-100">
  <div class="flex items-center min-w-0">
    <img src="{{ Vite::asset('resources/images/eco-topics/air.jpg') }}" 
         class="w-10 h-10 object-cover rounded-md mr-3">
    <h4 class="text-[13px] font-medium text-[#5C7919] truncate">
      Commute or Walk
    </h4>
  </div>

  <div class="flex items-center gap-2 flex-shrink-0">
    <button class="mark-done-btn text-[10px] font-medium px-3 py-1.5 rounded-full 
                   bg-[#5C7919]/10 text-[#5C7919] hover:bg-[#5C7919]/20 transition">
      Mark as done
    </button>
    <button class="text-yellow-500 hover:text-yellow-600" title="Unsave">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
      </svg>
    </button>
  </div>
</div>


  <!-- 🌱 Footer -->
  <div class="text-center mt-4 text-sm text-[#5C7919]">
    Want more exciting challenges?<br>
    <button class="mt-2 px-4 py-1 bg-[#5C7919] text-white rounded-full text-xs hover:bg-[#6b9220] transition">
      Go to Quests →
    </button>
  </div>
`;

    content.innerHTML = `
      <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-100 hover:shadow transition">
        <img src="{{ Vite::asset('resources/images/eco-topics/plastic.jpg') }}" class="w-16 h-16 object-cover rounded-lg mr-4">
        <div class="flex-1">
          <h3 class="font-semibold text-lg text-[#5C7919]">Recycle Properly</h3>
          <p class="text-xs text-gray-500 mt-1">Step 1:<br>Step 2:<br>Step 3:</p>
        </div>
        <button class="text-gray-400 hover:text-yellow-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
          </svg>
        </button>
      </div>
      <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-100 hover:shadow transition">
        <img src="{{ Vite::asset('resources/images/eco-topics/carbon.jpg') }}" class="w-16 h-16 object-cover rounded-lg mr-4">
        <div class="flex-1">
          <h3 class="font-semibold text-lg text-[#5C7919]">Share Environmental Facts Online</h3>
          <p class="text-xs text-gray-500 mt-1">Step 1:<br>Step 2:<br>Step 3:</p>
        </div>
        <button class="text-gray-400 hover:text-yellow-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
          </svg>
        </button>
      </div>
      <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-100 hover:shadow transition">
        <img src="{{ Vite::asset('resources/images/eco-topics/air.jpg') }}" class="w-16 h-16 object-cover rounded-lg mr-4">
        <div class="flex-1">
          <h3 class="font-semibold text-lg text-[#5C7919]">Commute or Walk</h3>
          <p class="text-xs text-gray-500 mt-1">Step 1:<br>Step 2:<br>Step 3:</p>
        </div>
        <button class="text-gray-400 hover:text-yellow-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
          </svg>
        </button>
      </div>
    `;
  }
}
</script>
<script>
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.mark-done-btn');
  if (!btn) return;

  // If currently "Mark as done"
  if (btn.textContent.trim() === 'Mark as done') {
    btn.innerHTML = 'Done for Today! <span class="ml-1">✅</span>';
    btn.classList.remove('bg-[#5C7919]/10', 'hover:bg-[#5C7919]/20');
    btn.classList.add('bg-[#5C7919]/20');
  } 
  // If clicked again (undo)
  else {
    btn.textContent = 'Mark as done';
    btn.classList.add('bg-[#5C7919]/10', 'hover:bg-[#5C7919]/20');
    btn.classList.remove('bg-[#5C7919]/20');
  }
});
</script>

@endsection
