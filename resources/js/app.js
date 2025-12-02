import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ✅ Define stores BEFORE start
Alpine.store('authModal', {
    open: false,
    mode: 'signin', // or 'signup'
});

Alpine.start();

//======================================================================================= navbar ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuToggle = document.getElementById('menu-toggle');
    const closeSidebar = document.getElementById('close-sidebar');

    // Detect current page (Laravel renders full path, so we check it cleanly)
    const isHomePage = window.location.pathname === '/' || window.location.pathname === '/home';

    // Function to apply or remove solid navbar
    const handleNavbarScroll = () => {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-solid');
        } else if (isHomePage) {
            navbar.classList.remove('navbar-solid');
        }
    };

    // Apply scroll listener
    window.addEventListener('scroll', handleNavbarScroll);

    // Immediately set navbar style based on current page
    if (!isHomePage) {
        // Force solid navbar on all non-home pages
        navbar.classList.add('navbar-solid');
    } else {
        // Home starts transparent and only changes after scroll
        handleNavbarScroll();
    }

    // Sidebar open/close
    menuToggle.addEventListener('click', () => {
        sidebar.classList.add('open');
        overlay.classList.add('active');
    });

    const close = () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    };

    closeSidebar.addEventListener('click', close);
    overlay.addEventListener('click', close);
});


//======================================================================================= VIEWPORT2 ======================================================================================
window.addEventListener('scroll', () => {
    const plant = document.getElementById('plant-container');
    const plantImg = document.getElementById('plant-image');
    const textDiv = document.getElementById('plant-text');
    const textEl = textDiv.querySelector('h1');
    const progressBar = document.getElementById('growth-bar');

    const scrollY = window.scrollY;
    const windowHeight = window.innerHeight;

    // Initialize state flags if undefined
    if (window.textShown === undefined) window.textShown = false;
    if (window.textFadedOut === undefined) window.textFadedOut = false;

    if (scrollY > windowHeight * 0.3) {

        // Move & scale plant
        const scaleFactor = window.innerWidth > 768 ? 1.3 : 0.9;
        const moveY = window.innerHeight * 0.6;
        plant.style.transform = `translateY(${moveY}px) scale(${scaleFactor})`;

        // Set text content & style
        textDiv.style.top = `${window.innerHeight * 0.520}px`;
        textEl.textContent = 'We all yearn to make a difference...';
        textEl.style.fontSize = window.innerWidth > 768 ? '1.5rem' : '1rem';
        textEl.style.color = '#5e471dff';

        if (!window.textShown) {
            window.textShown = true;
            window.textFadedOut = false;

            clearTimeout(window.fadeInTimeout);
            clearTimeout(window.fadeOutTimeout);

            // Start instantly hidden, with NO transition yet
            textEl.style.transition = 'none';
            textEl.style.opacity = '0';

            // DELAY before fading in
            window.fadeInTimeout = setTimeout(() => {

                textEl.style.transition = 'opacity 2s ease';
                textEl.style.opacity = '1';

                // Fade out after being fully visible
                window.fadeOutTimeout = setTimeout(() => {
                    textEl.style.transition = 'opacity 1.4s ease';
                    textEl.style.opacity = '0';
                    window.textFadedOut = true;
                }, 5000); // Keep text visible for 5 seconds

            }, 1800); // Delay before fade-in (1.8 seconds)
        }


        // Progress bar slightly lower under text
        progressBar.style.opacity = '1';
        progressBar.style.transform =
            window.innerWidth > 768
                ? 'scale(0.7) translateY(-15%)'
                : 'scale(0.55) translateY(-18%)';

        // Stop for guests
        if (window.isGuest) return;

        // Update plant image
        plantImg.src = `${plantBasePath}/${stage}.gif`;

    } else {
        // Reset plant
        plant.style.transform = 'translateY(0px) scale(1)';

        // Reset text
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

        // Reset progress bar
        progressBar.style.opacity = '0';
        progressBar.style.transform = 'scale(1) translateY(0)';

        // Reset plant image
        plantImg.src = `${plantBasePath}/5.gif`;

        // Clear all timers
        clearTimeout(window.fadeInTimeout);
        clearTimeout(window.fadeOutTimeout);

        // Reset flags to allow fade-in on next scroll past threshold
        window.textShown = false;
        window.textFadedOut = false;
    }
});




