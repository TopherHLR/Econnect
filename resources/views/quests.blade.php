@extends('layouts.mainLayout')

@section('content')
<div class="max-w-6xl mx-auto px-6 md:px-12 py-12 mt-12">

  <div class="bg-[#F7F3E7] rounded-4xl shadow-md border border-green-100 overflow-hidden p-8">

    <!-- 🌿 Top Container: Columns -->
    <div class="flex flex-col md:flex-row gap-6">

      <!-- ✅ Left Column: Accepted Challenges -->
      <div class="w-full md:w-1/4 bg-[#FCFFF6] rounded-2xl shadow-md p-4 max-h-[600px] overflow-y-auto flex flex-col justify-between">
<h2 class="text-lg font-semibold text-[#4F6B3F] mb-4 py-3 rounded-xl text-center"
    style="font-family: var(--font-serif);">
  Accepted Quests
</h2>


        <div class="space-y-3 flex-1">
          {{-- Sample Accepted Quests --}}
          <div class="flex justify-between items-center bg-white p-3 rounded-2xl shadow-sm border-l-4 border-[#da7a5f] hover:shadow-md transition cursor-pointer accepted-quest">
              <span class="text-sm font-medium text-[#4F6B3F]">Plastic-Free Lunch Challenge</span>
              <small class="text-gray-500 text-xs">1 day left</small>
          </div>

          <div class="flex justify-between items-center bg-white p-3 rounded-2xl shadow-sm border-l-4 border-[#da7a5f] hover:shadow-md transition cursor-pointer accepted-quest">
              <span class="text-sm font-medium text-[#4F6B3F]">Eco Outfit Day</span>
            <small class="text-gray-500 text-xs">1 day left</small>
          </div>
          <div class="flex justify-between items-center bg-white p-3 rounded-2xl shadow-sm border-l-4 border-[#da7a5f] hover:shadow-md transition cursor-pointer accepted-quest">
              <span class="text-sm font-medium text-[#4F6B3F]">Clean Corner Project</span>
            <small class="text-gray-500 text-xs">3 days left</small>
          </div>
          <div class="flex justify-between items-center bg-white p-3 rounded-2xl shadow-sm border-l-4 border-[#da7a5f] hover:shadow-md transition cursor-pointer accepted-quest">
              <span class="text-sm font-medium text-[#4F6B3F]">Green Commute Day</span>
            <small class="text-gray-500 text-xs">3 days left</small>
          </div>
          <div class="flex justify-between items-center bg-white p-3 rounded-2xl shadow-sm border-l-4 border-[#da7a5f] hover:shadow-md transition cursor-pointer accepted-quest">
              <span class="text-sm font-medium text-[#4F6B3F]">Paper Reuse Art</span>
            <small class="text-gray-500 text-xs">3 days left</small>
          </div>
        </div>

        <!-- Completed Section -->
        <div class="mt-6 border-t border-[#e0e0d6] pt-4 space-y-2">
          {{-- Sample Completed Quests --}}
          <div class="flex justify-between items-center text-sm text-gray-700">
            <span>✅ Plastic-Free Lunch</span>
            <small>12/10/2025</small>
          </div>
          <div class="flex justify-between items-center text-sm text-gray-700">
            <span>✅ Paper Reuse Art</span>
            <small>13 pts</small>
          </div>
        </div>
      </div>

      <!-- 🌱 Right Column: Active Challenges -->
      <div class="w-full md:w-3/4 bg-[#FCFFF6] rounded-2xl shadow-md p-5 flex flex-col">

        <!-- Heading + All Button -->
        <div class="flex justify-between items-center mb-6 gap-4">
<h2 class="px-6 py-2 text-[#4F6B3F] rounded-xl text-lg font-semibold text-center"
    style="font-family: var(--font-serif);">
  Active Eco-Quests
</h2>


          <button class="text-sm bg-[#e8ead9] hover:bg-[#dfe1cc] px-4 py-2 rounded-full shadow transition">
            All
          </button>
        </div>
<!-- Grid of Challenges -->
<div class="max-w-full max-h-[500px] overflow-y-auto pr-2 flex-1 custom-scroll">
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">
    {{-- Sample Challenges --}}
    @for ($i = 0; $i < 8; $i++)
   <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition transform hover:-translate-y-1 cursor-pointer eco-card" data-type="ecoAction" data-id="{{ $i }}">
      <img src="{{ Vite::asset('resources/images/ecoChallenges/pollution.jpg') }}" alt="Challenge" class="h-28 w-full object-cover rounded-t-2xl">
      <div class="bg-gradient-to-t from-[#4a7144] to-[#6ea057] text-white p-3 flex flex-col justify-between rounded-b-2xl">
        <div>
          <h3 class="text-sm font-semibold truncate">Digital Declutter Challenge</h3>
          <p class="text-xs mt-1 opacity-80">Ends in 3 days</p>
        </div>
        <p class="text-sm mt-2 font-bold">3 pts 🌱</p>
      </div>
    </div>
    @endfor
  </div>
