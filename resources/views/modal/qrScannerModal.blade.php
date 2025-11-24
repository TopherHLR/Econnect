<!-- QR Scanner Modal (Theme-Matched with Image Upload) -->
<div id="qrScannerModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-lg rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#8B6E4A] text-white">
            <h3 id="qr-scanner-title" class="text-lg font-semibold flex items-center">
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

<!-- PENDING QQUEST VIA QR-->
<div id="userPendingQuestsModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-[#FCFFF6] w-full max-w-3xl rounded-2xl shadow-2xl border border-[#8B6E4A]/40 overflow-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-[#4F6B3F]">User Pending Quests</h2>
            <button onclick="closeUserPendingQuestsModal()" class="text-[#8B6E4A] hover:text-[#6A8A52]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div id="pending-quests-list"></div>

        <div class="flex justify-end mt-4">
            <button onclick="closeUserPendingQuestsModal()" class="btn-eco btn-sand">Close</button>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    let qrMode = "voucher"; // default
    let html5QrCode = null;
    const resultEl = document.getElementById('qr-result');

    function openQrScanner() {
        const scannerTitle = document.getElementById('qr-scanner-title');

        if (qrMode === "verify") {
            scannerTitle.textContent = "Scan User QR Code";
        } else {
            scannerTitle.textContent = "Scan Voucher QR Code";
        }

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

                if (qrMode === "verify") {
                    handleUserVerification(qrCodeMessage);
                } else {
                    handleQrCode(qrCodeMessage);
                }

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
            .catch(err => resultEl.textContent = `Error for User: ${err}`)
            .finally(() => {
                setTimeout(() => {
                    qrCooldown = false;
                    overlay.remove();
                }, 3000);
            });
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

    // FETCHING PENDING QUEST VIA QR 
    let userQrCooldown = false;
    let html5UserQrCode = null;

    function openUserQrScannerModal() {
        const scannerTitle = document.getElementById('qr-scanner-title');

        scannerTitle.textContent = "Scan User QR Code";

        document.getElementById('qrScannerModal').classList.remove('hidden');
        startUserQrScanner();
    }

    function closeUserQrScannerModal() {
        document.getElementById('qrScannerModal').classList.add('hidden');
        stopUserQrScanner();
        document.getElementById('qr-file-input').value = null;
    }

    function stopUserQrScanner() {
        if (html5UserQrCode) {
            html5UserQrCode.stop().catch(() => {});
            html5UserQrCode.clear();
            html5UserQrCode = null;
        }
    }

    function startUserQrScanner() {
        if (!html5UserQrCode) html5UserQrCode = new Html5Qrcode("qr-reader");

        html5UserQrCode.start({
                facingMode: "environment"
            }, {
                fps: 20,
                qrbox: 250
            },
            qrCodeMessage => handleUserQrScan(qrCodeMessage)
        ).catch(err => console.error("User QR start failed:", err));

        document.getElementById('qr-file-input').onchange = async e => {
            if (!e.target.files.length) return;
            const file = e.target.files[0];
            await html5UserQrCode.stop().catch(() => {});

            try {
                const qrCodeMessage = await html5UserQrCode.scanFile(file, true);
                handleUserQrScan(qrCodeMessage);
            } catch (err) {
                resultEl.textContent = `Error reading image: ${err}`;
            } finally {
                html5UserQrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 20,
                        qrbox: 250
                    },
                    qrCodeMessage => handleUserQrScan(qrCodeMessage)
                ).catch(() => {});
            }
        };
    }

    function handleUserQrScan(qrCodeMessage) {
        if (userQrCooldown) return;
        userQrCooldown = true;
        resultEl.textContent = `Scanning: ${qrCodeMessage}`;

        // Fetch pending quests
        fetch(`/admin/user-qr/${qrCodeMessage}/pending-quests`, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })


            .then(res => res.json())
            .then(data => {
                // closeUserQrScannerModal();  <-- comment this out for testing
                openUserPendingQuestsModal(data.user, data.pendingQuests);
            })

            .catch(err => resultEl.textContent = `Error: ${err}`)
            .finally(() => {
                setTimeout(() => {
                    userQrCooldown = false;
                }, 3000);
            });
    }

    function openUserPendingQuestsModal(user, pendingQuests) {
        const container = document.getElementById('pending-quests-list');
        container.innerHTML =
            `<p><strong>Name:</strong> ${user.name} | <strong>Email:</strong> ${user.email}</p><hr class="my-2">`;

        if (!pendingQuests.length) {
            container.innerHTML += "<p>No pending quests.</p>";
        } else {
            pendingQuests.forEach(q => {
                const div = document.createElement('div');
                div.classList.add('border', 'p-2', 'my-1', 'rounded', 'flex', 'justify-between',
                    'items-center');

                div.innerHTML = `
                <span>${q.quest.title} (Points: ${q.quest.points_reward})</span>
                <div class="flex gap-2">
                    <button class="btn-eco btn-mint btn-sm" onclick="updateSubmissionStatus(${q.submission_id}, 'completed', this)">Approve</button>
                    <button class="btn-eco btn-sand btn-sm" onclick="updateSubmissionStatus(${q.submission_id}, 'rejected', this)">Reject</button>
                </div>
            `;

                container.appendChild(div);
            });
        }

        document.getElementById('userPendingQuestsModal').classList.remove('hidden');
    }

    function updateSubmissionStatus(submissionId, newStatus, btn) {
        btn.disabled = true; // prevent double clicks

        fetch(`/submissions/${submissionId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ status: newStatus }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showMessage(`Submission marked as ${newStatus}`, 'success');

                // Disable buttons
                const buttonContainer = btn.parentElement;
                buttonContainer.querySelectorAll('button').forEach(b => b.disabled = true);

                // **Update the text in the modal dynamically**
                // We'll append a small status label or replace buttons
                const statusLabel = document.createElement('span');
                statusLabel.classList.add('text-sm', 'font-semibold', newStatus === 'completed' ? 'text-green-600' : 'text-red-600');
                statusLabel.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                // Replace buttons with status label
                buttonContainer.innerHTML = '';
                buttonContainer.appendChild(statusLabel);

            } else {
                showMessage('Failed to update submission', 'error');
            }
        })
        .catch(err => {
            showMessage('Something went wrong', 'error');
        })
        .finally(() => {
            btn.disabled = false;
        });
    }



    function closeUserPendingQuestsModal() {
        document.getElementById('userPendingQuestsModal').classList.add('hidden');
    }
</script>
