<!-- Add/Edit Eco Topic Modal -->
<div id="ecoTopicModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 id="ecoModalTitle" class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-leaf mr-2"></i> Add Eco Topic
            </h2>
            <button onclick="closeEcoTopicModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="ecoTopicForm" class="p-6 space-y-4" method="POST" action="{{ route('libraries.store') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="Topic">

            <!-- Title -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Title</label>
                <input type="text" name="title" required class="w-full rounded-lg border p-2"
                    placeholder="Enter eco topic title">
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Category</label>
                <input type="text" name="category" class="w-full rounded-lg border p-2"
                    placeholder="e.g. Sustainability, Recycling, Energy Saving">
            </div>

            <!-- Content -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Content</label>
                <textarea name="content" rows="5" required class="w-full rounded-lg border p-2"
                    placeholder="Write the eco topic details here..."></textarea>
            </div>

            <!-- Source Link -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Source Link (optional)</label>
                <input type="url" name="source_link" class="w-full rounded-lg border p-2"
                    placeholder="https://example.com">
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border p-2">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeEcoTopicModal()"
                    class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" id="ecoTopicSubmitBtn"
                    class="px-5 py-2 rounded-full bg-[#8B6E4A] text-white font-medium hover:bg-[#7A5F40]">
                    <i class="fa-solid fa-plus mr-1"></i> Add Topic
                </button>
            </div>
        </form>

    </div>
</div>


<!-- Add Eco Action Modal -->
<div id="addEcoActionModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-hand-holding-seedling mr-2"></i> Add Eco Action
            </h2>
            <button onclick="closeEcoActionModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="ecoActionForm" class="p-6 space-y-4" method="POST" action="{{ route('ecoactions.store') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="Action">
            <!-- Title -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Action Title</label>
                <input type="text" name="title" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter eco action title (e.g. Plant a tree)">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Description</label>
                <textarea name="description" rows="4" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Describe the eco action and how users can complete it."></textarea>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Category (optional)</label>
                <input type="text" name="category"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="e.g. Recycling, Energy Saving, Community">
            </div>

            <!-- Points Value -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Points Value</label>
                <input type="number" name="points_value" min="1" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter points earned (e.g. 5)">
            </div>

            <!-- Active Toggle -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked
                    class="w-4 h-4 text-[#8B6E4A] border-[#8B6E4A]/40 rounded focus:ring-[#8B6E4A]">
                <label class="text-[#4F6B3F] font-medium">Set as Active</label>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Image (optional)</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeEcoActionModal()"
                    class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-[#8B6E4A] text-white font-medium hover:bg-[#7A5F40] transition">
                    <i class="fa-solid fa-plus mr-1"></i> Add Action
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('ecoTopicModal');

    function openEcoTopicModal() {
        modal.classList.remove('hidden');
    }

    function closeEcoTopicModal() {
        modal.classList.add('hidden');
    }
    // Open "Add Eco Topic" modal
    function openCreateEcoTopicModal() {
        const form = document.getElementById('ecoTopicForm');
        form.reset();
        form.action = "{{ route('libraries.store') }}";

        // Remove PUT method input if exists
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();

        document.getElementById('ecoModalTitle').textContent = "Add Eco Topic";
        document.getElementById('ecoTopicSubmitBtn').innerHTML = '<i class="fa-solid fa-plus mr-1"></i> Add Topic';

        openEcoTopicModal();
    }

    // Open "Edit Eco Topic" modal
    document.querySelectorAll('.btn-edit-eco').forEach(button => {
        button.addEventListener('click', () => {
            const topic = JSON.parse(button.dataset.topic); // make sure data-topic has the topic JSON

            const form = document.getElementById('ecoTopicForm');
            form.title.value = topic.title;
            form.content.value = topic.content;
            form.category.value = topic.category || '';
            form.source_link.value = topic.source_link || '';

            document.getElementById('ecoModalTitle').textContent = "Edit Eco Topic";
            document.getElementById('ecoTopicSubmitBtn').innerHTML =
                '<i class="fa-solid fa-pen mr-1"></i> Update Topic';

            // Update form action & method
            form.action = `/admin/libraries/${topic.library_id}`;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            openEcoTopicModal();
        });
    });
    // Optional: close when clicking backdrop
    modal?.addEventListener('click', e => {
        if (e.target === modal) closeEcoTopicModal();
    });

    const actionModal = document.getElementById('addEcoActionModal');

    function openEcoActionModal() {
        actionModal.classList.remove('hidden');
    }

    function closeEcoActionModal() {
        actionModal.classList.add('hidden');
    }

    // Optional: close when clicking backdrop
    actionModal?.addEventListener('click', e => {
        if (e.target === actionModal) closeEcoActionModal();
    });
</script>
