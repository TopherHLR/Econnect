<!-- Modal -->
<div id="ecoDetailModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="w-full max-w-3xl rounded-2xl shadow-2xl mt-10 overflow-hidden max-h-[90vh] flex flex-col">
        
        <!-- Brown Header -->
        <div class="bg-[#8B6E4A] text-white rounded-t-2xl px-6 py-4 flex-shrink-0">
            <div class="flex justify-between items-center">
                <h2 id="ecoModalTitle" class="text-xl font-bold flex items-center">
                    <i class="fa-solid fa-leaf mr-3"></i>
                    <!-- Dynamic title will appear here -->
                </h2>
                <button onclick="closeEcoModal()" class="text-white hover:text-[#E0E5D8] transition-transform hover:scale-110">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
        </div>
        
        <!-- White Content Area with fixed height -->
        <div class="bg-[#FCFFF6] border border-[#8B6E4A]/40 border-t-0 p-8 rounded-b-2xl flex-1 overflow-hidden flex flex-col">
            <!-- Image -->
            <img id="ecoModalImage" src="" alt=""
                class="rounded-2xl w-full h-50 object-cover mb-8 border-2 border-[#8B6E4A]/30 shadow-lg flex-shrink-0">
            
            <!-- Description Container -->
            <div id="ecoModalContent" class="flex-1 overflow-y-auto pr-3 custom-scrollbar mb-6">
                <!-- Content will be dynamically filled -->
                <div class="text-center py-12">
                    <div class="inline-block p-5 bg-[#E8EFDF] rounded-full mb-4 animate-pulse">
                        <i class="fa-solid fa-spinner fa-spin text-3xl text-[#5C7919]"></i>
                    </div>
                    <p class="text-[#4F6B3F] text-lg">Loading content...</p>
                </div>
            </div>

            <!-- Footer with category and source link -->
            <div id="ecoModalFooter" class="flex-shrink-0">
                <!-- Dynamic footer content will appear here -->
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

    // Advanced text formatting function
    function formatDescriptionText(text) {
        if (!text) return '';
        
        // Split by paragraphs (double newlines or more)
        const paragraphs = text.split(/\n\s*\n/);
        
        let formattedHTML = '';
        
        paragraphs.forEach(paragraph => {
            paragraph = paragraph.trim();
            if (!paragraph) return;
            
            // Check if this looks like a list
            const lines = paragraph.split('\n').map(line => line.trim()).filter(line => line);
            
            // Check for bullet points or numbered lists
            const hasListItems = lines.some(line => 
                /^\s*[-•*]\s+.+$/.test(line) || /^\s*\d+\.\s+.+$/.test(line)
            );
            
            if (hasListItems && lines.length > 1) {
                // Format as list
                formattedHTML += '<div class="mb-4 last:mb-0">';
                lines.forEach(line => {
                    if (/^\s*[-•*]\s+(.+)$/.test(line)) {
                        // Bullet points
                        const content = line.replace(/^\s*[-•*]\s+/, '');
                        formattedHTML += `
                            <div class="flex items-start gap-2 mb-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-[#5C7919] mt-2 flex-shrink-0"></div>
                                <span class="text-[#4F6B3F] leading-relaxed">${content}</span>
                            </div>
                        `;
                    } else if (/^\s*\d+\.\s+(.+)$/.test(line)) {
                        // Numbered lists
                        const content = line.replace(/^\s*\d+\.\s+/, '');
                        formattedHTML += `
                            <div class="flex items-start gap-2 mb-2">
                                <span class="text-[#5C7919] font-medium flex-shrink-0">${line.match(/^\s*(\d+)\./)[1]}.</span>
                                <span class="text-[#4F6B3F] leading-relaxed">${content}</span>
                            </div>
                        `;
                    } else {
                        // Regular line with line break
                        formattedHTML += `<p class="mb-2 text-[#4F6B3F] leading-relaxed">${line}</p>`;
                    }
                });
                formattedHTML += '</div>';
            } else {
                // Regular paragraph - preserve single line breaks within
                const formattedParagraph = paragraph
                    .split('\n')
                    .map(line => line.trim())
                    .filter(line => line)
                    .join('<br>');
                
                formattedHTML += `<p class="mb-4 last:mb-0 text-[#4F6B3F] leading-relaxed">${formattedParagraph}</p>`;
            }
        });
        
        return formattedHTML;
    }

    function openEcoModal(type, id) {
        currentItemType = type;
        currentItemId = id;

        const modal = document.getElementById('ecoDetailModal');
        const title = document.getElementById('ecoModalTitle');
        const image = document.getElementById('ecoModalImage');
        const content = document.getElementById('ecoModalContent');
        const footer = document.getElementById('ecoModalFooter');

        const url = type === 'ecoTopic' ? `/libraries/${id}` : `/actions/${id}`;

        // Show loading state
        content.innerHTML = `
            <div class="text-center py-12">
                <div class="inline-block p-5 bg-[#E8EFDF] rounded-full mb-4 animate-pulse">
                    <i class="fa-solid fa-spinner fa-spin text-3xl text-[#5C7919]"></i>
                </div>
                <p class="text-[#4F6B3F] text-lg">Loading content...</p>
            </div>
        `;
        footer.innerHTML = '';

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
                // Set modal title with icon
                title.innerHTML = `<i class="fa-solid fa-leaf mr-3"></i>${data.title}`;

                // Build correct image path
                const basePath = type === 'ecoTopic' ?
                    window.assetPaths.ecoLibrary :
                    window.assetPaths.ecoActions;

                image.src = data.image ?
                    `${basePath}/${data.image}` :
                    window.assetPaths.default;

                image.alt = data.title;

                // Main description with advanced formatting
                const mainText = type === 'ecoTopic' ? data.content : data.description;
                
                content.innerHTML = `
                    <div class="bg-white rounded-xl p-6 border border-[#8B6E4A]/20 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-[#E8EFDF] rounded-xl flex-shrink-0 mt-1">
                                <i class="fa-solid fa-lightbulb text-2xl text-[#5C7919]"></i>
                            </div>
                            <div class="flex-1">
                               <h3 class="text-2xl font-serif font-bold text-[#4F6B3F] mb-4">
                                    ${data.title}
                                </h3>
                               <div class="prose prose-2xl prose-green max-w-none text-justify">
                                    ${formatDescriptionText(mainText)}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Footer with category and source link
                let footerHTML = '<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">';

                // Category badge
                if (data.category) {
                    footerHTML += `
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-[#E8EFDF] rounded-lg">
                                <i class="fa-solid fa-tags text-[#5C7919]"></i>
                            </div>
                            <div>
                                <p class="text-sm text-[#6B7D5A]">Category</p>
                                <p class="font-semibold text-[#4F6B3F]">${data.category}</p>
                            </div>
                        </div>
                    `;
                }

                // Source link if available
                if (type === 'ecoTopic' && data.source_link) {
                    footerHTML += `
                        <div class="flex items-center gap-3">
                            <div class="text-sm text-[#6B7D5A]">Source:</div>
                            <a href="${data.source_link}" target="_blank" 
                            class="text-[#5C7919] hover:text-[#4A6613] font-medium hover:underline transition-colors text-sm flex items-center gap-1">
                                <i class="fa-solid fa-external-link-alt text-xs"></i>
                                <span>Visit link</span>
                            </a>
                        </div>
                    `;
                }

                footerHTML += '</div>';
                footer.innerHTML = footerHTML;

                modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                content.innerHTML = `
                    <div class="text-center py-12">
                        <div class="inline-block p-5 bg-[#FFEDED] rounded-full mb-4">
                            <i class="fa-solid fa-exclamation-circle text-2xl text-red-500"></i>
                        </div>
                        <h3 class="text-red-500 font-bold text-xl mb-2">Failed to load content</h3>
                        <p class="text-gray-500">Please try again or check your connection</p>
                    </div>
                `;
                footer.innerHTML = '';
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

<style>
    /* Custom scrollbar styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
        margin: 4px 0;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #8A9A7B, #6B7D5A);
        border-radius: 10px;
        border: 2px solid #f1f1f1;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #7A8C4F, #5A6B4A);
    }
    
    /* Prose styling for better readability */
.prose p {
    font-size: 18px;
    margin-bottom: 1.2em;
    line-height: 1.5;
    text-align: justify;
    text-justify: inter-word;
    hyphens: auto;
    word-spacing: -0.05em;
    margin-right: 1.7%;
}
    
    .prose p:last-child {
        margin-bottom: 0;
    }
    
    /* Smooth fade-in animation */
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>