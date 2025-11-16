@extends('layouts.adminLayout')

@section('title', 'Quests')

@section('content')
<div class="space-y-8">
  <!-- 🌿 Header -->
  <div>
    <h1 class="text-3xl font-semibold text-[#4E3A2E]">Quests</h1>
    <p class="text-[#7A8C4F] mt-1">Create, manage, and validate sustainability challenges.</p>
  </div>

  <!-- 📦 Layout Wrapper -->
  <div class="flex flex-col md:flex-row gap-8">
    <!-- ✅ Sidebar -->
    <aside class="w-full md:w-1/4 max-w-xs bg-[#FCF9EF] rounded-2xl p-6 shadow-[0_8px_20px_rgba(74,85,48,0.2)] border border-[#C6D0B2]">
      <!-- 🌿 Active Quests Header -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-[#4E3A2E]">Active Quests</h2>
        <button onclick="openQuestModal()" class="btn-eco btn-sage">
          + New
        </button>
      </div>
      
   <ul id="questList" class="space-y-2 mb-6">
  <li data-quest="plastic" class="tab-eco">Reduce Plastic Use</li>
  <li data-quest="tree" class="tab-eco">Plant a Tree</li>
  <li data-quest="cleanup" class="tab-eco">Join Clean-Up Drive</li>
</ul>

      <hr class="border-[#C6D0B2] mb-6">

     <!-- 🌿 Quest Collection Button -->
<button data-quest="collection" class="tab-eco w-full text-center mb-2">
  Quest Collection
</button>

<!-- 🗂 Archive Dropdown -->
<div class="relative">
<button id="archiveDropdownBtn" class="btn-eco w-full flex justify-center items-center relative">
  <span>Archive</span>
  <svg id="archiveArrow" class="w-4 h-4 ml-2 absolute right-4 top-1/2 -translate-y-1/2 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
  </svg>
</button>

  <!-- Dropdown Menu -->
  <ul id="archiveDropdownMenu" class="absolute left-0 right-0 bg-[#FCF9EF] border border-[#C6D0B2] rounded-lg mt-2 shadow-lg hidden z-10">
    <li data-quest="archive-submissions" class="px-4 py-2 hover:bg-[#E9F0E1] cursor-pointer text-[#4E3A2E]">Submissions</li>
    <li data-quest="archive-quests" class="px-4 py-2 hover:bg-[#E9F0E1] cursor-pointer text-[#4E3A2E]">Quests</li>
  </ul>
</div>

    </aside>

    <!-- 📋 Main Content -->
 <!-- 📋 Main Content -->
<main class="flex-1 space-y-6">
  <div class="max-w-8xl mx-auto space-y-6 mt-7 ml-5 mr-5">
    <!-- 🔍 Search Bars -->
<div class="flex flex-wrap items-center justify-between gap-4">
  <!-- Search for Submissions -->
  <div id="searchSubmissions" class="relative w-80">
    <input type="text" placeholder="Search submissions..."
      class="bg-[#E9F0E1] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#4E3A2E]">
    <svg class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
  </div>

  <!-- Search for Quests -->
  <div id="searchQuests" class="relative w-80 hidden">
    <input type="text" placeholder="Search quests..."
      class="bg-[#E9F0E1] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#4E3A2E]">
    <svg class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
  </div>
</div>


    <!-- 🧭 Quest Tables -->
    <div id="questTables" class="space-y-8">
     <!-- 🧩 Reduce Plastic Use -->
<div id="plasticTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7]">
  <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Reduce Plastic Use Participants</h2>
  <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
      <tr>
        <th class="px-4 py-2 w-16">#</th>
        <th class="px-4 py-2">Participant</th>
        <th class="px-4 py-2 w-32">Status</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">1</td>
        <td class="participant-name px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline"
            data-name="Maria Santos"
            data-status="Completed"
            data-proof="https://proof-link.example.com"
            data-submitted="2025-10-21"
            data-completed="2025-10-25">
          Maria Santos
        </td>
        <td class="px-4 py-2 text-[#6A8A52]">Completed</td>
      </tr>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">2</td>
        <td class="participant-name px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline"
            data-name="John Dela Cruz"
            data-status="Pending"
            data-proof="https://example.com/proof2"
            data-submitted="2025-10-22"
            data-completed="-">
          John Dela Cruz
        </td>
        <td class="px-4 py-2 text-[#C37A49]">Pending</td>
      </tr>
    </tbody>
  </table>
</div>


<!-- 🌳 Plant a Tree -->
<div id="treeTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
  <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Plant a Tree Participants</h2>
  <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
      <tr>
        <th class="px-4 py-2 w-16">#</th>
        <th class="px-4 py-2">Participant</th>
        <th class="px-4 py-2 w-32">Status</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">1</td>
        <td class="participant-name px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline"
            data-name="Liza Ramos"
            data-status="Completed"
            data-proof="https://proof-link-liza.example.com"
            data-submitted="2025-10-14"
            data-completed="2025-10-17">
          Liza Ramos
        </td>
        <td class="px-4 py-2 text-[#6A8A52]">Completed</td>
      </tr>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">2</td>
        <td class="participant-name px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline"
            data-name="Paolo Cruz"
            data-status="Ongoing"
            data-proof="https://proof-link-paolo.example.com"
            data-submitted="2025-10-18"
            data-completed="-">
          Paolo Cruz
        </td>
        <td class="px-4 py-2 text-[#C37A49]">Ongoing</td>
      </tr>
    </tbody>
  </table>
</div>

<!-- 🧹 Clean-Up Drive -->
<div id="cleanupTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
  <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Join Clean-Up Drive Participants</h2>
  <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
      <tr>
        <th class="px-4 py-2 w-16">#</th>
        <th class="px-4 py-2">Participant</th>
        <th class="px-4 py-2 w-32">Status</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">1</td>
        <td class="participant-name px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline"
            data-name="Maria Santos"
            data-status="Completed"
            data-proof="https://proof-link-maria.example.com"
            data-submitted="2025-10-20"
            data-completed="2025-10-25">
          Maria Santos
        </td>
        <td class="px-4 py-2 text-[#6A8A52]">Completed</td>
      </tr>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">2</td>
        <td class="participant-name px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline"
            data-name="Carlos Reyes"
            data-status="Pending"
            data-proof="https://proof-link-carlos.example.com"
            data-submitted="2025-10-22"
            data-completed="-">
          Carlos Reyes
        </td>
        <td class="px-4 py-2 text-[#C37A49]">Pending</td>
      </tr>
    </tbody>
  </table>
</div>

<!-- 📋 Submission Modal -->
<div id="submissionModal"
  class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 border border-[#E6EAD7]">
    <h3 class="text-lg font-semibold text-[#4E3A2E] mb-3" id="modalParticipantName"></h3>
    <div class="space-y-2 text-sm text-[#4E3A2E]">
      <p><strong>Status:</strong> <span id="modalStatus"></span></p>
      <p><strong>Date Submitted:</strong> <span id="modalDateSubmitted"></span></p>
      <p><strong>Date Completed:</strong> <span id="modalDateCompleted"></span></p>
      <p><strong>Proof:</strong> 
        <a id="modalProofLink" href="#" target="_blank" class="text-blue-600 underline">View Submission</a>
      </p>
    </div>

    <!-- 📝 Optional Admin Note -->
    <div class="mt-4">
      <label for="adminNote" class="block text-sm font-medium text-[#4E3A2E] mb-1">Admin Note (optional)</label>
      <textarea id="adminNote"
        class="w-full border border-[#E6EAD7] rounded-lg p-2 text-sm focus:ring-[#6A8A52] focus:border-[#6A8A52]"
        placeholder="Write a note for this participant..."></textarea>
    </div>

    <!-- ✅❌ Action Buttons -->
    <div class="flex justify-end gap-3 mt-5">
      <button id="rejectBtn" class="px-3 py-1.5 bg-red-100 text-red-700 rounded hover:bg-red-200">❌ Reject</button>
      <button id="approveBtn" class="px-3 py-1.5 bg-green-100 text-green-700 rounded hover:bg-green-200">✅ Approve</button>
      <button id="closeModal" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Close</button>
    </div>
  </div>
</div>
<!-- 🗂 Quest Collection -->
<div id="collectionTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7]">
  <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Quest Collection</h2>
  <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
      <tr>
        <th class="px-4 py-2 w-16">#</th>
        <th class="px-4 py-2">Quest Title</th>
        <th class="px-4 py-2 w-64">Description</th>
        <th class="px-4 py-2 w-48">Category</th>
        <th class="px-4 py-2 w-32">Points</th>
        <th class="px-4 py-2 w-32">Start Date</th>
        <th class="px-4 py-2 w-32">End Date</th>
        <th class="px-4 py-2 w-32">Status</th>
        <th class="px-4 py-2 w-32">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">1</td>
        <td class="px-4 py-2 text-[#4E3A2E]">Reduce Plastic Use</td>
        <td class="px-4 py-2">Encourage communities to reduce single-use plastics through awareness and alternatives.</td>
        <td class="px-4 py-2">Waste Management</td>
        <td class="px-4 py-2">100</td>
        <td class="px-4 py-2">2025-09-01</td>
        <td class="px-4 py-2">2025-09-30</td>
        <td class="px-4 py-2 text-[#6A8A52]">Active</td>
        <td class="px-4 py-2">
          <div class="flex gap-1.5">
            <button class="btn-action btn-edit" title="Edit Quest">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn-action btn-delete" title="Archive Quest">
              <i class="fas fa-archive"></i>
            </button>
          </div>
        </td>
      </tr>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">2</td>
        <td class="px-4 py-2 text-[#4E3A2E]">Plant a Tree</td>
        <td class="px-4 py-2">Join a local tree planting initiative and contribute to reforestation efforts.</td>
        <td class="px-4 py-2">Biodiversity</td>
        <td class="px-4 py-2">120</td>
        <td class="px-4 py-2">2025-10-01</td>
        <td class="px-4 py-2">2025-10-31</td>
        <td class="px-4 py-2 text-[#6A8A52]">Active</td>
        <td class="px-4 py-2">
          <div class="flex gap-1.5">
            <button class="btn-action btn-edit" title="Edit Quest">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn-action btn-delete" title="Archive Quest">
              <i class="fas fa-archive"></i>
            </button>
          </div>
        </td>
      </tr>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">3</td>
        <td class="px-4 py-2 text-[#4E3A2E]">Water Conservation</td>
        <td class="px-4 py-2">Spread awareness on responsible water usage and organize educational drives.</td>
        <td class="px-4 py-2">Water Saving</td>
        <td class="px-4 py-2">90</td>
        <td class="px-4 py-2">2025-11-01</td>
        <td class="px-4 py-2">2025-11-30</td>
        <td class="px-4 py-2 text-[#C37A49]">Ending Soon</td>
        <td class="px-4 py-2">
          <div class="flex gap-1.5">
            <button class="btn-action btn-edit" title="Edit Quest">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn-action btn-delete" title="Archive Quest">
              <i class="fas fa-archive"></i>
            </button>
          </div>
        </td>
      </tr>
      <tr class="hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">4</td>
        <td class="px-4 py-2 text-[#4E3A2E]">Sustainable Fashion</td>
        <td class="px-4 py-2">Encourage the use of thrifted or eco-friendly clothing to reduce textile waste.</td>
        <td class="px-4 py-2">Sustainable Fashion</td>
        <td class="px-4 py-2">150</td>
        <td class="px-4 py-2">2025-08-01</td>
        <td class="px-4 py-2">2025-08-31</td>
        <td class="px-4 py-2 text-[#A36B47]">Closed</td>
        <td class="px-4 py-2">
          <div class="flex gap-1.5">
            <button class="btn-action btn-edit" title="Edit Quest">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn-action btn-delete" title="Archive Quest">
              <i class="fas fa-archive"></i>
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<!-- 🗂 Archive - Submissions -->
<div id="archive-submissionsTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
  <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Archived Submissions</h2>
  <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
      <tr>
        <th class="px-4 py-2 w-16">#</th>
        <th class="px-4 py-2">Participant</th>
        <th class="px-4 py-2 w-48">Quest</th>
        <th class="px-4 py-2 w-32">Status</th>
        <th class="px-4 py-2 w-48">Date Completed</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">1</td>
        <td class="px-4 py-2">Maria Santos</td>
        <td class="px-4 py-2">Reduce Plastic Use</td>
        <td class="px-4 py-2 text-[#6A8A52]">Completed</td>
        <td class="px-4 py-2">2025-09-28</td>
      </tr>
    </tbody>
  </table>
</div>

<!-- 🗂 Archive - Quests -->
<div id="archive-questsTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
  <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Archived Quests</h2>
  <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
    <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
      <tr>
        <th class="px-4 py-2 w-16">#</th>
        <th class="px-4 py-2">Quest Title</th>
        <th class="px-4 py-2 w-64">Description</th>
        <th class="px-4 py-2 w-32">Points</th>
        <th class="px-4 py-2 w-32">Status</th>
      </tr>
    </thead>
    <tbody>
      <tr class="hover:bg-[#FAFBF8]">
        <td class="px-4 py-2">1</td>
        <td class="px-4 py-2">Sustainable Fashion</td>
        <td class="px-4 py-2">Encourage eco-friendly clothing usage.</td>
        <td class="px-4 py-2">150</td>
        <td class="px-4 py-2 text-[#A36B47]">Closed</td>
      </tr>
    </tbody>
  </table>
</div>

    </div>
  </div>
</main>

  </div>
</div>

<!-- 🌿 Modal -->
<div id="questModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-[#FCF9EF] rounded-2xl shadow-xl max-w-lg w-full p-6 text-[#3E5730] relative">
    <button id="closeModal" class="absolute top-3 right-4 text-[#7A8C4F] hover:text-[#4E3A2E] text-2xl">&times;</button>
    <h2 id="modalTitle" class="text-2xl font-semibold text-[#4E3A2E] mb-2"></h2>
    <p id="modalCategory" class="text-sm text-[#7A8C4F] mb-4"></p>
    <p id="modalDescription" class="text-[#4E3A2E] leading-relaxed"></p>
    <div id="modalStatus" class="mt-4 inline-block px-3 py-1 rounded-full text-sm font-medium"></div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll('#questList .tab-eco');
  const collectionBtn = document.querySelector('[data-quest="collection"]');
  const questTables = document.querySelectorAll('#questTables > div');
  const searchSubmissions = document.getElementById('searchSubmissions');
  const searchQuests = document.getElementById('searchQuests');

  function activateQuest(questKey, clickedElement) {
    // Remove active class from all tabs and collection button
    tabs.forEach(t => t.classList.remove('tab-eco-active'));
    if (collectionBtn) collectionBtn.classList.remove('tab-eco-active');

    // Add active class to clicked tab/button
    clickedElement.classList.add('tab-eco-active');

    // Hide all tables
    questTables.forEach(table => table.classList.add('hidden'));

    // Show the selected table
    const targetTable = document.getElementById(questKey + 'Table');
    if (targetTable) targetTable.classList.remove('hidden');

    // Toggle search bars
    if (questKey === 'collection') {
      searchSubmissions.classList.add('hidden');
      searchQuests.classList.remove('hidden');
    } else {
      searchSubmissions.classList.remove('hidden');
      searchQuests.classList.add('hidden');
    }
  }

  // Tabs click
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const quest = tab.getAttribute('data-quest');
      activateQuest(quest, tab);
    });
  });

  // Collection button click
  if (collectionBtn) {
    collectionBtn.addEventListener('click', () => {
      activateQuest('collection', collectionBtn);
    });
  }

  // Optional: set default active tab on page load
  if (tabs.length) {
    activateQuest(tabs[0].getAttribute('data-quest'), tabs[0]);
  }

 // -------------------------------
