@extends('layouts.mainLayout')

@section('content')
<section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">
    <!-- Clouds -->
     @if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded-md text-center mb-4">
        {{ session('success') }}
    </div>
@endif
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

    <!-- 🌿 Widgets for Logged-in Users -->
    @auth
    <div class="absolute bottom-35 left-1/2 -translate-x-1/2 flex gap-10 max-md:flex-col max-md:items-center z-40">

            <!-- 🌱 Saved Eco-Actions Widget -->
            <div class="relative bg-[url('/images/viewport1/widgetcloud1.svg')] bg-contain bg-no-repeat bg-center px-8 py-10 shadow-lg flex flex-col items-center w-[250px] text-center">
                <button class="absolute -top-5 bg-[#5C7919] text-white px-3 py-1 rounded-full text-sm italic font-semibold shadow-md">
                    My Eco-actions
                </button>
                <p class="text-[#625237] font-serif text-xl font-semibold mt-6">
                    “Turn Off Unused Lights”
                </p>
                <a href="#" class="text-sm text-[#5C7919] underline mt-2">
                    View saved eco-actions >
                </a>
            </div>

            <!-- 🌎 Saved Eco-Topics Widget -->
            <div class="relative bg-[url('/images/viewport1/widgetcloud1.svg')] bg-contain bg-no-repeat bg-center px-8 py-10 shadow-lg flex flex-col items-center w-[250px] text-center">
                <button class="absolute -top-5 bg-[#5C7919] text-white px-3 py-1 rounded-full text-sm italic font-semibold shadow-md">
                    Saved Eco-topics
                </button>
                <p class="text-[#625237] font-serif text-xl font-semibold mt-6">
                    “The Impact of Plastic”
                </p>
                <a href="#" class="text-sm text-[#5C7919] underline mt-2">
                    Continue reading >
                </a>
            </div>



    </div>
    @endauth
</section>

<section class="relative -top-75 min-h-[200vh] flex items-center justify-center viewport2BG">
    <div 
        id="plant-container" 
        class="relative w-[250px] -top-210 flex items-center justify-center transition-transform duration-[1500ms] ease-out">

        <!-- 🌿 Text Above Plant -->
        <div id="plant-text" 
            class="absolute top-0 left-1/2 z-50 -translate-x-1/2 w-max text-center transition-all duration-700 ease-out">
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
