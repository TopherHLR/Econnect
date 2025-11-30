<!-- Create / Edit Quest Modal -->
<div id="createQuestModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 id="modalTitle" class="text-lg font-semibold flex items-center">
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
            <div x-data="{ custom: false }">
                <label class="block text-[#4F6B3F] font-medium mb-1">Category</label>
                <select x-show="!custom" name="category" x-on:change="custom = ($event.target.value === '__custom')"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
                    <option value="">Select Category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                    <option value="__custom">➕ Add new category...</option>
                </select>
                <div x-show="custom" x-transition>
                    <input type="text" name="custom_category"
                        class="mt-2 w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                        placeholder="Type new category..." x-ref="customInput"
                        x-on:shown="setTimeout(() => $refs.customInput.focus(), 10)">
                    <button type="button" x-on:click="custom = false"
                        class="mt-2 text-sm text-[#4F6B3F] underline hover:text-[#6A8A52]">
                        ← Back to select dropdown
                    </button>
                </div>
            </div>

            <!-- Points Reward -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Points Reward</label>
                <input type="number" name="points_reward" min="1" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter points awarded">
            </div>

            <!-- Required Points -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Required Points</label>
                <input type="number" name="required_points" min="0" value="0"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter minimum points to unlock quest">
            </div>

            <!-- Start & End Date -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Start Date</label>
                <input type="date" name="start_date" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
            </div>
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

                <button type="submit" id="questSubmitBtn" class="btn-eco btn-leaf">
                    <i class="fa-solid fa-plus"></i> Create Quest
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Submission Modal -->
<div id="submissionModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-[#8B6E4A]/40 w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-[#4E3A2E]">Submission Details</h2>
            <button type="button" onclick="closeSubmissionModal()" class="text-gray-600 hover:text-gray-900">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Form for verify/reject -->
        <form id="submissionForm" method="POST" action="{{ route('submissions.process') }}">
            @csrf
            <input type="hidden" name="submission_id" id="modalSubmissionId">
            <input type="hidden" name="action" id="modalAction">

            <div id="modalContent" class="space-y-3">
                <p class="text-gray-500">Click a participant to see submission details.</p>
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

        const form = document.getElementById('questForm');
        form.reset();
        form.action = "{{ route('quests.store') }}"; // reset to create route
        form.method = 'POST';

        // Reset modal title and button
        const modalTitle = questModal.querySelector('h2');
        modalTitle.innerHTML = `<i class="fa-solid fa-bullseye mr-2"></i> Create New Quest`;
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fa-solid fa-plus"></i> Create Quest';

        // Reset _method hidden input if exists
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
    }

    // Close when clicking backdrop
    questModal?.addEventListener('click', e => {
        if (e.target === questModal) closeQuestModal();
    });

    const submissionModal = document.getElementById('submissionModal');
    const modalContent = document.getElementById('modalContent');
    const modalSubmissionId = document.getElementById('modalSubmissionId');
    const modalAction = document.getElementById('modalAction');

    document.querySelectorAll('.participant-name').forEach(nameCell => {
        nameCell.addEventListener('click', (e) => {
            e.stopPropagation(); // prevent row-level clicks if any
            const row = nameCell.closest('tr');

            const submissionId = row.dataset.submissionId;
            const user = row.dataset.user;
            const status = row.dataset.status;
            const proofLink = row.dataset.proofLink;
            const proofImage = row.dataset.proofImage;

            modalSubmissionId.value = submissionId;

            // NEW STATUS LOGIC
            const hasProof = proofLink || proofImage;
            const displayStatus = (status === 'pending' && hasProof) ? 'Submitted' : status;

            // Build modal content
            let html = `
            <p><strong>User:</strong> ${user}</p>
            <p><strong>Status:</strong> ${displayStatus}</p>
            ${proofLink ? `<p><strong>Proof Link:</strong> <a href="${proofLink}" target="_blank">${proofLink}</a></p>` : ''}
            ${proofImage ? `<p><strong>Proof Image:</strong><br><img src="/storage/${proofImage}" class="max-w-full rounded mt-2" /></p>` : ''}
        `;
            if (status.toLowerCase().trim() === 'pending') {
                html += `
                <input type="hidden" name="verified_by" value="{{ auth()->user()->user_id }}">
                <div class="flex justify-end gap-3 mt-4">
                    <button type="submit" onclick="setAction('reject')"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject</button>
                    <button type="submit" onclick="setAction('verify')"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Verify</button>
                </div>
            `;
            }

            modalContent.innerHTML = html;
            submissionModal.classList.remove('hidden');
        });
    });


    function closeSubmissionModal() {
        submissionModal.classList.add('hidden');
    }

    function setAction(action) {
        modalAction.value = action;
    }
    const questForm = document.getElementById('questForm');
    // JS: Prefill form for editing
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            const quest = JSON.parse(button.dataset.quest);

            // Prefill form
            const questForm = document.getElementById('questForm');
            questForm.title.value = quest.title;
            questForm.description.value = quest.description;
            questForm.category.value = quest.category;
            questForm.points_reward.value = quest.points_reward;
            questForm.required_points.value = quest.required_points ?? 0;
            questForm.start_date.value = quest.start_date ?? new Date().toISOString().split('T')[0];
            questForm.end_date.value = quest.end_date;
            questForm.status.value = quest.status;

            // Update modal title
            document.getElementById('modalTitle').textContent = "Edit Quest";

            // Update submit button text & icon
            const submitBtn = document.getElementById('questSubmitBtn');
            submitBtn.innerHTML = '<i class="fa-solid fa-pen"></i> Update Quest';

            // Form action & method
            questForm.action = `/quests/${quest.quest_id}`;
            let methodInput = questForm.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                questForm.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            // Open modal
            openQuestModal();
        });
    });
    // Reset modal when creating new quest
    function openCreateQuestModal() {
        const questForm = document.getElementById('questForm');
        questForm.reset();
        questForm.action = "{{ route('quests.store') }}";
        const methodInput = questForm.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();

        document.getElementById('modalTitle').textContent = "Create New Quest";
        document.getElementById('questSubmitBtn').innerHTML = '<i class="fa-solid fa-plus"></i> Create Quest';

        openQuestModal();
    }
    // Attach submit listener once
    questForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(questForm);
        const action = questForm.action;

        fetch(action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const data = await response.json();
                    throw data;
                }
                return response.json();
            })
            .then(data => {
                closeQuestModal();
                showMessage(data.message, 'success');

                // Update table row (your existing logic)
                const row = document.querySelector(
                    `#collectionTable tr[data-quest-id="${data.quest.quest_id}"]`);
                if (row) {
                    row.querySelector('td:nth-child(2)').textContent = data.quest.title;
                    row.querySelector('td:nth-child(3)').textContent = data.quest.description;
                    row.querySelector('td:nth-child(4)').textContent = data.quest.category || '';
                    row.querySelector('td:nth-child(5)').textContent = data.quest.points_reward;
                    row.querySelector('td:nth-child(6)').textContent = data.quest.start_date;
                    row.querySelector('td:nth-child(7)').textContent = data.quest.end_date;
                    row.querySelector('td:nth-child(8) select').value = data.quest.status;
                }

                // 🔥 NEW: Update Active Quests sidebar
                if (data.quest.status !== 'archived') {
                    const questList = document.getElementById('questList');

                    // Create new <li>
                    const li = document.createElement('li');
                    li.dataset.quest = data.quest.quest_id;
                    li.classList.add('tab-eco', 'cursor-pointer');
                    li.textContent = data.quest.title;

                    // Append to top of Active Quests (before the <hr>)
                    const hr = questList.querySelector('hr');
                    questList.insertBefore(li, hr);
                }
            })

            .catch(error => {
                if (error.errors) {
                    const messages = Object.values(error.errors).flat().join("\n");
                    showMessage(messages, 'error');
                } else {
                    showMessage('Something went wrong.', 'error');
                }
            });
    });


    function showMessage(message, type = 'success') {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.className = type === 'success' ?
            'fixed top-6 left-1/2 -translate-x-1/2 bg-[#f5f8ef]/90 text-[#5C7919] text-lg px-6 py-3 z-[9999] opacity-100 rounded-lg shadow-md' :
            'fixed top-6 left-1/2 -translate-x-1/2 bg-[#fff5f5]/90 text-[#d9534f] text-lg px-6 py-3 z-[9999] opacity-100 rounded-lg shadow-md';

        document.body.appendChild(toast);

        setTimeout(() => toast.remove(), 3000); // auto-remove after 3s
    }
</script>
