@extends('layouts.mainLayout')

@section('content')
<section class="w-full py-16 flex justify-center bg-gradient-to-b from-[#556B2F] via-[#7f915c] to-[#dfeadf]">
    <div class="bg-[#fdf8ef] w-10/12 md:w-2/3 rounded-3xl shadow-xl p-6 md:p-10 pt-16 pb-20 relative">

        <!-- Title -->
        <h2 class="ml-6 text-4xl md:text-5xl italic font-black text-[#6B462D] flex items-center gap-2"
            style="font-family: var(--font-serif);">
            About<span class="text-[#C37A49]">Ecobrew</span>
        </h2>

        <!-- Carousel Container -->
        <div class="mt-8 relative w-full overflow-hidden rounded-[40px] shadow-xl ring-1 ring-black/5">

            <!-- Slides Wrapper -->
            <div id="carouselWrapper" class="flex transition-transform duration-700 ease-out">
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
                            class="w-full h-[300px] md:h-[650px] object-cover rounded-[40px] animate-fadeZoom"
                            alt="Carousel Image">
                        <!-- Image Overlay -->
                        <div class="absolute inset-0 rounded-[40px] bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
                    </div>
                @endforeach
            </div>

<!-- Left Arrow -->
<button id="prevBtn"
    class="absolute top-1/2 left-6 -translate-y-1/2 
           w-11 h-11 flex items-center justify-center
           bg-white/25 backdrop-blur-lg
           hover:bg-white/50
           rounded-full shadow-lg shadow-black/20
           transition-all duration-300">
    <span class="text-3xl text-white drop-shadow-sm">‹</span>
</button>

<!-- Right Arrow -->
<button id="nextBtn"
    class="absolute top-1/2 right-6 -translate-y-1/2 
           w-11 h-11 flex items-center justify-center
           bg-white/25 backdrop-blur-lg
           hover:bg-white/50
           rounded-full shadow-lg shadow-black/20
           transition-all duration-300">
    <span class="text-3xl text-white drop-shadow-sm">›</span>
</button>

        </div>

        <!-- Indicator Dots -->
        <div id="dots" class="flex justify-center gap-2 mt-4">
            @foreach ($images as $key => $img)
                <div class="dot w-3 h-3 rounded-full bg-[#c5b79b]/50 transition" data-index="{{ $key }}"></div>
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
        </style>

        <!-- Carousel Script -->
        <script>
            const wrapper = document.getElementById('carouselWrapper');
            const dots = document.querySelectorAll('.dot');
            const totalSlides = wrapper.children.length;
            let index = 0;

            function updateCarousel() {
                wrapper.style.transform = `translateX(-${index * 100}%)`;
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-[#6B462D]', i === index);
                    dot.classList.toggle('bg-[#c5b79b]/50', i !== index);
                });
            }

            document.getElementById('nextBtn').onclick = () => {
                index = (index + 1) % totalSlides;
                updateCarousel();
            };

            document.getElementById('prevBtn').onclick = () => {
                index = (index - 1 + totalSlides) % totalSlides;
                updateCarousel();
            };

            // Autoplay
            setInterval(() => {
                index = (index + 1) % totalSlides;
                updateCarousel();
            }, 5000);

            // Initialize
            updateCarousel();
        </script>

    </div>
