@extends('layouts.adminLayout')

@section('title', 'Quests')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">Quests</h1>
        <p class="text-[#6A8A52] mt-1">Create, manage, and validate sustainability challenges.</p>
    </div>

    <!-- Layout Wrapper -->
    <div class="flex flex-col md:flex-row gap-8">
        <!-- ✅ Sidebar -->
        <aside class="w-full md:w-1/4 max-w-xs mx-auto bg-[#FCF9EF] rounded-2xl p-6 shadow-[0_8px_20px_#7A8C4F]/40 border border-green-100">
            <!-- 🌿 Active Quests Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Active Quests</h2>
                <button class="bg-[#7A8C4F] hover:bg-[#90A955] text-white font-semibold py-1.5 px-3 rounded-lg shadow-md transition">
                    + New Quest
                </button>
            </div>

            <!-- 🌱 Active Quests List -->
            <ul id="questList" class="space-y-2 mb-6">
                <li data-quest="plastic" class="p-3 bg-[#FFFFFF] border border-green-100 rounded-xl hover:scale-[1.02] transition transform shadow-sm cursor-pointer">
                    Reduce Plastic Use
                </li>
                <li data-quest="tree" class="p-3 bg-[#FFFFFF] border border-green-100 rounded-xl hover:scale-[1.02] transition transform shadow-sm cursor-pointer">
                    Plant a Tree
                </li>
                <li data-quest="cleanup" class="p-3 bg-[#FFFFFF] border border-green-100 rounded-xl hover:scale-[1.02] transition transform shadow-sm cursor-pointer italic text-[#6D7058]">
                    Join Clean-Up Drive
                </li>
            </ul>

            <hr class="border-[#E6EAD7] mb-6">

            <!-- 🌿 Quest Collection Section -->
            <div class="flex flex-col gap-3">
                <button 
                    data-quest="collection"
                    class="bg-[#4F6B3F] text-[#F6F9EE] py-2 rounded-lg text-center hover:bg-[#3E5730] transition font-medium shadow cursor-pointer">
                    Quest Collection
                </button>
            </div>
        </aside>

        <!-- 📋 Main Content -->
        <main class="flex-1 space-y-6">
            <!-- 🔍 Search Bars -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- Search for Submissions -->
                <div id="searchSubmissions" class="relative w-80">
                    <input 
                        type="text" 
                        placeholder="Search submissions..."
                        class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]">
                    <svg 
                        class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24">
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Search for Quests -->
                <div id="searchQuests" class="relative w-80 hidden">
                    <input 
                        type="text" 
                        placeholder="Search quests..."
                        class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]">
                    <svg 
                        class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24">
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <button class="flex items-center gap-2 bg-[#4F6B3F] text-[#F6F9EE] px-5 py-2 rounded-full shadow hover:bg-[#3E5730] transition font-medium">
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
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4">Reduce Plastic Use Participants</h2>
                    <table class="min-w-full text-sm text-[#4F3B2C]">
                        <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                            <tr><th class="px-4 py-2">#</th><th class="px-4 py-2">Participant</th><th class="px-4 py-2">Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td class="px-4 py-2">1</td><td class="px-4 py-2">Maria Santos</td><td class="px-4 py-2 text-[#6A8A52]">Completed</td></tr>
                            <tr><td class="px-4 py-2">2</td><td class="px-4 py-2">John Dela Cruz</td><td class="px-4 py-2 text-[#A68A4F]">Pending</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- 🌳 Plant a Tree -->
                <div id="treeTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4">Plant a Tree Participants</h2>
                    <table class="min-w-full text-sm text-[#4F3B2C]">
                        <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                            <tr><th class="px-4 py-2">#</th><th class="px-4 py-2">Participant</th><th class="px-4 py-2">Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td class="px-4 py-2">1</td><td class="px-4 py-2">Liza Ramos</td><td class="px-4 py-2 text-[#6A8A52]">Completed</td></tr>
                            <tr><td class="px-4 py-2">2</td><td class="px-4 py-2">Paolo Cruz</td><td class="px-4 py-2 text-[#A68A4F]">Ongoing</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- 🧹 Clean-Up Drive -->
                <div id="cleanupTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4">Join Clean-Up Drive Participants</h2>
                    <table class="min-w-full text-sm text-[#4F3B2C]">
                        <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                            <tr><th class="px-4 py-2">#</th><th class="px-4 py-2">Participant</th><th class="px-4 py-2">Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td class="px-4 py-2">1</td><td class="px-4 py-2">Ella Gomez</td><td class="px-4 py-2 text-[#A68A4F]">Ongoing</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- 🗂 Quest Collection -->
                <div id="collectionTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4">Quest Collection</h2>
                    <table class="min-w-full text-sm text-[#4F3B2C]">
                        <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                            <tr><th class="px-4 py-2">Quest Name</th><th class="px-4 py-2">Category</th><th class="px-4 py-2">Status</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 text-[#3E5730] hover:underline cursor-pointer quest-link"
                                    data-title="Recycle Initiative" data-category="Environmental"
                                    data-status="Active" data-description="Encourages recycling in local communities.">
                                    Recycle Initiative
                                </td>
                                <td class="px-4 py-2">Environmental</td>
                                <td class="px-4 py-2 text-[#6A8A52]">Active</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 text-[#3E5730] hover:underline cursor-pointer quest-link"
                                    data-title="Water Conservation" data-category="Awareness"
                                    data-status="Draft" data-description="Promotes water-saving practices in households.">
                                    Water Conservation
                                </td>
                                <td class="px-4 py-2">Awareness</td>
                                <td class="px-4 py-2 text-[#A68A4F]">Draft</td>
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
        <button id="closeModal" class="absolute top-3 right-4 text-[#4F6B3F] hover:text-[#2F4025] text-2xl">&times;</button>
        <h2 id="modalTitle" class="text-2xl font-semibold text-[#4F6B3F] mb-2"></h2>
        <p id="modalCategory" class="text-sm text-[#6A8A52] mb-4"></p>
        <p id="modalDescription" class="text-[#3B3B3B] leading-relaxed"></p>
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

            // Toggle search bars
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
    const title = document.getElementById('modalTitle');
    const category = document.getElementById('modalCategory');
    const description = document.getElementById('modalDescription');
    const status = document.getElementById('modalStatus');

    document.querySelectorAll('.quest-link').forEach(link => {
        link.addEventListener('click', () => {
            title.textContent = link.dataset.title;
            category.textContent = "Category: " + link.dataset.category;
            description.textContent = link.dataset.description;
            status.textContent = link.dataset.status;
            status.className = link.dataset.status === 'Active'
                ? 'mt-4 inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-[#4F6B3F]'
                : 'mt-4 inline-block px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-[#A68A4F]';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', e => { if (e.target === modal) modal.classList.add('hidden'); });
});
</script>

@endsection
