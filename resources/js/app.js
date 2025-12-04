import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Define stores BEFORE start
Alpine.store('authModal', {
    open: false,
    mode: 'signin', // or 'signup'
});

Alpine.start();

//======================================================================================= NAVBAR ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    const navbar   = document.getElementById('navbar');
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('overlay');
    const menuToggle = document.getElementById('menu-toggle');
    const closeSidebar = document.getElementById('close-sidebar');

    // Detect current page
    const isHomePage = window.location.pathname === '/' || window.location.pathname === '/home';

    const handleNavbarScroll = () => {
        if (!navbar) return;
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else if (isHomePage) {
            navbar.classList.remove('navbar-scrolled');
        }
    };

    window.addEventListener('scroll', handleNavbarScroll);

    // Initial style
    if (navbar) {
        if (!isHomePage) {
            navbar.classList.add('navbar-scrolled', 'navbar-green-shadow');
        } else {
            handleNavbarScroll();
        }
    }

    // Sidebar open/close
    menuToggle?.addEventListener('click', () => {
        sidebar?.classList.add('open');
        overlay?.classList.add('active');
    });

    const close = () => {
        sidebar?.classList.remove('open');
        overlay?.classList.remove('active');
    };

    closeSidebar?.addEventListener('click', close);
    overlay?.addEventListener('click', close);
});

//======================================================================================= VIEWPORT2 (Plant animation) ======================================================================================
window.addEventListener('scroll', () => {
    const plant       = document.getElementById('plant-container');
    const plantImg    = document.getElementById('plant-image');
    const textDiv     = document.getElementById('plant-text');
    const textEl      = textDiv?.querySelector('h1');
    const progressBar = document.getElementById('growth-bar');

    if (!plant && !textDiv && !progressBar) return; // nothing to animate

    const scrollY      = window.scrollY;
    const windowHeight = window.innerHeight;

    // Initialise flags
    if (window.textShown === undefined) window.textShown = false;
    if (window.textFadedOut === undefined) window.textFadedOut = false;

    if (scrollY > windowHeight * 0.3) {
        // ---- Plant movement ----
        if (plant) {
            const scaleFactor = window.innerWidth > 768 ? 1.3 : 0.9;
            const moveY       = window.innerHeight * 0.600;
            plant.style.transform = `translateY(${moveY}px) scale(${scaleFactor})`;
        }

        // ---- Text positioning & content ----
        if (textDiv && textEl) {
            textDiv.style.top = `${window.innerHeight * 0.590}px`;
            textEl.textContent = 'We all yearn to make a difference...';
            textEl.style.fontSize = window.innerWidth > 768 ? '1.5rem' : '1rem';
            textEl.style.color = '#3a5a0c';

            if (!window.textShown) {
                window.textShown = true;
                window.textFadedOut = false;

                clearTimeout(window.fadeInTimeout);
                clearTimeout(window.fadeOutTimeout);

                // start hidden, no transition yet
                textEl.style.transition = 'none';
                textEl.style.opacity = '0';

                window.fadeInTimeout = setTimeout(() => {
                    textEl.style.transition = 'opacity 3s ease';
                    textEl.style.opacity = '1';

                    window.fadeOutTimeout = setTimeout(() => {
                        textEl.style.transition = 'opacity 1.4s ease';
                        textEl.style.opacity = '0';
                        window.textFadedOut = true;
                    }, 5000);
                }, 1400);
            }
        }

        // ---- Progress bar ----
        if (progressBar) {
            progressBar.style.opacity = '1';
            progressBar.style.transform =
                window.innerWidth > 768
                    ? 'scale(0.7) translateY(-15%)'
                    : 'scale(0.55) translateY(-18%)';
        }

        // Stop for guests
        if (window.isGuest) return;

        // ---- Plant image ----
        if (plantImg && typeof plantBasePath !== 'undefined' && typeof stage !== 'undefined') {
            plantImg.src = `${plantBasePath}/${stage}.gif`;
        }

    } else {
        // ---- Reset plant ----
        plant?.style && (plant.style.transform = 'translateY(0px) scale(1)');

        // ---- Reset text ----
        if (textDiv && textEl) {
            textDiv.style.top = '25rem';
            textEl.textContent = 'Even in small ways,';
            textEl.style.fontSize = window.innerWidth > 768 ? '2rem' : '1.5rem';
            textEl.style.color = '#7a5d2bff';
            textEl.style.textShadow = `
                0 0 10px rgba(255, 255, 200, 1),
                0 0 20px rgba(255, 255, 200, 0.95),
                0 0 30px rgba(255, 255, 180, 0.85),
                0 0 40px rgba(255, 255, 180, 0.7),
                0 0 50px rgba(255, 255, 180, 0.5)
            `;
            textEl.style.opacity = '1';
        }

        // ---- Reset progress bar ----
        progressBar?.style && (progressBar.style.opacity = '0');
        progressBar?.style && (progressBar.style.transform = 'scale(1) translateY(0)');

        // ---- Reset plant image ----
        if (plantImg && typeof plantBasePath !== 'undefined') {
            plantImg.src = `${plantBasePath}/5.gif`;
        }

        // ---- Clean timers ----
        clearTimeout(window.fadeInTimeout);
        clearTimeout(window.fadeOutTimeout);
        window.textShown = false;
        window.textFadedOut = false;
    }
});

