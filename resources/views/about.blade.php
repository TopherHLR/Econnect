@extends('layouts.mainLayout')

@section('content')
<!-- Hero Section -->
<section class="w-full py-8 md:py-16 flex justify-center bg-gradient-to-b from-[#556B2F] via-[#7f915c] to-[#dfeadf]">
    <div class="bg-[#fdf8ef] w-11/12 md:w-10/12 lg:w-2/3 rounded-3xl shadow-xl p-4 md:p-8 lg:p-10 pt-12 md:pt-16 pb-12 md:pb-20 relative mx-4 md:mx-0">
        
        <!-- Title -->
        <h2 class="ml-4 md:ml-6 text-3xl md:text-4xl lg:text-5xl italic font-black text-[#6B462D] flex flex-col md:flex-row items-start md:items-center gap-1 md:gap-2"
            style="font-family: var(--font-serif);">
            About<span class="text-[#C37A49] block md:inline">Ecobrew</span>
        </h2>

        <!-- Carousel Container -->
        <div class="mt-6 md:mt-8 relative w-full overflow-hidden rounded-2xl md:rounded-[40px] shadow-xl ring-1 ring-black/5">
            <!-- Slides Wrapper -->
            <div id="carouselWrapper" class="flex transition-transform duration-500 ease-out">
                @php
                    $images = [
                        'resources/images/viewport1/ecobrew.jpg',
                        'resources/images/viewport1/ecobrew2.jpg',
                        'resources/images/viewport1/ecobrew3.jpg',
                        'resources/images/viewport1/ecobrew4.jpg',
                        'resources/images/viewport1/ecobrew5.jpg',
                        'resources/images/viewport1/ecobrew6.jpg',
                        'resources/images/viewport1/ecobrew7.jpg',
                    ];
                @endphp

                @foreach ($images as $img)
                    <div class="relative w-full flex-shrink-0">
                        <img src="{{ Vite::asset($img) }}"
                            class="w-full h-[200px] sm:h-[300px] md:h-[400px] lg:h-[650px] object-cover rounded-2xl md:rounded-[40px] animate-fadeZoom"
                            alt="Carousel Image"
                            loading="lazy">
                        <!-- Image Overlay -->
                        <div class="absolute inset-0 rounded-2xl md:rounded-[40px] bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <button id="prevBtn"
                class="absolute top-1/2 left-2 md:left-6 -translate-y-1/2 
                       w-8 h-8 md:w-10 md:h-10 lg:w-11 lg:h-11 flex items-center justify-center
                       bg-white/25 backdrop-blur-lg hover:bg-white/50
                       rounded-full shadow-lg shadow-black/20
                       transition-all duration-300 active:scale-95"
                aria-label="Previous slide">
                <span class="text-xl md:text-2xl lg:text-3xl text-white drop-shadow-sm">‹</span>
            </button>

            <button id="nextBtn"
                class="absolute top-1/2 right-2 md:right-6 -translate-y-1/2 
                       w-8 h-8 md:w-10 md:h-10 lg:w-11 lg:h-11 flex items-center justify-center
                       bg-white/25 backdrop-blur-lg hover:bg-white/50
                       rounded-full shadow-lg shadow-black/20
                       transition-all duration-300 active:scale-95"
                aria-label="Next slide">
                <span class="text-xl md:text-2xl lg:text-3xl text-white drop-shadow-sm">›</span>
            </button>
        </div>

        <!-- Indicator Dots -->
        <div id="dots" class="flex justify-center gap-1 md:gap-2 mt-3 md:mt-4 flex-wrap">
            @foreach ($images as $key => $img)
                <button class="dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-[#c5b79b]/50 transition-all duration-300 hover:scale-125 active:scale-100"
                        data-index="{{ $key }}"
                        aria-label="Go to slide {{ $key + 1 }}"></button>
            @endforeach
        </div>

        <!-- Animations -->
        <style>
            @keyframes fadeZoom {
                from { opacity: .3; transform: scale(1.05); }
                to { opacity: 1; transform: scale(1); }
            }
            .animate-fadeZoom {
                animation: fadeZoom .6s ease;
            }
            
            /* Mobile optimizations */
            @media (max-width: 768px) {
                #carouselWrapper img {
                    object-position: center;
                }
                
                #prevBtn, #nextBtn {
                    opacity: 0.9;
                }
                
                #prevBtn:hover, #nextBtn:hover {
                    opacity: 1;
                }
            }
        </style>

        <!-- Carousel Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.getElementById('carouselWrapper');
                const dots = document.querySelectorAll('.dot');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const totalSlides = wrapper.children.length;
                let index = 0;
                let autoplayInterval;
                
                // Ensure elements exist
                if (!wrapper || totalSlides === 0) return;

                function updateCarousel() {
                    wrapper.style.transform = `translateX(-${index * 100}%)`;
                    dots.forEach((dot, i) => {
                        if (i === index) {
                            dot.classList.add('bg-[#6B462D]', 'scale-125');
                            dot.classList.remove('bg-[#c5b79b]/50', 'scale-100');
                        } else {
                            dot.classList.remove('bg-[#6B462D]', 'scale-125');
                            dot.classList.add('bg-[#c5b79b]/50');
                        }
                    });
                }

                function nextSlide() {
                    index = (index + 1) % totalSlides;
                    updateCarousel();
                }

                function prevSlide() {
                    index = (index - 1 + totalSlides) % totalSlides;
                    updateCarousel();
                }

                // Button event listeners
                if (nextBtn) nextBtn.addEventListener('click', nextSlide);
                if (prevBtn) prevBtn.addEventListener('click', prevSlide);

                // Dot navigation
                dots.forEach(dot => {
                    dot.addEventListener('click', function() {
                        index = parseInt(this.getAttribute('data-index'));
                        updateCarousel();
                        resetAutoplay();
                    });
                });

                // Touch/swipe support for mobile
                let startX = 0;
                let endX = 0;
                
                wrapper.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                }, { passive: true });
                
                wrapper.addEventListener('touchend', (e) => {
                    endX = e.changedTouches[0].clientX;
                    const diff = startX - endX;
                    
                    // Swipe threshold
                    if (Math.abs(diff) > 50) {
                        if (diff > 0) {
                            nextSlide(); // Swipe left
                        } else {
                            prevSlide(); // Swipe right
                        }
                        resetAutoplay();
                    }
                }, { passive: true });

                // Autoplay functions
                function startAutoplay() {
                    autoplayInterval = setInterval(nextSlide, 5000);
                }
                
                function stopAutoplay() {
                    clearInterval(autoplayInterval);
                }
                
                function resetAutoplay() {
                    stopAutoplay();
                    startAutoplay();
                }
                
                // Pause autoplay on hover/touch
                wrapper.addEventListener('mouseenter', stopAutoplay);
                wrapper.addEventListener('mouseleave', startAutoplay);
                wrapper.addEventListener('touchstart', stopAutoplay, { passive: true });
                wrapper.addEventListener('touchend', () => {
                    setTimeout(startAutoplay, 3000);
                }, { passive: true });

                // Initialize
                updateCarousel();
                if (totalSlides > 1) startAutoplay();
                
                // Handle window resize
                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(updateCarousel, 100);
                });
            });
        </script>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="w-full py-12 md:py-16 bg-[#dfeadf]">
    <div class="w-11/12 md:w-10/12 mx-auto space-y-16 md:space-y-24">
        <!-- MISSION ROW -->
        <div class="animate-row flex flex-col md:flex-row items-center md:justify-between">
            <!-- Image -->
            <div class="animate-element w-full md:w-1/2 flex justify-center mb-8 md:mb-0 order-1 md:order-1">
                <div class="w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96 rounded-full overflow-hidden shadow-xl border-4 md:border-8 border-white/20">
                    <img src="{{ Vite::asset('resources/images/viewport1/left-image.webp') }}" 
                         alt="Mission" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
            </div>
            
            <!-- Space (desktop only) -->
            <div class="hidden md:block w-4 md:w-8 lg:w-24"></div>
            
            <!-- Card -->
            <div class="animate-element w-full md:w-1/2 order-2 md:order-2" style="animation-delay: 0.3s">
                <div class="bg-[#7a8f57] text-white rounded-3xl p-6 md:p-8 shadow-xl min-h-[220px] md:min-h-[280px]">
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold tracking-wider">MISSION</h3>
                    <div class="bg-[#fdf8ef] text-[#5c4b3c] mt-4 md:mt-6 p-5 md:p-7 lg:p-8 rounded-2xl shadow-inner min-h-[140px] md:min-h-[180px]">
                        <p class="text-lg md:text-xl lg:text-2xl font-bold leading-relaxed">
                            To inspire mindful, eco-conscious habits through small,
                            trackable digital actions.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- VISION ROW -->
        <div class="animate-row flex flex-col md:flex-row-reverse items-center md:justify-between">
            <!-- Image -->
            <div class="animate-element w-full md:w-1/2 flex justify-center mb-8 md:mb-0 order-1 md:order-3" style="animation-delay: 0.2s">
                <div class="w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96 rounded-full overflow-hidden shadow-xl border-4 md:border-8 border-white/20">
                    <img src="{{ Vite::asset('resources/images/viewport1/right-image.webp') }}" 
                         alt="Vision" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
            </div>
            
            <!-- Space (desktop only) -->
            <div class="hidden md:block w-4 md:w-8 lg:w-24"></div>
            
            <!-- Card -->
            <div class="animate-element w-full md:w-1/2 order-2 md:order-4">
                <div class="bg-[#7a8f57] text-white rounded-3xl p-6 md:p-8 shadow-xl min-h-[220px] md:min-h-[280px]">
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold tracking-wider">VISION</h3>
                    <div class="bg-[#fdf8ef] text-[#5c4b3c] mt-4 md:mt-6 p-5 md:p-7 lg:p-8 rounded-2xl shadow-inner min-h-[140px] md:min-h-[180px]">
                        <p class="text-lg md:text-xl lg:text-2xl font-bold leading-relaxed">
                            A community where sustainability feels personal, rewarding, and consistent.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Advocacy Section -->
