<!-- Create Eco Topic Modal -->
<div id="createEcoTopicModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-leaf mr-2"></i> Add Eco Topic
            </h2>
            <button onclick="closeCreateEcoTopicModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="createEcoTopicForm" class="p-6 space-y-4" method="POST" action="{{ route('libraries.store') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="Topic">

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Title</label>
                <input type="text" name="title" required class="w-full rounded-lg border p-2"
                    placeholder="Enter eco topic title">
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Category</label>
                <input type="text" name="category" class="w-full rounded-lg border p-2"
                    placeholder="e.g. Sustainability, Recycling, Energy Saving">
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Content</label>
                <textarea name="content" rows="5" required class="w-full rounded-lg border p-2"
                    placeholder="Write the eco topic details here..."></textarea>
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Source Link (optional)</label>
                <input type="url" name="source_link" class="w-full rounded-lg border p-2"
                    placeholder="https://example.com">
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border p-2">
            </div>

            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeCreateEcoTopicModal()"
                    class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-[#8B6E4A] text-white font-medium hover:bg-[#7A5F40]">
                    <i class="fa-solid fa-plus mr-1"></i> Add Topic
                </button>
            </div>
        </form>

    </div>
</div>
<!-- Edit Eco Topic Modal -->
<div id="editEcoTopicModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-leaf mr-2"></i> Edit Eco Topic
            </h2>
            <button onclick="closeEditEcoTopicModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="editEcoTopicForm" class="p-6 space-y-4" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="type" value="Topic">

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Title</label>
                <input type="text" name="title" required class="w-full rounded-lg border p-2">
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Category</label>
                <input type="text" name="category" class="w-full rounded-lg border p-2">
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Content</label>
                <textarea name="content" rows="5" required class="w-full rounded-lg border p-2"></textarea>
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Source Link (optional)</label>
                <input type="url" name="source_link" class="w-full rounded-lg border p-2">
            </div>

            <div id="editPreviewWrapper" class="mt-2 hidden">
                <p class="text-sm text-[#4F6B3F] font-medium mb-1">Current Image:</p>
                <img id="editPreviewImage" src="" class="w-32 rounded-lg border shadow-sm">
            </div>

            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border p-2">
            </div>

            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeEditEcoTopicModal()"
                    class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-[#8B6E4A] text-white font-medium hover:bg-[#7A5F40]">
                    <i class="fa-solid fa-pen mr-1"></i> Update Topic
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

<!-- Edit Eco Action Modal -->
<!-- Edit Eco Action Modal -->
<div id="editEcoActionModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-hand-holding-seedling mr-2"></i> Edit Eco Action
            </h2>
            <button onclick="closeEditEcoActionModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="editEcoActionForm" class="p-6 space-y-4" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Action Title</label>
                <input type="text" name="title" required class="w-full rounded-lg border p-2">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Description</label>
                <textarea name="description" rows="4" required class="w-full rounded-lg border p-2"></textarea>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Category (optional)</label>
                <input type="text" name="category" class="w-full rounded-lg border p-2">
            </div>

            <!-- Points Value -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Points Value</label>
                <input type="number" name="points_value" min="1" required
                    class="w-full rounded-lg border p-2">
            </div>

            <!-- Active Toggle -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1"
                    class="w-4 h-4 text-[#8B6E4A] border-[#8B6E4A]/40 rounded">
                <label class="text-[#4F6B3F] font-medium">Set as Active</label>
            </div>

            <!-- Current Image Preview -->
            <div id="editActionPreviewWrapper" class="mt-2 hidden">
                <p class="text-sm text-[#4F6B3F] font-medium mb-1">Current Image:</p>
                <img id="editActionPreviewImage" src="" class="w-32 rounded-lg border shadow-sm">
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border p-2">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeEditEcoActionModal()"
                    class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-full bg-[#8B6E4A] text-white hover:bg-[#7A5F40]">
                    <i class="fa-solid fa-pen mr-1"></i> Update Action
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    // --- MODAL UTILITIES ---
    function openModal(modal) {
        modal.classList.remove('hidden');
    }

    function closeModal(modal) {
        modal.classList.add('hidden');
    }

    function setupModalClose(modal) {
        // Close when clicking on backdrop
        modal.addEventListener('click', e => {
            if (e.target === modal) closeModal(modal);
        });
    }

    function setupEscClose(modal) {
        document.addEventListener('keydown', e => {
            if (e.key === "Escape" && !modal.classList.contains('hidden')) {
                closeModal(modal);
            }
        });
    }

    // --- CREATE ECO TOPIC MODAL ---
    const createModal = document.getElementById('createEcoTopicModal');
    setupModalClose(createModal);
    setupEscClose(createModal);

    function openCreateEcoTopicModal() {
        // Reset form each time
        const form = document.getElementById('createEcoTopicForm');
        form.reset();
        form.action = "{{ route('libraries.store') }}";
        openModal(createModal);
    }

    function closeCreateEcoTopicModal() {
        closeModal(createModal);
    }

    // --- EDIT ECO TOPIC MODAL ---
    const editModal = document.getElementById('editEcoTopicModal');
    setupModalClose(editModal);
    setupEscClose(editModal);

    function closeEditEcoTopicModal() {
        closeModal(editModal);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editEcoTopicModal');

        function openEditEcoTopicModal(topic) {
            const form = document.getElementById('editEcoTopicForm');
            form.action = `/admin/libraries/${topic.id || topic.library_id}`;
            form.querySelector("input[name='title']").value = topic.title ?? '';
            form.querySelector("input[name='category']").value = topic.category ?? '';
            form.querySelector("textarea[name='content']").value = topic.content ?? '';
            form.querySelector("input[name='source_link']").value = topic.source_link ?? '';

            const previewWrapper = document.getElementById("editPreviewWrapper");
            const previewImage = document.getElementById("editPreviewImage");
            if (topic.image_url) {
                previewImage.src = topic.image_url;
                previewWrapper.classList.remove("hidden");
            } else {
                previewWrapper.classList.add("hidden");
            }

            editModal.classList.remove('hidden');
        }

        document.querySelectorAll('.btn-edit-eco').forEach(btn => {
            btn.addEventListener('click', () => {
                const topicData = JSON.parse(btn.dataset.topic);
                topicData.image_url = btn.dataset.image || '';
                openEditEcoTopicModal(topicData);
            });
        });

        editModal.addEventListener('click', e => {
            if (e.target === editModal) editModal.classList.add('hidden');
        });
    });

    // --- ADD ECO ACTION MODAL ---
    const actionModal = document.getElementById('addEcoActionModal');
    setupModalClose(actionModal);
    setupEscClose(actionModal);

    function openEcoActionModal() {
        const form = document.getElementById('ecoActionForm');
        form.reset();
        openModal(actionModal);
    }

    function closeEcoActionModal() {
        closeModal(actionModal);
    }
    // --- EDIT ECO ACTION MODAL ---
    const editActionModal = document.getElementById('editEcoActionModal');
    setupModalClose(editActionModal);
    setupEscClose(editActionModal);
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editEcoActionModal');

        function openEditEcoActionModal(action) {
            const form = document.getElementById('editEcoActionForm');

            // Correct route for update
            form.action = `/admin/actions/${action.action_id}`; // use `id` from DB

            form.querySelector("input[name='title']").value = action.title || '';
            form.querySelector("textarea[name='description']").value = action.description || '';
            form.querySelector("input[name='category']").value = action.category || '';
            form.querySelector("input[name='points_value']").value = action.points_value || '';
            form.querySelector("input[name='is_active']").checked = !!action.is_active;

            const previewWrapper = document.getElementById('editActionPreviewWrapper');
            const previewImage = document.getElementById('editActionPreviewImage');
            if (action.image_url) {
                previewImage.src = action.image_url;
                previewWrapper.classList.remove('hidden');
            } else {
                previewWrapper.classList.add('hidden');
            }

            editModal.classList.remove('hidden');
        }

        function closeEditEcoActionModal() {
            editModal.classList.add('hidden');
        }

        document.querySelectorAll('.btn-edit-eco-action').forEach(btn => {
            btn.addEventListener('click', () => {
                const actionData = JSON.parse(btn.dataset.action);

                // Debug: make sure ID exists
                console.log('Editing action ID:', actionData.action_id);

                actionData.image_url = btn.dataset.image || '';
                openEditEcoActionModal(actionData);
            });
        });


        // Close modal when clicking on backdrop
        editModal.addEventListener('click', e => {
            if (e.target === editModal) closeEditEcoActionModal();
        });
    });


    function closeEditEcoActionModal() {
        closeModal(editActionModal);
    }
</script>
