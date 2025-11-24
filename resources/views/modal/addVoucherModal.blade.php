<div id="addVoucherModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 id="voucherModalTitle" class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-ticket mr-2"></i> Add New Voucher
            </h2>
            <button onclick="closeAddVoucherModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="voucherForm" class="p-6 space-y-4" method="POST">
            @csrf
            <input type="hidden" id="voucherMethod" name="_method" value="POST">
            <!-- Voucher Title -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Voucher Title</label>
                <input type="text" id="title" name="title" maxlength="150" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter voucher title">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Describe the voucher"></textarea>
            </div>

            <!-- Points Required -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Points Required</label>
                <input type="number" id="required_points" name="required_points" min="1" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter points required">
            </div>

            <!-- Discount Value -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Discount Value</label>
                <input type="text" id="discount_value" name="discount_value"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="e.g., 10%, $5 off">
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Status</label>
                <select id="is_active" name="is_active" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <!-- Modal Buttons -->
            <div class="flex justify-end gap-3 pt-3">
                <button type="button" onclick="closeAddVoucherModal()" class="btn-eco btn-sand">
                    Cancel
                </button>
                <button type="submit" id="voucherSubmit" class="btn-eco btn-leaf">
                    <i class="fa-solid fa-plus"></i> Add Voucher
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const modal = document.getElementById('addVoucherModal');
    const form = document.getElementById('voucherForm');
    const modalTitle = document.getElementById('voucherModalTitle');
    const methodField = document.getElementById('voucherMethod');
    const voucherSubmit = document.getElementById('voucherSubmit');

    // OPEN for ADD
    function openAddVoucherModal() {
        form.reset();
        modalTitle.innerHTML = `<i class="fa-solid fa-ticket mr-2"></i> Add New Voucher`;
        voucherSubmit.innerHTML = `<i class="fa-solid fa-plus"></i> Add Voucher`;

        form.action = "{{ route('vouchers.store') }}";
        methodField.value = "POST";

        modal.classList.remove('hidden');

    }

    // OPEN for EDIT
    function openEditVoucherModal(voucher) {
        modalTitle.innerHTML = `<i class="fa-solid fa-ticket mr-2"></i> Edit Voucher`;
        voucherSubmit.innerHTML = `<i class="fa-solid fas fa-edit "></i> Update Voucher`;


        form.action = `/rewards/update/${voucher.voucher_id}`;

        methodField.value = "PUT";

        // fill inputs
        form.title.value = voucher.title;
        form.description.value = voucher.description;
        form.required_points.value = voucher.required_points;
        form.discount_value.value = voucher.discount_value;
        form.is_active.value = voucher.is_active ? 1 : 0;
        form.expiry_date.value = voucher.expiry_date; // "2025-11-26"




        modal.classList.remove('hidden');
    }

    function closeAddVoucherModal() {
        modal.classList.add('hidden');
    }

    function closeAddVoucherModal() {
        addVoucherModal.classList.add('hidden');
    }

    // Close when clicking backdrop
    addVoucherModal?.addEventListener('click', e => {
        if (e.target === addVoucherModal) closeAddVoucherModal();
    });

    function handleQrCode(qrCodeMessage) {
        if (qrCooldown) return; // skip if in cooldown
        qrCooldown = true; // start cooldown

        // Show scanned message
        resultEl.textContent = `Scanned: ${qrCodeMessage}`;

        let overlay = document.createElement('div');
        overlay.textContent = "QR Code Processed";
        overlay.style.position = "absolute";
        overlay.style.top = "50px";
        overlay.style.left = "50%";
        overlay.style.transform = "translateX(-50%) scaleX(-1)"; // flip overlay back
        overlay.style.backgroundColor = "rgba(0,0,0,0.6)";
        overlay.style.color = "white";
        overlay.style.padding = "10px 20px";
        overlay.style.borderRadius = "10px";
        overlay.style.fontWeight = "bold";
        overlay.style.zIndex = "9999";
        overlay.style.pointerEvents = "none";

        // Append to body or the scanner container
        document.getElementById('qr-reader').appendChild(overlay);

        fetch(`/admin/voucher/redeem/${qrCodeMessage}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    status: 'Used'
                })
            })
            .then(res => res.json())
            .then(data => {
                resultEl.textContent = data.success ? `Voucher redeemed successfully!` : `Error: ${data.error}`;
            })
            .catch(err => resultEl.textContent = `Error: ${err}`);

        // Remove overlay and reset cooldown after 3 seconds
        setTimeout(() => {
            qrCooldown = false;
            overlay.remove();
        }, 3000);
    }
</script>
