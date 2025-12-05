<!-- Modal -->
<div id="ecoDetailModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden">
        
        <!-- Brown Header -->
        <div class="bg-[#8B6E4A] text-white rounded-t-2xl px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 id="ecoModalTitle" class="text-lg font-semibold flex items-center">
                    <i class="fa-solid fa-leaf mr-2"></i>
                    <!-- Dynamic title will appear here -->
                </h2>
                <button onclick="closeEcoModal()" class="text-white hover:text-[#E0E5D8]">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- White Content Area -->
        <div class="bg-[#FCFFF6] border border-[#8B6E4A]/40 border-t-0 p-6 rounded-b-2xl">
            <!-- Image -->
            <img id="ecoModalImage" src="" alt=""
                class="rounded-xl w-full h-64 object-cover mb-6 border border-[#8B6E4A]/20">

            <!-- Content -->
            <div id="ecoModalContent" class="space-y-4">
                <!-- Content will be dynamically filled -->
                <div class="text-center py-8">
                    <div class="inline-block p-4 bg-[#E8EFDF] rounded-full mb-3">
                        <i class="fa-solid fa-spinner fa-spin text-2xl text-[#5C7919]"></i>
                    </div>
                    <p class="text-[#4F6B3F]">Loading content...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.assetPaths = {
        ecoLibrary: '{{ asset('storage/eco-library') }}',
        ecoActions: '{{ asset('storage/eco-actions') }}',
        default: '{{ asset('storage/default.png') }}'
    };

    function openEcoModal(type, id) {
        currentItemType = type;
        currentItemId = id;

        const modal = document.getElementById('ecoDetailModal');
        const title = document.getElementById('ecoModalTitle');
        const image = document.getElementById('ecoModalImage');
        const content = document.getElementById('ecoModalContent');

        const url = type === 'ecoTopic' ? `/libraries/${id}` : `/actions/${id}`;

        // Show loading state
        content.innerHTML = `
            <div class="text-center py-8">
                <div class="inline-block p-4 bg-[#E8EFDF] rounded-full mb-3">
                    <i class="fa-solid fa-spinner fa-spin text-2xl text-[#5C7919]"></i>
                </div>
                <p class="text-[#4F6B3F]">Loading content...</p>
            </div>
        `;

        fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Set title with icon
                title.innerHTML = `<i class="fa-solid fa-leaf mr-2"></i>${data.title}`;

                // Build correct image path
                const basePath = type === 'ecoTopic' ?
                    window.assetPaths.ecoLibrary :
                    window.assetPaths.ecoActions;

                image.src = data.image ?
                    `${basePath}/${data.image}` :
                    window.assetPaths.default;

                image.alt = data.title;

                // Build content with consistent styling
                let contentHTML = '';

                // Main description
                const mainText = type === 'ecoTopic' ? data.content : data.description;
                contentHTML += `
                    <div class="bg-white rounded-lg border border-[#8B6E4A]/20 p-4 mb-4">
                        <p class="text-[#4F6B3F] leading-relaxed">${mainText}</p>
                    </div>
                `;

                // Category badge
                if (data.category) {
                    contentHTML += `
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-[#4F6B3F] font-medium">Category:</span>
                            <span class="px-3 py-1 bg-[#E8EFDF] text-[#5C7919] rounded-full text-sm">
                                <i class="fa-solid fa-tag mr-1"></i>${data.category}
                            </span>
                        </div>
                    `;
                }

                // Source link if available
                if (type === 'ecoTopic' && data.source_link) {
                    contentHTML += `
                        <div class="mt-6 pt-4 border-t border-[#8B6E4A]/20">
                            <a href="${data.source_link}" target="_blank" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-[#5C7919] text-white rounded-lg hover:bg-[#4A6613] transition">
                                <i class="fa-solid fa-external-link"></i>
                                Learn More from Source
                            </a>
                        </div>
                    `;
                }

                content.innerHTML = contentHTML;
                modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                content.innerHTML = `
                    <div class="text-center py-8">
                        <div class="inline-block p-4 bg-[#FFEDED] rounded-full mb-3">
                            <i class="fa-solid fa-exclamation-circle text-2xl text-red-500"></i>
                        </div>
                        <p class="text-red-500 font-medium">Failed to load content</p>
                        <p class="text-gray-500 text-sm mt-1">Please try again</p>
                    </div>
                `;
                modal.classList.remove('hidden');
            });
    }

    // Close modal
    function closeEcoModal() {
        const modal = document.getElementById('ecoDetailModal');
        modal.classList.add('hidden');
        currentItemId = null;
        currentItemType = null;
    }

    // Close when clicking backdrop
    document.getElementById('ecoDetailModal')?.addEventListener('click', e => {
        if (e.target === document.getElementById('ecoDetailModal')) {
            closeEcoModal();
        }
    });

    // Close with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEcoModal();
        }
    });
</script>