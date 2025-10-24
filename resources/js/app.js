import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ✅ Define stores BEFORE start
Alpine.store('authModal', {
    open: false,
    mode: 'signin', // or 'signup'
});

Alpine.start(); 

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuToggle = document.getElementById('menu-toggle');
    const closeSidebar = document.getElementById('close-sidebar');

    // Navbar scroll behavior
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-solid');
        } else {
            navbar.classList.remove('navbar-solid');
        }
    });

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

window.addEventListener('scroll', () => {
    const plant = document.getElementById('plant-container');
    const textDiv = document.getElementById('plant-text');
    const textEl = textDiv.querySelector('h1');
    const progressBar = document.getElementById('growth-bar');
    const scrollY = window.scrollY;
    const windowHeight = window.innerHeight;

    if (scrollY > windowHeight * 0.3) {
        // 🌿 Move & scale plant
        plant.style.transform = 'translateY(400px) scale(1.2)';

        // 🌱 Move text below plant
        textDiv.style.top = '550px';
        textEl.textContent = 'We all yearn to make a difference...';
        textEl.style.fontSize = window.innerWidth > 768 ? '4rem' : '2.5rem';
        textEl.style.opacity = '0.9';

        // 🌾 Reveal progress bar
        progressBar.style.opacity = '1';
    } else {
        // Reset position and scale
        plant.style.transform = 'translateY(0px) scale(1)';
        textDiv.style.top = '0px';
        textEl.textContent = 'Even in small ways';
        textEl.style.fontSize = window.innerWidth > 768 ? '3rem' : '1.8rem';
        textEl.style.opacity = '1';
        progressBar.style.opacity = '0';
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