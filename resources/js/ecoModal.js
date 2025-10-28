// --- ecoModal.js ---
document.addEventListener("DOMContentLoaded", () => {
  // 🌿 Modal references
  const ecoModal = document.getElementById("ecoDetailModal");
  const modalTitle = document.getElementById("ecoModalTitle");
  const modalImage = document.getElementById("ecoModalImage");
  const modalContent = document.getElementById("ecoModalContent");
  const actionBtn = document.getElementById("ecoModalActionBtn");

  // ✅ Make closeEcoModal globally accessible (for inline onclick)
  window.closeEcoModal = function () {
    ecoModal.classList.add("hidden");
    ecoModal.classList.remove("flex");
  };

  // ✅ Global click listener — works for both .eco-card and saved items
  document.body.addEventListener("click", async (e) => {
    const target = e.target.closest(".eco-card, .saved-item");
    if (!target) return;

    const type = target.dataset.type; // "ecoTopic" or "ecoAction"
    const id = target.dataset.id;

    try {
      // 🧩 Fetch or mock backend content
      const res = await fetch(`/api/${type}/${id}`);
      if (!res.ok) throw new Error("Failed to fetch modal data");
      const data = await res.json();

      // 🏷️ Fill modal title & image
      modalTitle.textContent = data.title || "Untitled";
      modalImage.src = data.image
        ? `/storage/${data.image}`
        : "/images/placeholder.jpg";
      modalImage.alt = data.title || "Eco content";

      // ♻️ Change layout depending on type
      if (type === "ecoAction") {
        modalContent.innerHTML = `
          <div class="space-y-2">
            <p><strong>Step 1:</strong> ${data.step1 || "No data"}</p>
            <p><strong>Step 2:</strong> ${data.step2 || "No data"}</p>
            <p><strong>Step 3:</strong> ${data.step3 || "No data"}</p>
          </div>
          <div class="mt-4 text-sm text-gray-500">
            <p><strong>Progress:</strong> ${data.progress || "0%"}</p>
          </div>
        `;
        actionBtn.classList.remove("hidden");
      } else {
        modalContent.innerHTML = `
          <p class="mb-2">${data.description || "No description available."}</p>
          <div class="mt-4 text-sm text-gray-500">
            <p><strong>Related Facts:</strong> ${data.related_facts || "None"}</p>
            <p><strong>References:</strong> ${data.references || "N/A"}</p>
          </div>
        `;
        actionBtn.classList.add("hidden");
      }

      // 🌱 Show modal
      ecoModal.classList.remove("hidden");
      ecoModal.classList.add("flex");
    } catch (err) {
      console.error("Error loading modal data:", err);
      alert("Failed to load details. Please try again later.");
    }
  });

  // ✅ Close modal when clicking outside content or close button
  document.body.addEventListener("click", (e) => {
    if (
      e.target.matches("#ecoDetailModal, #closeEcoModalBtn") ||
      e.target.closest("#closeEcoModalBtn")
    ) {
      window.closeEcoModal();
    }
  });

  // ✅ Handle “Mark as Done”
  if (actionBtn) {
    actionBtn.addEventListener("click", () => {
      actionBtn.textContent = "✅ Completed";
      actionBtn.classList.add("opacity-70", "cursor-not-allowed");
      actionBtn.disabled = true;
      // optional PATCH/POST call here later
    });
  }
});