const dropdownButton = document.getElementById('dropdownButton');
const dropdownMenu = document.getElementById('dropdownMenu');

dropdownButton.addEventListener('click', () => {
    dropdownMenu.classList.toggle('hidden');
});

// Close dropdown if clicked outside
document.addEventListener('click', (event) => {
    if (!document.getElementById('profileDropdown').contains(event.target)) {
        dropdownMenu.classList.add('hidden');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('container');
    const overlayBtn = document.getElementById('overlayBtn');

    if (overlayBtn) {
        overlayBtn.addEventListener('click', () => {
            container.classList.toggle('right-panel-active');
            overlayBtn.classList.remove('btnScaled');
            window.requestAnimationFrame(() => {
                overlayBtn.classList.add('btnScaled');
            });
        });
    }
});

//======================================================================================= MESSAGE ======================================================================================
document.addEventListener('DOMContentLoaded', () => {
    const questListItems = document.querySelectorAll('#questList li');
    const questTables = document.querySelectorAll('[id^="questTable-"]');
    const collectionTable = document.getElementById('collectionTable');

    questListItems.forEach(item => {
        item.addEventListener('click', () => {
            const selectedId = item.dataset.quest;

            // Hide all quest tables
            questTables.forEach(table => table.classList.add('hidden'));
            collectionTable.classList.add('hidden');

            if (selectedId === 'collection') {
                collectionTable.classList.remove('hidden');
            } else {
                // Show selected quest table
                const selectedTable = document.getElementById('questTable-' + selectedId);
                if (selectedTable) {
                    selectedTable.classList.remove('hidden');
                }
            }

            // Highlight active tab
            questListItems.forEach(li => li.classList.remove('bg-[#E9F0E1]', 'font-semibold'));
            item.classList.add('bg-[#E9F0E1]', 'font-semibold');
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const archiveBtn = document.getElementById('archiveDropdownBtn');
    const archiveMenu = document.getElementById('archiveDropdownMenu');
    const archiveArrow = document.getElementById('archiveArrow');

    archiveBtn.addEventListener('click', () => {
        archiveMenu.classList.toggle('hidden'); // show/hide menu
        archiveArrow.classList.toggle('rotate-180'); // rotate arrow
    });

    // Optional: close the dropdown if user clicks outside
    document.addEventListener('click', (e) => {
        if (!archiveBtn.contains(e.target) && !archiveMenu.contains(e.target)) {
            archiveMenu.classList.add('hidden');
            archiveArrow.classList.remove('rotate-180');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {

    // Status update via AJAX
    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', (e) => {
            const questId = e.target.dataset.questId;
            const status = e.target.value;

            fetch(`/quests/${questId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success); // optional feedback
                    }
                })
                .catch(err => console.error(err));
        });
    });

});

document.addEventListener('DOMContentLoaded', () => {
    const archiveMenu = document.getElementById('archiveDropdownMenu');

    document.querySelectorAll('.btn-archive').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const questId = button.dataset.questId;
            const questTitle = button.closest('tr').querySelector('td:nth-child(2)').innerText;

            if (!confirm('Are you sure you want to archive this quest?')) return;

            fetch(`/quests/${questId}/archive`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const row = button.closest('tr');
                        if (row) row.remove();

                        // Add the quest to the archive dropdown
                        const li = document.createElement('li');
                        li.className = "flex justify-between items-center px-4 py-2 hover:bg-[#E9F0E1] text-[#4E3A2E]";

                        li.innerHTML = `
                        <span class="cursor-pointer" data-quest="questTable-${questId}">${questTitle}</span>
                        <form onsubmit="return confirm('Recover this quest?')" class="ml-2" data-quest-id="${questId}">
                            <button type="button" class="text-green-600 hover:text-green-800 font-semibold text-sm btn-recover">Recover</button>
                        </form>
                    `;
                        archiveMenu.appendChild(li);

                        // Add recover button functionality
                        li.querySelector('.btn-recover').addEventListener('click', () => recoverQuest(questId, li));
                    }
                })
                .catch(err => console.error(err));
        });
    });
    // Recover function
    function recoverQuest(questId, liElement) {
        if (!confirm('Recover this quest?')) return;

        fetch(`/quests/${questId}/recover2`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    liElement.remove(); // Remove from archive dropdown

                    // Optional: refresh table or re-add to active quests table
                    location.reload(); // Or implement JS to add it back dynamically
                }
            });
    }
});