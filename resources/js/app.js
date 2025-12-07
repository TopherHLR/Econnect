import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.store("authModal", {
        open: Boolean(window.authModalOpen),   // read from backend
        mode: window.authModalMode || "signin"
    });
});

Alpine.start();


//======================================================================================= NAVBAR ======================================================================================
(() => {
    const plant = document.getElementById("plant-container");
    const plantImg = document.getElementById("plant-image");
    const textDiv = document.getElementById("plant-text");
    const textEl = textDiv?.querySelector("h1");
    const progressBar = document.getElementById("growth-bar");
    const leftPanel = document.getElementById("left-panel");
    const rightPanel = document.getElementById("right-panel");

    if (!plant && !textDiv && !progressBar) return;

    let ticking = false;
    let hasAnimated = false; // run animation only once

    const onScroll = () => {
        const scrollY = window.scrollY;
        const windowHeight = window.innerHeight;
        const pastThreshold = scrollY > windowHeight * 0.3;

        if (!ticking && pastThreshold && !hasAnimated) {
            window.requestAnimationFrame(() => {
                // ---- Panels ----
                if (leftPanel) leftPanel.classList.add("show");
                if (rightPanel) rightPanel.classList.add("show");

                // ---- Plant ----
                if (plant) {
                    const scaleFactor = window.innerWidth > 768 ? 1.3 : 0.9;
                    const moveY = window.innerHeight * 0.6;
                    plant.style.transform = `translateY(${moveY}px) scale(${scaleFactor})`;
                    plant.style.willChange = "transform";
                }

                // ---- Progress bar ----
                if (progressBar) {
                    progressBar.style.opacity = "1";
                    progressBar.style.transform =
                        window.innerWidth > 768
                            ? "scale(0.7) translateY(-15%)"
                            : "scale(0.55) translateY(-18%)";
                    progressBar.style.willChange = "transform, opacity";
                }

                // ---- Plant image ----
                if (
                    plantImg &&
                    typeof plantBasePath !== "undefined" &&
                    typeof stage !== "undefined"
                ) {
                    plantImg.src = `${plantBasePath}/${stage}.gif`;
                }

                // ---- Text ----
                if (textDiv && textEl) {
                    textDiv.style.top = `${window.innerHeight * 0.59}px`;
                    textEl.innerHTML =
                        "<strong>Grow with us</strong> on a sustainable journey <br>" +
                        "where <strong>every small action blooms into impact</strong><br>" +
                        "and every quest brings meaningful rewards.";
                    textEl.classList.add("fade-text");

                    // Add inline styles for text size and other properties
                    textEl.style.fontSize = "clamp(0.9rem, 1.8vw, 1.3rem)"; // Much smaller
                    textEl.style.lineHeight = "1.3"; // Tighter line height
                    textDiv.style.top = `${window.innerHeight * 0.57}px`; // Near the top
                    textEl.style.textAlign = "center";
                    textEl.style.color = "#556037ff";
                    textEl.style.fontWeight = "500";
                    textEl.style.maxWidth = "500px"; // Smaller max width
                    textEl.style.margin = "0 auto";
                }
                // ---- GLOW ANIMATION ----
                // Find the glow container and add the activation class
                const glowContainers = document.querySelectorAll(
                    ".absolute.top-1\\/4.flex.items-center.justify-center"
                );
                if (glowContainers.length > 0) {
                    glowContainers.forEach((container) => {
                        container.classList.add("glow-active");
                    });
                }

                hasAnimated = true; // prevent further animation
                ticking = false;
            });

            ticking = true;
        }
    };

    window.addEventListener("scroll", onScroll, { passive: true });
})();

//======================================================================================= PROFILE DROPDOWN ======================================================================================
(() => {
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const profileDropdown = document.getElementById("profileDropdown");

    dropdownButton?.addEventListener("click", () => {
        dropdownMenu?.classList.toggle("hidden");
    });

    // Close when clicking outside
    document.addEventListener("click", (e) => {
        if (profileDropdown && !profileDropdown.contains(e.target)) {
            dropdownMenu?.classList.add("hidden");
        }
    });
})();
//======================================================================================= SIGN-IN / SIGN-UP OVERLAY ======================================================================================
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("container");
    const overlayBtn = document.getElementById("overlayBtn");

    overlayBtn?.addEventListener("click", () => {
        container?.classList.toggle("right-panel-active");
        overlayBtn.classList.remove("btnScaled");
        window.requestAnimationFrame(() => {
            overlayBtn.classList.add("btnScaled");
        });
    });
});

