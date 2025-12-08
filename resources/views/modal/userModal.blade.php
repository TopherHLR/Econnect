<div id="viewUserModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class=" w-full max-w-5xl rounded-2xl shadow-2xl bg-[linear-gradient(135deg,#FFFFFF_0%,#F8F4E7_100%)]
            border-2 border-[#C8D5BB] overflow-auto max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#4A6613] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fas fa-user mr-2"></i> User Details
            </h2>
            <button onclick="closeViewUserModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="p-6 space-y-4">

            <!-- Responsive layout: 2 columns on lg, 1 column on sm -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Left: QR Code -->
                <div class="flex items-center justify-center">
                    <div class="w-64 h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div id="user-qr" class="w-60 h-60"></div>
                    </div>
                    <!-- QR code text -->
                    <p id="user-qr-text" class="mt-2 text-center text-sm text-gray-700"></p>
                </div>

                <!-- Right: User Details -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-[#4F6B3F]">First Name</label>
                            <input type="text" id="view_first_name" class="w-full border p-2 rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block font-medium text-[#4F6B3F]">Middle Name</label>
                            <input type="text" id="view_middle_name" class="w-full border p-2 rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block font-medium text-[#4F6B3F]">Last Name</label>
                            <input type="text" id="view_last_name" class="w-full border p-2 rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block font-medium text-[#4F6B3F]">Email</label>
                            <input type="text" id="view_email" class="w-full border p-2 rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block font-medium text-[#4F6B3F]">User Type</label>
                            <input type="text" id="view_user_type" class="w-full border p-2 rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block font-medium text-[#4F6B3F]">Verified</label>
                            <input type="text" id="view_verified" class="w-full border p-2 rounded-lg" readonly>
                        </div>
                        <div class="col-span-2">
                            <label class="block font-medium text-[#4F6B3F]">Registered</label>
                            <input type="text" id="view_registered" class="w-full border p-2 rounded-lg" readonly>
                        </div>
                    </div>

                    <!-- Connected Data Sections -->
                    <div class="space-y-4 mt-4">
                        <div>
                            <h3 class="font-semibold text-[#4F6B3F] mb-2">Saved Libraries</h3>
                            <ul id="view_libraries" class="list-disc list-inside text-sm text-[#4F3B2C]"></ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-[#4F6B3F] mb-2">Eco Actions</h3>
                            <ul id="view_eco_actions" class="list-disc list-inside text-sm text-[#4F3B2C]"></ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-[#4F6B3F] mb-2">Points History</h3>
                            <ul id="view_points_history" class="list-disc list-inside text-sm text-[#4F3B2C]"></ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-[#4F6B3F] mb-2">Vouchers</h3>
                            <ul id="view_vouchers" class="list-disc list-inside text-sm text-[#4F3B2C]"></ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-[#4F6B3F] mb-2">Feedback</h3>
                            <ul id="view_feedback" class="list-disc list-inside text-sm text-[#4F3B2C]"></ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex justify-end mt-4">
                <button onclick="closeViewUserModal()" class="btn-eco btn-sand">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    // QR code generator function
    function generateUserQrCode(elementId, qrCodeText) {
        const container = document.getElementById(elementId);
        if (!container) return;

        container.innerHTML = ''; // clear old QR

        new QRCode(container, {
            text: qrCodeText,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    // Open modal and populate data
    function openViewUserModal(user) {
        document.getElementById('view_first_name').value = user.first_name;
        document.getElementById('view_middle_name').value = user.middle_name || '';
        document.getElementById('view_last_name').value = user.last_name;
        document.getElementById('view_email').value = user.email;
        document.getElementById('view_user_type').value = user.user_type;
        document.getElementById('view_verified').value = user.is_verified ? 'Yes' : 'No';
        document.getElementById('view_registered').value = user.created_at;

        // Populate connected data...
        const libraries = document.getElementById('view_libraries');
        libraries.innerHTML = '';
        user.savedLibraries?.forEach(lib => {
            const li = document.createElement('li');
            li.textContent = lib.eco_library ? lib.eco_library.title : `Library ID: ${lib.library_id}`;
            libraries.appendChild(li);
        });

        const ecoActions = document.getElementById('view_eco_actions');
        ecoActions.innerHTML = '';
        user.savedEcoActions?.forEach(action => {
            const li = document.createElement('li');
            li.textContent = action.eco_action ? action.eco_action.title : `Action ID: ${action.action_id}`;
            ecoActions.appendChild(li);
        });

        const pointsHistory = document.getElementById('view_points_history');
        pointsHistory.innerHTML = '';
        user.pointsHistory?.forEach(history => {
            const li = document.createElement('li');
            li.textContent = `${history.activity_type} | ${history.points_change} pts | ${history.created_at}`;
            pointsHistory.appendChild(li);
        });

        const vouchers = document.getElementById('view_vouchers');
        vouchers.innerHTML = '';
        user.user_vouchers?.forEach(v => {
            const li = document.createElement('li');
            li.textContent = `${v.voucher?.title || 'Voucher'} | ${v.status}`;
            vouchers.appendChild(li);
        });

        const feedback = document.getElementById('view_feedback');
        feedback.innerHTML = '';
        user.feedbacks?.forEach(f => {
            const li = document.createElement('li');
            li.textContent = `${f.content} | Rating: ${f.rating}`;
            feedback.appendChild(li);
        });

        // Generate QR
        generateUserQrCode("user-qr", user.qr_code);
        // Show QR code text below image
        document.getElementById('user-qr-text').textContent = user.qr_code;
        // Show modal
        document.getElementById('viewUserModal').classList.remove('hidden');
    }

    function closeViewUserModal() {
        document.getElementById('viewUserModal').classList.add('hidden');
    }
</script>
