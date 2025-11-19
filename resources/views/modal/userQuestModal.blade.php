    <!-- 🔹 Active Quest Modal -->
    <div id="activeQuestModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
                <h2 class="text-lg font-semibold flex items-center">
                    <i class="fa-solid fa-bullseye mr-2"></i> Active Eco Quest
                </h2>
                <button onclick="closeActiveQuestModal()" class="text-white hover:text-[#E0E5D8]">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <!-- Quest Info (dynamic) -->
                <p><strong>Title:</strong> <span id="modalQuestTitle"></span></p>
                <p><strong>Description:</strong> <span id="modalQuestDescription"></span></p>
                <p><strong>Category:</strong> <span id="modalQuestCategory"></span></p>
                <p><strong>Points Reward:</strong> <span id="modalQuestPoints"></span> pts 🌱</p>
                <p><strong>Status:</strong> <span id="modalQuestStatus"></span></p>
                <p><strong>Start Date:</strong> <span id="modalQuestStart"></span></p>
                <p><strong>End Date:</strong> <span id="modalQuestEnd"></span></p>

                <!-- Accept Challenge Form -->
                <form id="acceptQuestForm" method="POST" action="{{ route('quests.accept') }}">
                    @csrf
                    <input type="hidden" name="quest_id" id="modalQuestId">
                    <div class="flex justify-center mt-4">
                        <button type="submit" class="btn-eco btn-leaf flex items-center gap-2">
                            <i class="fa-solid fa-check"></i> Accept Challenge
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- 🔹 Accepted Quest Submission Modal -->
    <div id="acceptedQuestModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
                <h2 class="text-lg font-semibold flex items-center">
                    <i class="fa-solid fa-bullseye mr-2"></i> Submit Quest Progress
                </h2>
                <button onclick="closeAcceptedQuestModal()" class="text-white hover:text-[#E0E5D8]">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <!-- Quest Info (dynamic) -->
                <p><strong>Title:</strong> <span id="modalAcceptedQuestTitle"></span></p>
                <p><strong>Description:</strong> <span id="modalAcceptedQuestDescription"></span></p>


                <!-- Submission Form -->
                <form id="acceptedQuestForm" method="POST" action="{{ route('quests.submit') }}"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="submission_id" id="modalSubmissionId">

                    <div>
                        <label class="block text-[#4F6B3F] font-medium mb-1">Proof Link</label>
                        <input type="url" name="proof_link"
                            class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                            placeholder="Paste a link to your proof (optional)">
                    </div>

                    <div>
                        <label class="block text-[#4F6B3F] font-medium mb-1">Upload Image</label>
                        <input type="file" name="proof_image"
                            class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                            accept="image/*">
                    </div>

                    <div class="flex justify-end gap-3 pt-3">
                        <button type="button" onclick="closeAcceptedQuestModal()"
                            class="btn-eco btn-sand">Cancel</button>
                        <button type="submit" class="btn-eco btn-leaf"><i class="fa-solid fa-paper-plane"></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 🔹 Quest View Modal (Completed & Rejected) -->
    <div id="viewQuestModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

            <!-- Modal Header -->
            <div id="viewQuestHeader" class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
                <h2 id="viewQuestTitleHeader" class="text-lg font-semibold flex items-center">
                    <i class="fa-solid fa-bullseye mr-2"></i> Quest Details
                </h2>
                <button onclick="closeViewQuestModal()" class="text-white hover:text-[#E0E5D8]">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <p><strong>Title:</strong> <span id="viewQuestTitle"></span></p>
                <p><strong>Description:</strong> <span id="viewQuestDescription"></span></p>
                <p><strong>Status:</strong> <span id="viewQuestStatus"></span></p>
                <p><strong>Points Reward:</strong> <span id="viewQuestPoints"></span> pts 🌱</p>
                <p><strong>Date Completed / Rejected:</strong> <span id="viewQuestDate"></span></p>
            </div>
        </div>
    </div>


    <script>
        const activeModal = document.getElementById('activeQuestModal');

        function openActiveQuestModal(quest) {
            // Set basic fields
            document.getElementById('modalQuestTitle').textContent = quest.title;
            document.getElementById('modalQuestCategory').textContent = quest.category;
            document.getElementById('modalQuestPoints').textContent = quest.points_reward;
            document.getElementById('modalQuestStatus').textContent = quest.status;
            document.getElementById('modalQuestStart').textContent = new Date(quest.start_date).toLocaleDateString();
            document.getElementById('modalQuestEnd').textContent = new Date(quest.end_date).toLocaleDateString();

            // Parse description and format labels
            let formattedDesc = '';

            if (quest.description) {
                const labels = ['Medium/Channel:', 'Step:', 'Strict Guidelines:', 'Points:', 'Deadline:',
                    'Verification Proof Required:'
                ];
                const escapedLabels = labels.map(label => label.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'));
                const regex = new RegExp(`(${escapedLabels.join('|')})`, 'gi');

                // Replace labels with <br><strong>LABEL</strong>
                formattedDesc = quest.description.replace(regex, '<br><strong>$1</strong>');
            }

            // Inject formatted description
            document.getElementById('modalQuestDescription').innerHTML = formattedDesc;

            // Set hidden input value for form submission
            document.getElementById('modalQuestId').value = quest.id;

            // Show modal
            activeModal.classList.remove('hidden');
        }



        function closeActiveQuestModal() {
            activeModal.classList.add('hidden');
        }

        // Attach click events to quest cards
        document.querySelectorAll('.eco-card').forEach(item => {
            item.addEventListener('click', function() {
                const quest = {
                    id: this.dataset.id,
                    title: this.querySelector('h3').textContent,
                    description: this.dataset.description ||
                        'No description available', // optional: pass real description from blade
                    category: this.dataset.category || 'General',
                    points_reward: this.querySelector('p.font-bold').textContent.replace(' pts 🌱', ''),
                    status: 'active',
                    start_date: this.dataset.start_date || new Date().toISOString(),
                    end_date: this.dataset.end_date || new Date().toISOString(),
                };

                openActiveQuestModal(quest);
            });
        });
        const acceptedModal = document.getElementById('acceptedQuestModal');

        function openAcceptedQuestModal(submission) {
            // Set title
            document.getElementById('modalAcceptedQuestTitle').textContent = submission.questTitle;

            let formattedDesc = '';

            if (submission.questDescription) {
                // List of labels to bold and separate
                const labels = ['Medium/Channel:', 'Step:', 'Strict Guidelines:', 'Points:', 'Deadline:',
                    'Verification Proof Required:'
                ];

                // Escape special regex characters in labels
                const escapedLabels = labels.map(label => label.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'));

                // Build regex to match all labels
                const regex = new RegExp(`(${escapedLabels.join('|')})`, 'gi');

                // Replace labels with <br><strong>LABEL</strong>
                formattedDesc = submission.questDescription.replace(regex, '<br><strong>$1</strong>');
            }

            // Inject into modal
            document.getElementById('modalAcceptedQuestDescription').innerHTML = formattedDesc;

            // Set hidden submission ID for form
            document.getElementById('modalSubmissionId').value = submission.submissionId;

            // Show modal
            acceptedModal.classList.remove('hidden');
        }


        function closeAcceptedQuestModal() {
            acceptedModal.classList.add('hidden');
        }



        function closeAcceptedQuestModal() {
            acceptedModal.classList.add('hidden');
        }

        // Attach click events to left column accepted quests
        document.querySelectorAll('.accepted-quest').forEach(item => {
            item.addEventListener('click', function() {
                const submission = {
                    submissionId: this.dataset.submissionId,
                    questTitle: this.querySelector('span').textContent,
                    questDescription: this.dataset.description ||
                        'No description provided', // optional: pass from Blade
                };
                openAcceptedQuestModal(submission);
            });
        });

        // Close modal when clicking backdrop
        acceptedModal?.addEventListener('click', e => {
            if (e.target === acceptedModal) closeAcceptedQuestModal();
        });
        const viewQuestModal = document.getElementById('viewQuestModal');

        function openViewQuestModal(submission) {
            document.getElementById('viewQuestTitle').textContent = submission.questTitle;
            document.getElementById('viewQuestDescription').textContent = submission.questDescription;
            document.getElementById('viewQuestStatus').textContent = submission.status;
            document.getElementById('viewQuestPoints').textContent = submission.pointsReward;

            // Show completed/rejected date
            document.getElementById('viewQuestDate').textContent = submission.date || 'N/A';

            // Change header color based on status
            const header = document.getElementById('viewQuestHeader');
            if (submission.status === 'completed') {
                header.classList.remove('bg-red-600');
                header.classList.add('bg-green-700');
            } else if (submission.status === 'rejected') {
                header.classList.remove('bg-green-700');
                header.classList.add('bg-red-600');
            }

            viewQuestModal.classList.remove('hidden');
        }

        function closeViewQuestModal() {
            viewQuestModal.classList.add('hidden');
        }

        document.querySelectorAll('.completed-quest, .rejected-quest').forEach(item => {
            item.addEventListener('click', function() {
                const submission = {
                    submissionId: this.dataset.submissionId,
                    questTitle: this.dataset.title,
                    questDescription: this.dataset.description || 'No description provided',
                    status: this.classList.contains('completed-quest') ? 'Completed' : 'Rejected',
                    pointsReward: this.dataset.points || '0',
                    date: this.dataset.date || 'N/A'
                };
                openViewQuestModal(submission);
            });
        });


        // Close modal when clicking backdrop
        viewQuestModal?.addEventListener('click', e => {
            if (e.target === viewQuestModal) closeViewQuestModal();
        });
    </script>
