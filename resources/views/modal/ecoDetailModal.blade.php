            <!-- Modal -->
            <div id="ecoDetailModal"
                class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm justify-center items-center z-50">
                <div
                    class="bg-white rounded-3xl shadow-lg border border-green-100 max-w-4xl w-full mx-4 p-8 relative animate-fadeIn">
                    <!-- Close Button -->
                    <button onclick="closeEcoModal()"
                        class="absolute top-6 right-6 text-gray-400 hover:text-[#5C7919] transition">
                        ✕
                    </button>

                    <!-- Title -->
                    <h1 id="ecoModalTitle" class="text-3xl font-serif font-semibold text-center text-[#5C7919] mb-6">
                        <!-- Dynamic title -->
                    </h1>

                    <!-- Image -->
                    <img id="ecoModalImage" src="" alt=""
                        class="rounded-xl w-full max-h-[300px] object-cover mb-6">

                    <!-- Content -->
                    <div id="ecoModalContent" class="text-sm leading-relaxed text-gray-700 space-y-3">
                        <!-- Filled dynamically -->
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

                            // Set title
                            title.textContent = data.title;

                            // Build correct image path
                            const basePath = type === 'ecoTopic' ?
                                window.assetPaths.ecoLibrary :
                                window.assetPaths.ecoActions;

                            image.src = data.image ?
                                `${basePath}/${data.image}` :
                                window.assetPaths.default;

                            image.alt = data.title;

                            // Clear previous text
                            content.innerHTML = '';

                            // Main description
                            const mainContent = document.createElement('p');
                            mainContent.textContent = type === 'ecoTopic' ? data.content : data.description;
                            content.appendChild(mainContent);

                            if (data.category) {
                                const category = document.createElement('p');
                                category.innerHTML = `<strong>Category:</strong> ${data.category}`;
                                content.appendChild(category);
                            }

                            if (type === 'ecoTopic' && data.source_link) {
                                const source = document.createElement('p');
                                source.innerHTML =
                                    `<strong>Source:</strong> <a href="${data.source_link}" target="_blank" class="text-[#5C7919] hover:underline">Learn more</a>`;
                                content.appendChild(source);
                            }

                            modal.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                            alert('Failed to load content. Please try again.');
                        });
                }

                // 🌱 Close modal
                function closeEcoModal() {
                    const modal = document.getElementById('ecoDetailModal');
                    modal.classList.add('hidden');
                    currentItemId = null;
                    currentItemType = null;
                }
            </script>
