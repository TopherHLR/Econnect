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

                <select id="categorySelect" x-show="!custom" name="category"
                    x-on:change="
            custom = ($event.target.value === '__custom');
            if (!custom) applyCategoryPoints($event.target.value);
        "
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">

                    <option value="">Select Category</option>
                    <option value="Small Quest">Small Quest</option>
                    <option value="Medium Quest">Medium Quest</option>
                    <option value="Big Quest">Big Quest</option>

                    <option value="__custom">➕ Add new category...</option>
                </select>

                <!-- Custom Category Input -->
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
    <div class="bg-white rounded-2xl shadow-2xl border border-[#8B6E4A]/40 w-full max-w-lg p-6 relative">
        <button type="button" onclick="closeSubmissionModal()"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>

        <h2 class="text-xl font-semibold text-[#4E3A2E] mb-4">Submission Details</h2>

        <div id="modalContent" class="space-y-4">
            <p class="text-gray-500">Click a participant to see submission details.</p>
        </div>

        <div id="modalActions" class="mt-6 flex justify-end gap-3 hidden">
            <button id="btnReject"
                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-lg font-medium transition">
                Reject
            </button>
            <button id="btnVerify"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
                Verify & Award Points
            </button>
        </div>
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

    // ——————————————————————————————————————
    // SUBMISSION MODAL – FINAL CLEAN VERSION (AJAX + WORKS EVERYWHERE)
    // ——————————————————————————————————————
    const submissionModal = document.getElementById('submissionModal');
    const modalContent = document.getElementById('modalContent');
    const modalActions = document.getElementById('modalActions');
    let currentSubmissionId = null;

    function closeSubmissionModal() {
        submissionModal.classList.add('hidden');
        modalContent.innerHTML = '<p class="text-gray-500">Click a participant to see submission details.</p>';
        modalActions.classList.add('hidden');
        currentSubmissionId = null;
    }

    // Close on backdrop click
    submissionModal.addEventListener('click', e => {
        if (e.target === submissionModal) closeSubmissionModal();
    });

    // OPEN MODAL – Event Delegation (works on AJAX-loaded rows too!)
    document.addEventListener('click', function(e) {
        const nameCell = e.target.closest('.participant-name');
        if (!nameCell) return;

        const row = nameCell.closest('tr');
        if (!row) return;

        const submissionId = row.dataset.submissionId;
        const user = row.dataset.user || 'Unknown User';
        const status = row.dataset.status || 'pending';
        const proofLink = row.dataset.proofLink;
        const proofImage = row.dataset.proofImage;

        currentSubmissionId = submissionId;

        // Build content
        let html = `
        <div class="space-y-4">
            <p><strong>User:</strong> ${user}</p>
            <p><strong>Status:</strong> 
                <span class="px-3 py-1 rounded text-sm font-medium
                    ${status === 'completed' ? 'bg-green-100 text-green-700' :
                      status === 'rejected' ? 'bg-red-100 text-red-700' :
                      'bg-amber-100 text-amber-700'}">
                    ${status.charAt(0).toUpperCase() + status.slice(1)}
                </span>
            </p>
            ${proofLink ? `<p><strong>Proof Link:</strong> <a href="${proofLink}" target="_blank" class="text-blue-600 underline hover:text-blue-800">${proofLink}</a></p>` : ''}
            ${proofImage ? `<p><strong>Proof Image:</strong><br><img src="/storage/${proofImage}" class="max-w-full rounded-lg border mt-3" alt="Proof"></p>` : ''}
            ${!proofLink && !proofImage ? '<p class="text-amber-600 italic">No proof submitted yet.</p>' : ''}
        </div>
    `;

        modalContent.innerHTML = html;

        // Show action buttons only if pending
        if (status === 'pending') {
            modalActions.classList.remove('hidden');
        } else {
            modalActions.classList.add('hidden');
            modalContent.innerHTML +=
                `<div class="text-center mt-6 text-gray-500 text-sm font-medium">Already processed</div>`;
        }

        submissionModal.classList.remove('hidden');
    });

    // VERIFY & REJECT BUTTONS
    document.getElementById('btnVerify').addEventListener('click', () => processSubmission('completed'));
    document.getElementById('btnReject').addEventListener('click', () => processSubmission('rejected'));
    
    function applyCategoryPoints(category) {
        const pointsReward = document.querySelector('input[name="points_reward"]');
        const requiredPoints = document.querySelector('input[name="required_points"]');

        // Default values for each category
        const preset = {
            "Small Quest": { reward: 10, required: 0 },
            "Medium Quest": { reward: 25, required: 10 },
            "Big Quest": { reward: 50, required: 20 }
        };

        if (preset[category]) {
            pointsReward.value = preset[category].reward;
            requiredPoints.value = preset[category].required;
        }
    }
    function processSubmission(newStatus) {
        if (!currentSubmissionId) return;

        const btnVerify = document.getElementById('btnVerify');
        const btnReject = document.getElementById('btnReject');
        const origVerify = btnVerify.textContent;
        const origReject = btnReject.textContent;

        btnVerify.disabled = true;
        btnReject.disabled = true;
        btnVerify.textContent = 'Processing...';
        btnReject.textContent = 'Processing...';

        fetch(`/submissions/${currentSubmissionId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showMessage(newStatus === 'completed' ? 'Verified & points awarded!' : 'Rejected', 'success');
                    closeSubmissionModal();

                    // Update table row instantly
                    const row = document.querySelector(`tr[data-submission-id="${currentSubmissionId}"]`);
                    if (row) {
                        row.dataset.status = newStatus;

                        // Update dropdown
                        const select = row.querySelector('.submission-status');
                        if (select) {
                            select.dataset.currentStatus = newStatus;
                            const hasProof = !!row.dataset.proofLink || !!row.dataset.proofImage;
                            select.innerHTML = `
                        <option value="pending" ${newStatus === 'pending' && !hasProof ? 'selected' : ''}>Pending</option>
                        ${newStatus === 'pending' && hasProof ? '<option value="pending" selected class="font-medium text-amber-700">Submitted (Has Proof)</option>' : ''}
                        <option value="completed" ${newStatus === 'completed' ? 'selected' : ''} class="font-medium text-green-700">Completed</option>
                        <option value="rejected" ${newStatus === 'rejected' ? 'selected' : ''} class="font-medium text-red-700">Rejected</option>
                    `;
                        }

                        // Update "Checked By"
                        const checkedCell = row.cells[3];
                        const action = newStatus === 'completed' ? 'Verified' : 'Rejected';
                        const color = newStatus === 'completed' ? 'text-green-600' : 'text-red-600';
                        checkedCell.innerHTML =
                            `<span class="${color} font-medium">${action} by {{ auth()->user()->first_name }}</span>`;
                    }
                } else throw new Error('Failed');
            })
            .catch(err => {
                console.error(err);
                showMessage('Action failed', 'error');
            })
            .finally(() => {
                btnVerify.disabled = false;
                btnReject.disabled = false;
                btnVerify.textContent = origVerify;
                btnReject.textContent = origReject;
            });
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

        // ALWAYS send as POST – Laravel will read _method if it exists
        fetch(action, {
                method: 'POST', // ← always POST
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    // DO NOT set Content-Type → browser sets correct multipart boundary
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const err = await response.json();
                    throw err;
                }
                return response.json();
            })
            .then(data => {
                closeQuestModal();
                showMessage(data.message || 'Quest saved!', 'success');

                // Update table row
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

                // Update sidebar if not archived
                if (data.quest.status !== 'archived') {
                    const questList = document.getElementById('questList');
                    let li = questList.querySelector(`li[data-quest="${data.quest.quest_id}"]`);
                    if (!li) {
                        li = document.createElement('li');
                        li.dataset.quest = data.quest.quest_id;
                        li.classList.add('tab-eco', 'cursor-pointer');
                        const hr = questList.querySelector('hr');
                        questList.insertBefore(li, hr);
                    }
                    li.textContent = data.quest.title;
                }

                // Only reload on create if you didn't append the row yourself
                if (!document.querySelector(`tr[data-quest-id="${data.quest.quest_id}"]`)) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Quest save error:', error);
                let msg = 'Failed to save quest.';
                if (error.errors) {
                    msg = Object.values(error.errors).flat().join('<br>');
                } else if (error.message) {
                    msg = error.message;
                }
                showMessage(msg, 'error');
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
