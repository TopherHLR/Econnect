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

<!-- Verify User Modal -->
<div id="verifyUserModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-2xl rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-qrcode mr-2"></i> Verify User
            </h2>
            <button onclick="closeVerifyModal()" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="p-6 space-y-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Scan QR Section -->
            <div onclick="openUserQrScanner()"
                class="border border-[#8B6E4A]/30 rounded-xl p-4 flex flex-col items-center justify-center hover:shadow-lg transition cursor-pointer">
                <h3 class="font-semibold text-[#4F6B3F] mb-2 text-center">Option 1: Scan User QR</h3>
                <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                    <i class="fa-solid fa-camera text-3xl"></i>
                    <span class="ml-2">Camera Placeholder</span>
                </div>
                <p class="text-sm text-[#6A8A52] mt-2 text-center">
                    Point your camera here to scan the user’s QR code.
                </p>
            </div>

            <!-- Admin QR Section -->
            <div
                class="border border-[#8B6E4A]/30 rounded-xl p-4 flex flex-col items-center justify-center hover:shadow-lg transition cursor-pointer">
                <h3 class="font-semibold text-[#4F6B3F] mb-2 text-center">Option 2: Show Admin QR</h3>
                <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-600">
                    <i class="fa-solid fa-qrcode text-4xl"></i>
                </div>
                <p class="text-sm text-[#6A8A52] mt-2 text-center">
                    Let users scan this QR code if they don't have one.
                </p>
                <button class="mt-2 btn-eco btn-mint text-sm">Copy QR</button>
            </div>

        </div>
        <div id="user-info-panel" class="hidden border p-4 rounded">
            <h3 class="text-lg font-bold mb-2">User Details</h3>

            <p><strong>Name:</strong> <span id="details-name">–</span></p>
            <p><strong>Email:</strong> <span id="details-email">–</span></p>
            <p><strong>User Type:</strong> <span id="details-type">–</span></p>
            <p><strong>Verification:</strong> <span id="details-status">–</span></p>
            <p><strong>Active:</strong> <span id="details-active">–</span></p>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-[#8B6E4A]/20">
            <button onclick="closeVerifyModal()" class="btn-eco btn-sand">Close</button>
        </div>

    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    let qrMode = "voucher"; // default
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
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }

        const qrReaderEl = document.getElementById('qr-reader');
        qrReaderEl.style.transform = "scaleX(-1)";
        qrReaderEl.style.filter = "brightness(0.8) contrast(1.1)";

        html5QrCode.start({
                facingMode: "environment"
            }, {
                fps: 20,
                qrbox: 250
            },
            qrCodeMessage => {
                if (qrMode === "verify") {
                    handleUserVerification(qrCodeMessage);
                } else {
                    handleQrCode(qrCodeMessage);
                }
            }
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
                    qrCodeMessage => {
                        if (qrMode === "verify") {
                            handleUserVerification(qrCodeMessage);
                        } else {
                            handleQrCode(qrCodeMessage);
                        }
                    }

                ).catch(() => {});
            }
        };
    }
    // Open Verify User Modal
    function openVerifyModal() {
        document.getElementById("verifyUserModal").classList.remove("hidden");
    }

    // Close Verify User Modal
    function closeVerifyModal() {
        document.getElementById("verifyUserModal").classList.add("hidden");
    }

    function openUserQrScanner() {
        qrMode = "verify";
        closeVerifyModal();
        openQrScanner();
    }

    function handleUserVerification(qrCodeMessage) {
        if (qrCooldown) return;
        qrCooldown = true;

        resultEl.textContent = `Scanning: ${qrCodeMessage}`;

        let overlay = document.createElement('div');
        overlay.textContent = "Processing Verification...";
        overlay.style.position = "absolute";
        overlay.style.top = "50px";
        overlay.style.left = "50%";
        overlay.style.transform = "translateX(-50%) scaleX(-1)";
        overlay.style.background = "rgba(0,0,0,0.6)";
        overlay.style.color = "white";
        overlay.style.padding = "10px 20px";
        overlay.style.borderRadius = "10px";
        overlay.style.fontWeight = "bold";
        overlay.style.zIndex = "9999";
        overlay.style.pointerEvents = "none";

        document.getElementById('qr-reader').appendChild(overlay);

        fetch(`/admin/user/verify/${qrCodeMessage}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(res => res.json())
            .then(data => {

                if (data.error) {
                    resultEl.textContent = "Error: " + data.error;
                    return;
                }

                resultEl.textContent = "User verified successfully!";

                // 🔥 ADD IT HERE — THIS IS WHAT YOU NEED
                closeVerifyModal();
                openViewUserModal(data.user);
            })
            .catch(err => resultEl.textContent = `Error: ${err}`)
            .finally(() => {
                setTimeout(() => {
                    qrCooldown = false;
                    overlay.remove();
                }, 3000);
            });
    }

</script>
