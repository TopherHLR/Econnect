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
        <button class="bg-[#7A8C4F] hover:bg-[#90A955] text-white font-semibold py-1.5 px-3 rounded-lg shadow-md transition">
          + New
        </button>
      </div>

      <!-- 🌱 Active Quests List -->
      <ul id="questList" class="space-y-2 mb-6">
        <li data-quest="plastic" class="p-3 bg-white border border-[#C6D0B2] rounded-xl hover:bg-[#F4F6ED] transition cursor-pointer">Reduce Plastic Use</li>
        <li data-quest="tree" class="p-3 bg-white border border-[#C6D0B2] rounded-xl hover:bg-[#F4F6ED] transition cursor-pointer">Plant a Tree</li>
        <li data-quest="cleanup" class="p-3 bg-white border border-[#C6D0B2] rounded-xl hover:bg-[#F4F6ED] transition cursor-pointer italic text-[#7A8C4F]">Join Clean-Up Drive</li>
      </ul>

      <hr class="border-[#C6D0B2] mb-6">

      <!-- 🌿 Quest Collection Button -->
      <button data-quest="collection" class="bg-[#4E3A2E] text-[#FCF9EF] py-2 w-full rounded-lg hover:bg-[#6B513F] transition font-medium shadow">
        Quest Collection
      </button>
    </aside>

    <!-- 📋 Main Content -->
    <main class="flex-1 space-y-6">
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

        <button class="flex items-center gap-2 bg-[#7A8C4F] text-white px-5 py-2 rounded-full shadow hover:bg-[#90A955] transition font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
          </svg>
          Export Quest List
        </button>
      </div>

      <!-- 🧭 Quest Tables -->
      <div id="questTables" class="space-y-8">
        <!-- 🧩 Reduce Plastic Use -->
        <div id="plasticTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
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
                <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline">Maria Santos</td>
                <td class="px-4 py-2 text-[#6A8A52]">Completed</td>
              </tr>
              <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
                <td class="px-4 py-2">2</td>
                <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline">John Dela Cruz</td>
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
                <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline">Liza Ramos</td>
                <td class="px-4 py-2 text-[#6A8A52]">Completed</td>
              </tr>
              <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
                <td class="px-4 py-2">2</td>
                <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline">Paolo Cruz</td>
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
                <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline">Ella Gomez</td>
                <td class="px-4 py-2 text-[#C37A49]">Ongoing</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- 🗂 Quest Collection -->
        <div id="collectionTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7]">
          <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Quest Collection</h2>
          <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
            <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
              <tr>
                <th class="px-4 py-2">Quest Name</th>
                <th class="px-4 py-2 w-48">Category</th>
                <th class="px-4 py-2 w-32">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
                <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline">Recycle Initiative</td>
                <td class="px-4 py-2">Environmental</td>
                <td class="px-4 py-2 text-[#6A8A52]">Active</td>
              </tr>
              <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
                <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline">Water Conservation</td>
                <td class="px-4 py-2">Awareness</td>
                <td class="px-4 py-2 text-[#C37A49]">Draft</td>
              </tr>
            </tbody>
          </table>
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
  const questItems = document.querySelectorAll('#questList li, [data-quest="collection"]');
  const questTables = document.querySelectorAll('#questTables > div');
  const searchSubmissions = document.getElementById('searchSubmissions');
  const searchQuests = document.getElementById('searchQuests');

  questItems.forEach(item => {
    item.addEventListener('click', () => {
      const quest = item.getAttribute('data-quest');
      questTables.forEach(div => div.classList.add('hidden'));
      if (quest === 'collection') {
        searchSubmissions.classList.add('hidden');
        searchQuests.classList.remove('hidden');
      } else {
        searchSubmissions.classList.remove('hidden');
        searchQuests.classList.add('hidden');
      }
      const table = document.getElementById(quest + 'Table');
      if (table) table.classList.remove('hidden');
    });
  });

  // Modal logic
  const modal = document.getElementById('questModal');
  const closeModal = document.getElementById('closeModal');

  document.querySelectorAll('tbody td.text-[#7A8C4F]').forEach(cell => {
    cell.addEventListener('click', () => {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });
  });

  closeModal.addEventListener('click', () => modal.classList.add('hidden'));
  modal.addEventListener('click', e => { if (e.target === modal) modal.classList.add('hidden'); });
});
</script>

@endsection
