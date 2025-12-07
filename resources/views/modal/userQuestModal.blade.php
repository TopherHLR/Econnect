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

                    <div id="proofFields">
                        <div>
                            <label class="block text-[#4F6B3F] font-medium mb-1">Proof Link</label>
                            <input type="url" name="proof_link" id="proofLink"
                                class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                                placeholder="Paste a link to your proof (optional)">
                        </div>

                        <div>
                            <label class="block text-[#4F6B3F] font-medium mb-1">Upload Image</label>
                            <input type="file" name="proof_image" id="proofImage"
                                class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                                accept="image/*">
                        </div>
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
        document.addEventListener("DOMContentLoaded", () => {
            @if (session('quest_modal_open'))
                const submissionId = "{{ session('quest_submission_id') }}";

                // Re-open modal with last data
                openAcceptedQuestModal(submissionId);

                // Restore old input
                @if (old('proof_link'))
                    document.getElementById('proofLink').value = "{{ old('proof_link') }}";
                @endif
            @endif
        });
        // Updated Helper function to parse and split description
        function parseQuestDescription(raw) {
            if (!raw) return {
                clean: 'No description available',
                extras: []
            };

            // 1. Fix escaped newlines (Laravel sometimes sends literal \n)
            let text = raw.replace(/\\n/g, '\n');

            // 2. Force line breaks before the keywords even if they are glued
            text = text
                .replace(/Medium\/Channel:/gi, '\nMedium/Channel:')
                .replace(/Strict Guidelines:/gi, '\nStrict Guidelines:')
                .replace(/Verification Proof Required:/gi, '\nVerification Proof Required:');

            const lines = text.split('\n').map(l => l.trim()).filter(Boolean);

            const cleanLines = [];
            const extras = [];

            let insideGuidelines = false;

            lines.forEach(line => {
                const lower = line.toLowerCase();

                // — Medium/Channel —
                if (lower.startsWith('medium/channel:')) {
                    const value = line.substring('medium/channel:'.length).trim();
                    extras.push(`<strong>Medium/Channel:</strong> ${value}`);
                    return;
                }

                // — Verification Proof Required —
                if (lower.startsWith('verification proof required:')) {
                    const value = line.substring('verification proof required:'.length).trim();
                    extras.push(`<strong>Verification Proof Required:</strong> ${value}`);
                    return;
                }

                // — Strict Guidelines header —
                if (lower.startsWith('strict guidelines:')) {
                    extras.push('<strong>Strict Guidelines:</strong>');
                    insideGuidelines = true;
                    // if there is text right after the colon, treat it as first bullet
                    const valueAfterColon = line.substring('strict guidelines:'.length).trim();
                    if (valueAfterColon) {
                        extras.push(`• ${valueAfterColon.replace(/\.:$/, '.').trim()}`);
                    }
                    return;
                }

                // — Guideline bullets (they usually end with . or .: and start with capital letter) —
                if (insideGuidelines && (line.match(/^[A-Z]/) || line.endsWith('.') || line.endsWith('.:'))) {
                    const bullet = line.replace(/\.:$/, '.').trim();
                    extras.push(`• ${bullet}`);
                    return;
                }

                // — If we exited guidelines (very rare) —
                if (insideGuidelines && !line.match(/^[A-Z].*[.:]$/)) {
                    insideGuidelines = false;
                }

                // — Everything else = main description —
                cleanLines.push(line);
            });

            const clean = cleanLines.join(' ').trim() || 'No description provided';

            return {
                clean,
                extras
            };
        }
        // =====
        const activeModal = document.getElementById('activeQuestModal');

        // ==================== Active Quest Modal ====================
        function openActiveQuestModal(quest) {
            const {
                clean,
                extras
            } = parseQuestDescription(quest.description);

            document.getElementById('modalQuestTitle').textContent = quest.title;
            document.getElementById('modalQuestDescription').innerHTML = clean +
                (extras.length > 0 ? '<br><br>' + extras.join('<br>') : '');
            document.getElementById('modalQuestCategory').textContent = quest.category || 'General';
            document.getElementById('modalQuestPoints').textContent = quest.points_reward;
            document.getElementById('modalQuestStatus').textContent = quest.status || 'Active';
            document.getElementById('modalQuestStart').textContent =
                quest.start_date ? new Date(quest.start_date).toLocaleDateString() : 'N/A';
            document.getElementById('modalQuestEnd').textContent =
                quest.end_date ? new Date(quest.end_date).toLocaleDateString() : 'N/A';
            document.getElementById('modalQuestId').value = quest.id;

            document.getElementById('activeQuestModal').classList.remove('hidden');
        }

        function closeActiveQuestModal() {
            activeModal.classList.add('hidden');
        }

        document.querySelectorAll('.eco-card').forEach(item => {
            item.addEventListener('click', function() {

                const quest = {
                    id: this.dataset.id,
                    title: this.dataset.title,
                    description: this.dataset.description || 'No description available',
                    category: this.dataset.category || 'General',
                    points_reward: this.dataset.points,
                    status: this.dataset.status || 'active',

                    // FIXED camelCase access
                    start_date: this.dataset.startDate || null,
                    end_date: this.dataset.endDate || null,
                };

                openActiveQuestModal(quest);
            });
        });

        const acceptedModal = document.getElementById('acceptedQuestModal');

        // ==================== Accepted Quest Modal ====================
        function openAcceptedQuestModal(quest) {
            const {
                clean,
                extras
            } = parseQuestDescription(quest.questDescription || quest.description);

            document.getElementById('modalAcceptedQuestTitle').textContent = quest.questTitle || quest.title;
            document.getElementById('modalAcceptedQuestDescription').innerHTML = clean +
                (extras.length > 0 ? '<br><br>' + extras.join('<br>') : '');

            document.getElementById('modalSubmissionId').value = quest.submissionId || quest.submission_id;

            const proofFields = document.getElementById('proofFields');
            const submitButton = document.querySelector('#acceptedQuestModal button[type="submit"]');

            if ((quest.questTitle || quest.title) === 'Daily Eco Action') {
                proofFields.style.display = 'none';
                submitButton.style.display = 'none';
            } else {
                proofFields.style.display = 'block';
                submitButton.style.display = 'inline-flex';
            }

            document.getElementById('acceptedQuestModal').classList.remove('hidden');
        }


        document.getElementById('acceptedQuestForm').addEventListener('submit', function(e) {
            const proofLink = document.getElementById('proofLink').value.trim();
            const proofImage = document.getElementById('proofImage').files.length;

            if (!proofLink && proofImage === 0) {
                e.preventDefault(); // stop form submission

                // Create the toast div dynamically
                const toast = document.createElement('div');
                toast.id = 'error-toast';
                toast.className =
                    `fixed top-6 left-1/2 -translate-x-1/2 bg-[#fff5f5]/90 border border-[#d9534f]/40 text-[#d9534f]
                    font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000`;
                toast.textContent = '❌ Please provide at least one proof: a link or an image.';

                document.body.appendChild(toast);

                // Auto-hide after 3 seconds
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    setTimeout(() => toast.remove(), 1000); // remove from DOM after transition
                }, 3000);

                return false;
            }
        });



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

        // ==================== View Quest Modal (Completed/Rejected) ====================
        function openViewQuestModal(submission) {
            const {
                clean,
                extras
            } = parseQuestDescription(submission.questDescription || submission.description);

            document.getElementById('viewQuestTitle').textContent = submission.questTitle || submission.title;
            document.getElementById('viewQuestDescription').innerHTML = clean +
                (extras.length > 0 ? '<br><br>' + extras.join('<br>') : '');
            document.getElementById('viewQuestStatus').textContent = submission.status;
            document.getElementById('viewQuestPoints').textContent = submission.pointsReward || '0';
            document.getElementById('viewQuestDate').textContent = submission.date || 'N/A';

            const header = document.getElementById('viewQuestHeader');
            header.classList.remove('bg-red-600', 'bg-green-700');
            if (submission.status === 'completed' || submission.status === 'Completed') {
                header.classList.add('bg-green-700');
            } else if (submission.status === 'rejected' || submission.status === 'Rejected') {
                header.classList.add('bg-red-600');
            }

            document.getElementById('viewQuestModal').classList.remove('hidden');
        }

        function closeViewQuestModal() {
            viewQuestModal.classList.add('hidden');
        }

        // Attach click events to completed/rejected quests
        document.querySelectorAll('.completed-quest, .rejected-quest').forEach(item => {
            item.addEventListener('click', function() {
                const submission = {
                    submissionId: this.dataset.submissionId,
                    questTitle: this.querySelector('span').textContent,
                    questDescription: this.dataset.description || 'No description provided',
                    status: this.classList.contains('completed-quest') ? 'Completed' : 'Rejected',
                    pointsReward: this.querySelector('small')?.textContent?.replace(' pts', '') || '0',
                    date: this.querySelector('small')?.textContent || 'N/A'
                };
                openViewQuestModal(submission);
            });
        });

        // Close modal when clicking backdrop
        viewQuestModal?.addEventListener('click', e => {
            if (e.target === viewQuestModal) closeViewQuestModal();
        });
    </script>
