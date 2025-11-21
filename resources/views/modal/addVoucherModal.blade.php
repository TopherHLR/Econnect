<!-- resources/views/modals/addVoucherModal.blade.php -->
<div id="addVoucherModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-ticket mr-2"></i> Add New Voucher
            </h2>
            <button onclick="closeAddVoucherModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="voucherForm" class="p-6 space-y-4" method="POST" action="{{ route('vouchers.store') }}">
            @csrf

            <!-- Voucher Title -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Voucher Title</label>
                <input type="text" name="title" maxlength="150" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter voucher title">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Describe the voucher"></textarea>
            </div>

            <!-- Points Required -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Points Required</label>
                <input type="number" name="required_points" min="1" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="Enter points required">
            </div>

            <!-- Discount Value -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Discount Value</label>
                <input type="text" name="discount_value"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]"
                    placeholder="e.g., 10%, $5 off">
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" required
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Status</label>
                <select name="is_active" required
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
                <button type="submit" class="btn-eco btn-leaf">
                    <i class="fa-solid fa-plus"></i> Add Voucher
                </button>
            </div>
        </form>
    </div>
</div>

<!-- QR Scanner Modal (Theme-Matched with Image Upload) -->
<div id="qrScannerModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-qrcode mr-2"></i> Scan Voucher QR Code
            </h3>
            <button onclick="closeQrScanner()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <!-- Webcam Scanner -->
            <div id="qr-reader" style="width:100%; height:348px;" class="rounded-lg border border-[#8B6E4A]/30"></div>

            <!-- Image Upload -->
            <div>
                <label class="block text-[#4F6B3F] font-medium mb-1">Or Upload QR Code Image</label>
                <input type="file" id="qr-file-input" accept="image/*"
                    class="w-full rounded-lg border border-[#8B6E4A]/30 p-2 focus:outline-none focus:ring-2 focus:ring-[#8B6E4A]">
            </div>

            <p id="qr-result" class="text-center text-md text-[#4F3B2C]">Scan QR Code</p>

            <div class="flex justify-end gap-3 pt-3">
                <button onclick="closeQrScanner()" class="btn-eco btn-sand">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    const addVoucherModal = document.getElementById('addVoucherModal');

    function openAddVoucherModal() {
        addVoucherModal.classList.remove('hidden');
    }

    function closeAddVoucherModal() {
        addVoucherModal.classList.add('hidden');
    }

    // Close when clicking backdrop
    addVoucherModal?.addEventListener('click', e => {
        if (e.target === addVoucherModal) closeAddVoucherModal();
    });

    let html5QrCode = null;
    const resultEl = document.getElementById('qr-result');

    function openQrScanner() {
        document.getElementById('qrScannerModal').classList.remove('hidden');
        startQrScanner();
    }

    function closeQrScanner() {
        document.getElementById('qrScannerModal').classList.add('hidden');
        stopScanner();
        document.getElementById('qr-file-input').value = null;
    }

    function stopScanner() {
        if (html5QrCode) {
            html5QrCode.stop().catch(() => {});
            html5QrCode.clear();
            html5QrCode = null;
        }
    }


    let qrCooldown = false; // prevents multiple scans in short time

    function startQrScanner() {
        // Initialize scanner if not already
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }

        const qrReaderEl = document.getElementById('qr-reader');

        // Mirror horizontally and reduce brightness slightly
        qrReaderEl.style.transform = "scaleX(-1)"; // mirror
        qrReaderEl.style.filter = "brightness(0.8) contrast(1.1)"; // dim and increase contrast

        // Start camera scan
        html5QrCode.start({
                facingMode: "environment",
            }, {
                fps: 20,
                qrbox: 250
            },
            qrCodeMessage => handleQrCode(qrCodeMessage)
        ).catch(err => console.error("QR start failed:", err));

        // Handle file input scanning
        const fileInput = document.getElementById('qr-file-input');
        fileInput.onchange = async e => {
            if (e.target.files.length === 0) return;
            const file = e.target.files[0];

            // Stop camera before scanning file
            await html5QrCode.stop().catch(() => {});

            try {
                const qrCodeMessage = await html5QrCode.scanFile(file, true);
                handleQrCode(qrCodeMessage);
            } catch (err) {
                resultEl.textContent = `Error reading image: ${err}`;
            } finally {
                // Restart camera scan after file scan
                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 20,
                        qrbox: 250
                    },
                    qrCodeMessage => handleQrCode(qrCodeMessage)
                ).catch(() => {});
            }
        };
    }


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