// Participant Submission Modal logic
// -------------------------------
const submissionModal = document.getElementById('submissionModal');
const closeSubmissionModal = document.querySelector('#submissionModal #closeModal');
const modalName = document.getElementById('modalParticipantName');
const modalStatus = document.getElementById('modalStatus');
const modalDateSubmitted = document.getElementById('modalDateSubmitted');
const modalDateCompleted = document.getElementById('modalDateCompleted');
const modalProofLink = document.getElementById('modalProofLink');

// Attach event listener to all participant name cells
document.querySelectorAll('.participant-name').forEach(cell => {
  cell.addEventListener('click', () => {
    modalName.textContent = cell.dataset.name;
    modalStatus.textContent = cell.dataset.status;
    modalDateSubmitted.textContent = cell.dataset.submitted;
    modalDateCompleted.textContent = cell.dataset.completed;
    modalProofLink.href = cell.dataset.proof;

    submissionModal.classList.remove('hidden');
    submissionModal.classList.add('flex');
  });
});

// Close button
closeSubmissionModal.addEventListener('click', () => {
  submissionModal.classList.add('hidden');
});

// Close modal when clicking outside content
submissionModal.addEventListener('click', e => {
  if (e.target === submissionModal) {
    submissionModal.classList.add('hidden');
  }
});
});

