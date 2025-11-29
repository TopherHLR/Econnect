@extends('layouts.mainLayout')

@section('content')
    <section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">

        <!-- 🌿 Left Branch -->
        <img src="{{ Vite::asset('resources/images/viewport1/branch-left.svg') }}" alt="Left branch"
            class="absolute top-[-40px] left-[-80px] w-[700px] z-[30] animate-sway-left
                                     max-lg:w-[350px] max-md:top-[40px] max-md:left-[-40px]" />

        <!-- 🌿 Right Branch -->
        <img src="{{ Vite::asset('resources/images/viewport1/branch-right.svg') }}" alt="Right branch"
            class="absolute top-0 right-0 w-[600px] z-[30] animate-sway-right
                                     max-lg:w-[350px] max-md:top-[30px]" />

        <!-- 🏔️ Mountains -->
        <img src="{{ Vite::asset('resources/images/viewport1/terrains.png') }}" alt="Terrains"
            class="absolute top-[190px] bottom-0 left-0 w-screen h-auto z-[3]" />

        <!-- 🌍 Globe (enlarged) -->
        <img src="{{ Vite::asset('resources/images/viewport1/earth-blue.png') }}" alt="Globe"
            class="absolute top-90 left-1/2 -translate-x-1/2 w-[1500px] z-[4]
                                     max-lg:w-[1100px] max-md:w-[900px] max-md:bottom-[-50px]" />

        <!-- 🌫️ Soft Fog Layer -->
        <div
            class="absolute bottom-0 left-0 w-full h-[200px] bg-gradient-to-t from-[#E0E9D6] via-[#E0E9D6]/80 to-transparent z-[5]">
        </div>


        <!-- ☁️ Clouds (top-most layer) -->
        <img src="{{ Vite::asset('resources/images/viewport1/realistic-cloud.png') }}" alt="cloud"
            class="absolute top-[100px] left-0 w-[1000px] opacity-90 z-[20]
                                     animate-[cloud1_60s_linear_infinite]
                                     max-md:top-[0px] max-md:w-[700px]
                                     max-sm:top-[-50px] max-sm:w-[500px]" />

        <img src="{{ Vite::asset('resources/images/viewport1/realistic-cloud2.png') }}" alt="cloud"
            class="absolute top-[100px] right-0 w-[1000px] opacity-90 z-[20]
                                     animate-[cloud2_60s_linear_infinite]
                                     max-md:top-[0px] max-md:w-[700px]
                                     max-sm:top-[50px] max-sm:w-[500px]" />
        <!-- 🌏 Centered Text (top-most) -->
        <div
            class="absolute top-[20%] left-1/2 -translate-x-1/2 text-center px-4 z-20 w-full max-w-[90vw] md:max-w-[70vw] lg:max-w-[50vw]">
            <!-- Main Title -->
            <h1
                class="italic text-4xl md:text-7xl font-serif font-semibold text-[#5C7919] leading-tight drop-shadow-[0_2px_3px_rgba(255,255,255,0.8)]">
                <span class="word-emphasis youre">You're</span>
                <span class="word-emphasis here">here</span>
            </h1>

            <!-- Subtext with word-by-word glow -->
            <div class="subtext-container">
                <p
                    class="italic text-2xl md:text-4xl font-serif font-medium text-[#5C7919] leading-snug drop-shadow-[0_2px_2px_rgba(255,255,255,0.6)] ">
                    <span class="glow-word word-1">because</span>
                    <span class="glow-word word-2">you</span>
                    <span class="glow-word word-3">care</span>
                    <span class="glow-word word-4">about</span>
                    <span class="glow-word word-5">the</span>
                    <span class="glow-word word-6">planet</span>
                    <span class="glow-word word-7">we</span>
                    <span class="glow-word word-8">call</span>
                    <span class="glow-word word-9">home.</span>
                </p>
            </div>
        </div>
    </section>
    <!-- 🌿 Widgets for Logged-in Users -->
    @include('modal.userQuestModal')
    @include('modal.ecoDetailModal')
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
                <a href="javascript:void(0);" id="ecoTopicLink" class="eco-widget-link">
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

        @auth
            <!-- 🌿 LEFT MODAL PANEL -->
            <div
                class="absolute left-20 top-[20%] w-[420px] h-[300px] bg-white/40 backdrop-blur-md border border-white/30 shadow-xl p-5 rounded-3xl z-10">
                <!-- Title + View More Link -->
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-xl font-bold text-green-900">Available Quests</h2>

                    @if ($pendingSubmissions->count() > 0)
                        <a href="/quests" class="text-xs text-green-700 underline hover:text-green-900">
                            View More →
                        </a>
                    @endif
                </div>

                @if ($availableQuests->isEmpty())
                    <p class="text-gray-500 text-sm italic">No available quests at the moment 🌱</p>
                @else
                    <div class="space-y-3">

                        @foreach ($availableQuests->take(2) as $quest)
                            <div class="p-4 bg-white/80 shadow rounded-xl border border-green-100">
                                <h3 class="font-semibold text-green-800">{{ $quest->title }}</h3>

                                <p class="text-xs text-gray-600 mt-1">
                                    Reward:
                                    <span class="font-bold text-green-700">{{ $quest->points_reward }} points</span>
                                </p>

                                <span
                                    onclick="openActiveQuestModal({
                                            id: {{ $quest->quest_id }},
                                            title: '{{ $quest->title }}',
                                            description: '{{ $quest->description }}',
                                            category: '{{ $quest->category }}',
                                            points_reward: {{ $quest->points_reward }},
                                            status: '{{ $quest->status }}',
                                            start_date: '{{ $quest->start_date }}',
                                            end_date: '{{ $quest->end_date }}'
                                        })"
                                    class="text-xs text-blue-700 underline mt-2 block cursor-pointer">
                                    View Quest →
                                </span>

                            </div>
                        @endforeach

                    </div>
                @endif

            </div>
            <!-- 🌿 RIGHT MODAL PANEL -->
            <div
                class="absolute right-20 top-[20%] w-[420px] h-[300px] bg-white/40 backdrop-blur-md border border-white/30 shadow-xl p-5 rounded-3xl z-10">

                <!-- Title + View More Link -->
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-xl font-bold text-green-900">Pending Submissions</h2>

                    @if ($pendingSubmissions->count() > 0)
                        <a href="/quests" class="text-xs text-green-700 underline hover:text-green-900">
                            View More →
                        </a>
                    @endif
                </div>

                @if ($pendingSubmissions->isEmpty())
                    <p class="text-gray-500 text-sm italic">No pending tasks </p>
                @else
                    <div class="space-y-3">

                        @foreach ($pendingSubmissions->take(2) as $sub)
                            <div class="p-4 bg-white/80 shadow rounded-xl border border-green-100">
                                <h3 class="font-semibold text-green-800">{{ $sub->quest->title }}</h3>

                                <p class="text-xs text-gray-600 mt-1">
                                    Status:
                                    <span class="font-medium text-orange-600">{{ ucfirst($sub->status) }}</span>
                                </p>
                                @php
                                    $submissionData = [
                                        'submission_id' => $sub->submission_id,
                                        'questTitle' => $sub->quest->title,
                                        'questDescription' => $sub->quest->description,
                                    ];
                                @endphp

                                <span onclick='openAcceptedQuestModal(@json($submissionData))'
                                    class="text-xs text-blue-700 underline mt-2 block cursor-pointer">
                                    Continue →
                                </span>


                            </div>
                        @endforeach

                    </div>
                @endif

            </div>

        @endauth



        <div id="plant-container"
            class="relative w-[250px] -top-210 flex items-center justify-center transition-transform duration-[1500ms] ease-out z-20">

            <!-- 🍂 Fallen Leaves Container -->
            <div id="fallen-leaves" class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden"></div>

            <!-- 🌿 Text Above Plant -->
            <div id="plant-text"
                class="absolute top-0 left-1/2 z-70 -translate-x-1/2 w-max text-center transition-all duration-700 ease-out">
                <h1
                    class="italic text-3xl md:text-5xl font-serif font-semibold text-[#625237] leading-snug whitespace-nowrap">
                    Even in small ways
                </h1>
            </div>

            <!-- 🌾 Glow Background -->
            <div class="absolute top-20 flex items-center justify-center">
                <div
                    class="w-[400px] h-[550px] rounded-full bg-gradient-to-b 
                            from-yellow-200/60 via-yellow-100/30 to-transparent 
                            blur-3xl scale-110">
                </div>
                <div class="absolute top-15 w-[250px] h-[350px] rounded-full bg-white/50 blur-2xl"></div>
            </div>

            <!-- 🌟 Hint Message -->
            <div id="tap-message"
                class="absolute left-full ml-3 top-1/2 -translate-y-1/2 text-xs italic text-white opacity-0 transition-opacity duration-500">
            </div>

            @auth

                <img id="plant-image" src="{{ Vite::asset('resources/images/tree/5.svg') }}" alt="Plant"
                    class="z-20 w-full transition-all duration-700">

                <!-- 🌾 Horizontal Progress Bar -->
                <div id="growth-bar"
                    class="absolute opacity-0 bottom-[-80px] flex flex-col items-center transition-opacity duration-700 ease-out">

                    <p class="text-[#5C7919] text-lg md:text-2xl font-serif italic mb-3 opacity-80">
                        Your personal growth tree
                    </p>

                    <div
                        class="relative w-[300px] md:w-[500px] h-[14px] rounded-full bg-[#d6cbb7]/40 overflow-hidden shadow-inner">
                        <div id="growth-fill"
                            class="absolute left-0 bottom-0 h-full bg-gradient-to-r 
                                from-[#9f8f6a] via-[#bfae7c] to-[#f2e9c2] rounded-full shadow-lg"
                            style="width: {{ $growthPercent }}%;">
                        </div>
                    </div>

                    <p id="growth-label" class="mt-2 text-[#6b665e] text-sm font-medium">
                        Stage {{ $stage }} / {{ $treeStages }} — {{ $progressPoints }} / {{ $growthMax }} points
                    </p>
                </div>

            @endauth

            @guest
                <img id="plant-image" src="{{ Vite::asset('resources/images/tree/5.svg') }}" alt="Plant"
                    class="z-20 w-full transition-all duration-700">

                <div id="growth-bar" class="absolute bottom-[-80px] flex flex-col items-center opacity-100">
                    <p class="text-[#5C7919] text-lg md:text-2xl font-serif italic mb-3 opacity-80">
                        Your personal growth tree
                    </p>

                    <div
                        class="relative w-[300px] md:w-[500px] h-[14px] rounded-full bg-[#d6cbb7]/40 overflow-hidden shadow-inner">
                        <div id="growth-fill" class="absolute left-0 bottom-0 h-full" style="width: 0%;"></div>
                    </div>

                    <p id="growth-label" class="mt-2 text-[#6b665e] text-sm font-medium">
                        Please log in to see your personalized growth tree
                    </p>
                </div>
            @endguest

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
        <div class="relative flex flex-col items-center justify-center space-y-10 z-10">
            <h2 class="text-white italic font-semibold text-3xl md:text-4xl drop-shadow-md">
                Just like <span class="font-bold">ECOnnect</span>
            </h2>

            <!-- Arrow -->
            <div class="flex justify-center">
                <img src="{{ Vite::asset('resources/images/viewport1/arrowdown.png') }}" alt="Arrow Down"
                    class="w-[100px] h-auto">
            </div>

            <!-- Text Box -->
            <div
                class="bg-[#6b3f26] text-white text-base md:text-lg px-6 py-3 rounded-xl max-w-md leading-relaxed shadow-md">
                ECOnnect shares simple ways to live more sustainably—at no cost.
            </div>
        </div>
    </section>

    <section class="py-20 px-8 overflow-hidden relative">


        <!-- 🌿 Cards -->
        <div class="relative z-10 flex flex-col items-start gap-20 max-w-6xl mx-auto mt-10">

            <!-- 🌱 Card 1 -->
            <div
                class="bg-gradient-to-r from-[#E3F2D3] to-[#F7FBEE] rounded-3xl p-8 shadow-md flex items-center justify-between w-[1000px] -ml-[160px] min-h-[300px]">
                <div class="flex-1">
                    <h3 class="text-[#4A6613] italic font-semibold text-[40px]">Discover eco-friendly habits</h3>
                    <p class="text-gray-700 mt-2 text-[20px]">EcoBrew shares simple ways to live more sustainably—at no
                        cost.</p>
                    <div class="flex justify-end">
                        <button class="mt-1 bg-[#5C3B23] text-white px-5 py-2 rounded-full text-sm hover:bg-[#3d2617]">
                            Explore eco-library
                        </button>
                    </div>
                </div>
            </div>

        <!-- 🌿 Card 2 -->
        <div
            class="bg-gradient-to-r from-[#F7FBEE] to-[#E3F2D3] rounded-3xl p-8 shadow-md flex items-center justify-between w-[1000px] ml-[160px] mr-[160px] min-h-[300px]">
            <div class="flex-1">
                <h3 class="text-[#4A6613] italic font-semibold text-[40px]">Take on fun eco-quests</h3>
                <p class="text-gray-700 mt-2 text-[20px]">Turn small actions into meaningful impact.</p>
                <!-- 🔽 Button moved to left side -->
                <div class="flex justify-start">
                    <button class="mt-10 bg-[#5C3B23] text-white px-5 py-2 rounded-full text-sm hover:bg-[#3d2617]">
                        Explore quests
                    </button>
                </div>
            </div>
        </div>

        <!-- ☕ Card 3 -->
            <div
                class="bg-gradient-to-r from-[#E3F2D3] to-[#F7FBEE] rounded-3xl p-8 shadow-md flex items-center justify-between w-[1000px] -ml-[160px] min-h-[300px]">
                <div class="flex-1">
                    <h3 class="text-[#4A6613] italic font-semibold text-[40px]"> Be inspired by ECOnnect</h3>
                    <p class="text-gray-700 mt-2 text-[20px]">See how one café walks its sustainability talk.</p>
                    <div class="flex justify-end">
                        <button class="mt-1 bg-[#5C3B23] text-white px-5 py-2 rounded-full text-sm hover:bg-[#3d2617]">
                            Explore eco-library
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
                <br><br>Simple, interactive, and real — designed <br> to help you live better for the planet.
                <br><br><br><br><br>
            </h2>

            <!-- Step Cards -->
            <h3 class="text-[#4A6613] italic font-semibold text-xl mt-10 mb-8">Choose your first step today</h3>

            <div class="flex flex-col md:flex-row justify-center gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-[#F8F4E7] rounded-2xl shadow-md w-full md:w-1/4 text-left overflow-hidden">
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
                        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (5).png') }}"
                            alt="Bag Icon" class="absolute bottom-4 right-4 w-[40px] opacity-90">
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#F8F4E7] rounded-2xl shadow-md w-full md:w-1/4 text-left overflow-hidden">
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
                        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (5).png') }}"
                            alt="Light Icon" class="absolute bottom-4 right-4 w-[40px] opacity-90">
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#F8F4E7] rounded-2xl shadow-md w-full md:w-1/4 text-left overflow-hidden">
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
                        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (5).png') }}"
                            alt="Paper Icon" class="absolute bottom-4 right-4 w-[40px] opacity-90">
                    </div>
                </div>
            </div>

            <button class="bg-[#7A8C4F] text-white px-6 py-2 rounded-full text-sm hover:bg-[#3d2617]">
                See more eco-actions
            </button>

            <!-- Discount Card -->
            <div class="mt-30 max-w-4xl mx-auto flex justify-center">
                <img src="{{ Vite::asset('resources/images/viewport1/dicountcard.png') }}" alt="Discount Card"
                    class="w-[900px]">
            </div>
        </div>
    </section>

    <section class="relative py-48 px-8 bg-center bg-cover overflow-hidden"
        style="background-image: url('{{ Vite::asset('resources/images/viewport1/cc23b421-0654-477b-86a8-4b6462a55a94.png') }}');">

        <!-- 🌿 Left Leaf Cluster Top (moved lower) -->
        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (15).png') }}"
            class="absolute left-93 bottom-27 w-48 md:w-64 opacity-90 pointer-events-none select-none" alt="Leaf cluster">

        <!-- 🌿 Right Leaf Cluster Top -->
        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (16).png') }}"
            class="absolute right-90 bottom-70 w-52 md:w-72 opacity-90 pointer-events-none select-none"
            alt="Leaf cluster">

        <!-- 🌿 Left Leaf Cluster Bottom -->
        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (18).png') }}"
            class="absolute left-[-100px] top-50 w-56 md:w-72 opacity-90 pointer-events-none select-none"
            alt="Leaf cluster">

        <!-- 🌿 Right Leaf Cluster Bottom -->
        <img src="{{ Vite::asset('resources/images/viewport1/image-removebg-preview (19).png') }}"
            class="absolute right-[-100px] top-50 w-60 md:w-80 opacity-90 pointer-events-none select-none"
            alt="Leaf cluster">

        <div class="relative z-10 max-w-6xl mx-auto text-center">
            <h2 class="text-[#5C3B23] font-semibold text-xl md:text-2xl mb-6">
                Ecobrew leads by example:
            </h2>

            <!-- ♻️ Recycle Image Slider -->
            <div class="relative mx-auto aspect-square w-[260px] md:w-[320px]">
                <img src="{{ Vite::asset('resources/images/viewport1/ecoexample.png') }}" alt="Eco Example">
                <button class="absolute left-[-40px] top-1/2 transform -translate-y-1/2 text-[#4A6613] text-3xl">
                    &#8249;
                </button>
                <button class="absolute right-[-40px] top-1/2 transform -translate-y-1/2 text-[#4A6613] text-3xl">
                    &#8250;
                </button>
            </div>

            <h3 class="text-[#4A6613] italic font-semibold text-2xl md:text-3xl mt-24 mb-12">
                What our community <br> is saying:
            </h3>

            <!-- ⭐ ADD FEEDBACK FORM -->
            @auth
                <form action="{{ route('feedback.store') }}" method="POST"
                    class="bg-[#F8F4E7] rounded-2xl shadow-lg p-8 mb-10 max-w-xl mx-auto text-left">
                    @csrf

                    <h4 class="text-[#4A6613] font-semibold text-xl mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-comment-dots text-[#4A6613]"></i>
                        Share Your Feedback
                    </h4>

                    <textarea name="content" required rows="3"
                        class="w-full p-4 border rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#4A6613]"
                        placeholder="Write your feedback here..."></textarea>

                    <label class="block mt-4 mb-2 font-semibold text-[#4A6613]">Rating:</label>


                    <div class="flex gap-2 mb-4" x-data="{ rating: 0 }">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden"
                                    x-model="rating" required>
                                <i class="fa-solid fa-star text-2xl"
                                    :class="rating >= {{ $i }} ? 'text-yellow-500' : 'text-gray-300'"
                                    @click="rating = {{ $i }}"></i>
                            </label>
                        @endfor
                    </div>


                    <button type="submit" class="bg-[#4A6613] text-white px-6 py-2 rounded-xl hover:bg-[#3a5010] transition">
                        Submit Feedback
                    </button>
                </form>
            @else
                <p class="text-red-600 font-semibold mb-10">You must be logged in to submit feedback.</p>
            @endauth

            <!-- FEEDBACK CARDS -->
            <div class="flex flex-col md:flex-row justify-center gap-6 flex-wrap">

                @foreach ($feedback as $item)
                    <div class="bg-[#F8F4E7] rounded-2xl shadow-md p-6 w-full md:w-1/4 text-left relative">

                        <!-- Quotation Mark -->
                        <i class="fa-solid fa-quote-left text-4xl text-[#4A6613] absolute top-3 left-3 opacity-70"></i>

                        <!-- User Avatar -->
                        <i class="fa-solid fa-user-circle text-4xl text-[#4A6613] absolute top-3 right-3 opacity-70"></i>

                        <!-- User Name -->
                        <p class="font-semibold text-[#4A6613] mt-14">
                            {{ $item->user->first_name ?? 'Anonymous' }} {{ $item->user->last_name ?? '' }}
                        </p>

                        <!-- Feedback Content -->
                        <p class="text-[#4E3A2E] italic mb-2">
                            “{{ $item->content }}”
                        </p>

                        <!-- ⭐ Dynamic Star Rating -->
                        <div class="absolute bottom-3 left-3 flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <i
                                    class="fa-solid fa-star {{ $i <= $item->rating ? 'text-yellow-500' : 'text-gray-300' }} text-xl"></i>
                            @endfor
                        </div>

                        <!-- Decorative icon -->
                        <i
                            class="fa-solid fa-quote-right text-3xl text-[#4A6613] absolute bottom-3 right-5 opacity-60"></i>
                    </div>
                @endforeach

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
                <img src="{{ Vite::asset('resources/images/viewport1/communityicon.png') }}" alt="Community Icons"
                    class="w-48 md:w-60 mx-auto select-none pointer-events-none">
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

    <script>
        window.isGuest = @guest true
        @else
            false
        @endguest ;
        const plantBasePath = "{{ Vite::asset('resources/images/tree') }}";
        // Pass Blade variables to JS
        const stage = {{ $stage }};
        const growthPercent = {{ $growthPercent }};
        document.addEventListener("DOMContentLoaded", () => {
            const fill = document.getElementById("growth-fill");
            const indicator = document.getElementById("growth-indicator");

            fill.style.transition = "width 1s ease-out";

        });
        document.addEventListener('DOMContentLoaded', () => {
            const plantTop = document.getElementById('plant-image');
            const growthFill = document.getElementById('growth-fill');
            const growthLabel = document.getElementById('growth-label');


            let taps = 0;

            plantTop.addEventListener('click', () => {
                taps++;
                plantTop.dataset.taps = taps;

                console.log(`Tree tapped ${taps} times`);

                // Send taps immediately (or you can batch every few taps)
                sendTaps(1);
            });

            function sendTaps(tapCount) {
                fetch("{{ url('/tree/tap') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            taps: tapCount
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);

                        // Show server message if any
                        if (data.message) {
                            showMessage(data.message);
                        }

                        // Update progress bar using progressPoints
                        if (data.progressPoints !== undefined) {

                            growthLabel.textContent =
                                `Stage {{ $stage }} / {{ $treeStages }} — {{ $progressPoints }} / {{ $growthMax }} points`;
                        }

                        // Show message if user has no active quest
                        if (data.has_quest === false) {
                            showMessage(
                                "You don't have an active small quest yet. Complete any pending quest to earn points!"
                            );
                        }
                    })
                    .catch(err => console.error(err));
            }


            function showMessage(msg) {
                const tapMessage = document.getElementById('tap-message');
                tapMessage.textContent = msg;

                // Add class to show message
                tapMessage.classList.remove('opacity-0');
                tapMessage.classList.add('opacity-100');

                // Optional: add slide effect if using transform
                // tapMessage.classList.add('show');
                // tapMessage.classList.remove('hide');

                setTimeout(() => {
                    tapMessage.classList.remove('opacity-100');
                    tapMessage.classList.add('opacity-0');
                    // tapMessage.classList.add('hide');
                    // tapMessage.classList.remove('show');
                }, 3000);
            }
        });
        const plantTop = document.getElementById('plant-image');
        const fallenLeavesContainer = document.getElementById('fallen-leaves');
        const leafImages = [
            "{{ Vite::asset('resources/images/leaves/leaf1.svg') }}",
            "{{ Vite::asset('resources/images/leaves/leaf2.svg') }}",
            "{{ Vite::asset('resources/images/leaves/leaf3.svg') }}"
        ];

        plantTop.addEventListener('click', () => {
            const leaf = document.createElement('img');
            leaf.src = leafImages[Math.floor(Math.random() * leafImages.length)];
            leaf.classList.add('absolute', 'w-6', 'h-6', 'pointer-events-none');

            // Get the bounding rectangle of the tree top
            const treeRect = plantTop.getBoundingClientRect();
            const containerRect = fallenLeavesContainer.getBoundingClientRect();

            // Start X somewhere along the tree's top width
            const startX = treeRect.left - containerRect.left + Math.random() * treeRect.width;
            const startY = treeRect.top - containerRect.top;

            leaf.style.left = `${startX}px`;
            leaf.style.top = `${startY}px`;
            leaf.style.opacity = 1;
            leaf.style.transform = `rotate(${Math.random() * 360}deg)`; // initial rotation

            fallenLeavesContainer.appendChild(leaf);

            // Animate falling straight down
            const fallDistance = containerRect.height - startY; // distance to bottom
            const fallDuration = 3000 + Math.random() * 2000; // 3–5 sec

            leaf.animate([{
                    transform: leaf.style.transform + ' translateY(0px)',
                    opacity: 1
                },
                {
                    transform: leaf.style.transform + ` translateY(${fallDistance}px)`,
                    opacity: 0
                }
            ], {
                duration: fallDuration,
                easing: 'linear', // straight downward fall
                fill: 'forwards'
            });

            setTimeout(() => leaf.remove(), fallDuration);
        });
    </script>
@endsection