</section>



    <section class="w-full py-16 bg-[#dfeadf] bg-cover bg-center">

        <div class="w-11/12 md:w-10/12 mx-auto grid md:grid-cols-2 gap-10">

            <!-- LEFT IMAGE -->
            <div class="ml-auto">
                <img src="{{ Vite::asset('resources/images/viewport1/side.png') }}" class="w-auto">
            </div>


            <!-- MISSION CARD -->
            <div class="flex items-center relative">
                <!-- CLIP IMAGE -->
                <img src="{{ Vite::asset('resources/images/viewport1/side2.jpg') }}"
                    class="absolute top-11 right-62 w-30 z-20">

                <div
                    class="bg-[#7a8f57] text-white rounded-3xl ml-20 p-6 shadow-xl w-[70%] md:w-[55%] min-h-[260px] relative">

                    <h3 class="text-3xl font-bold tracking-wider">MISSION</h3>

                    <div class="bg-[#fdf8ef] text-[#5c4b3c] mt-4 p-7 rounded-2xl shadow-inner min-h-[160px]">
                        <p class="text-xl font-bold">
                            To inspire mindful, eco-conscious habits through small,
                            trackable digital actions.
                        </p>
                    </div>
                </div>
            </div>

            <!-- VISION CARD -->
            <div class="flex items-center relative">
                <!-- Paperclip Image -->
                <img src="{{ Vite::asset('resources/images/viewport1/vissionclip.png') }}" alt="paperclip"
                    class="absolute top-10 right-64 w-30 z-20">

                <div
                    class="bg-[#7a8f57] text-white rounded-3xl ml-20 p-6 shadow-xl w-[70%] md:w-[55%] min-h-[260px] relative">

                    <h3 class="text-3xl font-bold tracking-wider">VISION</h3>

                    <div class="bg-[#fdf8ef] text-[#5c4b3c] mt-4 p-7 rounded-2xl shadow-inner min-h-[160px]">
                        <p class="text-xl font-bold">
                            A community where sustainability feels personal, rewarding, and consistent.
                        </p>
                    </div>
                </div>
            </div>


            <!-- RIGHT IMAGE -->
            <div class="order-2 md:order-none">
                <img src="{{ Vite::asset('resources/images/viewport1/planting.png') }}">
            </div>

        </div>
    </section>
    <div class="w-full bg-[#E0E9D6] py-16 px-6 md:px-20">

        <!-- ADVOCACY SECTION -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            <!-- Left empty rounded box -->
            <div class="bg-[#faf5eb] rounded-3xl shadow-md w-[60%] h-52 flex items-center justify-center ml-50">
                <img src="{{ Vite::asset('resources/images/viewport1/ecologo.png') }}" class="h-32 object-contain" />
            </div>


            <!-- Advocacy Text -->
            <div class="text-[#5c4b3c]">
                <h2 class="text-3xl font-extrabold tracking-wide">ADVOCACY</h2>

                <p class="mt-3 font-medium leading-relaxed text-lg">
                    ECOconnect promotes education, reflection, and eco-action tracking —
                    encouraging long-term behavioral change.
                </p>
            </div>
        </div>

        <!-- DEVELOPERS SECTION -->
        <div
            class="bg-[#7a8f57] w-[75%] md:w-[65%] mx-auto rounded-3xl shadow-xl mt-16 p-12 text-center text-white min-h-[520px]">

            <h3 class="text-2xl font-extrabold tracking-wide mb-6">
                OUR DEVELOPERS:
            </h3>

            <!-- Inner white card -->
            <div
                class="bg-[#fdf8ef] rounded-2xl shadow-inner p-20 grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-10 text-[#5c4b3c]">

                <!-- Column 1 -->
                <div class="space-y-6">
                    <div>
                        <p class="font-bold tracking-wide text-xl">GRUEZO, CATHYHANNEL</p>
                        <p class="text-[#c77f55] tracking-wide text-base">PROJECT MANAGER</p>
                    </div>

                    <div>
                        <p class="font-bold tracking-wide text-xl">ARANDA, SHYNNE MISFAH L.</p>
                        <p class="text-[#c77f55] tracking-wide text-base">UI & UX DESIGNER</p>
                    </div>

                    <div>
                        <p class="font-bold tracking-wide text-xl">SILANG, ALLEN JAMES</p>
                        <p class="text-[#c77f55] tracking-wide text-base">TECHNICAL WRITER</p>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="space-y-6">
                    <div>
                        <p class="font-bold tracking-wide text-xl">HILAIRON, CHRISTOPHER</p>
                        <p class="text-[#c77f55] tracking-wide text-base">BACKEND PROGRAMMER</p>
                    </div>

                    <div>
                        <p class="font-bold tracking-wide text-xl">RICALDE, ANDREA JANEL</p>
                        <p class="text-[#c77f55] tracking-wide text-base">SYSTEM ANALYST</p>
                    </div>

                    <div>
                        <p class="font-bold tracking-wide text-xl">CASABAL, AINSLEY</p>
                        <p class="text-[#c77f55] tracking-wide text-base">PROGRAMMER 2</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- QUOTE -->
        <div class="text-center mt-16">
            <p class="relative text-[47px] italic font-semibold text-[#5c4b3c] top-10">
                “Small steps create <br><br class="md:hidden" /> meaningful change.”
            </p>
            <p class="relative mt-3 text-[#5c4b3c] ml-50 font-medium top-10">— ECOconnect Core Value</p>
        </div>

    </div>
@endsection
