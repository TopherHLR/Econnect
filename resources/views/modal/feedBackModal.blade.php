<!-- 🌿 FEEDBACK DETAILS MODAL -->
<div id="feedbackModal" class="hidden fixed inset-0 z-[1000] bg-black/50 flex items-center justify-center p-4">
    <div
        class="w-full max-w-lg rounded-2xl shadow-2xl 
               bg-[linear-gradient(135deg,#FFFFFF_0%,#F8F4E7_100%)]
               border-2 border-[#C8D5BB] overflow-hidden">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 bg-[#4A6613] text-white">
            <h2 class="text-lg font-semibold flex items-center">
                <i class="fa-solid fa-comment-dots mr-2"></i> Community Feedback
            </h2>
            <button id="closeFeedbackModal" class="text-white hover:text-[#E0E5D8]">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="p-6 space-y-4">
            <p><strong class="text-[#4A6613]">From:</strong> <span id="modalFeedbackUser"></span></p>
            <p><strong class="text-[#4A6613]">Date:</strong> <span id="modalFeedbackDate"></span></p>
            <p><strong class="text-[#4A6613]">Rating:</strong> <span id="modalFeedbackRating"></span></p>

            <p class="pt-2 border-t border-[#C8D5BB]">
                <strong class="text-[#4A6613]">Full Feedback:</strong>
            </p>
            <p class="text-[#4E3A2E] leading-relaxed italic" id="modalFeedbackContent"></p>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("feedbackModal");
        const closeBtn = document.getElementById("closeFeedbackModal");

        const modalUser = document.getElementById("modalFeedbackUser");
        const modalDate = document.getElementById("modalFeedbackDate");
        const modalRating = document.getElementById("modalFeedbackRating");
        const modalContent = document.getElementById("modalFeedbackContent");

        document.querySelectorAll(".open-feedback-modal").forEach(btn => {
            btn.addEventListener("click", () => {
                modalUser.textContent = btn.dataset.user;
                modalDate.textContent = btn.dataset.date;

                const stars = "★".repeat(btn.dataset.rating) + "☆".repeat(5 - btn.dataset
                    .rating);
                modalRating.textContent = stars;

                modalContent.textContent = btn.dataset.content;

                modal.classList.remove("hidden");
            });
        });

        // Close Modal
        closeBtn.addEventListener("click", () => modal.classList.add("hidden"));
        modal.addEventListener("click", (e) => {
            if (e.target === modal) modal.classList.add("hidden");
        });
    });
</script>