<div class="w-full bg-[#E0E9D6] py-12 md:py-16 px-4 md:px-8 lg:px-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-start">
        <!-- Box with slide-up animation -->
        <div class="animate-on-scroll slide-up bg-[#faf5eb] rounded-3xl shadow-md w-full md:w-[70%] h-48 md:h-52 flex items-center justify-center mx-auto md:ml-auto md:mr-0 order-2 md:order-1">
            <img src="{{ Vite::asset('resources/images/viewport1/logo.webp') }}" 
                 class="h-24 md:h-32 object-contain" 
                 alt="ECOconnect Logo"
                 loading="lazy">
        </div>
        
        <!-- Text with fade-in animation -->
        <div class="animate-on-scroll fade-in text-[#5c4b3c] order-1 md:order-2" style="animation-delay: 0.3s">
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-wide">ADVOCACY</h2>
            <p class="mt-3 md:mt-4 font-medium leading-relaxed text-base md:text-lg lg:text-xl">
                ECOconnect promotes education, reflection, and eco-action tracking — 
                encouraging long-term behavioral change.
            </p>
        </div>
    </div>
</div>

<!-- Developers Section -->
<div class="bg-[#7a8f57] w-11/12 md:w-10/12 lg:w-[65%] mx-auto rounded-3xl shadow-xl mt-12 md:mt-16 p-6 md:p-8 lg:p-12 text-center text-white min-h-[400px] md:min-h-[520px]">
    <h3 class="text-xl md:text-2xl font-extrabold tracking-wide mb-6">
        OUR DEVELOPERS:
    </h3>

    <!-- Inner white card -->
    <div class="bg-[#fdf8ef] rounded-2xl shadow-inner p-6 md:p-8 lg:p-12 xl:p-20 grid grid-cols-1 md:grid-cols-2 gap-y-6 md:gap-y-8 gap-x-6 md:gap-x-10 text-[#5c4b3c]">
        <!-- Column 1 -->
        <div class="space-y-4 md:space-y-6">
            <div>
                <p class="font-bold tracking-wide text-lg md:text-xl">GRUEZO, CATHYHANNEL</p>
                <p class="text-[#c77f55] tracking-wide text-sm md:text-base">PROJECT MANAGER</p>
            </div>

            <div>
                <p class="font-bold tracking-wide text-lg md:text-xl">ARANDA, SHYNNE MISFAH L.</p>
                <p class="text-[#c77f55] tracking-wide text-sm md:text-base">UI & UX DESIGNER</p>
            </div>

            <div>
                <p class="font-bold tracking-wide text-lg md:text-xl">SILANG, ALLEN JAMES</p>
                <p class="text-[#c77f55] tracking-wide text-sm md:text-base">TECHNICAL WRITER</p>
            </div>
        </div>

        <!-- Column 2 -->
        <div class="space-y-4 md:space-y-6">
            <div>
                <p class="font-bold tracking-wide text-lg md:text-xl">HILAIRON, CHRISTOPHER</p>
                <p class="text-[#c77f55] tracking-wide text-sm md:text-base">BACKEND PROGRAMMER</p>
            </div>

            <div>
                <p class="font-bold tracking-wide text-lg md:text-xl">RICALDE, ANDREA JANEL</p>
                <p class="text-[#c77f55] tracking-wide text-sm md:text-base">SYSTEM ANALYST</p>
            </div>

            <div>
                <p class="font-bold tracking-wide text-lg md:text-xl">CASABAL, AINSLEY</p>
                <p class="text-[#c77f55] tracking-wide text-sm md:text-base">PROGRAMMER 2</p>
            </div>
        </div>
    </div>
