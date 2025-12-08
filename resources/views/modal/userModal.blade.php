<style>
    .label-eco {
        display: block;
        font-weight: 500;
        color: #4F6B3F;
    }

    .input-eco {
        width: 100%;
        border: 1px solid #D1D5DB;
        padding: 0.5rem;
        border-radius: 0.5rem;
        background: white;
    }

    .section-title {
        font-weight: 600;
        color: #4F6B3F;
        margin-bottom: 0.25rem;
        font-size: 1.125rem;
    }

    .eco-list {
        list-style-type: disc;
        list-style-position: inside;
        font-size: 0.875rem;
        color: #4F3B2C;
    }

    /* Divider line design (NOW VISIBLE) */
    .mlines {
        border-top: 1px solid #C8D5BB;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>


<div id="viewUserModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div
        class=" w-full max-w-5xl rounded-2xl shadow-2xl bg-[linear-gradient(135deg,#FFFFFF_0%,#F8F4E7_100%)]
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
        <div class="p-6 space-y-8">

            <!-- QR + Basic Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <!-- LEFT: QR Code -->
                <div class="flex flex-col items-center justify-center">
                    <div
                        class="w-64 h-64 bg-white shadow-lg rounded-xl flex items-center justify-center border border-gray-300">
                        <div id="user-qr" class="w-56 h-56"></div>
                    </div>

                    <p id="user-qr-text" class="mt-3 text-center text-sm text-gray-700 font-medium"></p>
                </div>

                <!-- RIGHT: User Details -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label-eco">First Name</label>
                            <input type="text" id="view_first_name" class="input-eco" readonly>
                        </div>
                        <div>
                            <label class="label-eco">Middle Name</label>
                            <input type="text" id="view_middle_name" class="input-eco" readonly>
                        </div>
                        <div>
                            <label class="label-eco">Last Name</label>
                            <input type="text" id="view_last_name" class="input-eco" readonly>
                        </div>
                        <div>
                            <label class="label-eco">Email</label>
                            <input type="text" id="view_email" class="input-eco" readonly>
                        </div>
                        <div>
                            <label class="label-eco">User Type</label>
                            <input type="text" id="view_user_type" class="input-eco" readonly>
                        </div>
                        <div>
                            <label class="label-eco">Verified</label>
                            <input type="text" id="view_verified" class="input-eco" readonly>
                        </div>
                        <div class="md:col-span-2">
                            <label class="label-eco">Registered</label>
                            <input type="text" id="view_registered" class="input-eco" readonly>
                        </div>
                    </div>
                </div>

            </div>

            <!-- CONNECTED DATA -->
            <div class="space-y-6">

                <div class="mlines"></div>

                <div>
                    <h3 class="section-title">Saved Libraries</h3>
                    <ul id="view_libraries" class="eco-list"></ul>
                </div>

                <div class="mlines"></div>

                <div>
                    <h3 class="section-title">Eco Actions</h3>
                    <ul id="view_eco_actions" class="eco-list"></ul>
                </div>

                <div class="mlines"></div>

                <div>
                    <h3 class="section-title">Points History</h3>
                    <ul id="view_points_history" class="eco-list"></ul>
                </div>

                <div class="mlines"></div>

                <div>
                    <h3 class="section-title">Vouchers</h3>
                    <ul id="view_vouchers" class="eco-list"></ul>
                </div>

                <div class="mlines"></div>

                <div>
                    <h3 class="section-title">Feedback</h3>
                    <ul id="view_feedback" class="eco-list"></ul>
                </div>
            </div>


            <div class="flex justify-end mt-4">
                <button onclick="closeViewUserModal()" class="btn-eco btn-sand">Close</button>
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
            width: 300,
            height: 300,
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
        document.getElementById('view_registered').value =
            formatReadableDate(user.created_at);

        // Populate connected data...
        const libraries = document.getElementById('view_libraries');
        libraries.innerHTML = '';
        if (user.savedLibraries?.length) {
            user.savedLibraries.forEach(lib => {
                const li = document.createElement('li');
                li.textContent = lib.eco_library ? lib.eco_library.title : `Library ID: ${lib.library_id}`;
                libraries.appendChild(li);
            });
        } else {
            libraries.innerHTML = '<li class="text-gray-500 italic">No saved libraries</li>';
        }


        const ecoActions = document.getElementById('view_eco_actions');
        ecoActions.innerHTML = '';
        if (user.savedEcoActions?.length) {
            user.savedEcoActions.forEach(action => {
                const li = document.createElement('li');
                li.textContent = action.eco_action ? action.eco_action.title : `Action ID: ${action.action_id}`;
                ecoActions.appendChild(li);
            });
        } else {
            ecoActions.innerHTML = '<li class="text-gray-500 italic">No eco actions recorded</li>';
        }

        const pointsHistory = document.getElementById('view_points_history');
        pointsHistory.innerHTML = '';
        if (user.pointsHistory?.length) {
            user.pointsHistory.forEach(history => {
                const li = document.createElement('li');
                li.textContent =
                    `${history.activity_type} | ${history.points_change} pts | ${formatReadableDate(history.created_at)}`;
                pointsHistory.appendChild(li);
            });
        } else {
            pointsHistory.innerHTML = '<li class="text-gray-500 italic">No points history available</li>';
        }

        const vouchers = document.getElementById('view_vouchers');
        vouchers.innerHTML = '';
        if (user.user_vouchers?.length) {
            user.user_vouchers.forEach(v => {
                const li = document.createElement('li');
                li.textContent = `${v.voucher?.title || 'Voucher'} | ${v.status}`;
                vouchers.appendChild(li);
            });
        } else {
            vouchers.innerHTML = '<li class="text-gray-500 italic">No vouchers found</li>';
        }


        const feedback = document.getElementById('view_feedback');
        feedback.innerHTML = '';
        if (user.feedbacks?.length) {
            user.feedbacks.forEach(f => {
                const li = document.createElement('li');
                li.textContent = `${f.content} | Rating: ${f.rating}`;
                feedback.appendChild(li);
            });
        } else {
            feedback.innerHTML = '<li class="text-gray-500 italic">No feedback submitted</li>';
        }


        // Generate QR
        generateUserQrCode("user-qr", user.qr_code);
        // Show QR code text below image
        document.getElementById('user-qr-text').textContent = user.qr_code;
        // Show modal
        document.getElementById('viewUserModal').classList.remove('hidden');
    }

    function formatReadableDate(dateString) {
        if (!dateString) return "";

        const date = new Date(dateString);

        return date.toLocaleString("en-US", {
            weekday: "short",
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });
    }

    function closeViewUserModal() {
        document.getElementById('viewUserModal').classList.add('hidden');
    }
</script>
