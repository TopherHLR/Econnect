<!-- Reward Voucher Modal -->
<div id="voucherModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-[#4b3f2f]">Redeem Voucher</h3>
            <button onclick="closeVoucherModal()" class="text-[#6b665e] hover:text-[#4b3f2f] text-2xl">&times;</button>
        </div>

        <!-- Voucher Details -->
        <div class="space-y-4">
            <div class="bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] rounded-xl p-4 text-white">
                <h4 id="modalVoucherTitle" class="text-lg font-bold mb-2">One Free Coffee</h4>
                <p id="modalVoucherDesc" class="text-sm opacity-90">Enjoy a complimentary coffee at our partner
                    eco-cafes</p>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-[#6b665e]">Required Points</p>
                    <p id="modalRequiredPoints" class="font-semibold text-[#4b3f2f]">60 pts</p>
                </div>
                <div>
                    <p class="text-[#6b665e]">Discount Value</p>
                    <p id="modalDiscountValue" class="font-semibold text-[#4b3f2f]">100%</p>
                </div>
                <div>
                    <p class="text-[#6b665e]">Expiry Date</p>
                    <p id="modalExpiryDate" class="font-semibold text-[#4b3f2f]">Dec 15, 2025</p>
                </div>
                <div>
                    <p class="text-[#6b665e]">Status</p>
                    <p id="modalStatus" class="font-semibold text-green-600">Active</p>
                </div>
            </div>
            <div class="bg-[#f9f8f4] rounded-lg p-4">
                <p class="text-sm text-[#6b665e] mb-2">
                    You currently have:
                    <span class="font-semibold text-[#4b3f2f]" id="userCurrentPoints">{{ $currentPoints }} points</span>
                </p>
                <p class="text-xs text-[#6b665e]">
                    After redemption, you'll have:
                    <span class="font-semibold text-[#4b3f2f]" id="afterRedemptionPoints">-</span>
                </p>

            </div>

        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3 mt-6">
            <button onclick="closeVoucherModal()"
                class="flex-1 bg-[#e8e6dc] text-[#4b3f2f] py-3 rounded-lg font-semibold hover:bg-[#d8d6cc] transition-colors">
                Cancel
            </button>
            <button id="redeemButton"
                class="flex-1 bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>
                Redeem Now
            </button>

        </div>
    </div>
</div>

<!-- My Vouchers Usage Modal -->
<div id="voucherUsageModal"
    class="fixed inset-0 h-screen w-screen bg-black bg-opacity-50 flex items-center justify-center z-100 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-[#4b3f2f]">Use Voucher</h3>
            <button onclick="closeVoucherUsageModal()"
                class="text-[#6b665e] hover:text-[#4b3f2f] text-2xl">&times;</button>
        </div>

        <!-- Voucher Details -->
        <div class="text-center mb-6">
            <h4 id="usageVoucherTitle" class="text-lg font-bold text-[#4b3f2f] mb-2">One Free Coffee</h4>
            <p class="text-sm text-[#6b665e]">Show this QR code to the cashier</p>
        </div>

        <!-- QR Code -->
        <div class="bg-white p-4 rounded-xl border-2 border-dashed border-[#e8e6dc] mb-4 flex justify-center">
            <div class="bg-gray-100 p-4 rounded-lg">
                <!-- Placeholder for QR code -->
                <div id="qrCodeContainer" class="w-48 h-48 flex items-center justify-center"></div>

            </div>
        </div>

        <!-- Voucher Code -->
        <div class="bg-[#f9f8f4] rounded-lg p-4 text-center mb-4">
            <p class="text-sm text-[#6b665e] mb-1">Voucher Code</p>
            <p id="voucherCode" class="text-lg font-mono font-bold text-[#4b3f2f]">sample</p>
        </div>

        <!-- Voucher Info -->
        <div class="space-y-2 text-sm text-[#6b665e] mb-6">
            <div class="flex justify-between">
                <span>Expires:</span>
                <span id="usageExpiryDate" class="font-semibold text-[#4b3f2f]">Dec 15, 2025</span>
            </div>
            <div class="flex justify-between">
                <span>Status:</span>
                <span id="usageStatus" class="font-semibold text-green-600">Ready to use</span>
            </div>
            <div class="flex justify-between">
                <span>Redeemed:</span>
                <span id="redeemedDate" class="font-semibold text-[#4b3f2f]">Nov 10, 2025</span>
            </div>
        </div>

        <!-- Usage Instructions -->
        <div class="bg-[#ecf4e7] rounded-lg p-3 mb-4">
            <p class="text-xs text-[#4b3f2f] text-center">
                📱 Present this QR code at any partner cafe to redeem your voucher
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <button onclick="closeVoucherUsageModal()"
                class="flex-1 bg-[#e8e6dc] text-[#4b3f2f] py-3 rounded-lg font-semibold hover:bg-[#d8d6cc] transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<Script>
    function openVoucherModal(voucherId) {
        const voucher = availableVouchers.find(v => v.voucher_id === voucherId);
        if (!voucher) return alert("Voucher not found");

        document.getElementById('modalVoucherTitle').textContent = voucher.title;
        document.getElementById('modalVoucherDesc').textContent = voucher.description;
        document.getElementById('modalRequiredPoints').textContent = voucher.required_points + ' pts';
        document.getElementById('modalDiscountValue').textContent = voucher.discount_value;

        // Format expiry date
        const expiryDate = new Date(voucher.expiry_date);
        const formattedDate = expiryDate.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
        document.getElementById('modalExpiryDate').textContent = formattedDate;

        document.getElementById('modalStatus').textContent = voucher.is_active ? 'Active' : 'Inactive';

        // Show user points
        const userPoints = {{ $totalPoints }};
        const afterRedemptionEl = document.getElementById('afterRedemptionPoints');
        afterRedemptionEl.textContent = userPoints - voucher.required_points;

        // Enable/disable redeem button
        const redeemButton = document.getElementById('redeemButton');
        if (userPoints >= voucher.required_points && voucher.is_active) {
            redeemButton.disabled = false;
            redeemButton.textContent = 'Redeem Now';
            redeemButton.onclick = () => redeemVoucher(voucher.voucher_id);
        } else {
            redeemButton.disabled = true;
            redeemButton.textContent = !voucher.is_active ? 'Not Available' :
                `Need ${voucher.required_points - userPoints} more pts`;
        }

        document.getElementById('voucherModal').classList.remove('hidden');
    }

    function closeVoucherModal() {
        document.getElementById('voucherModal').classList.add('hidden');
    }

    function openVoucherUsageModal(voucherCode) {
        const uv = myVouchers.find(u => u.voucher_code === voucherCode);
        if (!uv) return alert("Voucher not found");

        document.getElementById('usageVoucherTitle').textContent = uv.voucher.title;
        document.getElementById('voucherCode').textContent = uv.voucher_code;

        // Format expiry date
        const expiryDate = new Date(uv.voucher.expiry_date);
        document.getElementById('usageExpiryDate').textContent = expiryDate.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });

        // Format redeemed date
        if (uv.redeemed_date) {
            const redeemedDate = new Date(uv.redeemed_date);
            document.getElementById('redeemedDate').textContent = redeemedDate.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        } else {
            document.getElementById('redeemedDate').textContent = '-';
        }

        // Status styling
        const statusEl = document.getElementById('usageStatus');
        statusEl.textContent = uv.status === 'active' ? 'Ready to use' : 'Used';
        statusEl.classList.toggle('text-green-600', uv.status === 'active');
        statusEl.classList.toggle('text-gray-600', uv.status !== 'active');

        // Generate QR code
        const qrContainer = document.getElementById('qrCodeContainer');
        qrContainer.innerHTML = ''; // clear previous QR code
        new QRCode(qrContainer, {
            text: uv.qr_code || uv.voucher_code, // fallback to voucher code
            width: 180,
            height: 180,
            colorDark: "#4b3f2f",
            colorLight: "#f9f8f4",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Show modal
        document.getElementById('voucherUsageModal').classList.remove('hidden');
    }



    function closeVoucherUsageModal() {
        document.getElementById('voucherUsageModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('voucherModal').addEventListener('click', function(e) {
        if (e.target === this) closeVoucherModal();
    });

    document.getElementById('voucherUsageModal').addEventListener('click', function(e) {
        if (e.target === this) closeVoucherUsageModal();
    });

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-6 left-1/2 -translate-x-1/2 font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000 
        ${type === 'success' 
            ? 'bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919]' 
            : 'bg-[#fff5f5]/90 border border-[#d9534f]/40 text-[#d9534f]'}`;
        toast.textContent = type === 'success' ? `🌱 ${message}` : `❌ ${message}`;

        document.body.appendChild(toast);

        // Auto-hide
        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 1000);
        }, 3000);
    }

    function redeemVoucher(voucherId) {
        fetch(`/rewards/redeem/${voucherId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json().then(data => ({
                status: res.status,
                body: data
            })))
            .then(({
                status,
                body
            }) => {
                if (status >= 200 && status < 300) {
                    showToast(body.success, 'success');
                    setTimeout(() => location.reload(), 1500); // reload after showing toast
                } else {
                    showToast(body.error || 'Something went wrong', 'error');
                }
            })
            .catch(() => showToast('Something went wrong', 'error'));
    }
</Script>