// -------------------------------
// 🗂 Archive Dropdown Logic
// -------------------------------
const archiveDropdownBtn = document.getElementById('archiveDropdownBtn');
const archiveDropdownMenu = document.getElementById('archiveDropdownMenu');
const archiveArrow = document.getElementById('archiveArrow');
const archiveOptions = archiveDropdownMenu.querySelectorAll('li');

if (archiveDropdownBtn) {
  // Toggle dropdown visibility
  archiveDropdownBtn.addEventListener('click', () => {
    archiveDropdownMenu.classList.toggle('hidden');
    archiveArrow.classList.toggle('rotate-180');
  });

  // Handle Archive tab clicks
  archiveOptions.forEach(option => {
    option.addEventListener('click', () => {
      const questKey = option.getAttribute('data-quest');
      activateQuest(questKey, option);

      // Close dropdown after selection
      archiveDropdownMenu.classList.add('hidden');
      archiveArrow.classList.remove('rotate-180');
    });
  });
}

// Close dropdown when clicking outside
document.addEventListener('click', e => {
  if (!archiveDropdownBtn.contains(e.target) && !archiveDropdownMenu.contains(e.target)) {
    archiveDropdownMenu.classList.add('hidden');
    archiveArrow.classList.remove('rotate-180');
  }
});

</script>



@endsection
@include('modal.createQuestModal')
@include('modal.verifyUserModal')