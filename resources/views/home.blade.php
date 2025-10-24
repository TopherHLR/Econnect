@extends('layouts.mainLayout')

@section('content')
<section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">
    <!-- Clouds -->
    <img 
        src="{{ Vite::asset('resources/images/viewport1/realistic-cloud.png') }}" 
        alt="cloud" 
        class="absolute top-[-150px] left-0 w-[1000px] opacity-80 animate-[cloud1_60s_linear_infinite]
               max-md:top-[-100px] max-md:w-[700px]
               max-sm:top-[-50px] max-sm:w-[500px]" 
    />

    <img 
        src="{{ Vite::asset('resources/images/viewport1/realistic-cloud2.png') }}" 
        alt="cloud" 
        class="absolute top-50 right-0 w-[1000px] opacity-80 animate-[cloud2_60s_linear_infinite]
               max-md:top-[0px] max-md:w-[700px]
               max-sm:top-[50px] max-sm:w-[500px]" 
    />
        <!-- Centered Text -->
    <div class="absolute top-50 text-center px-4">
        <h1 class="italic text-3xl md:text-4xl font-serif font-semibold text-[#5C7919] leading-snug">
            You’re here because you care<br class="hidden md:block">
            about the planet we call home.
        </h1>
    </div>
</section>

<section class="relative -top-75 min-h-[200vh] flex items-center justify-center viewport2BG">
    <div 
        id="plant-container" 
        class="relative w-[250px] -top-210 flex items-center justify-center transition-transform duration-[1500ms] ease-out">

        <!-- 🌿 Text Above Plant -->
        <div id="plant-text" 
            class="absolute top-0 left-1/2 z-50 -translate-x-1/2 w-max text-center transition-all duration-700 ease-out">
            <h1 class="italic text-3xl md:text-5xl font-serif font-semibold text-[#625237] leading-snug whitespace-nowrap">
                Even in small ways test
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
        />

        <!-- 🌿 Animated Top Image -->
        <img 
            src="{{ Vite::asset('resources/images/plants/small_plant.png') }}" 
            alt="plant-top"
            class="absolute top-0 left-0 w-full animate-sway-top z-20"
            style="clip-path: inset(0 0 15% 0); transform-origin: center 80%;"
        />

        <!-- 🌾 Horizontal Progress Bar (Initially Hidden) -->
        <div 
            id="growth-bar" 
            class="absolute opacity-0 bottom-[-80px] flex flex-col items-center transition-opacity duration-700 ease-out">
            
            <!-- Label -->
            <p class="text-[#5C7919] text-lg md:text-2xl font-serif italic mb-3 opacity-80">
                Your personal growth tree
            </p>

            <!-- Progress Track -->
            <div class="relative w-[300px] md:w-[500px] h-[14px] rounded-full bg-[#d6cbb7]/40 overflow-hidden shadow-inner">
                <!-- Static Filled Portion -->
                <div class="absolute left-0 bottom-0 h-full w-[40%] bg-gradient-to-r from-[#9f8f6a] via-[#bfae7c] to-[#f2e9c2] rounded-full shadow-lg"></div>
            </div>

            <!-- Small Glowing Dot -->
            <div class="absolute right-[60%] bottom-[-10px] w-[24px] h-[24px] rounded-full bg-yellow-100 blur-sm shadow-md"></div>
        </div>
    </div>
</section>



</section>
@endsection