</div>

<!-- Quote Section -->
<div class="text-center mt-10 md:mt-12 lg:mt-16 px-4 md:px-8">
    <p class="relative text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-[47px] italic font-semibold text-[#5c4b3c] leading-tight sm:leading-snug md:leading-normal">
        "Small steps create <br class="block md:hidden" /><span class="hidden md:inline"> </span>meaningful change."
    </p>
    <p class="relative mt-3 sm:mt-4 md:mt-5 text-[#5c4b3c] text-base sm:text-lg md:text-xl font-medium md:ml-50">
        — ECOconnect Core Value
    </p>
</div>

<!-- Animation Styles and Scripts -->
<style>
    /* Animation classes */
    .animate-element {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .animate-row.animated .animate-element {
        opacity: 1;
        transform: translateY(0);
    }

    .animate-on-scroll {
        opacity: 0;
    }

    .slide-up {
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .fade-in {
        transition: opacity 1s ease;
    }

    .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        .w-90 {
            width: 22rem !important;
            height: 22rem !important;
        }
        
        .rounded-3xl {
            border-radius: 1.5rem !important;
        }
        
        .shadow-xl {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Improve touch targets */
        button, .dot {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Better text wrapping */
        .text-2xl {
            font-size: 1.5rem !important;
            line-height: 2rem !important;
        }
    }
    
    @media (max-width: 640px) {
        .w-90 {
            width: 18rem !important;
            height: 18rem !important;
        }
        
        .grid-cols-1 {
            grid-template-columns: 1fr !important;
        }
        
        .gap-y-6 {
            row-gap: 1.5rem !important;
        }
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Prevent content shift */
    .carousel-container {
        overflow: hidden;
        position: relative;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mission/Vision Animation
        const missionVisionRows = document.querySelectorAll('.animate-row');
        const missionVisionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                } else {
                    // Remove this line if you want animation to happen only once
                    entry.target.classList.remove('animated');
                }
            });
        }, {
            threshold: 0.2,
            rootMargin: '0px 0px -100px 0px'
        });
        
        missionVisionRows.forEach(row => missionVisionObserver.observe(row));

        // Advocacy Animation
        const advocacyElements = document.querySelectorAll('.animate-on-scroll');
        const advocacyObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    advocacyObserver.unobserve(entry.target); // Animate only once
                }
            });
        }, {
            threshold: 0.2,
            rootMargin: '0px 0px -50px 0px'
        });
        
        advocacyElements.forEach(el => advocacyObserver.observe(el));

        // Performance optimizations
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    // Any scroll-based calculations here
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        // Mobile touch improvements
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
            
            // Increase touch target sizes for mobile
            const buttons = document.querySelectorAll('button, .dot');
            buttons.forEach(btn => {
                btn.style.minHeight = '44px';
                btn.style.minWidth = '44px';
            });
        }

        // Lazy loading for images
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.getAttribute('src');
            });
        }
    });
</script>
@endsection