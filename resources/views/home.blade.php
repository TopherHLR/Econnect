@extends('layouts.mainLayout')

@section('content')
    <section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">
        <div class="overlay"></div>
        <!-- Left Branch -->
        <img src="{{ Vite::asset('resources/images/viewport1/branch-leftt.svg') }}" alt="Left branch"
            class="opacity-100 absolute top-[12%] right-0 z-[30] animate-sway-left" style="width: 66vh; left: -6%;" />

        <!-- Right Branch -->
        <img src="{{ Vite::asset('resources/images/viewport1/branch-right_.svg') }}" alt="Right branch"
            class="opacity-100 absolute top-[10%] z-[30] animate-sway-right" style="width: 87vh; right: -4%;" />


        <!-- 🌍 Globe (enlarged) -->
        <img src="{{ Vite::asset('resources/images/viewport1/earth-blue.png') }}" alt="Globe"
            class="absolute top-90 left-1/2 -translate-x-1/2 w-[1500px] z-[4]
                                     max-lg:w-[1100px] max-md:w-[900px] max-md:bottom-[-50px]" />

        <!-- 🌫️ Soft Fog Layer -->
        <div
            class="absolute bottom-0 left-0 w-full h-[200px] bg-gradient-to-t from-[#E0E9D6] via-[#E0E9D6]/80 to-transparent z-[5]">
        </div>


        <!-- 🌏 Centered Text (top-most) -->
        <div
            class="absolute top-[17%] left-1/2 -translate-x-1/2 text-center px-4 z-20 w-full max-w-[90vw] md:max-w-[70vw] lg:max-w-[50vw]">
            <!-- Main Title -->
            <h1
                class="italic text-4xl md:text-8xl font-serif font-semibold text-[#758848] leading-tight drop-shadow-[0_2px_3px_rgba(255,255,255,0.8)]">
                <span class="word-emphasis youre">You're</span>
                <span class="word-emphasis here">here</span>
            </h1>

            <!-- Subtext with word-by-word glow -->
            <div class="subtext-container">
                <p
                    class="italic text-3xl md:text-2xl font-sans-serif font-bold text-[#758848] leading-snug drop-shadow-[0_2px_2px_rgba(255,255,255,0.6)] ">
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
            @if (auth()->user()->user_type === 'verified_user')
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
            @else
                <!-- 🌿 LEFT MODAL PANEL LOCKED -->
                <div
                    class="absolute left-20 top-[20%] w-[420px] h-[300px] bg-white/40 backdrop-blur-md border border-white/30 shadow-xl p-5 rounded-3xl z-10">
                    <div class="flex justify-center items-center h-full">
                        <!-- 🔒 Overlay Lock -->
                        <div
                            class="bg-white/50 backdrop-blur-md border border-white/30 rounded-2xl p-6 shadow-lg flex flex-col items-center text-center w-full">
                            <div class="text-6xl text-green-800 mb-4"><i class="fas fa-lock"></i></div>
                            <h2 class="text-2xl font-semibold text-green-900 mb-2">Access Restricted</h2>
                            <p class="text-green-800 text-sm">
                                Only verified users can access Available Quests. Become a customer and scan your Account QR at
                                your first in-store purchase.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 🌿 RIGHT MODAL PANEL LOCKED -->
                <div
                    class="absolute right-20 top-[20%] w-[420px] h-[300px] bg-white/40 backdrop-blur-md border border-white/30 shadow-xl p-5 rounded-3xl z-10">
                    <div class="flex justify-center items-center h-full">
                        <!-- 🔒 Overlay Lock -->
                        <div
                            class="bg-white/50 backdrop-blur-md border border-white/30 rounded-2xl p-6 shadow-lg flex flex-col items-center text-center w-full">
                            <div class="text-6xl text-green-800 mb-4"><i class="fas fa-lock"></i></div>
                            <h2 class="text-2xl font-semibold text-green-900 mb-2">Access Restricted</h2>
                            <p class="text-green-800 text-sm">
                                Only verified users can access Pending Submissions. Become a customer and scan your Account QR
                                at your first in-store purchase.
                            </p>
                        </div>
                    </div>
                </div>
            @endif


        @endauth



        <div id="plant-container"
            class="relative w-[600px] -top-210 flex items-center justify-center transition-transform duration-[1500ms] ease-out z-20">

            <!-- 🍂 FALLEN LEAVES CONTAINER WITH RADIAL FADE -->
            <!-- 🍂 FALLEN LEAVES CONTAINER WITH MULTI-LAYER FADE -->
            <div id="fallen-leaves" class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-10"
                style="
        mask-image: 
            /* Top soft fade */
            linear-gradient(
                to bottom,
                transparent 0%,
                rgba(0, 0, 0, 0.1) 15%,
                rgba(0, 0, 0, 0.3) 30%,
                rgba(0, 0, 0, 0.6) 45%,
                black 60%,
                black 80%,
                /* Bottom very soft fade */
                rgba(0, 0, 0, 0.7) 85%,
                rgba(0, 0, 0, 0.4) 90%,
                rgba(0, 0, 0, 0.2) 95%,
                transparent 100%
            );
        -webkit-mask-image: 
            linear-gradient(
                to bottom,
                transparent 0%,
                rgba(0, 0, 0, 0.1) 15%,
                rgba(0, 0, 0, 0.3) 30%,
                rgba(0, 0, 0, 0.6) 45%,
                black 60%,
                black 80%,
                rgba(0, 0, 0, 0.7) 85%,
                rgba(0, 0, 0, 0.4) 90%,
                rgba(0, 0, 0, 0.2) 95%,
                transparent 100%
            );
     ">
            </div>
            <!-- Rest of your HTML remains the same... -->

            <div id="plant-text" class="absolute top-[24rem] left-1/2 z-70 -translate-x-1/2 w-max text-center"
                style="text-shadow: 
            0 0 10px rgba(255, 255, 200, 1),
            0 0 20px rgba(255, 255, 200, 0.95),
            0 0 30px rgba(255, 255, 180, 0.85),
            0 0 40px rgba(255, 255, 180, 0.7),
            0 0 50px rgba(255, 255, 180, 0.5);">
                <h1 class="md:text-3xl font-serif font-semibold text-[#7a5d2bff] leading-snug whitespace-nowrap">
                    Even in small ways,
                </h1>
            </div>

            <!-- 🌾 Glow Background -->
            <div class="absolute top-0 flex items-center justify-center">
                <!-- Outer glow -->
                <div
                    class="w-[500px] h-[650px] rounded-full bg-gradient-to-b 
                from-yellow-200/80 via-yellow-100/50 to-transparent 
                blur-3xl scale-125">
                </div>
                <!-- Inner soft white glow -->
                <div class="absolute top-0 w-[300px] h-[400px] rounded-full bg-white/60 blur-2xl"></div>
            </div>

            <!-- 🌟 Hint Message -->
            <!-- 🌟 Hint Message -->
            <div id="tap-message"
                class="absolute left-full ml-3 top-1/2 -translate-y-1/2 
           text-xs italic text-[#6B5840] opacity-0 transition-opacity duration-500
           bg-gradient-to-r from-[#E8E2D5]/90 to-[#D8D1C1]/90
           px-3 py-2 rounded-lg border border-[#B8A992]/30 shadow-md">
            </div>

            @auth
                <!-- Plant Container with Glow Effects -->
                <div class="relative">
                    <!-- Background glow aura -->
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-[#5C7919]/10 via-transparent to-[#9f8f6a]/5 
                    blur-[30px] -z-10 w-[110%] h-[110%] -left-[5%] -top-[5%] 
                    opacity-60 group-hover:opacity-80 transition-opacity duration-500">
                    </div>

                    <!-- Particle effect container -->
                    <div id="plant-particle-container" class="absolute inset-0 z-30 pointer-events-none"></div>

                    <!-- Main plant image -->
                    <img id="plant-image" src="{{ Vite::asset('resources/images/tree/5.gif') }}" alt="Plant"
                        class="z-20 w-full transition-all duration-700 select-none
                    drop-shadow-[0_0_25px_rgba(92,121,25,0.3)]
                    hover:drop-shadow-[0_0_40px_rgba(159,143,106,0.6)]
                    hover:scale-[1.03] 
                    active:scale-[0.98]
                    cursor-pointer
                    transition-all duration-300 ease-out
                    filter brightness-[1.05]
                    hover:brightness-[1.12]
                    relative
                    after:absolute after:inset-0 after:z-10
                    after:bg-gradient-to-b after:from-transparent after:via-transparent after:to-[#5C7919]/5
                    after:rounded-full after:pointer-events-none
                    group">

                    <!-- Interactive tap hint (optional - can be removed) -->
                    <div
                        class="absolute -bottom-6 left-1/2 -translate-x-1/2 z-30
                    text-xs text-[#9f8f6a] font-medium tracking-wide
                    opacity-0 group-hover:opacity-100 transition-opacity duration-300
                    whitespace-nowrap">
                        👆 Tap to grow your tree
                    </div>
                </div>

                <!-- 🌾 Horizontal Progress Bar -->
                <div id="growth-bar"
                    class="absolute opacity-0 flex flex-col items-center gap-2 md:gap-3 z-70 transition-opacity duration-700 ease-out
                w-full px-4 top-90"
                    style="bottom: 50px;">

                    <!-- Enhanced glow container with bright center -->
                    <div class="relative top-0">
                        <!-- Outer beige-yellow glow -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                from-[#f8f5e6]/40 via-[#f5f1dc]/35 to-[#f2ecce]/30 
                blur-[18px] md:blur-[24px] -z-10 w-[130%] -left-[15%]
                opacity-80">
                        </div>


                        <!-- Middle warm white layer (yellow-beige) -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                from-[#fffaf0]/70 via-[#fff8e6]/65 to-[#fff5dd]/60 
                blur-[12px] md:blur-[18px] -z-10 w-[115%] -left-[7.5%]
                opacity-90 mix-blend-overlay">
                        </div>

                        <!-- Warm yellow-beige center core -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                from-[#fffef9] via-[#fffdf5] to-[#fffcf0] 
                blur-[6px] md:blur-[10px] -z-10 w-[105%] -left-[2.5%]
                opacity-70 mix-blend-screen">
                        </div>

                        <!-- Subtle warm shimmer effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                from-transparent via-[#fffef9]/25 to-transparent 
                blur-[3px] -z-10 w-[102%] -left-[1%]
                opacity-100 mix-blend-lighten">
                        </div>

                        <p
                            class="text-[#5C7919] text-base md:text-2xl font-sans-serif italic tracking-wide text-center
               drop-shadow-[0_0_15px_rgba(255,255,255,0.8),
                           0_0_25px_rgba(248,245,230,0.5),
                           0_0_35px_rgba(242,236,206,0.3)]
               relative font-medium">
                            Your personal growth tree
                        </p>
                    </div>

                    <!-- Enhanced Progress Bar with Interactive Features -->
                    <div class="relative group">
                        <!-- Outer glow effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#9f8f6a]/40 via-[#bfae7c]/30 to-[#f2e9c2]/20 
                blur-[10px] -z-10 w-[105%] -left-[2.5%] scale-y-125 
                group-hover:blur-[12px] transition-all duration-300">
                        </div>

                        <!-- Progress bar container -->
                        <div
                            class="relative w-[260px] sm:w-[320px] md:w-[480px] lg:w-[520px]
                h-[14px] md:h-[16px] rounded-full bg-[#d6cbb7]/40 overflow-hidden 
                shadow-inner border border-[#cbbfa8]/40 shadow-lg shadow-[#9f8f6a]/25
                group-hover:shadow-[#9f8f6a]/35 transition-all duration-300">

                            <!-- Interactive progress fill -->
                            <div id="growth-fill"
                                class="absolute left-0 bottom-0 h-full bg-gradient-to-r
                    from-[#9f8f6a] via-[#bfae7c] to-[#f2e9c2]
                    rounded-full transition-all duration-700 ease-out
                    shadow-[0_0_20px_5px_rgba(159,143,106,0.5)]
                    group-hover:shadow-[0_0_25px_8px_rgba(159,143,106,0.6)]
                    before:absolute before:inset-0 
                    before:bg-gradient-to-r before:from-transparent before:via-white/25 before:to-transparent
                    before:translate-x-[-100%] before:animate-shimmer
                    after:absolute after:right-0 after:top-0 after:h-full 
                    after:w-[3px] after:bg-white/70 after:blur-[2px] relative
                    hover:scale-y-110 transition-transform duration-300"
                                style="width: {{ $growthPercent }}%;">

                                <!-- Percentage indicator on hover -->
                                <span
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-white/90 
                          mix-blend-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    {{ $growthPercent }}%
                                </span>
                            </div>

                            <!-- Stage markers with status distinction -->
                            <div class="absolute inset-0 flex justify-between items-center px-2">
                                @php
                                    $stages = $treeStages;
                                    $currentStage = $stage;
                                    $progressPerStage = 100 / $stages;
                                @endphp
                                @for ($i = 1; $i <= $stages; $i++)
                                    @php
                                        $isCurrentStage = $i == $currentStage;
                                        $isUnlocked = $i <= $currentStage;
                                        $isFutureStage = $i > $currentStage;
                                        $positionPercent = ($i - 1) * $progressPerStage;
                                    @endphp

                                    <div class="relative group/marker"
                                        style="left: {{ $positionPercent }}%; transform: translateX(-50%);">

                                        <!-- Dot marker with status styles -->
                                        <div
                                            class="w-[8px] h-[8px] rounded-full transition-all duration-300
                                @if ($isCurrentStage) bg-gradient-to-br from-[#f2e9c2] to-[#9f8f6a]
                                    shadow-[0_0_8px_2px_rgba(159,143,106,0.6)]
                                    ring-2 ring-white/50
                                @elseif($isUnlocked)
                                    bg-gradient-to-br from-[#bfae7c] to-[#9f8f6a]
                                    shadow-[0_0_4px_1px_rgba(159,143,106,0.4)]
                                @else
                                    bg-gradient-to-br from-[#cbbfa8]/40 to-[#9f8f6a]/30
                                    border border-[#cbbfa8]/50 @endif
                                group-hover/marker:scale-150 
                                group-hover/marker:shadow-[0_0_10px_3px_rgba(159,143,106,0.8)]">
                                        </div>

                                        <!-- Stage label -->
                                        <span
                                            class="absolute -top-7 left-1/2 -translate-x-1/2 text-[10px] font-medium
                                 opacity-0 group-hover/marker:opacity-100 
                                 transition-opacity duration-300 whitespace-nowrap
                                 @if ($isCurrentStage) text-[#5C7919] font-bold
                                 @elseif($isUnlocked)
                                    text-[#9f8f6a]
                                 @else
                                    text-[#cbbfa8]/70 @endif">
                                            @if ($isCurrentStage)
                                                ⭐ Stage {{ $i }}
                                            @elseif($isUnlocked)
                                                ✓ Stage {{ $i }}
                                            @else
                                                Stage {{ $i }}
                                            @endif
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced progress label -->
                    @auth
                        @if (auth()->user()->user_type === 'verified_user')
                            <!-- ====================== VERIFIED USER: FULL PROGRESS INFO ====================== -->
                            <p id="growth-label"
                                class="text-[#6b665e] text-xs md:text-sm font-medium tracking-wide text-center
              bg-gradient-to-r from-[#d6cbb7]/30 to-transparent px-4 py-2 rounded-full
              border border-[#cbbfa8]/30 shadow-sm
              group-hover:bg-gradient-to-r group-hover:from-[#d6cbb7]/40 group-hover:to-[#cbbfa8]/20
              group-hover:border-[#cbbfa8]/40 transition-all duration-300">
                                Stage {{ $stage }} / {{ $treeStages }} — {{ $progressPoints }} / {{ $growthMax }}
                                points
                                <span class="block text-[10px] text-[#9f8f6a]/70 font-normal mt-1">
                                    {{ $treeStages - $stage }} stages remaining
                                </span>
                            </p>
                        @else
                            <!-- ====================== AUTHENTICATED BUT NOT VERIFIED: RESTRICTED MESSAGE ====================== -->
                            <p id="growth-label"
                                class="text-[#6b665e] text-xs md:text-sm font-medium tracking-wide text-center
              bg-gradient-to-r from-[#d6cbb7]/30 to-transparent px-4 py-2 rounded-full
              border border-[#cbbfa8]/30 shadow-sm">
                                Please verify your account to grow your tree and earn points
                            </p>
                        @endif
                    @else
                        <!-- ====================== GUEST: LOGIN PROMPT ====================== -->
                        <p id="growth-label"
                            class="text-[#6b665e] text-xs md:text-sm font-medium tracking-wide text-center
          bg-gradient-to-r from-[#d6cbb7]/30 to-transparent px-4 py-2 rounded-full
          border border-[#cbbfa8]/30 shadow-sm">
                            Please log in to see your personalized growth tree
                        </p>
                    @endauth
                </div>

            @endauth


            @guest

                <img id="plant-image" src="{{ Vite::asset('resources/images/tree/5.gif') }}" alt="Plant"
                    class="z-20 w-full transition-all duration-700 select-none drop-shadow-[0_0_25px_rgba(159,143,106,0.4)] 
                hover:drop-shadow-[0_0_35px_rgba(159,143,106,0.6)] hover:scale-[1.02] transition-all duration-300">

                <!-- 🌾 Horizontal Progress Bar -->
                <div id="growth-bar"
                    class="absolute opacity-0 flex flex-col items-center gap-2 md:gap-3 z-70 transition-opacity duration-700 ease-out w-full px-4 top-90"
                    style="bottom: 50px;">

                    <!-- Enhanced glow container with bright center -->
                    <div class="relative top-0">
                        <!-- Outer beige-yellow glow -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                                    from-[#f8f5e6]/40 via-[#f5f1dc]/35 to-[#f2ecce]/30 
                                    blur-[18px] md:blur-[24px] -z-10 w-[130%] -left-[15%]
                                    opacity-80">
                        </div>


                        <!-- Middle warm white layer (yellow-beige) -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                                from-[#fffaf0]/70 via-[#fff8e6]/65 to-[#fff5dd]/60 
                                blur-[12px] md:blur-[18px] -z-10 w-[115%] -left-[7.5%]
                                opacity-90 mix-blend-overlay">
                        </div>

                        <!-- Warm yellow-beige center core -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                                from-[#fffef9] via-[#fffdf5] to-[#fffcf0] 
                                blur-[6px] md:blur-[10px] -z-10 w-[105%] -left-[2.5%]
                                opacity-70 mix-blend-screen">
                        </div>

                        <!-- Subtle warm shimmer effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                                from-transparent via-[#fffef9]/25 to-transparent 
                                blur-[3px] -z-10 w-[102%] -left-[1%]
                                opacity-100 mix-blend-lighten">
                        </div>

                        <p
                            class="text-[#5C7919] text-base md:text-2xl font-sans-serif italic tracking-wide text-center
                                drop-shadow-[0_0_15px_rgba(255,255,255,0.8),
                                            0_0_25px_rgba(248,245,230,0.5),
                                            0_0_35px_rgba(242,236,206,0.3)]
                                relative font-medium">
                            Your personal growth tree
                        </p>
                    </div>

                    <!-- Enhanced Progress Bar with Glow -->
                    <div class="relative">
                        <!-- Outer glow effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#9f8f6a]/40 via-[#bfae7c]/30 to-[#f2e9c2]/20 
                        blur-[10px] -z-10 w-[105%] -left-[2.5%] scale-y-125">
                        </div>

                        <!-- Progress bar container -->
                        <div
                            class="relative w-[260px] sm:w-[320px] md:w-[480px] lg:w-[520px]
                        h-[14px] md:h-[16px] rounded-full bg-[#d6cbb7]/40 overflow-hidden 
                        shadow-inner border border-[#cbbfa8]/40 shadow-lg shadow-[#9f8f6a]/25">

                            <!-- Progress fill with enhanced glow -->
                            <div id="growth-fill"
                                class="absolute left-0 bottom-0 h-full bg-gradient-to-r
                            from-[#9f8f6a] via-[#bfae7c] to-[#f2e9c2]
                            rounded-full transition-all duration-700 ease-out
                            shadow-[0_0_20px_5px_rgba(159,143,106,0.5)]
                            before:absolute before:inset-0 
                            before:bg-gradient-to-r before:from-transparent before:via-white/25 before:to-transparent
                            before:translate-x-[-100%] before:animate-shimmer
                            after:absolute after:right-0 after:top-0 after:h-full 
                            after:w-[3px] after:bg-white/70 after:blur-[2px] relative"
                                style="width: 0%;">
                            </div>

                            <!-- Progress markers (subtle) -->
                            <div class="absolute inset-0 flex justify-between px-1">
                                <div class="w-px h-1/2 bg-[#cbbfa8]/60 self-center mt-1"></div>
                                <div class="w-px h-1/2 bg-[#cbbfa8]/60 self-center mt-1"></div>
                                <div class="w-px h-1/2 bg-[#cbbfa8]/60 self-center mt-1"></div>
                                <div class="w-px h-1/2 bg-[#cbbfa8]/60 self-center mt-1"></div>
                            </div>
                        </div>
                    </div>

                    <p id="growth-label"
                        class="text-[#6b665e] text-xs md:text-sm font-medium tracking-wide text-center
                  bg-gradient-to-r from-[#d6cbb7]/30 to-transparent px-4 py-2 rounded-full
                  border border-[#cbbfa8]/30 shadow-sm">
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
        const stage = {{ $stage }};
        const growthPercent = {{ $growthPercent }};

        document.addEventListener("DOMContentLoaded", () => {
            const fill = document.getElementById("growth-fill");
            const indicator = document.getElementById("growth-indicator");

            // Add pulse animation when progress increases
            if (fill) {
                fill.style.transition = "width 1s cubic-bezier(0.34, 1.56, 0.64, 1)";

                // Add pulse effect on load if there's progress
                if (growthPercent > 0) {
                    setTimeout(() => {
                        fill.classList.add('animate-pulse');
                        setTimeout(() => {
                            fill.classList.remove('animate-pulse');
                        }, 1000);
                    }, 500);
                }
            }

            // Initialize leaf falling system with better physics and adjusted positioning
            initJuicyLeafSystem();
        });

        function initJuicyLeafSystem() {
            const plantTop = document.getElementById('plant-image');
            const fallenLeavesContainer = document.getElementById('fallen-leaves');

            if (!plantTop || !fallenLeavesContainer) {
                console.error('Leaf system: Required elements not found!');
                return;
            }

            const leafImages = [
                "{{ Vite::asset('resources/images/leaves/leaf1.svg') }}",
                "{{ Vite::asset('resources/images/leaves/leaf2.svg') }}",
                "{{ Vite::asset('resources/images/leaves/leaf3.svg') }}"
            ];

            plantTop.addEventListener('click', (e) => {
                createJuicyLeafBurst(e, plantTop, fallenLeavesContainer, leafImages);
            });

            console.log('Juicy leaf system initialized with adjusted positioning!');
        }

        function createJuicyLeafBurst(clickEvent, plantTop, fallenLeavesContainer, leafImages) {
            // Create burst of leaves with physics
            const burstCount = 3 + Math.floor(Math.random() * 4); // 3-6 leaves
            const containerRect = fallenLeavesContainer.getBoundingClientRect();

            // ADJUSTED: Position burst higher and more to the left
            // Use plant position as reference instead of click position
            const plantRect = plantTop.getBoundingClientRect();

            // Calculate burst center - higher and more left
            const burstCenterX = plantRect.left + (plantRect.width * 0.35); // 35% from left (more left)
            const burstCenterY = plantRect.top + (plantRect.height * 0.25); // 25% from top (higher)

            console.log(`Creating juicy leaf burst with ${burstCount} leaves at adjusted position`);

            // Create initial burst particles at adjusted position
            createBurstParticles(burstCenterX, burstCenterY);

            for (let i = 0; i < burstCount; i++) {
                setTimeout(() => {
                    createJuicyLeaf(clickEvent, plantTop, fallenLeavesContainer, leafImages, i, burstCount,
                        burstCenterX, burstCenterY);
                }, i * 80); // Staggered start for more natural burst
            }
        }

        function createBurstParticles(x, y) {
            const container = document.getElementById('fallen-leaves') || document.body;

            // Create burst glow
            const burstGlow = document.createElement('div');
            burstGlow.style.cssText = `
            position: fixed;
            width: 50px;
            height: 50px;
            background: radial-gradient(circle, rgba(159,143,106,0.4) 0%, rgba(159,143,106,0) 70%);
            border-radius: 50%;
            left: ${x - 25}px;
            top: ${y - 25}px;
            pointer-events: none;
            z-index: 45;
            filter: blur(8px);
            opacity: 0;
        `;

            container.appendChild(burstGlow);

            // Animate burst glow
            burstGlow.animate([{
                    transform: 'scale(0.5)',
                    opacity: 0.8
                },
                {
                    transform: 'scale(1.5)',
                    opacity: 0
                }
            ], {
                duration: 400,
                easing: 'ease-out'
            });

            setTimeout(() => burstGlow.remove(), 400);

            // Create mini particles
            for (let i = 0; i < 6; i++) { // Reduced particle count
                setTimeout(() => {
                    const particle = document.createElement('div');
                    particle.style.cssText = `
                    position: fixed;
                    width: ${3 + Math.random() * 4}px;
                    height: ${3 + Math.random() * 4}px;
                    background: linear-gradient(135deg, #f2e9c2, #9f8f6a);
                    border-radius: 50%;
                    left: ${x}px;
                    top: ${y}px;
                    pointer-events: none;
                    z-index: 45;
                    filter: blur(1px);
                    opacity: 0;
                    transform: translate(-50%, -50%);
                `;

                    container.appendChild(particle);

                    const angle = (i * (Math.PI * 2)) / 6;
                    const distance = 20 + Math.random() * 25; // Increased distance

                    particle.animate([{
                            transform: 'translate(-50%, -50%) scale(1)',
                            opacity: 0.8
                        },
                        {
                            transform: `translate(calc(-50% + ${Math.cos(angle) * distance}px), calc(-50% + ${Math.sin(angle) * distance}px)) scale(0)`,
                            opacity: 0
                        }
                    ], {
                        duration: 300 + Math.random() * 200,
                        easing: 'cubic-bezier(0.18, 0.89, 0.32, 1.28)'
                    });

                    setTimeout(() => particle.remove(), 500);
                }, i * 30);
            }
        }

        function createJuicyLeaf(clickEvent, plantTop, fallenLeavesContainer, leafImages, index, total, burstCenterX,
            burstCenterY) {
            const leaf = document.createElement('img');
            leaf.src = leafImages[Math.floor(Math.random() * leafImages.length)];

            // More responsive leaf sizing
            const leafSize = 24 + Math.random() * 12; // 24-36px
            const leafRotation = Math.random() * 720 - 360; // -360 to +360 degrees

            // Juicy leaf styles
            leaf.style.cssText = `
            position: absolute;
            width: ${leafSize}px;
            height: ${leafSize}px;
            pointer-events: none;
            z-index: 40;
            opacity: 0;
            filter: 
                drop-shadow(0 0 6px rgba(159, 143, 106, 0.6))
                drop-shadow(0 0 12px rgba(159, 143, 106, 0.3))
                blur(${0.3 + Math.random() * 0.4}px);
            transform-origin: center;
            mix-blend-mode: multiply;
            will-change: transform, opacity, filter;
            transition: opacity 0.2s ease-out;
        `;

            const containerRect = fallenLeavesContainer.getBoundingClientRect();

            // ADJUSTED: Use the adjusted burst center position
            // Calculate burst position - leaves burst from adjusted center point
            const burstRadius = 30 + Math.random() * 20; // 30-50px radius
            const angle = (index / total) * Math.PI * 2;

            // Add some randomness to the burst pattern
            const randomOffsetX = (Math.random() - 0.5) * 40;
            const randomOffsetY = (Math.random() - 0.5) * 30;

            const burstX = burstCenterX + Math.cos(angle) * burstRadius + randomOffsetX;
            const burstY = burstCenterY + Math.sin(angle) * burstRadius + randomOffsetY;

            // ADJUSTED: Position relative to container
            const startX = burstX - containerRect.left - (leafSize / 2);
            const startY = burstY - containerRect.top - (leafSize / 2);

            leaf.style.left = `${startX}px`;
            leaf.style.top = `${startY}px`;

            fallenLeavesContainer.appendChild(leaf);

            // Fade in quickly
            setTimeout(() => {
                leaf.style.opacity = '0.9';
            }, 10);

            // ADJUSTED: Shorter fall distance since we're starting higher
            const fallDistance = 300 + Math.random() * 200; // Reduced from 400+
            const swayPattern = Math.random() > 0.5 ? 'sine' : 'cosine';
            const swayFrequency = 0.5 + Math.random() * 1.5;
            const swayAmplitude = 40 + Math.random() * 50; // Increased sway for more dramatic effect
            const rotationSpeed = 180 + Math.random() * 360;
            const duration = 2500 + Math.random() * 1500;

            // Create more natural swaying motion
            const keyframes = [];
            const steps = 10;

            for (let i = 0; i <= steps; i++) {
                const progress = i / steps;

                // Sway calculation
                let swayX = 0;
                if (swayPattern === 'sine') {
                    swayX = Math.sin(progress * Math.PI * 2 * swayFrequency) * swayAmplitude;
                } else {
                    swayX = Math.cos(progress * Math.PI * 2 * swayFrequency) * swayAmplitude;
                }

                // ADJUSTED: More parabolic fall with slower start
                const fallY = easeInOutCubic(progress) * fallDistance;

                // Rotation
                const rotation = leafRotation + (progress * rotationSpeed);

                // Opacity fade
                let opacity = 0.9;
                if (progress > 0.6) { // Start fading earlier
                    opacity = 0.9 - ((progress - 0.6) / 0.4) * 0.9;
                }

                // Scale down gradually
                const scale = 1 - (progress * 0.4); // Faster scaling down

                keyframes.push({
                    transform: `translate(${swayX}px, ${fallY}px) rotate(${rotation}deg) scale(${scale})`,
                    opacity: opacity,
                    filter: `drop-shadow(0 0 ${6 - progress * 5}px rgba(159,143,106,${0.6 - progress * 0.5})) blur(${0.3 + progress * 0.7}px)`
                });
            }

            const animation = leaf.animate(keyframes, {
                duration: duration,
                easing: 'cubic-bezier(0.33, 0, 0.67, 1)', // More natural easing
                fill: 'forwards'
            });

            // Create leaf trail particles
            createLeafTrail(startX, startY, leafSize, fallenLeavesContainer, duration);

            // Remove leaf with smooth fade
            animation.onfinish = () => {
                leaf.style.transition = 'opacity 0.5s cubic-bezier(0.33, 0, 0.67, 1)';
                leaf.style.opacity = '0';
                setTimeout(() => {
                    if (leaf.parentNode === fallenLeavesContainer) {
                        fallenLeavesContainer.removeChild(leaf);
                    }
                }, 500);
            };
        }

        // ADJUSTED: Add new easing function for better fall animation
        function easeInOutCubic(t) {
            return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
        }

        function createLeafTrail(x, y, size, container, duration) {
            const trailCount = Math.floor(Math.random() * 2) + 1; // 1-2 trail particles

            for (let i = 0; i < trailCount; i++) {
                setTimeout(() => {
                    const trail = document.createElement('div');
                    const trailSize = 2 + Math.random() * 3;

                    trail.style.cssText = `
                    position: absolute;
                    width: ${trailSize}px;
                    height: ${trailSize}px;
                    background: radial-gradient(circle, #f2e9c2, #9f8f6a);
                    border-radius: 50%;
                    left: ${x + size/2 + (Math.random() * 10 - 5)}px;
                    top: ${y + size/2 + (Math.random() * 10 - 5)}px;
                    opacity: 0;
                    filter: blur(1px);
                    pointer-events: none;
                    z-index: 35;
                `;

                    container.appendChild(trail);

                    const trailDuration = duration * 0.3;
                    const trailDistance = 25 + Math.random() * 35; // Increased trail distance

                    trail.animate([{
                            opacity: 0.4,
                            transform: 'translate(0, 0) scale(1)'
                        },
                        {
                            opacity: 0,
                            transform: `translate(${Math.random() * 20 - 10}px, ${trailDistance}px) scale(0)`
                        }
                    ], {
                        duration: trailDuration,
                        easing: 'ease-out'
                    });

                    setTimeout(() => trail.remove(), trailDuration);
                }, i * 200);
            }
        }

        // REST OF YOUR EXISTING CODE - UPDATED FOR BETTER FEEDBACK
        document.addEventListener('DOMContentLoaded', () => {
            const plantTop = document.getElementById('plant-image');
            const growthFill = document.getElementById('growth-fill');
            const growthLabel = document.getElementById('growth-label');

            let taps = 0;
            let tapCooldown = false;

            // Enhanced click handler with better feedback
            plantTop.addEventListener('click', (e) => {
                if (tapCooldown) return;

                // Cooldown to prevent spam
                tapCooldown = true;
                setTimeout(() => {
                    tapCooldown = false;
                }, 200);

                taps++;
                plantTop.dataset.taps = taps;

                // Enhanced visual feedback
                plantTop.classList.add('active-tap');
                setTimeout(() => {
                    plantTop.classList.remove('active-tap');
                }, 150);

                // Create ripple effect at click position
                createRippleEffect(e.clientX, e.clientY);

                console.log(`Tree tapped ${taps} times - JUICY!`);

                // Send taps immediately
                sendTaps(1);
            });

            function createRippleEffect(x, y) {
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: fixed;
                    width: 40px;
                    height: 40px;
                    border: 2px solid rgba(159, 143, 106, 0.6);
                    border-radius: 50%;
                    left: ${x - 20}px;
                    top: ${y - 20}px;
                    pointer-events: none;
                    z-index: 45;
                    opacity: 0.8;
                `;

                document.body.appendChild(ripple);

                ripple.animate([{
                        transform: 'scale(0.8)',
                        opacity: 0.8,
                        borderWidth: '2px'
                    },
                    {
                        transform: 'scale(2)',
                        opacity: 0,
                        borderWidth: '1px'
                    }
                ], {
                    duration: 500,
                    easing: 'cubic-bezier(0.22, 0.61, 0.36, 1)'
                });

                setTimeout(() => ripple.remove(), 500);
            }

            // Add CSS for active tap effect
            const style = document.createElement('style');
            style.textContent = `
                .active-tap {
                    animation: juicyTap 0.3s cubic-bezier(0.22, 0.61, 0.36, 1) !important;
                    filter: brightness(1.2) !important;
                }
                
                @keyframes juicyTap {
                    0% { transform: scale(1); }
                    50% { transform: scale(0.95); }
                    100% { transform: scale(1); }
                }
            `;
            document.head.appendChild(style);

            // Keep the rest of your functions (sendTaps, showMessage, etc.) unchanged
            // They should work with the enhanced click handler

            // Update the sendTaps function to show messages in the progress label area:
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
                        console.log("Tree tap response:", data);

                        const growthFill = document.getElementById('growth-fill');
                        const growthLabel = document.getElementById('growth-label');
                        const growthBar = document.getElementById('growth-bar');

                        // 1. Update Progress Bar Fill
                        if (data.growthPercent !== undefined && growthFill) {
                            const oldPercent = parseFloat(growthFill.style.width) || 0;
                            const newPercent = parseFloat(data.growthPercentReal);

                            growthFill.style.width = `${newPercent}%`;

                            // Level-up celebration when crossing a stage
                            const segment = 100 / 10; // 10 stages
                            if (Math.floor(oldPercent / segment) < Math.floor(newPercent / segment)) {
                                createLevelUpEffect();
                            }
                        }

                        // 2. Update Growth Label (only for verified users)
                        if (growthLabel && data.stage !== undefined) {
                            // Non-verified users see restricted message (handled in Blade)
                            // But if server says we're good → show full info
                            growthLabel.innerHTML = `
                                Stage ${data.stage} / 10 — ${data.progressPointsReal} / ${data.growthMax} points
                                <span class="block text-[10px] text-[#9f8f6a]/70 font-normal mt-1">
                                    ${data.stages_remaining} stage${data.stages_remaining === 1 ? '' : 's'} remaining
                                </span>
                            `;
                        }

                        // 3. Update Stage Markers (current stage glows)
                        const markerContainer = growthBar?.querySelector('.absolute.inset-0.flex');
                        if (markerContainer && data.stage !== undefined) {
                            const markers = markerContainer.querySelectorAll('.group\\/marker');
                            markers.forEach((markerEl, index) => {
                                const stageNum = index + 1;
                                const dot = markerEl.querySelector('div[class*="w-["]');
                                const label = markerEl.querySelector('span');

                                const isCurrent = stageNum === data.stage;
                                const isPast = stageNum < data.stage;

                                // Update dot
                                if (isCurrent) {
                                    dot.className = dot.className.replace(/bg-gradient-to-br[^ ]*/g,
                                        '') +
                                        ' bg-gradient-to-br from-[#f2e9c2] to-[#9f8f6a] shadow-[0_0_8px_2px_rgba(159,143,106,0.6)] ring-2 ring-white/50';
                                    if (label) label.textContent = 'Stage ' + stageNum;
                                    if (label) label.className = label.className.replace(/text-[^ ]*/g,
                                        'text-[#5C7919] font-bold');
                                } else if (isPast) {
                                    dot.className = dot.className.replace(/bg-gradient-to-br[^ ]*/g,
                                        '') +
                                        ' bg-gradient-to-br from-[#bfae7c] to-[#9f8f6a] shadow-[0_0_4px_1px_rgba(159,143,106,0.4)]';
                                    if (label) label.textContent = 'Stage ' + stageNum;
                                    if (label) label.className = label.className.replace(/text-[^ ]*/g,
                                        'text-[#9f8f6a]');
                                } else {
                                    dot.className = dot.className.replace(/bg-gradient-to-br[^ ]*/g,
                                        '') +
                                        ' bg-gradient-to-br from-[#cbbfa8]/40 to-[#9f8f6a]/30 border border-[#cbbfa8]/50';
                                    if (label) label.textContent = 'Stage ' + stageNum;
                                    if (label) label.className = label.className.replace(/text-[^ ]*/g,
                                        'text-[#cbbfa8]/70');
                                }
                            });
                        }

                        // 4. Quest Progress Message
                        if (data.tap_progress !== undefined) {
                            if (data.quest_completed || data.tap_progress >= 100) {
                                showProgressBarMessage("Quest Already completed! +5 points awarded", "success");
                            } else if (data.has_quest && data.tap_progress > 0) {
                                showProgressBarMessage(`Keep tapping — ${data.tap_progress}/100 taps`, "info");
                            }
                        }

                        // 5. Optional: Show toast message from server
                        if (data.message && !data.message.includes("progress")) {
                            showIntegratedMessage(data.message, growthLabel);
                        }
                    })
                    .catch(err => {
                        console.error("Tap failed:", err);
                        showProgressBarMessage("Connection lost. Try again!", "warning");
                    });
            }


            // New function for integrated messages
            function showProgressBarMessage(msg, type = "info") {
                const growthBar = document.getElementById('growth-bar');
                if (!growthBar) return;

                // Remove any existing message badges
                const existingBadge = growthBar.querySelector('.progress-message-badge');
                if (existingBadge) existingBadge.remove();

                // Create message badge
                const badge = document.createElement('div');
                // Line ~515-525
                badge.className = `progress-message-badge absolute -top-10 left-1/2 -translate-x-1/2 
                   px-3 py-2 rounded-lg shadow-lg text-xs font-medium whitespace-nowrap
                   z-50 animate-bounce pointer-events-none
                   ${type === 'warning' ? 
                     'bg-gradient-to-r from-[#8B7355]/90 to-[#6B5840]/90 text-[#F5F1E6]' : 
                     'bg-gradient-to-r from-[#7A6B5A]/90 to-[#5C4E3F]/90 text-[#F5F1E6]'}`;

                badge.innerHTML = `
                    ${msg}
                    <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 
                                border-[6px] border-transparent border-t-${type === 'warning' ? '[#8B7355]/90' : '[#7A6B5A]/90'}"></div>
                `;

                growthBar.appendChild(badge);

                // Auto-remove after 3 seconds
                setTimeout(() => {
                    badge.style.transition = 'all 0.5s ease-out';
                    badge.style.opacity = '0';
                    badge.style.transform = 'translateX(-50%) translateY(-10px)';
                    setTimeout(() => badge.remove(), 500);
                }, 3000);
            }

            function showIntegratedMessage(msg, targetElement) {
                if (!targetElement) return;

                // Save original content
                const originalContent = targetElement.innerHTML;
                const originalClasses = targetElement.className;

                // Update with message
                targetElement.innerHTML = `
                <div class="flex items-center gap-2 animate-pulse">
                    <span class="text-sm font-medium">${msg}</span>
                </div>
            `;

                // Add visual styling

                targetElement.className = originalClasses +
                    ' bg-gradient-to-r from-[#E8E2D5]/80 to-[#D8D1C1]/80 ' +
                    'border border-[#B8A992]/50 shadow-sm text-[#5C4E3F]';

                // Restore after 3 seconds
                setTimeout(() => {
                    targetElement.innerHTML = originalContent;
                    targetElement.className = originalClasses;
                }, 3000);
            }

            function createLevelUpEffect() {
                // Create level up particles
                for (let i = 0; i < 15; i++) {
                    setTimeout(() => {
                        const particle = document.createElement('div');
                        particle.className =
                            'absolute w-3 h-3 bg-gradient-to-br from-[#5C7919] to-[#9f8f6a] rounded-full pointer-events-none z-50';

                        const bar = document.querySelector('#growth-bar');
                        if (!bar) return;

                        const rect = bar.getBoundingClientRect();
                        const x = rect.left + Math.random() * rect.width;
                        const y = rect.top;

                        particle.style.left = `${x}px`;
                        particle.style.top = `${y}px`;

                        document.body.appendChild(particle);

                        particle.animate([{
                                transform: 'translateY(0) scale(1)',
                                opacity: 1
                            },
                            {
                                transform: `translateY(-${100 + Math.random() * 100}px) scale(0)`,
                                opacity: 0
                            }
                        ], {
                            duration: 1000 + Math.random() * 500,
                            easing: 'cubic-bezier(0.22, 0.61, 0.36, 1)'
                        });

                        setTimeout(() => particle.remove(), 1500);
                    }, i * 50);
                }
            }

            function showMessage(msg) {
                const tapMessage = document.getElementById('tap-message');
                if (!tapMessage) return;

                tapMessage.textContent = msg;
                tapMessage.classList.remove('opacity-0', 'translate-y-2');
                tapMessage.classList.add('opacity-100', 'translate-y-0');

                setTimeout(() => {
                    tapMessage.classList.remove('opacity-100', 'translate-y-0');
                    tapMessage.classList.add('opacity-0', 'translate-y-2');
                }, 3000);
            }
        });
    </script>
@endsection
