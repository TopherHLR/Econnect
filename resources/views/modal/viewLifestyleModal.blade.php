{{-- VIEW MODAL - Matches your existing ecoDetailModal style --}}
<div id="viewEcoModal"
    class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50 overflow-y-auto">
    <div
        class="rounded-3xl shadow-2xl bg-[linear-gradient(135deg,#FFFFFF_0%,#F8F4E7_100%)]
            border-2 border-[#C8D5BB max-w-4xl w-full mx-4 my-8 relative animate-fadeIn">
        <!-- Close Button -->
        <button onclick="closeViewModal()"
            class="absolute top-6 right-6 text-gray-400 hover:text-[#5C7919] transition text-2xl z-10">
            ✕
        </button>

        <!-- Title -->
        <h1 id="viewModalTitle" class="text-4xl font-serif font-bold text-center text-[#5C7919] mb-6 pt-8 px-8">
            Loading...
        </h1>

        <!-- Image -->
        <div class="px-8">
            <img id="viewModalImage" src="" alt="Eco Item"
                class="rounded-2xl w-full max-h-[380px] object-cover border-4 border-[#E0E9D6] shadow-lg">
        </div>

        <!-- Content Body -->
        <div class="p-8 space-y-6">
            <!-- Type Badge -->
            <div class="text-center">
                <span id="viewModalTypeBadge"
                    class="inline-block px-5 py-2 rounded-full text-sm font-medium bg-[#F0F7E6] text-[#4F6B3F]">
                    Eco Topic
                </span>
            </div>

            <!-- Description / Content -->
            <div id="viewModalContent" class="text-base leading-relaxed text-gray-700 prose max-w-none">
                <!-- Will be filled with HTML or plain text -->
            </div>

            <!-- Extra Info Grid (only shown for Eco Actions) -->
            <div id="actionStatsGrid" class="hidden grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">

                <div class="bg-[#F8FBF3] rounded-xl p-5 text-center border border-[#D8E2CA]">
                    <i class="fa-solid fa-tag text-2xl text-[#7A8C4F] mb-2"></i>
                    <p class="text-xs text-[#6A8A52]">Category</p>
                    <p id="viewActionCategory" class="font-bold text-[#4F6B3F]">—</p>
                </div>

            </div>

            <!-- Source Link (only for Eco Library) -->
            <div id="sourceLinkSection" class="hidden mt-6 p-5 bg-[#F0F7E6] rounded-2xl border border-[#D8E2CA]">
                <p class="text-sm font-medium text-[#4F6B3F] flex items-center gap-2">
                    <i class="fa-solid fa-link"></i> Source
                </p>
                <a id="viewSourceLink" href="#" target="_blank" class="text-[#5C7919] hover:underline break-all">
                    View original source
                </a>
            </div>

            <!-- Footer Info -->
            <div class="text-center text-sm text-[#7A8C4F] pt-4 border-t border-[#E0E9D6]">
                Added on <span id="viewModalDate"></span>

                    • Created by <span id="viewCreatorName">{{ auth()->user()->first_name }}</span>

            </div>
        </div>
    </div>
</div>

{{-- JavaScript to Open & Populate Modal --}}
<script>
    function openViewModal(item, type = 'topic') {
        const modal = document.getElementById('viewEcoModal');
        const titleEl = document.getElementById('viewModalTitle');
        const imageEl = document.getElementById('viewModalImage');
        const contentEl = document.getElementById('viewModalContent');
        const typeBadge = document.getElementById('viewModalTypeBadge');
        const dateEl = document.getElementById('viewModalDate');
        const sourceSection = document.getElementById('sourceLinkSection');
        const sourceLink = document.getElementById('viewSourceLink');
        const statsGrid = document.getElementById('actionStatsGrid');

        // Reset
        sourceSection.classList.add('hidden');
        statsGrid.classList.add('hidden');

        // Common fields
        titleEl.textContent = item.title || 'Untitled';
        imageEl.src = item.image_url || item.image || '/images/default.jpg';
        dateEl.textContent = item.created_at ?
            new Date(item.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }) :
            'Unknown date';

        if (type === 'topic') {
            typeBadge.textContent = 'Eco Library • ' + (item.type || 'Tip');
            typeBadge.className = 'inline-block px-5 py-2 rounded-full text-sm font-medium bg-[#F0F7E6] text-[#4F6B3F]';

            // For EcoLibrary: content is rich text (can be HTML)
            contentEl.innerHTML = item.content || '<p class="text-gray-500">No content available.</p>';

            // Source link
            if (item.source_link) {
                sourceLink.href = item.source_link;
                sourceLink.textContent = item.source_link;
                sourceSection.classList.remove('hidden');
            }

        } else if (type === 'action') {
            typeBadge.textContent = 'Eco Action • ' + (item.type || 'Daily');
            typeBadge.className = 'inline-block px-5 py-2 rounded-full text-sm font-medium bg-[#E8F5E8] text-[#2E7D32]';

            // For EcoAction: description is plain text
            contentEl.innerHTML = item.description ?
                `<p class="whitespace-pre-wrap">${item.description.replace(/\n/g, '</p><p>')}</p>` :
                '<p class="text-gray-500">No description available.</p>';

            // Show stats grid

            document.getElementById('viewActionCategory').textContent = item.category || '—';

            statsGrid.classList.remove('hidden');
        }

        modal.classList.remove('hidden');
    }

    function closeViewModal() {
        document.getElementById('viewEcoModal').classList.add('hidden');
    }

    // Close on backdrop
    document.getElementById('viewEcoModal').addEventListener('click', function(e) {
        if (e.target === this) closeViewModal();
    });
</script>