</div>


      </div> <!-- End Right Column -->

    </div> <!-- End Top Container Columns -->

    <!-- 🌸 Bottom Sections -->
    <div class="flex flex-col md:flex-row gap-6 mt-8">

      <!-- Left Bottom -->
      <div class="w-full md:w-1/4 flex flex-col items-center">
        <p class="text-xs text-[#a67c52] mb-2 text-center">Want to view all your progress?</p>
        <button class="bg-gradient-to-r from-[#c4b48a] to-[#b3a175] hover:from-[#b3a175] hover:to-[#a48f5c] text-white px-4 py-2 rounded-lg shadow transition">
          Go to My Progress
        </button>
      </div>

      <!-- Right Bottom -->
      <div class="w-full md:w-3/4 flex flex-col items-center">
        <p class="text-sm text-[#7a6f59] italic mb-4 text-center">Your progress can turn into discount badges (go to Rewards tab when clicked)</p>
        <div class="flex justify-center gap-6 mb-4 flex-wrap">
          {{-- Sample Badges --}}
          @for ($i = 0; $i < 4; $i++)
          <div class="flex flex-col items-center">
            <img src="{{ Vite::asset('resources/images/icons/sprout-badge.svg') }}" alt="Badge" class="h-10 mb-1">
            <p class="text-sm font-semibold text-[#4b3f2f]">10% discount</p>
          </div>
          @endfor
        </div>
      </div>

    </div> <!-- End Bottom Sections -->

  </div> <!-- End Main Container -->

</div><!-- 🔹 Active Quest Modal -->
<div id="activeQuestModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
  <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

    <!-- Modal Header -->
    <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
      <h2 class="text-lg font-semibold flex items-center">
        <i class="fa-solid fa-bullseye mr-2"></i> Active Eco Quest
      </h2>
      <button onclick="closeActiveQuestModal()" class="text-white hover:text-[#E0E5D8]">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
    </div>

    <div class="p-6 space-y-4">
      <!-- Quest Info (static) -->
      <p><strong>Title:</strong> Digital Declutter Challenge</p>
      <p><strong>Description:</strong> Clean up your digital space to reduce clutter and energy consumption.</p>
      <p><strong>Category:</strong> Waste Management</p>
      <p><strong>Points Reward:</strong> 3 pts 🌱</p>
      <p><strong>Status:</strong> Active</p>
      <p><strong>Start Date:</strong> 2025-11-10</p>
      <p><strong>End Date:</strong> 2025-11-15</p>

      <!-- Accept Challenge Button -->
      <div class="flex justify-center mt-4">
        <button type="button" onclick="acceptQuestFromActiveModal()" class="btn-eco btn-leaf flex items-center gap-2">
          <i class="fa-solid fa-check"></i> Accept Challenge
        </button>
      </div>
    </div>
  </div>
</div>

<!-- 🔹 Accepted Quest Modal (with submission) -->
<div id="acceptedQuestModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
  <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

    <!-- Modal Header -->
    <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
      <h2 class="text-lg font-semibold flex items-center">
        <i class="fa-solid fa-bullseye mr-2"></i> Submit Quest Progress
      </h2>
      <button onclick="closeAcceptedQuestModal()" class="text-white hover:text-[#E0E5D8]">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
    </div>

    <div class="p-6 space-y-4">
      <!-- Quest Info (static) -->
      <p><strong>Title:</strong> Plastic-Free Lunch Challenge</p>
      <p><strong>Description:</strong> Bring your own lunch container to reduce plastic waste.</p>
      <p><strong>Category:</strong> Waste Management</p>
      <p><strong>Points Reward:</strong> 5 pts 🌱</p>
      <p><strong>Status:</strong> Active</p>
      <p><strong>Start Date:</strong> 2025-11-09</p>
      <p><strong>End Date:</strong> 2025-11-12</p>

      <!-- Submission Input -->
      <form id="acceptedQuestForm" method="POST" action="#" class="space-y-4">
        @csrf
        <div>
          <label class="block text-[#4F6B3F] font-medium mb-1">Your Progress / Notes</label>
          <textarea name="progress" rows="4"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Describe your progress or upload proof if needed"></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-3">
          <button type="button" onclick="closeAcceptedQuestModal()" class="btn-eco btn-sand">Cancel</button>
          <button type="submit" class="btn-eco btn-leaf"><i class="fa-solid fa-paper-plane"></i> Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const activeModal = document.getElementById('activeQuestModal');
  const acceptedModal = document.getElementById('acceptedQuestModal');

  // Open/close modals
  function openActiveQuestModal() { activeModal.classList.remove('hidden'); }
  function closeActiveQuestModal() { activeModal.classList.add('hidden'); }

  function openAcceptedQuestModal() { acceptedModal.classList.remove('hidden'); }
  function closeAcceptedQuestModal() { acceptedModal.classList.add('hidden'); }

  // Accept challenge from Active Quest modal
  function acceptQuestFromActiveModal() {
      alert('Quest added to Accepted Quests!');
      closeActiveQuestModal();
      // TODO: integrate logic to add quest to Accepted Quests list dynamically
  }

  // Close when clicking backdrop
  activeModal?.addEventListener('click', e => { if(e.target === activeModal) closeActiveQuestModal(); });
  acceptedModal?.addEventListener('click', e => { if(e.target === acceptedModal) closeAcceptedQuestModal(); });

  // Attach click events
  document.querySelectorAll('.eco-card').forEach(item => item.addEventListener('click', openActiveQuestModal));
  document.querySelectorAll('.accepted-quest').forEach(item => item.addEventListener('click', openAcceptedQuestModal));
</script>

@endsection