//======================================================================================= PROFILE DROPDOWN ======================================================================================
(() => {
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu   = document.getElementById('dropdownMenu');
    const profileDropdown = document.getElementById('profileDropdown');

    dropdownButton?.addEventListener('click', () => {
        dropdownMenu?.classList.toggle('hidden');
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (profileDropdown && !profileDropdown.contains(e.target)) {
            dropdownMenu?.classList.add('hidden');
        }
    });
})();

//======================================================================================= SIGN-IN / SIGN-UP OVERLAY ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    const container  = document.getElementById('container');
    const overlayBtn = document.getElementById('overlayBtn');

    overlayBtn?.addEventListener('click', () => {
        container?.classList.toggle('right-panel-active');
        overlayBtn.classList.remove('btnScaled');
        window.requestAnimationFrame(() => {
            overlayBtn.classList.add('btnScaled');
        });
    });
});

//======================================================================================= QUEST LIST TABS ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    const questListItems = document.querySelectorAll('#questList li');
    const questTables    = document.querySelectorAll('[id^="questTable-"]');
    const collectionTable = document.getElementById('collectionTable');

    questListItems.forEach(item => {
        item.addEventListener('click', () => {
            const selectedId = item.dataset.quest;

            // Hide everything
            questTables.forEach(t => t?.classList.add('hidden'));
            collectionTable?.classList.add('hidden');

            if (selectedId === 'collection') {
                collectionTable?.classList.remove('hidden');
            } else {
                const selectedTable = document.getElementById('questTable-' + selectedId);
                selectedTable?.classList.remove('hidden');
            }

            // Highlight active tab
            questListItems.forEach(li => li.classList.remove('bg-[#E9F0E1]', 'font-semibold'));
            item.classList.add('bg-[#E9F0E1]', 'font-semibold');
        });
    });
});

//======================================================================================= ARCHIVE DROPDOWN ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    const archiveBtn   = document.getElementById('archiveDropdownBtn');
    const archiveMenu  = document.getElementById('archiveDropdownMenu');
    const archiveArrow = document.getElementById('archiveArrow');

    archiveBtn?.addEventListener('click', () => {
        archiveMenu?.classList.toggle('hidden');
        archiveArrow?.classList.toggle('rotate-180');
    });

    // Close on outside click
    document.addEventListener('click', e => {
        if (
            archiveBtn && !archiveBtn.contains(e.target) &&
            archiveMenu && !archiveMenu.contains(e.target)
        ) {
            archiveMenu.classList.add('hidden');
            archiveArrow?.classList.remove('rotate-180');
        }
    });
});

//======================================================================================= STATUS UPDATE (AJAX) ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', e => {
            const questId = e.target.dataset.questId;
            const status  = e.target.value;

            fetch(`/quests/${questId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ status })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                    }
                })
                .catch(console.error);
        });
    });
});

//======================================================================================= ARCHIVE / RECOVER QUESTS ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    const archiveMenu = document.getElementById('archiveDropdownMenu');

    // ---- ARCHIVE ----
    document.querySelectorAll('.btn-archive').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            const questId    = button.dataset.questId;
            const questTitle = button.closest('tr')?.querySelector('td:nth-child(2)')?.innerText || '';

            if (!confirm('Are you sure you want to archive this quest?')) return;

            fetch(`/quests/${questId}/archive`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const row = button.closest('tr');
                        row?.remove();

                        // Add to archive dropdown
                        const li = document.createElement('li');
                        li.className = "flex justify-between items-center px-4 py-2 hover:bg-[#E9F0E1] text-[#4E3A2E]";

                        li.innerHTML = `
                            <span class="cursor-pointer" data-quest="questTable-${questId}">${questTitle}</span>
                            <form onsubmit="return confirm('Recover this quest?')" class="ml-2" data-quest-id="${questId}">
                                <button type="button" class="text-green-600 hover:text-green-800 font-semibold text-sm btn-recover">Recover</button>
                            </form>
                        `;
                        archiveMenu?.appendChild(li);

                        li.querySelector('.btn-recover')?.addEventListener('click', () => recoverQuest(questId, li));
                    }
                })
                .catch(console.error);
        });
    });

    // ---- RECOVER ----
    function recoverQuest(questId, liElement) {
        if (!confirm('Recover this quest?')) return;

        fetch(`/quests/${questId}/recover2`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    liElement?.remove();
                    location.reload(); // or insert row dynamically
                }
            })
            .catch(console.error);
    }
});