//======================================================================================= QUEST LIST TABS ======================================================================================
document.addEventListener("DOMContentLoaded", () => {
    const questListItems = document.querySelectorAll("#questList li");
    const questTables = document.querySelectorAll('[id^="questTable-"]');
    const collectionTable = document.getElementById("collectionTable");

    questListItems.forEach((item) => {
        item.addEventListener("click", () => {
            const selectedId = item.dataset.quest;

            // Hide everything
            questTables.forEach((t) => t?.classList.add("hidden"));
            collectionTable?.classList.add("hidden");

            if (selectedId === "collection") {
                collectionTable?.classList.remove("hidden");
            } else {
                const selectedTable = document.getElementById(
                    "questTable-" + selectedId
                );
                selectedTable?.classList.remove("hidden");
            }

            // Highlight active tab
            questListItems.forEach((li) =>
                li.classList.remove("bg-[#E9F0E1]", "font-semibold")
            );
            item.classList.add("bg-[#E9F0E1]", "font-semibold");
        });
    });
});

//======================================================================================= ARCHIVE DROPDOWN ======================================================================================
document.addEventListener("DOMContentLoaded", () => {
    const archiveBtn = document.getElementById("archiveDropdownBtn");
    const archiveMenu = document.getElementById("archiveDropdownMenu");
    const archiveArrow = document.getElementById("archiveArrow");

    archiveBtn?.addEventListener("click", () => {
        archiveMenu?.classList.toggle("hidden");
        archiveArrow?.classList.toggle("rotate-180");
    });

    // Close on outside click
    document.addEventListener("click", (e) => {
        if (
            archiveBtn &&
            !archiveBtn.contains(e.target) &&
            archiveMenu &&
            !archiveMenu.contains(e.target)
        ) {
            archiveMenu.classList.add("hidden");
            archiveArrow?.classList.remove("rotate-180");
        }
    });
});

//======================================================================================= STATUS UPDATE (AJAX) ======================================================================================
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".status-dropdown").forEach((dropdown) => {
        dropdown.addEventListener("change", (e) => {
            const questId = e.target.dataset.questId;
            const status = e.target.value;

            fetch(`/quests/${questId}/status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
                body: JSON.stringify({ status }),
            })
                .then((r) => r.json())
                .then((data) => {
                    if (data.success) {
                        alert(data.success);
                    }
                })
                .catch(console.error);
        });
    });
});

//======================================================================================= ARCHIVE / RECOVER QUESTS ======================================================================================
document.addEventListener("DOMContentLoaded", () => {
    const archiveMenu = document.getElementById("archiveDropdownMenu");

    // ---- ARCHIVE ----
    document.querySelectorAll(".btn-archive").forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            const questId = button.dataset.questId;
            const questTitle =
                button.closest("tr")?.querySelector("td:nth-child(2)")
                    ?.innerText || "";

            if (!confirm("Are you sure you want to archive this quest?"))
                return;

            fetch(`/quests/${questId}/archive`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
            })
                .then((r) => r.json())
                .then((data) => {
                    if (data.success) {
                        const row = button.closest("tr");
                        row?.remove();

                        // Add to archive dropdown
                        const li = document.createElement("li");
                        li.className =
                            "flex justify-between items-center px-4 py-2 hover:bg-[#E9F0E1] text-[#4E3A2E]";

                        li.innerHTML = `
                            <span class="cursor-pointer" data-quest="questTable-${questId}">${questTitle}</span>
                            <form onsubmit="return confirm('Recover this quest?')" class="ml-2" data-quest-id="${questId}">
                                <button type="button" class="text-green-600 hover:text-green-800 font-semibold text-sm btn-recover">Recover</button>
                            </form>
                        `;
                        archiveMenu?.appendChild(li);

                        li.querySelector(".btn-recover")?.addEventListener(
                            "click",
                            () => recoverQuest(questId, li)
                        );
                    }
                })
                .catch(console.error);
        });
    });

    // ---- RECOVER ----
    function recoverQuest(questId, liElement) {
        if (!confirm("Recover this quest?")) return;

        fetch(`/quests/${questId}/recover2`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        })
            .then((r) => r.json())
            .then((data) => {
                if (data.success) {
                    liElement?.remove();
                    location.reload(); // or insert row dynamically
                }
            })
            .catch(console.error);
    }
});
