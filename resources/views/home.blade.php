@extends('layouts.mainLayout')

@section('content')
  <section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">

    <!-- 🌿 Left Branch -->
    <img src="{{ Vite::asset('resources/images/viewport1/branch-left.svg') }}" alt="Left branch" class="absolute top-[-40px] left-[-80px] w-[700px] z-[30] animate-sway-left
                 max-lg:w-[350px] max-md:top-[40px] max-md:left-[-40px]" />

    <!-- 🌿 Right Branch -->
    <img src="{{ Vite::asset('resources/images/viewport1/branch-right.svg') }}" alt="Right branch" class="absolute top-0 right-0 w-[600px] z-[30] animate-sway-right
                 max-lg:w-[350px] max-md:top-[30px]" />

    <!-- 🏔️ Mountains -->
    <img src="{{ Vite::asset('resources/images/viewport1/terrains.png') }}" alt="Terrains"
      class="absolute top-[190px] bottom-0 left-0 w-screen h-auto z-[3]" />

    <!-- 🌍 Globe (enlarged) -->
    <img src="{{ Vite::asset('resources/images/viewport1/earth-blue.png') }}" alt="Globe" class="absolute top-90 left-1/2 -translate-x-1/2 w-[1500px] z-[4]
                 max-lg:w-[1100px] max-md:w-[900px] max-md:bottom-[-50px]" />

    <!-- 🌫️ Soft Fog Layer -->
    <div
      class="absolute bottom-0 left-0 w-full h-[200px] bg-gradient-to-t from-[#E0E9D6] via-[#E0E9D6]/80 to-transparent z-[5]">
    </div>


    <!-- ☁️ Clouds (top-most layer) -->
    <img src="{{ Vite::asset('resources/images/viewport1/realistic-cloud.png') }}" alt="cloud" class="absolute top-[100px] left-0 w-[1000px] opacity-90 z-[20]
                 animate-[cloud1_60s_linear_infinite]
                 max-md:top-[0px] max-md:w-[700px]
                 max-sm:top-[-50px] max-sm:w-[500px]" />

    <img src="{{ Vite::asset('resources/images/viewport1/realistic-cloud2.png') }}" alt="cloud" class="absolute top-[100px] right-0 w-[1000px] opacity-90 z-[20]
                 animate-[cloud2_60s_linear_infinite]
                 max-md:top-[0px] max-md:w-[700px]
                 max-sm:top-[50px] max-sm:w-[500px]" />

    <!-- 🌏 Centered Text (top-most) -->
    <div class="absolute top-[20%] left-1/2 -translate-x-1/2 text-center px-4 z-20">
      <h1
        class="italic text-3xl md:text-4xl font-serif font-semibold text-[#5C7919] leading-snug drop-shadow-[0_2px_3px_rgba(255,255,255,0.8)]">
        You’re here because you care<br class="hidden md:block">
        about the planet we call home.
      </h1>
    </div>

  </section>
@include('modal.ecoDetailModal')
  <!-- 🌿 Widgets for Logged-in Users -->
  @auth
  <div class="eco-widgets-container">
      <!-- 🌱 Saved Eco-Actions Widget -->
      <div class="eco-widget eco-actions"
          style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
          <button class="eco-widget-btn">My Eco-actions</button>
          <p id="eco-action-text" class="eco-widget-text">Loading...</p>
          <a href="/lifestyle?tab=actions" class="eco-widget-link">
              View saved eco-actions &gt;
          </a>

      </div>
      <!-- 🌎 Saved Eco-Topics Widget -->
      <div class="eco-widget eco-topics"
          style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
          <button class="eco-widget-btn">Saved Eco-topics</button>
          <p id="eco-topic-text" class="eco-widget-text">Loading...</p>
          <a href="javascript:void(0);" 
            id="ecoTopicLink"
            class="eco-widget-link">
            Continue reading &gt;
          </a>

      </div>

  </div>

  {{-- 🔄 Auto-refresh widget texts --}}
  <script>
