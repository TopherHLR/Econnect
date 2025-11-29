@extends('layouts.mainLayout')

@section('content')
    <section class="w-full py-12 flex justify-center bg-cover bg-center bg-no-repeat"
        style="background-image: url('resource/images/viewport1/aboutbg.png');">
        <div class="bg-[#fdf8ef] w-10/12 md:w-2/3 rounded-3xl shadow-xl p-6 md:p-10 pt-16 pb-20 relative">

            <!-- Title -->
            <h2 class="ml-6 text-3xl md:text-4xl italic font-semibold text-[#6B462D] flex items-center gap-2"
                style="font-family: var(--font-serif);">
                About<span class="text-[#C37A49]">ECOnnect</span>
                <img src="{{ Vite::asset('resources/images/viewport1/minidahon.png') }}" class="w-10 h-10 " />
            </h2>

            <!-- Content Wrapper -->
            <div class="relative mt-6 flex items-center justify-center">

                <!-- Left Arrow -->
                <button
                    class="absolute left-0 md:-left-8 bg-[#d8cbb7] hover:bg-[#c4b39e] text-[#654321] 
                                                                             rounded-full w-8 h-8 flex items-center justify-center shadow-md">
                    <span class="text-xl">&lsaquo;</span>
                </button>

                <!-- Image Box -->
                <div class="overflow-hidden rounded-[40px] shadow-md w-full">
                    <img src="{{ Vite::asset('resources/images/viewport1/abouteconnect.png') }}" alt="About ECOconnect"
                        class="w-full h-[300px] md:h-[650px] object-cover rounded-[40px]">
                </div>

                <!-- Right Arrow -->
                <button
                    class="absolute right-0 md:-right-8 bg-[#d8cbb7] hover:bg-[#c4b39e] text-[#654321] 
                                                                             rounded-full w-8 h-8 flex items-center justify-center shadow-md">
                    <span class="text-xl">&rsaquo;</span>
                </button>

            </div>

            <!-- Caption -->
            <p class="text-[#6b5b4d]  mt-6 text-center text-base md:text-lg">
                Connecting people, actions, and awareness for a sustainable world.
            </p>

        </div>
    </section>

    <section class="w-full py-16 bg-[#dfeadf] bg-cover bg-center">

        <div class="w-11/12 md:w-10/12 mx-auto grid md:grid-cols-2 gap-10">

            <!-- LEFT IMAGE -->
            <div class="ml-auto">
                <img src="{{ Vite::asset('resources/images/viewport1/planting.png') }}" class="w-auto">
            </div>


            <!-- MISSION CARD -->
            <div class="flex items-center relative">
                <!-- CLIP IMAGE -->
                <img src="{{ Vite::asset('resources/images/viewport1/missionclip.png') }}"
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
