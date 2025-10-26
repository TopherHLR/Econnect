@extends('layouts.mainLayout')

@section('content')
<section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">

    <!-- 🌿 Left Branch -->
    <img 
        src="{{ Vite::asset('resources/images/viewport1/branch-left.svg') }}" 
        alt="Left branch" 
        class="absolute top-[-40px] left-[-80px] w-[700px] z-[30] animate-sway-left
               max-lg:w-[350px] max-md:top-[40px] max-md:left-[-40px]" />

    <!-- 🌿 Right Branch -->
    <img 
        src="{{ Vite::asset('resources/images/viewport1/branch-right.svg') }}" 
        alt="Right branch" 
        class="absolute top-0 right-0 w-[600px] z-[30] animate-sway-right
               max-lg:w-[350px] max-md:top-[30px]" />

    <!-- 🏔️ Mountains -->
    <img 
        src="{{ Vite::asset('resources/images/viewport1/terrains.png') }}" 
        alt="Terrains" 
        class="absolute top-[190px] bottom-0 left-0 w-screen h-auto z-[3]" />

    <!-- 🌍 Globe (enlarged) -->
    <img 
        src="{{ Vite::asset('resources/images/viewport1/earth-blue.png') }}" 
        alt="Globe" 
        class="absolute top-90 left-1/2 -translate-x-1/2 w-[1500px] z-[4]
               max-lg:w-[1100px] max-md:w-[900px] max-md:bottom-[-50px]" />

    <!-- 🌫️ Soft Fog Layer -->
    <div class="absolute bottom-0 left-0 w-full h-[200px] bg-gradient-to-t from-[#E0E9D6] via-[#E0E9D6]/80 to-transparent z-[5]"></div>

    <!-- 🌿 Feedback Notification -->
    @if (session('success'))
        <div 
            id="feedback-toast"
            class="fixed top-6 left-1/2 -translate-x-1/2 bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919] font-serif italic text-lg shadow-md px-6 py-3 rounded-full z-[9999] transition-opacity duration-1000 ease-in-out opacity-100"
        >
            🌱 {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('feedback-toast');
                if (toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 1000);
                }
            }, 3000);
        </script>
    @endif

    <!-- ☁️ Clouds (top-most layer) -->
    <img 
        src="{{ Vite::asset('resources/images/viewport1/realistic-cloud.png') }}" 
        alt="cloud" 
        class="absolute top-[100px] left-0 w-[1000px] opacity-90 z-[20]
               animate-[cloud1_60s_linear_infinite]
               max-md:top-[0px] max-md:w-[700px]
               max-sm:top-[-50px] max-sm:w-[500px]" 
    />

    <img 
        src="{{ Vite::asset('resources/images/viewport1/realistic-cloud2.png') }}" 
        alt="cloud" 
        class="absolute top-[100px] right-0 w-[1000px] opacity-90 z-[20]
               animate-[cloud2_60s_linear_infinite]
               max-md:top-[0px] max-md:w-[700px]
               max-sm:top-[50px] max-sm:w-[500px]" 
    />

    <!-- 🌏 Centered Text (top-most) -->
    <div class="absolute top-[20%] left-1/2 -translate-x-1/2 text-center px-4 z-[60]">
        <h1 class="italic text-3xl md:text-4xl font-serif font-semibold text-[#5C7919] leading-snug drop-shadow-[0_2px_3px_rgba(255,255,255,0.8)]">
            You’re here because you care<br class="hidden md:block">
            about the planet we call home.
        </h1>
    </div>

</section>

<!-- 🌿 Widgets for Logged-in Users -->
@auth
<div class="eco-widgets-container">
    <!-- 🌱 Saved Eco-Actions Widget -->
    <div class="eco-widget eco-actions"
         style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
        <button class="eco-widget-btn">My Eco-actions</button>
        <p class="eco-widget-text">“Turn Off Unused Lights”</p>
        <a href="#" class="eco-widget-link">View saved eco-actions ></a>
    </div>

    <!-- 🌎 Saved Eco-Topics Widget -->
    <div class="eco-widget eco-topics"
         style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
        <button class="eco-widget-btn">Saved Eco-topics</button>
        <p class="eco-widget-text">“The Impact of Plastic”</p>
        <a href="#" class="eco-widget-link">Continue reading ></a>
    </div>
</div>
@endauth

<section class="relative -top-75 min-h-[200vh] flex items-center justify-center viewport2BG">
    <div 
        id="plant-container" 
        class="relative w-[250px] -top-210 flex items-center justify-center transition-transform duration-[1500ms] ease-out">

        <!-- 🌿 Text Above Plant -->
        <div id="plant-text" 
            class="absolute top-0 left-1/2 z-70 -translate-x-1/2 w-max text-center transition-all duration-700 ease-out">
            <h1 class="italic text-3xl md:text-5xl font-serif font-semibold text-[#625237] leading-snug whitespace-nowrap">
                Even in small ways 
            </h1>
        </div>

        <!-- 🌾 Glow Background -->
        <div class="absolute top-20 flex items-center justify-center">
            <div class="w-[400px] h-[550px] rounded-full bg-gradient-to-b from-yellow-200/60 via-yellow-100/30 to-transparent blur-3xl scale-110"></div>
            <div class="absolute top-15 w-[250px] h-[350px] rounded-full bg-white/50 blur-2xl"></div>
        </div>

        <!-- 🌱 Base Image -->
        <img 
            src="{{ Vite::asset('resources/images/plants/small_plant.png') }}" 
            alt="plant"
            class="w-full relative z-10"
            style="clip-path: inset(80% 0 0 0); transform-origin: center 80%;"
        />

        <!-- 🌿 Animated Top Image -->
        <img 
            src="{{ Vite::asset('resources/images/plants/small_plant.png') }}" 
            alt="plant-top"
            class="absolute top-0 left-0 w-full animate-sway-top z-20"
            style="clip-path: inset(0 0 15% 0); transform-origin: center 80%;"
        />

        <!-- 🌾 Horizontal Progress Bar -->
        <div 
            id="growth-bar" 
            class="absolute opacity-0 bottom-[-80px] flex flex-col items-center transition-opacity duration-700 ease-out">
            
            <p class="text-[#5C7919] text-lg md:text-2xl font-serif italic mb-3 opacity-80">
                Your personal growth tree
            </p>

            <div class="relative w-[300px] md:w-[500px] h-[14px] rounded-full bg-[#d6cbb7]/40 overflow-hidden shadow-inner">
                <div class="absolute left-0 bottom-0 h-full w-[40%] bg-gradient-to-r from-[#9f8f6a] via-[#bfae7c] to-[#f2e9c2] rounded-full shadow-lg"></div>
            </div>

            <div class="absolute right-[60%] bottom-[-10px] w-[24px] h-[24px] rounded-full bg-yellow-100 blur-sm shadow-md"></div>
        </div>
    </div>
</section>
@endsection