async function updateWidgets() {
    try {
        const response = await fetch("{{ route('widgets.random') }}");
        const data = await response.json();

        // Update action text
        document.getElementById('eco-action-text').textContent = 
            data.eco_action?.title ?? '"No saved actions yet"';

        // Update topic text and link
        const topicText = document.getElementById('eco-topic-text');
        const topicLink = document.getElementById('ecoTopicLink');

        if (data.eco_topic) {
            topicText.textContent = `"${data.eco_topic.title}"`;
            topicLink.onclick = () => openEcoModal('ecoTopic', data.eco_topic.id);
        } else {
            topicText.textContent = '"No saved topics yet"';
            topicLink.onclick = null;
        }


    } catch (error) {
        console.error('Error updating widgets:', error);
    }

    // Change every 5–10 seconds
    const nextUpdate = Math.floor(Math.random() * 5000) + 5000;
    setTimeout(updateWidgets, nextUpdate);
}

updateWidgets();


  </script>
  @endauth


  <section class="relative -top-75 min-h-[200vh] flex items-center justify-center viewport2BG">
    <div id="plant-container"
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
        <div
          class="w-[400px] h-[550px] rounded-full bg-gradient-to-b from-yellow-200/60 via-yellow-100/30 to-transparent blur-3xl scale-110">
        </div>
        <div class="absolute top-15 w-[250px] h-[350px] rounded-full bg-white/50 blur-2xl"></div>
      </div>

      <!-- 🌱 Base Image -->
      <img src="{{ Vite::asset('resources/images/plants/small_plant.png') }}" alt="plant" class="w-full relative z-10"
        style="clip-path: inset(86% 0 0 0); transform-origin: center 80%;" />

      <!-- 🌿 Animated Top Image -->
      <img src="{{ Vite::asset('resources/images/plants/small_plant.png') }}" alt="plant-top"
        class="absolute top-0 left-0 w-full animate-sway-top z-20"
        style="clip-path: inset(0 0 14% 0); transform-origin: center 80%;" />

      <!-- 🌾 Horizontal Progress Bar -->
      <div id="growth-bar"
        class="absolute opacity-0 bottom-[-80px] flex flex-col items-center transition-opacity duration-700 ease-out">

        <p class="text-[#5C7919] text-lg md:text-2xl font-serif italic mb-3 opacity-80">
          Your personal growth tree
        </p>

        <div class="relative w-[300px] md:w-[500px] h-[14px] rounded-full bg-[#d6cbb7]/40 overflow-hidden shadow-inner">
          <div
            class="absolute left-0 bottom-0 h-full w-[40%] bg-gradient-to-r from-[#9f8f6a] via-[#bfae7c] to-[#f2e9c2] rounded-full shadow-lg">
          </div>
        </div>

        <div class="absolute right-[60%] bottom-[-10px] w-[24px] h-[24px] rounded-full bg-yellow-100 blur-sm shadow-md">
        </div>
      </div>
    </div>
  </section>

  <section class="relative text-center py-20 px-6 overflow-hidden mb-[96px]">
    <!-- Left Cloud -->
    <img src="{{ Vite::asset('resources/images/cloud/cloud-removebg-preview.png') }}" alt="Cloud Left"
      class="absolute left-[-160px] top-10 w-[500px] opacity-90">

    <!-- Right Cloud -->
    <img src="{{ Vite::asset('resources/images/cloud/cloud-removebg-preview.png') }}" alt="Cloud Right"
      class="absolute right-[-160px] top-10 w-[500px] opacity-90 scale-x-[-1]">

    <!-- Content -->
    <div class="relative z-10 flex flex-col items-center justify-center space-y-10">
      <h2 class="text-white italic font-semibold text-3xl md:text-4xl drop-shadow-md">
        Just like <span class="font-bold">ECOnnect</span>
      </h2>

      <!-- Arrow -->
      <div class="w-[2px] h-[60px] bg-[#654321] relative">
        <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 rotate-45 
                          w-[12px] h-[12px] border-b-[3px] border-r-[3px] border-[#654321]">
        </div>
      </div>

      <!-- Text Box -->
      <div class="bg-[#6b3f26] text-white text-base md:text-lg px-6 py-3 rounded-xl max-w-md leading-relaxed shadow-md">
        ECOnnect shares simple ways to live more sustainably—at no cost.
      </div>
    </div>
  </section>

  <section class="py-20 px-8 overflow-hidden relative">
    <!-- 🕊️ Bird -->
    <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (9).png') }}" alt="Bird"
      class="absolute top-[80px] right-[0px] w-[440px] z-0">

    <!-- 🦎 Chameleon -->
    <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (10).png') }}" alt="Chameleon"
      class="absolute top-[380px] left-[-120px] w-[560px] z-0">

    <!-- 🦥 Sloth -->
    <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (11).png') }}" alt="Sloth"
      class="absolute bottom-[-0px] right-[-2px] w-[380px] z-0">

    <!-- 🌿 Cards -->
    <div class="relative z-10 flex flex-col items-start gap-20 max-w-6xl mx-auto mt-10">

      <!-- 🌱 Card 1 -->
      <div
        class="bg-gradient-to-r from-[#E3F2D3] to-[#F7FBEE] rounded-3xl p-8 shadow-md flex items-center justify-between w-[520px] ml-[80px]">
        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (5).png') }}"
          alt="Eco Habit Light Bulb" class="w-[120px] mr-6">
        <div class="flex-1">
          <h3 class="text-[#4A6613] italic font-semibold text-2xl">Discover eco-friendly habits</h3>
          <p class="text-gray-700 mt-2">EcoBrew shares simple ways to live more sustainably—at no cost.</p>
          <div class="flex justify-end">
            <button class="mt-4 bg-[#5C3B23] text-white px-5 py-2 rounded-full text-sm hover:bg-[#3d2617]">
              Explore eco-library
            </button>
          </div>
        </div>
      </div>

      <!-- 🌿 Card 2 -->
      <div
        class="bg-gradient-to-r from-[#F7FBEE] to-[#E3F2D3] rounded-3xl p-8 shadow-md flex items-center justify-between w-[520px] ml-auto mr-[160px]">
        <div class="flex-1">
          <h3 class="text-[#4A6613] italic font-semibold text-2xl">Take on fun eco-quests</h3>
          <p class="text-gray-700 mt-2">Turn small actions into meaningful impact.</p>
          <!-- 🔽 Button moved to left side -->
          <div class="flex justify-start">
            <button class="mt-4 bg-[#5C3B23] text-white px-5 py-2 rounded-full text-sm hover:bg-[#3d2617]">
              Explore quests
            </button>
          </div>
        </div>
        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (6).png') }}" alt="Eco Ribbon"
          class="w-[120px] ml-6">
      </div>

      <!-- ☕ Card 3 -->
      <div
        class="bg-gradient-to-r from-[#E3F2D3] to-[#F7FBEE] rounded-3xl p-8 shadow-md flex items-center justify-between w-[520px] ml-[100px]">
        <img src="{{ Vite::asset('resources/images/viewport1/cup.png') }}" alt="Eco Cup"
          class="w-[120px] mr-6">
        <div class="flex-1">
          <h3 class="text-[#4A6613] italic font-semibold text-2xl">Be inspired by ECOnnect</h3>
          <p class="text-gray-700 mt-2">See how one café walks its sustainability talk.</p>
          <div class="flex justify-end">
            <button class="mt-4 bg-[#5C3B23] text-white px-5 py-2 rounded-full text-sm hover:bg-[#3d2617]">
              About us
            </button>
          </div>
        </div>
      </div>

    </div>
  </section>



  <section class="py-20 px-8 bg-center bg-repeat"
    style="background-image: url('{{ Vite::asset('resources/images/viewport1/image-removebg-preview (12).png') }}'); background-blend-mode: soft-light;">

    <div class="relative z-10 max-w-5xl mx-auto text-center">
      <h2 class="text-[#4A6613] italic text-2xl md:text-3xl font-semibold mb-4">
        Simple, interactive, and real — designed to help you live better for the planet.
      </h2>

      <!-- Step Cards -->
      <h3 class="text-[#4A6613] italic font-semibold text-xl mt-10 mb-8">Choose your first step today</h3>

      <div class="flex flex-col md:flex-row justify-center gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-[#F8F4E7] rounded-2xl shadow-md w-full md:w-1/3 text-left overflow-hidden">
          <!-- Header -->
          <div class="bg-[#A16A44] text-white text-center font-semibold py-3 text-lg rounded-t-2xl">
            Use a Reusable Bag
          </div>
          <!-- Body -->
          <div class="p-6 relative">
            <p class="text-[#4A6613] text-sm leading-relaxed mb-2">
              <strong>STEP 1:</strong> Place an eco bag in your pocket or bag.
            </p>
            <p class="text-[#4A6613] text-sm leading-relaxed">
              <strong>STEP 2:</strong> Apply it when purchasing food <br>or groceries.
            </p>
            <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (5).png') }}" alt="Bag Icon"
              class="absolute bottom-4 right-4 w-[40px] opacity-90">
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-[#F8F4E7] rounded-2xl shadow-md w-full md:w-1/3 text-left overflow-hidden">
          <!-- Header -->
          <div class="bg-[#A16A44] text-white text-center font-semibold py-3 text-lg rounded-t-2xl">
            Turn Off Unused Lights
          </div>
          <!-- Body -->
          <div class="p-6 relative">
            <p class="text-[#4A6613] text-sm leading-relaxed mb-2">
              <strong>STEP 1:</strong> Check all the rooms before you leave.
            </p>
            <p class="text-[#4A6613] text-sm leading-relaxed">
              <strong>STEP 2:</strong> Turn off lights and remove <br>charger plugs.
            </p>
            <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (5).png') }}" alt="Light Icon"
              class="absolute bottom-4 right-4 w-[40px] opacity-90">
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-[#F8F4E7] rounded-2xl shadow-md w-full md:w-1/3 text-left overflow-hidden">
          <!-- Header -->
          <div class="bg-[#A16A44] text-white text-center font-semibold py-3 text-lg rounded-t-2xl">
            Use Both Sides of Paper
          </div>
          <!-- Body -->
          <div class="p-6 relative">
            <p class="text-[#4A6613] text-sm leading-relaxed mb-2">
              <strong>STEP 1:</strong> If writing or printing is required, use the back side.
            </p>
            <p class="text-[#4A6613] text-sm leading-relaxed">
              <strong>STEP 2:</strong> Reserve used paper for drafts <br> or notes.
            </p>
            <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (5).png') }}" alt="Paper Icon"
              class="absolute bottom-4 right-4 w-[40px] opacity-90">
          </div>
        </div>
      </div>

      <button class="bg-[#7A8C4F] text-white px-6 py-2 rounded-full text-sm hover:bg-[#3d2617]">
        See more eco-actions
      </button>

      <!-- Discount Card -->
      <div
        class="mt-16 bg-gradient-to-r from-[#f6f1e9] to-[#e3f0dc] rounded-3xl shadow-md p-8 flex flex-col md:flex-row items-center justify-between max-w-3xl mx-auto">
        <div class="flex items-center gap-4">
          <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (13).png') }}" alt="Eco Badge"
            class="w-[150px]">
          <div>
            <h4 class="text-[#4A6613] italic text-xl font-semibold">Turn your actions into discounts!</h4>
            <p class="text-[#5C3B23] mt-2 text-sm">“Quest has been validated!”<br>You made small steps that help the
              planet today!</p>
          </div>
        </div>

        <!-- Placeholder Image -->
        <div
          class="w-[200px] h-[200px] mt-6 md:mt-0 flex items-center justify-center bg-gray-200 rounded-2xl border border-dashed border-gray-400 text-gray-500 italic text-sm">
          Placeholder Image
        </div>
      </div>
    </div>
  </section>

  <section class="relative py-48 px-8 bg-center bg-cover overflow-hidden"
    style="background-image: url('{{ Vite::asset('resources/images/viewport1/cc23b421-0654-477b-86a8-4b6462a55a94.png') }}');">

    <!-- 🌿 Left Leaf Cluster Top (moved lower) -->
    <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (15).png') }}"
      class="absolute left-65 bottom-27 w-48 md:w-64 opacity-90 pointer-events-none select-none" alt="Leaf cluster">

    <!-- 🌿 Right Leaf Cluster Top -->
    <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (16).png') }}"
      class="absolute right-60 bottom-50 w-52 md:w-72 opacity-90 pointer-events-none select-none" alt="Leaf cluster">

    <!-- 🌿 Left Leaf Cluster Bottom -->
    <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (18).png') }}"
      class="absolute left-[-100px] top-50 w-56 md:w-72 opacity-90 pointer-events-none select-none" alt="Leaf cluster">

    <!-- 🌿 Right Leaf Cluster Bottom -->
    <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (19).png') }}"
      class="absolute right-[-100px] top-50 w-60 md:w-80 opacity-90 pointer-events-none select-none" alt="Leaf cluster">

    <div class="relative z-10 max-w-6xl mx-auto text-center">
      <h2 class="text-[#5C3B23] font-semibold text-xl md:text-2xl mb-6">
        Ecobrew leads by example:
      </h2>

      <!-- ♻️ Recycle Image Slider -->
      <div class="relative mx-auto aspect-square w-[260px] md:w-[320px]">
        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (14).png') }}" alt="Eco Example"
          class="rounded-[32px] shadow-lg w-full h-full object-cover mx-auto">
        <button class="absolute left-[-40px] top-1/2 transform -translate-y-1/2 text-[#4A6613] text-3xl">
          &#8249;
        </button>
        <button class="absolute right-[-40px] top-1/2 transform -translate-y-1/2 text-[#4A6613] text-3xl">
          &#8250;
        </button>
      </div>

      <!-- 💬 Testimonials -->
      <!-- 💬 Testimonials -->
      <h3 class="text-[#4A6613] italic font-semibold text-2xl md:text-3xl mt-24 mb-12">
        What our community is saying:
      </h3>


      <div class="flex flex-col md:flex-row justify-center gap-6">
        <!-- Testimonial 1 (moved higher) -->
        <div class="bg-[#F8F4E7] rounded-2xl shadow-md p-6 w-full md:w-1/3 text-left relative md:-top-10 -top-6">
          <p class="text-[#4A6613] italic mb-2">
            “I really appreciate how this eco-based system encourages action, hindi lang puro awareness. May results
            talaga.”
          </p>
          <p class="text-[#4A6613] text-sm mt-4">★★★★★</p>
        </div>

        <!-- Testimonial 2 (lowered) -->
        <div class="bg-[#F8F4E7] rounded-2xl shadow-md p-6 w-full md:w-1/3 text-left relative md:top-20 top-10">
          <p class="text-[#4A6613] italic mb-2">
            “It motivates me to do small eco-quests every day. Super fun and fulfilling!”
          </p>
          <p class="text-[#4A6613] text-sm mt-4">★★★★★</p>
        </div>

        <!-- Testimonial 3 -->
        <div class="bg-[#F8F4E7] rounded-2xl shadow-md p-6 w-full md:w-1/3 text-left relative">
          <p class="text-[#4A6613] italic mb-2">
            “Love how it turns eco-awareness into real actions that make an impact!”
          </p>
          <p class="text-[#4A6613] text-sm mt-4">★★★★★</p>
        </div>
      </div>
    </div>
  </section>

  <section class="relative text-center py-32 px-6 bg-center bg-repeat"
    style="background-image: url('{{ Vite::asset('resources/images/viewport1/image-removebg-preview (12).png') }}'); background-blend-mode: soft-light;">

    <div class="max-w-3xl mx-auto">
      <h2 class="text-[#4A6613] italic font-semibold text-2xl md:text-4xl mb-8 leading-[1.8]">
        Join others in making small <br><br class="md:hidden"> movements for a big impact
      </h2>

      <!-- 👥 Community Icons -->
      <div class="flex justify-center gap-2 mb-4">
        <img src="{{ Vite::asset('resources/images/viewport1/1430e7da-9929-47a5-b098-bdc742198b2c.png') }}"
          alt="Community Icons" class="w-48 md:w-60 mx-auto select-none pointer-events-none">
      </div>

      <p class="text-[#4A6613] text-sm mb-16">200 eco-actions completed this week</p>

      <!-- 🌎 Call to Action -->
      <h3 class="text-[#5C3B23] italic font-semibold text-xl md:text-5xl mb-8">
        Your first eco-quest awaits!
      </h3>

      <button
        class="bg-gradient-to-r from-[#8B5E3C] to-[#5C3B23] text-white font-semibold py-3 px-8 rounded-full shadow-md hover:opacity-90 transition">
        Start Your Journey
      </button>
    </div>
  </section>





@endsection