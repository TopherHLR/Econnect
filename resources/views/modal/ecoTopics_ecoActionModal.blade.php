<!-- Add Eco Topic Modal -->
<div id="addEcoTopicModal"
     class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-leaf mr-2"></i> Add Eco Topic
            </h2>
            <button onclick="closeEcoTopicModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="ecoTopicForm" class="p-6 space-y-4" method="POST" action="{{ route('libraries.store') }}">
            @csrf
            <input type="hidden" name="type" value="Topic">

            <!-- Title -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Title</label>
                <input type="text" name="title" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]" 
                    placeholder="Enter eco topic title">
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Category</label>
                <input type="text" name="category"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]" 
                    placeholder="e.g. Sustainability, Recycling, Energy Saving">
            </div>

            <!-- Content -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Content</label>
                <textarea name="content" rows="5" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]" 
                    placeholder="Write the eco topic details here..."></textarea>
            </div>

            <!-- Source Link -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Source Link (optional)</label>
                <input type="url" name="source_link"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]" 
                    placeholder="https://example.com">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeEcoTopicModal()"
                    class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-[#8B6E4A] text-white font-medium hover:bg-[#7A5F40] transition">
                    <i class="fa-solid fa-plus mr-1"></i> Add Topic
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('addEcoTopicModal');

    function openEcoTopicModal() {
        modal.classList.remove('hidden');
    }

    function closeEcoTopicModal() {
        modal.classList.add('hidden');
    }

    // Optional: close when clicking backdrop
    modal?.addEventListener('click', e => {
        if (e.target === modal) closeEcoTopicModal();
    });
</script>
