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

            <!-- Scan QR Section (Primary Action) -->
            <div class="border border-[#8B6E4A]/30 rounded-xl p-4 flex flex-col items-center justify-center hover:shadow-lg transition cursor-pointer">
                <h3 class="font-semibold text-[#4F6B3F] mb-2 text-center">Option 1: Scan User QR</h3>
                <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                    <i class="fa-solid fa-camera text-3xl"></i>
                    <span class="ml-2">Camera Placeholder</span>
                </div>
                <p class="text-sm text-[#6A8A52] mt-2 text-center">
                    Point your camera here to scan the user's QR code.
                </p>
            </div>

            <!-- Admin QR Section (Secondary Action) -->
            <div class="border border-[#8B6E4A]/30 rounded-xl p-4 flex flex-col items-center justify-center hover:shadow-lg transition cursor-pointer">
                <h3 class="font-semibold text-[#4F6B3F] mb-2 text-center">Option 2: Show Admin QR</h3>
                <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-600">
                    <i class="fa-solid fa-qrcode text-4xl"></i>
                </div>
                <p class="text-sm text-[#6A8A52] mt-2 text-center">
                    Let users scan this QR code if they don't have one.
                </p>
                <button class="mt-2 btn-eco btn-mint text-sm">
                    Copy QR
                </button>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-[#8B6E4A]/20">
            <button type="button" onclick="closeVerifyModal()" class="btn-eco btn-sand">
                Close
            </button>
        </div>

    </div>
</div>

<script>
    const verifyModal = document.getElementById('verifyUserModal');

    function openVerifyModal() {
        verifyModal.classList.remove('hidden');
    }

    function closeVerifyModal() {
        verifyModal.classList.add('hidden');
    }

    // Close when clicking backdrop
    verifyModal?.addEventListener('click', e => {
        if (e.target === verifyModal) closeVerifyModal();
    });
</script>
