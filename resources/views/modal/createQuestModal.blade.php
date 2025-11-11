<!-- Create New Quest Modal -->
<div id="createQuestModal"
     class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-bullseye mr-2"></i> Create New Quest
            </h2>
            <button onclick="closeQuestModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="questForm" class="p-6 space-y-4" method="POST" action="{{ route('quests.store') }}">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Quest Title</label>
                <input type="text" name="title" maxlength="150" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]" 
                    placeholder="Enter quest title">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Description</label>
                <textarea name="description" rows="4" required
                        class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]" 
                        placeholder="Describe the quest"></textarea>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Category</label>
                <select name="category" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
                    <option value="">Select Category</option>
                    <option value="Waste Management">Waste Management</option>
                    <option value="Energy Conservation">Energy Conservation</option>
                    <option value="Water Saving">Water Saving</option>
                    <option value="Food Waste Reduction">Food Waste Reduction</option>
                    <option value="Community Advocacy">Community Advocacy</option>
                    <option value="Biodiversity">Biodiversity</option>
                    <option value="Sustainable Fashion">Sustainable Fashion</option>
                    <option value="General Sustainability">General Sustainability</option>
                </select>
            </div>

            <!-- Points Reward -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Points Reward</label>
                <input type="number" name="points_reward" min="1" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]" 
                    placeholder="Enter points awarded">
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Start Date</label>
                <input type="date" name="start_date" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">End Date</label>
                <input type="date" name="end_date" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Status</label>
                <select name="status" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
                    <option value="active">Active</option>
                    <option value="ending_soon">Ending Soon</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-3">
            <button type="button" onclick="closeQuestModal()" class="btn-eco btn-sand">
    Cancel
</button>

<button type="submit" class="btn-eco btn-leaf">
    <i class="fa-solid fa-plus"></i> Create Quest
</button>

            </div>
        </form>
    </div>
</div>

<script>
    const questModal = document.getElementById('createQuestModal');

    function openQuestModal() {
        questModal.classList.remove('hidden');
    }

    function closeQuestModal() {
        questModal.classList.add('hidden');
    }

    // Close when clicking backdrop
    questModal?.addEventListener('click', e => {
        if (e.target === questModal) closeQuestModal();
    });
</script>
