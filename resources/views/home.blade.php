@extends('layouts.mainLayout')
@section('title', 'Home')
@section('content')
    <!-- ⭐ Rating Required Toast -->
    <div id="rating-toast"
        class="fixed top-6 left-1/2 hidden -translate-x-1/2 bg-[#fff5f5]/90 border border-[#d9534f]/40 text-[#d9534f] font-serif italic text-lg shadow-md px-6 py-3 rounded-2xl z-[9999] transition-opacity duration-1000 ease-in-out opacity-100 flex items-center gap-2">
        <!-- Error Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span>Please select a star rating before submitting.</span>
    </div>
    <section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">
        <div class="overlay"></div>
        <!-- In your layout file or body tag -->

        <body class="overflow-x-hidden">
            <!-- Your entire page content -->

            <!-- Branches without wrapper -->
            <img src="{{ Vite::asset('resources/images/viewport1/branch-leftt.svg') }}" alt="Left branch"
                class="opacity-100 absolute z-[10] animate-sway-left
               w-[36vh] top-[2%] left-[-43%]
               md:w-[60vh] md:top-[25%] md:left-[-10%]
               lg:w-[80vh] lg:top-[10%] lg:left-[-12%]" />

            <img src="{{ Vite::asset('resources/images/viewport1/branch-right_.svg') }}" alt="Right branch"
                class="opacity-100 absolute z-[10] animate-sway-right
               w-[45vh] top-[0%] right-[-30%]
               md:w-[70vh] md:top-[20%] md:right-[-10%]
               lg:w-[98vh] lg:top-[8%] lg:right-[-10%]" />
        </body>
        <!-- 🌍 Globe (Mobile Optimized) -->
        <img src="{{ Vite::asset('resources/images/viewport1/store2.webp') }}" alt="Globe"
            class="absolute left-1/2 -translate-x-1/2 z-[4] opacity-100
               /* Mobile (default) - positioned in lower half */
               w-[900px] top-[55%]
               /* Small mobile */
               xs:w-[350px]
               /* Tablet */
               md:w-[700px] md:top-[40%]
               /* Desktop */
               lg:w-[1100px] lg:top-90" />

        <!-- 🌫️ Soft Fog Layer - Mobile Optimized -->
        <div
            class="absolute bottom-0 left-0 w-full z-[5]
                /* Mobile - full width but properly cropped */
                h-[100px]
                /* Desktop */
                md:h-[150px]
                bg-gradient-to-t from-[#E0E9D6] via-[#E0E9D6]/80 to-transparent">
        </div>

        <!-- 🌏 Centered Text - Mobile Optimized -->
        <div
            class="absolute left-1/2 -translate-x-1/2 text-center px-4 z-20 w-full
                /* Mobile - upper half positioning */
                top-[18%] max-w-[95vw]
                /* Tablet */
                md:top-[17%] md:max-w-[85vw]
                /* Desktop */
                lg:top-[17%] lg:max-w-[70vw]">

            <!-- Main Title - Mobile Optimized -->
            <!-- 🌏 Centered Text with Position Controllers -->
            <div
                class="absolute left-1/2 -translate-x-1/2 text-center px-4 z-20 w-full
            /* Mobile positioning controller */
            top-[8%]
            /* Small phones adjustment */
            xs:top-[14%]
            /* Tablet positioning */
            md:top-[16%]
            /* Desktop positioning */
            lg:top-[17%]
            /* Width controllers */
            max-w-[95vw]
            md:max-w-[85vw]
            lg:max-w-[70vw]">

                <!-- Main Title with Vertical Spacing Controller -->
                <h1
                    class="italic font-serif font-bold text-[#758848] leading-tight 
               drop-shadow-[0_2px_3px_rgba(255,255,255,0.8)]
               /* Mobile font sizing */
               text-2xl
               /* Small mobile */
               xs:text-3xl
               /* Tablet */
               md:text-4xl
               /* Desktop */
               lg:text-6xl xl:text-8xl
               /* Vertical spacing controller */
               mb-3
               xs:mb-4
               md:mb-5
               lg:mb-6">
                    <span class="word-emphasis youre">A cafe</span>
                    <span class="word-emphasis here">on a mission</span>
                </h1>

                <!-- Subtext Container with Position Adjuster -->
                <div
                    class="subtext-container
                /* Mobile vertical spacing */
                mt-3
                xs:mt-4
                md:mt-5
                lg:mt-6
                /* Position from bottom adjuster */
                pb-2
                md:pb-4
                lg:pb-6">
                    <p
                        class="italic font-sans-serif font-bold text-[#758848] leading-snug
                  drop-shadow-[0_2px_2px_rgba(255,255,255,0.6)]
                  /* Mobile font sizing */
                  text-sm
                  xs:text-base
                  md:text-lg
                  lg:text-xl xl:text-2xl
                  /* Line spacing controller */
                  leading-relaxed
                  md:leading-snug
                  /* Max width for better mobile readability */
                  max-w-[90vw] mx-auto
                  md:max-w-none">
                        <span class="glow-word word-1">we</span>
                        <span class="glow-word word-2">donate</span>
                        <span class="glow-word word-3">5%,</span>
                        <span class="glow-word word-4">of</span>
                        <span class="glow-word word-5">our</span>
                        <span class="glow-word word-6">revenue</span>
                        <span class="glow-word word-7">to</span>
                        <span class="glow-word word-8">environmental</span>
                        <span class="glow-word word-9">causes.</span>
                    </p>
                </div>
            </div>
    </section>
    <!-- Spacer for mobile (adjusts based on content) -->
    <div class="mt-6 md:mt-8 lg:mt-12"></div>
    <!-- 🌿 Widgets for ALL Users (Guests see different content) -->
    @include('modal.userQuestModal')
    @include('modal.ecoDetailModal')

    <div class="eco-widgets-container">
        @auth
            <!-- Logged-in users see personalized widgets -->
            <!-- 🌱 Saved Eco-Actions Widget -->
            <div class="eco-widget eco-actions mr-7"
                style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
                <button class="eco-widget-btn">My Eco-actions</button>
                <p id="eco-action-text" class="eco-widget-text">Loading...</p>
                <a href="/lifestyle?tab=actions" class="eco-widget-link">
                    View saved &gt;
                </a>
            </div>

            <!-- 🌎 Saved Eco-Topics Widget -->
            <div class="eco-widget eco-topics"
                style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
                <button class="eco-widget-btn">Saved Topics</button>
                <p id="eco-topic-text" class="eco-widget-text">Loading...</p>
                <a href="javascript:void(0);" id="ecoTopicLink" class="eco-widget-link">
                    Continue &gt;
                </a>
            </div>
        @else
            <!-- Guests see engagement widgets -->
            <!-- 🌱 Join Community Widget -->
            <div x-data class="eco-widget eco-join mr-7"
                style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
                <button @click="$store.authModal.open = true; $store.authModal.mode = 'signup'" class="eco-widget-btn">Join Our
                    Community</button>
                <p class="eco-widget-text">"Start your sustainable journey with us"</p>
                <button @click="$store.authModal.open = true; $store.authModal.mode = 'signin'" class="eco-widget-link">
                    Login Now &gt;
                </button>
            </div>

            <!-- 🌎 Explore Features Widget -->
            <div class="eco-widget eco-explore"
                style="background-image: url('{{ Vite::asset('resources/images/viewport1/widgetcloudb.png') }}');">
                <button class="eco-widget-btn" onclick="window.location.href='/lifestyle'">Learn Sustainable Lifestyle</button>
                <p class="eco-widget-text">"Eco-topics and actions that you can apply anytime"</p>
                <a href="/quests" class="eco-widget-link">
                    Browse quests &gt;
                </a>
            </div>
        @endauth
    </div>

    @auth
        {{-- 🔄 Auto-refresh widget texts only for logged-in users --}}
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
    <section
        style="position: relative; top: -75px; min-height: 110vh; display: flex; align-items: center; justify-content: center;"
        class="viewport2BG">

        @auth
            @if (auth()->user()->user_type === 'verified_user')
                <!-- 🌿 LEFT MODAL PANEL -->
                <div id="left-panel"
                    class="fade-in-panel hidden lg:block left-1/2 -translate-x-1/2 lg:left-[5rem] lg:translate-x-0"
                    style="position: absolute; top: 25%; width: 420px; height: 360px; background: rgba(255, 255, 255, 0.97); backdrop-filter: blur(10px); border: 1.5px solid rgba(224, 233, 214, 0.6); box-shadow: 0 12px 48px rgba(122, 140, 79, 0.18); padding: 1.75rem; border-radius: 1.5rem; z-index: 10;">
                    <!-- Title + View More Link -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                        <h2
                            style="font-size: 1.5rem; font-weight: 700; color: #4F6B3F; font-family: 'Nunito Sans', sans-serif;">
                            Available Quests</h2>

                        @if ($availableQuests->count() > 0)
                            <a href="/quests"
                                style="font-size: 0.875rem; color: #7A8C4F; text-decoration: none; transition: color 0.3s; display: flex; align-items: center; gap: 0.25rem; font-weight: 500;">
                                View More <i class="fas fa-arrow-right" style="font-size: 0.75rem; margin-top: 0.125rem;"></i>
                            </a>
                        @endif
                    </div>

                    @if ($availableQuests->isEmpty())
                        <div
                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 14rem; text-align: center;">
                            <div style="font-size: 2.5rem; color: rgba(122, 140, 79, 0.3); margin-bottom: 0.75rem;">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <p style="color: rgba(90, 74, 54, 0.7); font-size: 0.875rem; font-style: italic;">No available
                                quests at the moment 🌱</p>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 1rem; max-height: 240px; overflow-y: auto;">
                            @foreach ($availableQuests->take(2) as $quest)
                                <div style="position: relative; display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; border-radius: 1rem; cursor: pointer; transition: all 0.3s ease-out; background: rgba(255, 255, 255, 0.9); border: 1.5px solid rgba(224, 233, 214, 0.5); box-shadow: 0 2px 8px rgba(122, 140, 79, 0.04), 0 1px 3px rgba(195, 122, 73, 0.02); transform: translateY(0);"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 16px rgba(122, 140, 79, 0.08), 0 2px 6px rgba(195, 122, 73, 0.04)'; this.style.borderColor='rgba(122, 140, 79, 0.3)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(122, 140, 79, 0.04), 0 1px 3px rgba(195, 122, 73, 0.02)'; this.style.borderColor='rgba(224, 233, 214, 0.5)';">
                                    <div style="margin-top: 0.25rem; color: #7A8C4F;">
                                        <i class="fas fa-tasks" style="font-size: 1.125rem;"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <h3
                                            style="font-weight: 600; color: #4F6B3F; font-size: 1rem; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $quest->title }}</h3>
                                        <p
                                            style="font-size: 0.75rem; color: rgba(90, 74, 54, 0.8); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0.5rem;">
                                            {{ $quest->description }}</p>

                                        <div
                                            style="display: flex; align-items: center; justify-content: space-between; margin-top: 0.75rem;">
                                            <div style="display: flex; align-items: center; gap: 1rem;">
                                                <span
                                                    style="font-size: 0.75rem; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(122, 140, 79, 0.1); color: #4F6B3F;">
                                                    <i class="fas fa-star"
                                                        style="font-size: 0.75rem; margin-right: 0.25rem;"></i>
                                                    {{ $quest->points_reward }} pts
                                                </span>
                                                <span style="font-size: 0.75rem; color: rgba(90, 74, 54, 0.6);">
                                                    <i class="far fa-calendar" style="margin-right: 0.25rem;"></i>
                                                    {{ \Carbon\Carbon::parse($quest->end_date)->format('M d') }}
                                                </span>
                                            </div>
                                            <span
                                                onclick="openActiveQuestModal({
                                            id: {{ $quest->quest_id }},
                                            title: '{{ addslashes($quest->title) }}',
                                            description: '{{ addslashes($quest->description) }}',
                                            category: '{{ $quest->category }}',
                                            points_reward: {{ $quest->points_reward }},
                                            status: '{{ $quest->status }}',
                                            start_date: '{{ $quest->start_date }}',
                                            end_date: '{{ $quest->end_date }}'
                                        })"
                                                style="display: inline-flex; align-items: center; gap: 0.25rem; font-weight: 500; font-size: 0.75rem; padding: 0.375rem 0.75rem; border-radius: 9999px; cursor: pointer; transition: all 0.3s ease-out; background: rgba(224, 229, 216, 0.95); color: #4F3B2C; box-shadow: inset 2px 2px 4px rgba(140, 160, 130, 0.25), inset -2px -2px 4px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(140, 160, 130, 0.12);"
                                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='-2px -2px 4px rgba(255, 255, 255, 0.65), 2px 2px 4px rgba(160, 180, 150, 0.25)'; this.style.filter='brightness(1.03)';"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='inset 2px 2px 4px rgba(140, 160, 130, 0.25), inset -2px -2px 4px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(140, 160, 130, 0.12)'; this.style.filter='brightness(1)';">
                                                View Quest <i class="fas fa-arrow-right"
                                                    style="font-size: 0.75rem; margin-left: 0.25rem;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <!-- 🌿 RIGHT MODAL PANEL -->
                <div id="right-panel"
                    class="fade-in-panel hidden lg:block left-1/2 -translate-x-1/2 lg:right-[5rem] lg:left-auto lg:translate-x-0"
                    style="position: absolute; top: 25%; width: 420px; height: 360px; background: rgba(255, 255, 255, 0.97); backdrop-filter: blur(10px); border: 1.5px solid rgba(240, 230, 222, 0.6); box-shadow: 0 12px 48px rgba(195, 122, 73, 0.18); padding: 1.75rem; border-radius: 1.5rem; z-index: 10;">
                    <!-- Title + View More Link -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                        <h2
                            style="font-size: 1.5rem; font-weight: 700; color: #8B5A3C; font-family: 'Nunito Sans', sans-serif;">
                            Pending Submissions</h2>

                        @if ($pendingSubmissions->count() > 0)
                            <a href="/quests"
                                style="font-size: 0.875rem; color: #C37A49; text-decoration: none; transition: color 0.3s; display: flex; align-items: center; gap: 0.25rem; font-weight: 500;">
                                View More <i class="fas fa-arrow-right" style="font-size: 0.75rem; margin-top: 0.125rem;"></i>
                            </a>
                        @endif
                    </div>

                    @if ($pendingSubmissions->isEmpty())
                        <div
                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 14rem; text-align: center;">
                            <div style="font-size: 2.5rem; color: rgba(195, 122, 73, 0.3); margin-bottom: 0.75rem;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <p style="color: rgba(90, 74, 54, 0.7); font-size: 0.875rem; font-style: italic;">No pending tasks
                                ✨
                            </p>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 1rem; max-height: 240px; overflow-y: auto;">
                            @foreach ($pendingSubmissions->take(2) as $sub)
                                <div style="position: relative; display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; border-radius: 1rem; cursor: pointer; transition: all 0.3s ease-out; background: rgba(255, 255, 255, 0.9); border: 1.5px solid rgba(240, 230, 222, 0.5); box-shadow: 0 2px 8px rgba(195, 122, 73, 0.04), 0 1px 3px rgba(122, 140, 79, 0.02); transform: translateY(0);"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 16px rgba(195, 122, 73, 0.08), 0 2px 6px rgba(122, 140, 79, 0.04)'; this.style.borderColor='rgba(195, 122, 73, 0.3)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(195, 122, 73, 0.04), 0 1px 3px rgba(122, 140, 79, 0.02)'; this.style.borderColor='rgba(240, 230, 222, 0.5)';">
                                    <div style="margin-top: 0.25rem; color: #C37A49;">
                                        <i class="fas fa-hourglass-half" style="font-size: 1.125rem;"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <h3
                                            style="font-weight: 600; color: #8B5A3C; font-size: 1rem; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $sub->quest->title }}</h3>
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                            <span
                                                style="font-size: 0.75rem; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(195, 122, 73, 0.1); color: #8B5A3C;">
                                                <i class="fas fa-clock"
                                                    style="font-size: 0.75rem; margin-right: 0.25rem;"></i>
                                                {{ ucfirst($sub->status) }}
                                            </span>
                                            @if ($sub->submitted_at)
                                                <span style="font-size: 0.75rem; color: rgba(90, 74, 54, 0.6);">
                                                    <i class="far fa-calendar-check" style="margin-right: 0.25rem;"></i>
                                                    {{ \Carbon\Carbon::parse($sub->submitted_at)->format('M d') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div
                                            style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.75rem;">
                                            <span style="font-size: 0.75rem; color: rgba(90, 74, 54, 0.7);">
                                                <i class="fas fa-exclamation-circle"
                                                    style="color: #C37A49; margin-right: 0.25rem;"></i> Awaiting review
                                            </span>
                                            @php
                                                $submissionData = [
                                                    'submission_id' => $sub->submission_id,
                                                    'questTitle' => $sub->quest->title,
                                                    'questDescription' => $sub->quest->description,
                                                ];
                                            @endphp
                                            <span onclick='openAcceptedQuestModal(@json($submissionData))'
                                                style="display: inline-flex; align-items: center; gap: 0.25rem; font-weight: 500; font-size: 0.75rem; padding: 0.375rem 0.75rem; border-radius: 9999px; cursor: pointer; transition: all 0.3s ease-out; background: rgba(224, 229, 216, 0.95); color: #4F6B3F; box-shadow: inset 2px 2px 4px rgba(140, 160, 130, 0.25), inset -2px -2px 4px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(140, 160, 130, 0.12);"
                                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='-2px -2px 4px rgba(255, 255, 255, 0.65), 2px 2px 4px rgba(160, 180, 150, 0.25)'; this.style.filter='brightness(1.03)';"
                                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='inset 2px 2px 4px rgba(140, 160, 130, 0.25), inset -2px -2px 4px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(140, 160, 130, 0.12)'; this.style.filter='brightness(1)';">
                                                Continue <i class="fas fa-external-link-alt"
                                                    style="font-size: 0.75rem; margin-left: 0.25rem;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <!-- 🌿 LEFT MODAL PANEL LOCKED -->
                <div id="left-panel"
                    class="fade-in-panel hidden lg:block left-1/2 -translate-x-1/2 lg:left-[5rem] lg:translate-x-0"
                    style="position: absolute; top: 25%; width: 420px; height: 360px; 360px; background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(240,245,235,0.3) 100%); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 24px 72px rgba(122,140,79,0.22); padding: 1.5rem; border-radius: 1.5rem; z-index: 10;">
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                        <!-- 🔒 Overlay Lock -->
                        <div
                            style="background: linear-gradient(135deg, rgba(255,255,255,0.7) 0%, rgba(248,250,237,0.5) 100%); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.4); border-radius: 1rem; padding: 2rem; box-shadow: 0 12px 40px rgba(122,140,79,0.2); display: flex; flex-direction: column; align-items: center; text-align: center; width: 100%;">
                            <div
                                style="font-size: 3rem; color: #7A8C4F; margin-bottom: 1rem; text-shadow: 0 4px 8px rgba(122,140,79,0.2);">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h2
                                style="font-size: 1.25rem; font-weight: 700; color: #4F6B3F; margin-bottom: 0.75rem; font-family: 'Nunito Sans', sans-serif;">
                                Access Restricted</h2>
                            <p
                                style="color: #5A4A36; font-size: 0.875rem; line-height: 1.5; max-width: 20rem; margin-bottom: 1.25rem;">
                                Only verified users can access Available Quests. Become a customer and scan your Account QR at
                                your first in-store purchase.
                            </p>
                            <div style="margin-top: 1.25rem;">
                                <a href="/about"
                                    style="position: relative; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; font-weight: 600; cursor: pointer; border-radius: 9999px; user-select: none; transition: all 0.3s ease-out; padding: 0.5rem 1rem; font-size: 0.875rem; min-width: 10rem; text-align: center; background: rgba(122, 140, 79, 0.92); color: white; box-shadow: inset 2px 2px 4px rgba(70, 85, 45, 0.35), inset -2px -2px 4px rgba(200, 220, 170, 0.4), 0 2px 6px rgba(122, 140, 79, 0.25);"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(140, 160, 130, 0.12), -2px -2px 4px rgba(255, 255, 255, 0.7), 2px 2px 4px rgba(160, 180, 150, 0.25)'; this.style.filter='brightness(1.03)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='inset 2px 2px 4px rgba(70, 85, 45, 0.35), inset -2px -2px 4px rgba(200, 220, 170, 0.4), 0 2px 6px rgba(122, 140, 79, 0.25)'; this.style.filter='brightness(1)';">
                                    <i class="fas fa-store" style="transition: transform 0.3s ease-out;"></i> Visit Store
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🌿 RIGHT MODAL PANEL LOCKED -->
                <div id="right-panel"
                    class="fade-in-panel hidden lg:block left-1/2 -translate-x-1/2 lg:right-[5rem] lg:left-auto lg:translate-x-0"
                    style="position: absolute; top: 25%; width: 420px; height: 360px; background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(250,248,242,0.3) 100%); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 24px 72px rgba(195,122,73,0.22); padding: 1.5rem; border-radius: 1.5rem; z-index: 10;">
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                        <!-- 🔒 Overlay Lock -->
                        <div
                            style="background: linear-gradient(135deg, rgba(255,255,255,0.7) 0%, rgba(250,248,242,0.5) 100%); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.4); border-radius: 1rem; padding: 2rem; box-shadow: 0 12px 40px rgba(195,122,73,0.2); display: flex; flex-direction: column; align-items: center; text-align: center; width: 100%;">
                            <div
                                style="font-size: 3rem; color: #C37A49; margin-bottom: 1rem; text-shadow: 0 4px 8px rgba(195,122,73,0.2);">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h2
                                style="font-size: 1.25rem; font-weight: 700; color: #8B5A3C; margin-bottom: 0.75rem; font-family: 'Nunito Sans', sans-serif;">
                                Access Restricted</h2>
                            <p
                                style="color: #5A4A36; font-size: 0.875rem; line-height: 1.5; max-width: 20rem; margin-bottom: 1.25rem;">
                                Only verified users can access Pending Submissions. Become a customer and scan your Account QR
                                at your first in-store purchase.
                            </p>
                            <div style="margin-top: 1.25rem;">
                                <a href="/account"
                                    style="position: relative; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; font-weight: 600; cursor: pointer; border-radius: 9999px; user-select: none; transition: all 0.3s ease-out; padding: 0.5rem 1rem; font-size: 0.875rem; min-width: 10rem; text-align: center; background: rgba(195, 122, 73, 0.92); color: white; box-shadow: inset 2px 2px 4px rgba(120, 80, 50, 0.3), inset -2px -2px 4px rgba(255, 200, 170, 0.5), 0 2px 6px rgba(195, 122, 73, 0.2);"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(140, 160, 130, 0.12), -2px -2px 4px rgba(255, 255, 255, 0.7), 2px 2px 4px rgba(160, 180, 150, 0.25)'; this.style.filter='brightness(1.03)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='inset 2px 2px 4px rgba(120, 80, 50, 0.3), inset -2px -2px 4px rgba(255, 200, 170, 0.5), 0 2px 6px rgba(195, 122, 73, 0.2)'; this.style.filter='brightness(1)';">
                                    <i class="fas fa-qrcode" style="transition: transform 0.3s ease-out;"></i> Scan QR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        <div id="plant-container"
            class="relative w-[600px] -top-170 flex items-center justify-center transition-transform duration-[1500ms] ease-out z-20">
            @auth
                <div id="mobile-button-wrapper"
                    class="lg:hidden fixed top-4 left-1/2 -translate-x-1/2 
                  flex items-center justify-center gap-6 z-[999]">
                    <!-- Left Arrow -->
                    <button id="mobile-switch-left"
                        class="w-10 h-10 flex hidden items-center justify-center
                        rounded-full bg-[#F7F6EB]/80 backdrop-blur-md
                        shadow-[0_4px_12px_rgba(0,0,0,0.15)]
                        border border-[#e6e4cf]
                        text-[#4B4A2E]
                        hover:bg-[#FFFDF4] active:scale-95 transition-all duration-300">
                        <!-- SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                            <path fill="currentColor" d="M15.5 19 8.5 12l7-7" />
                        </svg>
                    </button>

                    <!-- Center main toggle button -->
                    <button id="mobile-panels-toggle" class="btn-eco">
                        Show Available Quests
                    </button>

                    <!-- Right Arrow -->
                    <button id="mobile-switch-right"
                        class="w-10 h-10  hidden flex items-center justify-center
                    rounded-full bg-[#F7F6EB]/80 backdrop-blur-md
                    shadow-[0_4px_12px_rgba(0,0,0,0.15)]
                    border border-[#e6e4cf]
                    text-[#4B4A2E]
                    hover:bg-[#FFFDF4] active:scale-95 transition-all duration-300">
                        <!-- SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                            <path fill="currentColor" d="m8.5 19 7-7-7-7" />
                        </svg>
                    </button>
                </div>
            @endauth

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

            <div id="plant-text" class="absolute top-[15rem] left-1/2 z-70 -translate-x-1/2 w-max text-center"
                style="text-shadow: 
                    0 0 10px rgba(255, 255, 200, 1),
                    0 0 20px rgba(255, 255, 200, 0.95),
                    0 0 30px rgba(255, 255, 180, 0.85),
                    0 0 40px rgba(255, 255, 180, 0.7),
                    0 0 50px rgba(255, 255, 180, 0.5);">
                <h1 class="md:text-3xl font-serif font-semibold text-[#5e471dff] leading-snug whitespace-nowrap">
                </h1>
            </div>


            <style>
                .animate-float

                /* Glow activation styles */
                .glow-active .w-\[500px\].h-\[650px\] {
                    background-image: linear-gradient(to bottom,
                            rgb(254 240 138 / 0.3) 0%,
                            rgb(254 249 195 / 0.2) 50%,
                            transparent 100%) !important;
                    transition: background-image 1s ease-out;
                }

                .glow-active .absolute.top-0.w-\[300px\].h-\[400px\] {
                    background-color: rgb(255 255 255 / 0.4) !important;
                    transition: background-color 1s ease-out;
                }
            </style>

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
                    <div id="plant-particle-container" class="absolute inset-0 z-20 pointer-events-none"></div>


                    <img id="plant-image">

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
                w-full px-4 top-105"
                    style="bottom: 50px;">

                    <!-- Enhanced glow container with bright center -->
                    <div class="relative top-0">
                        <!-- Outer golden glow -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-[#fffacd]/60 via-[#fff8b0]/80 to-[#fff695]/80 
                            blur-[10px] md:blur-[15px] -z-10 w-[130%] -left-[15%]
                            opacity-80">
                        </div>

                        <!-- Middle bright yellow layer -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-[#fffee0]/70 via-[#fffdc2]/65 to-[#fffb9d]/60 
                            blur-[6px] md:blur-[10px] -z-10 w-[115%] -left-[7.5%]
                            opacity-90 mix-blend-overlay">
                        </div>

                        <!-- Center intense yellow core -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-[#ffffe0] via-[#ffffb5] to-[#ffff8f] 
                            blur-[3px] md:blur-[5px] -z-10 w-[105%] -left-[2.5%]
                            opacity-70 mix-blend-screen">
                        </div>

                        <!-- Subtle yellow shimmer effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-transparent via-[#ffffd0]/30 to-transparent 
                            blur-[2px] -z-10 w-[102%] -left-[1%]
                            opacity-100 mix-blend-lighten">
                        </div>
                        <p
                            class="text-[#553722ff] text-base md:text-3xl font-serif italic tracking-wide text-center relative font-medium">
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
                    before:bg-gradient-to-r before:from-transparent before:via-white/60 before:to-transparent
                    before:translate-x-[-100%] before:animate-shimmer
                    after:absolute after:right-0 after:top-0 after:h-full 
                    after:w-[3px] after:bg-white/90 after:blur-[2px] relative
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
                                    bg-gradient-to-br from-[#cbbfa8]/80 to-[#9f8f6a]/30
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

                    @auth
                        @if (auth()->user()->user_type === 'verified_user')
                            <!-- ====================== VERIFIED USER: FULL PROGRESS INFO ====================== -->
                            <p id="growth-label"
                                class="text-[#5e471dff] text-lg md:text-lg font-medium tracking-wide text-center
                                    bg-gradient-to-r from-[#fffacd] via-[#f0edcaff] to-[#ebe7c0ff]
                                    px-4 py-2 rounded-[1.4rem] border border-[#fff695]/60 shadow-sm
                                    shadow-[0_0_15px_rgba(255,246,149,0.3)]
                                    group-hover:bg-gradient-to-r group-hover:from-[#fffee0] group-hover:to-[#fff695]/80
                                    group-hover:border-[#fff695] transition-all duration-300">
                                Stage {{ $stage }} / {{ $treeStages }} — {{ $progressPoints }} /
                                {{ $growthMax }}
                                points
                                <span class="block text-lg text-[#885b2eff]/90 font-normal mt-1">
                                    {{ $treeStages - $stage }} stages remaining
                                </span>
                            </p>
                        @else
                            <!-- ====================== AUTHENTICATED BUT NOT VERIFIED: RESTRICTED MESSAGE ====================== -->
                            <p id="growth-label"
                                class="text-[#594422ff] text-lg md:text-lg font-medium tracking-wide text-center
                                    bg-gradient-to-r from-[#d6cbb7] to-transparent px-4 py-2 rounded-[1.3rem]
                                    border border-[#cbbfa8] shadow-sm">
                                Please verify your account to grow your tree and earn points
                            </p>
                        @endif
                    @else
                        <!-- ====================== GUEST: LOGIN PROMPT ====================== -->
                        <p id="growth-label"
                            class="text-[#594422ff] text-lg md:text-lg font-medium tracking-wide text-center
                                bg-gradient-to-r from-[#0048ffff] to-transparent px-4 py-2 rounded-[1.3rem]
                                border border-[#cbbfa8] shadow-sm">
                            Please log in to see your personalized growth tree
                        </p>
                    @endauth
                </div>

            @endauth


            @guest

                <img id="plant-image">

                <!-- 🌾 Horizontal Progress Bar -->
                <div id="growth-bar"
                    class="absolute opacity-0 flex flex-col items-center gap-2 md:gap-3 z-70 transition-opacity duration-700 ease-out w-full px-4 top-90"
                    style="bottom: 50px;">

                    <!-- Enhanced glow container with bright center -->
                    <div class="relative top-0">
                        <!-- Outer golden glow -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-[#fffacd]/60 via-[#fff8b0]/80 to-[#fff695]/80 
                            blur-[10px] md:blur-[15px] -z-10 w-[130%] -left-[15%]
                            opacity-80">
                        </div>

                        <!-- Middle bright yellow layer -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-[#fffee0]/70 via-[#fffdc2]/65 to-[#fffb9d]/60 
                            blur-[6px] md:blur-[10px] -z-10 w-[115%] -left-[7.5%]
                            opacity-90 mix-blend-overlay">
                        </div>

                        <!-- Center intense yellow core -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-[#ffffe0] via-[#ffffb5] to-[#ffff8f] 
                            blur-[3px] md:blur-[5px] -z-10 w-[105%] -left-[2.5%]
                            opacity-70 mix-blend-screen">
                        </div>

                        <!-- Subtle yellow shimmer effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r 
                            from-transparent via-[#ffffd0]/30 to-transparent 
                            blur-[2px] -z-10 w-[102%] -left-[1%]
                            opacity-100 mix-blend-lighten">
                        </div>

                        <p
                            class="text-[#553722ff] text-base md:text-2xl font-sans-serif italic tracking-wide text-center relative font-medium">
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
                        h-[14px] md:h-[16px] rounded-full bg-[#d6cbb7]/80 overflow-hidden 
                        shadow-inner border border-[#cbbfa8]/80 shadow-lg shadow-[#9f8f6a]/25">

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
                        class="text-[#6b665e] text-lg md:text-lg font-medium tracking-wide text-center
                  bg-gradient-to-r from-[#d6cbb7]/30 to-transparent px-4 py-2 rounded-full
                  border border-[#cbbfa8]/30 shadow-sm">
                        Please log in to see your personalized growth tree
                    </p>
                </div>
            @endguest
        </div>
    </section>
    <section class="relative text-center overflow-hidden min-h-screen"
        style="
        padding-top: 6.75rem;
        padding-bottom: 6.75rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        margin-bottom: 96px;
        margin-top: 5rem;
        min-height: 100vh;
        
        @media (max-width: 640px) {
            padding-top: 4rem;
            padding-bottom: 4rem;
            padding-left: 1rem;
            padding-right: 1rem;
            margin-bottom: 60px;
            min-height: 85vh;
            margin-top: 4rem;
        }
        
        @media (min-width: 640px) {
            margin-top: 6rem;
        }
        
        @media (min-width: 768px) {
            margin-top: 7rem;
        }
        
        @media (min-width: 1024px) {
            margin-top: 8rem;
        }
        
        @media (min-width: 1280px) {
            margin-top: 9rem;
        }
    ">

        <!-- FIXED: Desktop/Laptop background (768px and above) -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0 hidden md:block"
            style="background-image: url('{{ Vite::asset('resources/images/viewport1/bgstatic.webp') }}');">
        </div>

        <!-- FIXED: Mobile background (less than 768px) -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0 block md:hidden"
            style="background-image: url('{{ Vite::asset('resources/images/viewport1/bgstatic.webp') }}');">
        </div>

        <!-- Content container -->
        <div class="relative flex flex-col items-center justify-center space-y-10 z-20"
            style="
            margin-top: 2rem;
            
            @media (max-width: 640px) {
                margin-top: 1.5rem;
                gap: 1.5rem;
            }
            
            @media (min-width: 640px) {
                margin-top: 2.5rem;
            }
            
            @media (min-width: 768px) {
                margin-top: 3rem;
            }
            
            @media (min-width: 1024px) {
                margin-top: 4rem;
            }
        ">


            <h2
                class="text-white font-serif italic font-bold text-5xl md:text-6xl lg:text-7xl 
            drop-shadow-[0_4px_8px_rgba(111,78,55,0.65),0_8px_24px_rgba(89,63,44,0.55),0_0_35px_rgba(255,252,225,0.25)]
            tracking-wider leading-snug text-center px-4 relative z-30
            [@media(max-width:640px)]:text-3xl [@media(max-width:640px)]:leading-tight [@media(max-width:640px)]:tracking-normal
            [@media(max-width:480px)]:text-2xl [@media(max-width:480px)]:px-2">
                The passion of
                <span
                    class="text-[#fff8b0] drop-shadow-[0_0_20px_rgba(255,248,176,0.6)]
                [@media(max-width:640px)]:text-[#fff8b0]/95
                [@media(max-width:640px)]:drop-shadow-[0_0_10px_rgba(255,248,176,0.4)]">
                    Ecobrew
                </span>
            </h2>

            <!-- PUSHED MORE TO BOTTOM - Increased mt values -->
            <div
                class="bg-gradient-to-br from-[#6b4f37]/90 via-[#5a402c] to-[#3a2a1c]/90 
            text-amber-50 text-[clamp(1rem,3.5vw,2rem)] md:text-2xl lg:text-3xl
            px-[clamp(1rem,6vw,3.75rem)] py-[clamp(1rem,3vw,2rem)] rounded-[clamp(1.25rem,2.5vw,2rem)]
            max-w-[95%] md:max-w-5xl lg:max-w-6xl mx-auto leading-relaxed
            shadow-[0_25px_50px_-12px_rgba(111,78,55,0.5)] border border-amber-900/30 backdrop-blur-md
            font-serif text-center 
            
            /* PUSHED DOWN MORE: Increased top margin significantly */
            mt-[clamp(8rem,20vw,12rem)]  /* Changed from 3rem,12vw,8rem to 8rem,20vw,12rem */
            
            mb-[clamp(1.5rem,4vw,5rem)]
            [@media(max-width:640px)]:leading-normal [@media(max-width:640px)]:backdrop-blur-sm
            [@media(max-width:480px)]:leading-snug
            [@media(max-width:640px)]:mt-[15rem]  /* Extra push for mobile */
            [@media(min-width:768px)]:mt-[35rem]  /* Extra push for laptop/desktop */">

                Ecobrew shares simple ways to live more sustainably—at no cost.
            </div>
        </div>
    </section>

    <section
        class="py-20 px-8 overflow-hidden relative
    [@media(max-width:640px)]:py-10 [@media(max-width:640px)]:px-4">

        <!-- Background overlay image -->
        <div
            class="absolute inset-0 bg-[url('/resources/images/viewport1/wood-texture.png')] bg-cover bg-center bg-no-repeat opacity-15">
        </div>

        <!-- 🌫️ Soft Fog Layer -->
        <div
            class="absolute bottom-0 left-0 w-full h-[150px] bg-gradient-to-t from-[#E0E9D6] via-[#E0E9D6]/80 to-transparent z-[5]
        [@media(max-width:640px)]:h-[80px]">
        </div>

        <!-- 🌫️ Soft Fog Layer -->
        <div
            class="absolute top-[-3rem] left-0 w-full h-[150px] bg-gradient-to-b from-[#E0E9D6] from-25% via-[#E0E9D6]/50 via-50% to-transparent z-[5]
        [@media(max-width:640px)]:top-[-1.5rem] [@media(max-width:640px)]:h-[80px]">
        </div>

        <!-- Cards Container - Stack vertically on mobile -->
        <div
            class="relative z-10 flex flex-col items-start gap-20 max-w-6xl mx-auto mt-10
        [@media(max-width:640px)]:items-center [@media(max-width:640px)]:gap-12 [@media(max-width:640px)]:mt-6 [@media(max-width:640px)]:max-w-full">

            <!-- 🌱 Card 1 -->
            <div class="fade-card
            [@media(max-width:640px)]:w-full">
                <div
                    class="bg-gradient-to-r from-[#E3F2D3]/95 to-[#F7FBEE]/95 rounded-3xl p-8 shadow-lg flex items-center justify-between w-[1000px] -ml-[160px] min-h-[300px] backdrop-blur-sm border border-white/20
                [@media(max-width:640px)]:flex-col [@media(max-width:640px)]:w-full [@media(max-width:640px)]:ml-0 [@media(max-width:640px)]:p-6 [@media(max-width:640px)]:min-h-auto [@media(max-width:640px)]:rounded-2xl">

                    <!-- Left side image -->
                    <div
                        class="w-64 h-64 mr-8 flex-shrink-0
                    [@media(max-width:640px)]:w-full [@media(max-width:640px)]:h-48 [@media(max-width:640px)]:mr-0 [@media(max-width:640px)]:mb-6">
                        <img src="{{ Vite::asset('resources/images/viewport1/91250.jpg') }}"
                            alt="People collaborating on sustainability"
                            class="w-full h-full object-cover rounded-2xl shadow-md
                        [@media(max-width:640px)]:rounded-xl">
                    </div>

                    <!-- Content on right -->
                    <div
                        class="flex-1
                    [@media(max-width:640px)]:w-full [@media(max-width:640px)]:text-center">
                        <h3
                            class="text-[#4A6613] italic font-semibold text-[40px]
                        [@media(max-width:640px)]:text-2xl [@media(max-width:640px)]:leading-tight">
                            Discover people who want to contribute more
                        </h3>
                        <p
                            class="text-gray-700 mt-1 text-[20px]
                        [@media(max-width:640px)]:text-base [@media(max-width:640px)]:mt-2">
                            EcoBrew shares simple ways to live more sustainably—at no cost.
                        </p>
                        <div
                            class="flex justify-end
                        [@media(max-width:640px)]:justify-center [@media(max-width:640px)]:mt-6">
                            <a href="/leaderboard"
                                class="mt-10 mr-[30px] bg-[#5C3B23] text-white px-5 py-2 rounded-xl text-sm hover:bg-[#3d2617] transition-colors duration-300
                            [@media(max-width:640px)]:mt-4 [@media(max-width:640px)]:mr-0 [@media(max-width:640px)]:px-6 [@media(max-width:640px)]:py-3">
                                Explore Leaderboards
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🌿 Card 2 -->
            <div class="fade-card
            [@media(max-width:640px)]:w-full">
                <div
                    class="bg-gradient-to-r from-[#F7FBEE]/95 to-[#E3F2D3]/95 rounded-3xl p-8 shadow-lg flex items-center justify-between w-[1000px] ml-[300px] min-h-[300px] backdrop-blur-sm border border-white/20
                [@media(max-width:640px)]:flex-col [@media(max-width:640px)]:w-full [@media(max-width:640px)]:ml-0 [@media(max-width:640px)]:p-6 [@media(max-width:640px)]:min-h-auto [@media(max-width:640px)]:rounded-2xl">

                    <!-- Content on left -->
                    <div
                        class="flex-1
                    [@media(max-width:640px)]:w-full [@media(max-width:640px)]:text-center [@media(max-width:640px)]:order-2">
                        <h3
                            class="text-[#4A6613] italic font-semibold text-[40px]
                        [@media(max-width:640px)]:text-2xl [@media(max-width:640px)]:leading-tight">
                            Take on fun eco-quests
                        </h3>
                        <p
                            class="text-gray-700 mt-2 text-[20px]
                        [@media(max-width:640px)]:text-base [@media(max-width:640px)]:mt-2">
                            Turn small actions into meaningful impact.
                        </p>
                        <div
                            class="flex justify-start
                        [@media(max-width:640px)]:justify-center [@media(max-width:640px)]:mt-6">
                            <a href="/quests"
                                class="mt-20 ml-[30px] bg-[#5C3B23] text-white px-5 py-2 rounded-xl text-sm hover:bg-[#3d2617] transition-colors duration-300
                            [@media(max-width:640px)]:mt-4 [@media(max-width:640px)]:ml-0 [@media(max-width:640px)]:px-6 [@media(max-width:640px)]:py-3">
                                Explore quests
                            </a>
                        </div>
                    </div>

                    <!-- Right side image -->
                    <div
                        class="w-64 h-64 ml-8 flex-shrink-0
                    [@media(max-width:640px)]:w-full [@media(max-width:640px)]:h-48 [@media(max-width:640px)]:ml-0 [@media(max-width:640px)]:mb-6 [@media(max-width:640px)]:order-1">
                        <img src="{{ Vite::asset('resources/images/viewport1/quest.jpg') }}"
                            alt="Eco quests and challenges"
                            class="w-full h-full object-cover rounded-2xl shadow-md
                        [@media(max-width:640px)]:rounded-xl">
                    </div>
                </div>
            </div>

            <!-- ☕ Card 3 -->
            <div class="fade-card
            [@media(max-width:640px)]:w-full">
                <div
                    class="bg-gradient-to-r from-[#E3F2D3]/95 to-[#F7FBEE]/95 rounded-3xl p-8 shadow-lg flex items-center justify-between w-[1000px] -ml-[160px] min-h-[300px] backdrop-blur-sm border border-white/20
                [@media(max-width:640px)]:flex-col [@media(max-width:640px)]:w-full [@media(max-width:640px)]:ml-0 [@media(max-width:640px)]:p-6 [@media(max-width:640px)]:min-h-auto [@media(max-width:640px)]:rounded-2xl">

                    <!-- Left side image -->
                    <div
                        class="w-64 h-64 mr-8 flex-shrink-0
                    [@media(max-width:640px)]:w-full [@media(max-width:640px)]:h-48 [@media(max-width:640px)]:mr-0 [@media(max-width:640px)]:mb-6">
                        <img src="{{ Vite::asset('resources/images/viewport1/shop.jpg') }}"
                            alt="Sustainable café inspiration"
                            class="w-full h-full object-cover rounded-2xl shadow-md
                        [@media(max-width:640px)]:rounded-xl">
                    </div>

                    <!-- Content on right -->
                    <div
                        class="flex-1
                    [@media(max-width:640px)]:w-full [@media(max-width:640px)]:text-center">
                        <h3
                            class="text-[#4A6613] italic font-semibold text-[40px]
                        [@media(max-width:640px)]:text-2xl [@media(max-width:640px)]:leading-tight">
                            Be inspired by Ecobrew
                        </h3>
                        <p
                            class="text-gray-700 mt-2 text-[20px]
                        [@media(max-width:640px)]:text-base [@media(max-width:640px)]:mt-2">
                            See how one café walks its sustainability talk.
                        </p>
                        <div
                            class="flex justify-end
                        [@media(max-width:640px)]:justify-center [@media(max-width:640px)]:mt-6">
                            <a href="/about"
                                class="mt-15 mr-[30px] bg-[#5C3B23] text-white px-5 py-2 rounded-xl text-sm hover:bg-[#3d2617] transition-colors duration-300
                            [@media(max-width:640px)]:mt-4 [@media(max-width:640px)]:mr-0 [@media(max-width:640px)]:px-6 [@media(max-width:640px)]:py-3">
                                Explore About Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Simple fade animation */
        .fade-card {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Mobile specific animations */
        @media (max-width: 640px) {
            .fade-card {
                transform: translateY(10px);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.fade-card');

            // Simple Intersection Observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    } else {
                        entry.target.classList.remove('show');
                    }
                });
            }, {
                threshold: 0.1, // Trigger when 10% of card is visible
                rootMargin: '0px 0px -50px 0px' // Slight offset for smoothness
            });

            // Start observing each card
            cards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>

    <section class="relative py-48 px-8 overflow-hidden pattern-bg">
        @include('modal.feedBackModal')
        <div class="relative z-10 max-w-6xl mx-auto text-center">
            <!-- Section header -->
            <div class="mb-14">
                <div class="inline-flex items-center gap-3 mb-4">
                    <div class="w-12 h-0.5 bg-[#C8D5BB]"></div>
                    <i class="fa-solid fa-heart text-2xl text-[#9BAF8D]"></i>
                    <div class="w-12 h-0.5 bg-[#C8D5BB]"></div>
                </div>
                <h3 class="font-serif italic font-medium text-4xl md:text-5xl mb-3 text-[#5A6B4A]">
                    Voices from Our Community
                </h3>
                <p class="text-lg max-w-2xl mx-auto font-light text-[#5B6B4A]/70">
                    Hear what mindful souls are saying about their sustainable journey
                </p>
            </div>

            <h3 class="text-[#4A6613] italic font-semibold text-2xl md:text-3xl mb-12">
                What our community <br> is saying:
            </h3>

            <!-- ⭐ Feedback Form -->
            @auth
                <form action="{{ route('feedback.store') }}" method="POST"
                    class="bg-[#F8F4E7] rounded-2xl shadow-lg p-8 mb-12 max-w-xl mx-auto text-center">
                    @csrf
                    <h4 class="text-[#4A6613] font-semibold text-xl mb-4 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-comment-dots"></i>
                        Share Your Feedback
                    </h4>

                    <textarea name="content" required rows="3"
                        class="w-full p-4 border-2 border-[#8A9A7B]/60 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#8A9A7B]/30 focus:border-[#6B7D5A]"
                        placeholder="Write your feedback here..."></textarea>

                    <label class="block mt-4 mb-2 font-semibold text-[#4A6613]">Rating:</label>
                    <div class="flex justify-center gap-2 mb-6" x-data="{ rating: 0 }">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden"
                                    x-model="rating">
                                <i class="fa-solid fa-star text-2xl transition-colors duration-300"
                                    :class="rating >= {{ $i }} ? 'text-yellow-500' : 'text-gray-300'"
                                    @click="rating = {{ $i }}"></i>
                            </label>
                        @endfor
                    </div>

                    <button type="submit"
                        class="bg-[#4A6613] cursor-pointer text-white px-8 py-3 rounded-xl hover:bg-[#3a5010] transition-colors duration-300 font-semibold">
                        Submit Feedback
                    </button>
                </form>
            @else
                <div class="bg-[#F8F4E7] rounded-2xl shadow-lg p-8 mb-12 max-w-xl mx-auto text-center">
                    <h4 class="text-[#4A6613] font-semibold text-xl mb-4 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-comment-dots"></i>
                        Share Your Feedback
                    </h4>

                    <div class="p-6 bg-white/80 rounded-xl border-2 border-[#8A9A7B]/30 mb-6">
                        <i class="fa-solid fa-lock text-4xl text-[#4A6613] mb-3"></i>
                        <p class="text-[#4A6613] font-semibold text-lg mb-2">Join the Conversation</p>
                        <p class="text-[#4E3A2E] mb-4">Sign in to share your sustainable journey with our community</p>
                    </div>

                    <div class="text-sm text-[#4E3A2E]/70">
                        <i class="fa-solid fa-info-circle mr-1"></i>
                        Your feedback helps others on their sustainability journey
                    </div>
                </div>
            @endauth

            <!-- FEEDBACK CARDS -->
            <div class="mt-16">
                <h4 class="text-[#4A6613] font-semibold text-2xl mb-8 text-center">Community Stories</h4>

                @php $feedbackCount = $feedback->count(); @endphp

                @if ($feedbackCount === 0)
                    <div class="bg-[#F8F4E7] rounded-2xl p-10 text-center max-w-md mx-auto">
                        <i class="fa-solid fa-comments text-5xl text-[#4A6613] opacity-70 mb-4"></i>
                        <h5 class="text-[#4A6613] font-semibold text-xl mb-2">No stories yet</h5>
                        <p class="text-[#4E3A2E] mb-4">Be the first to share your sustainable journey</p>
                        @auth
                            <p class="text-sm text-[#4E3A2E]/70">Use the form above to share your experience</p>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-[#4A6613] font-semibold hover:text-[#3a5010] transition-colors">
                                Sign in to get started →
                            </a>
                        @endauth
                    </div>
                @elseif ($feedbackCount === 1)
                    <div class="flex justify-center">
                        @php $item = $feedback->first(); @endphp
                        <div
                            class="bg-[#F8F4E7] rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 relative w-full max-w-md feedback-card">
                            <div class="flex items-center gap-3 mb-4 mt-8">
                                <div class="w-10 h-10 rounded-full bg-[#4A6613]/10 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-[#4A6613]"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#4A6613] text-sm">
                                        {{ $item->user->first_name ?? 'Anonymous' }} {{ $item->user->last_name ?? '' }}
                                    </p>
                                    <p class="text-xs text-[#4E3A2E]/60">{{ $item->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <p class="text-[#4E3A2E] italic mb-4 text-sm line-clamp-3">"{{ $item->content }}"</p>
                            <div class="flex justify-between items-center pt-4 border-t border-[#8A9A7B]/30">
                                <div class="flex gap-1">
                                    <span class="text-yellow-500">{!! str_repeat('<i class="fa-solid fa-star"></i>', $item->rating) !!}</span>
                                    <span class="text-gray-300">{!! str_repeat('<i class="fa-solid fa-star"></i>', 5 - $item->rating) !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Leaf decorations -->
                    <div class="relative mb-8 z-70">
                        <img src="{{ Vite::asset('resources/images/viewport1/3leaves-left.png') }}" alt="Leaf Cluster"
                            class="absolute right-0 top-1/2 transform translate-x-[85%] -translate-y-[30%] w-90 h-auto filter brightness-[0.85] opacity-70"
                            loading="lazy">
                        <img src="{{ Vite::asset('resources/images/viewport1/3leaves-right.png') }}" alt="Leaf Cluster"
                            class="absolute left-0 top-1/2 transform -translate-x-[85%] -translate-y-[30%] w-90 h-auto filter brightness-[0.85] opacity-70"
                            loading="lazy">
                    </div>

                    <!-- Horizontal Scrolling Container -->
                    <div class="relative max-w-6xl mx-auto">
                        <!-- Scroll Container with Custom Scrollbar -->
                        <div class="relative">
                            <!-- Cards Container -->
                            <div id="feedback-scroll-container"
                                class="flex gap-6 pb-8 overflow-x-auto scrollbar-hide hover:scrollbar-default">
                                @foreach ($feedback as $item)
                                    <div class="flex-shrink-0 w-80">
                                        <div
                                            class="bg-[#F8F4E7] rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300 relative feedback-card h-full">
                                            <div class="flex items-center gap-3 mb-4 mt-8">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-[#4A6613]/10 flex items-center justify-center">
                                                    <i class="fa-solid fa-user text-[#4A6613]"></i>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-[#4A6613] text-sm">
                                                        {{ $item->user->first_name ?? 'Anonymous' }}
                                                        {{ $item->user->last_name ?? '' }}
                                                    </p>
                                                    <p class="text-xs text-[#4E3A2E]/60">
                                                        {{ $item->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <p class="text-[#4E3A2E] italic mb-4 text-sm line-clamp-3  feedback-text">
                                                "{{ $item->content }}"</p>
                                            <button class="text-[#4A6613] text-xs font-semibold open-feedback-modal"
                                                data-content="{{ $item->content }}"
                                                data-user="{{ $item->user->first_name ?? 'Anonymous' }} {{ $item->user->last_name ?? '' }}"
                                                data-date="{{ $item->created_at->format('M d, Y') }}"
                                                data-rating="{{ $item->rating }}">
                                                Read full review →
                                            </button>

                                            <div
                                                class="flex justify-between items-center pt-4 border-t border-[#8A9A7B]/30">
                                                <div class="flex gap-1">
                                                    <span class="text-yellow-500">{!! str_repeat('<i class="fa-solid fa-star"></i>', $item->rating) !!}</span>
                                                    <span class="text-gray-300">{!! str_repeat('<i class="fa-solid fa-star"></i>', 5 - $item->rating) !!}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Custom Scrollbar -->
                            <div class="scrollbar-track relative h-2 mt-4 bg-[#E8E4D7] rounded-full overflow-hidden">
                                <div id="scrollbar-thumb"
                                    class="absolute left-0 h-full bg-[#4A6613] rounded-full transition-all duration-300"
                                    style="width: 33.33%"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <style>
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .feedback-card::before {
                content: "“";
                font-size: 1.5rem;
                color: #4A6613;
                position: absolute;
                top: 1rem;
                left: 1rem;
                opacity: 0.7;
            }

            /* Custom Scrollbar Styles */
            .scrollbar-hide {
                scrollbar-width: none;
                /* Firefox */
                -ms-overflow-style: none;
                /* IE and Edge */
            }

            .scrollbar-hide::-webkit-scrollbar {
                display: none;
                /* Chrome, Safari, Opera */
            }

            .scrollbar-default::-webkit-scrollbar {
                display: block;
                height: 6px;
            }

            .scrollbar-default::-webkit-scrollbar-track {
                background: #E8E4D7;
                border-radius: 10px;
            }

            .scrollbar-default::-webkit-scrollbar-thumb {
                background: #4A6613;
                border-radius: 10px;
            }

            .scrollbar-default::-webkit-scrollbar-thumb:hover {
                background: #3a5010;
            }

            @media (max-width: 768px) {
                #feedback-scroll-container>div {
                    width: 300px !important;
                }
            }

            @media (max-width: 640px) {
                #feedback-scroll-container>div {
                    width: 280px !important;
                }

                .scrollbar-track {
                    margin-left: 1rem;
                    margin-right: 1rem;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.querySelector('form[action="{{ route('feedback.store') }}"]');
                const ratingToast = document.getElementById('rating-toast');

                form.addEventListener('submit', function(e) {
                    const ratingSelected = form.querySelector('input[name="rating"]:checked');

                    if (!ratingSelected) {
                        e.preventDefault(); // stop form submission
                        showRatingToast();
                    }
                });

                function showRatingToast() {
                    ratingToast.classList.remove('hidden');
                    ratingToast.classList.add('opacity-100');

                    setTimeout(() => {
                        ratingToast.classList.add('opacity-0');
                    }, 2000);

                    setTimeout(() => {
                        ratingToast.classList.add('hidden');
                        ratingToast.classList.remove('opacity-0');
                    }, 2500);
                }
            });
            document.addEventListener('DOMContentLoaded', function() {
                const scrollContainer = document.getElementById('feedback-scroll-container');
                const scrollbarThumb = document.getElementById('scrollbar-thumb');

                if (!scrollContainer) return;

                // Calculate scroll amount (80% of container width)
                function getScrollAmount() {
                    return scrollContainer.clientWidth * 0.8;
                }

                // Update scrollbar position
                function updateScrollbar() {
                    const scrollWidth = scrollContainer.scrollWidth;
                    const clientWidth = scrollContainer.clientWidth;
                    const scrollLeft = scrollContainer.scrollLeft;
                    const maxScroll = scrollWidth - clientWidth;

                    if (maxScroll > 0) {
                        const thumbWidth = (clientWidth / scrollWidth) * 100;
                        const thumbPosition = (scrollLeft / maxScroll) * (100 - thumbWidth);

                        scrollbarThumb.style.width = `${thumbWidth}%`;
                        scrollbarThumb.style.left = `${thumbPosition}%`;
                    } else {
                        scrollbarThumb.style.width = '100%';
                        scrollbarThumb.style.left = '0';
                    }
                }


                // Update scrollbar on scroll
                scrollContainer.addEventListener('scroll', updateScrollbar);

                // Update scrollbar on resize
                window.addEventListener('resize', updateScrollbar);

                // Initial update
                updateScrollbar();

                // Optional: Drag functionality for scrollbar
                let isDragging = false;

                scrollbarThumb.parentElement.addEventListener('mousedown', function(e) {
                    isDragging = true;
                    handleScrollbarDrag(e);
                    e.preventDefault();
                });

                document.addEventListener('mousemove', function(e) {
                    if (isDragging) {
                        handleScrollbarDrag(e);
                    }
                });

                document.addEventListener('mouseup', function() {
                    isDragging = false;
                });

                function handleScrollbarDrag(e) {
                    const scrollbarTrack = scrollbarThumb.parentElement;
                    const trackRect = scrollbarTrack.getBoundingClientRect();
                    const trackWidth = trackRect.width;
                    const thumbWidth = scrollbarThumb.offsetWidth;

                    let mouseX = e.clientX - trackRect.left;
                    mouseX = Math.max(0, Math.min(mouseX, trackWidth - thumbWidth));

                    const thumbPosition = mouseX / (trackWidth - thumbWidth);

                    const scrollWidth = scrollContainer.scrollWidth;
                    const clientWidth = scrollContainer.clientWidth;
                    const maxScroll = scrollWidth - clientWidth;

                    scrollContainer.scrollLeft = thumbPosition * maxScroll;
                }

                // Touch support for mobile
                scrollbarThumb.parentElement.addEventListener('touchstart', function(e) {
                    isDragging = true;
                    handleScrollbarTouch(e);
                    e.preventDefault();
                });

                document.addEventListener('touchmove', function(e) {
                    if (isDragging) {
                        handleScrollbarTouch(e);
                    }
                });

                document.addEventListener('touchend', function() {
                    isDragging = false;
                });

                function handleScrollbarTouch(e) {
                    const touch = e.touches[0];
                    const scrollbarTrack = scrollbarThumb.parentElement;
                    const trackRect = scrollbarTrack.getBoundingClientRect();
                    const trackWidth = trackRect.width;
                    const thumbWidth = scrollbarThumb.offsetWidth;

                    let touchX = touch.clientX - trackRect.left;
                    touchX = Math.max(0, Math.min(touchX, trackWidth - thumbWidth));

                    const thumbPosition = touchX / (trackWidth - thumbWidth);

                    const scrollWidth = scrollContainer.scrollWidth;
                    const clientWidth = scrollContainer.clientWidth;
                    const maxScroll = scrollWidth - clientWidth;

                    scrollContainer.scrollLeft = thumbPosition * maxScroll;
                }
            });
        </script>

    </section>

    <section class="relative text-center py-8px-6 overflow-hidden">
        <!-- Background overlay image with exact opacity and pointer-events -->

        <!-- 🌫️ Soft Fog Layer -->
        <div
            class="absolute bottom-0 left-0 w-full h-[150px] bg-gradient-to-t from-[#E0E9D6] via-[#E0E9D6]/80 to-transparent z-[5]">
        </div>

        <!-- 🌫️ Soft Fog Layer -->
        <div
            class="absolute top-[-3rem] left-0 w-full h-[150px] 
            bg-gradient-to-b from-[#E0E9D6] from-25% via-[#E0E9D6]/50 via-50% to-transparent z-[5]">
        </div>

        <!-- Soft gradient background (different from above) -->
        <div class="absolute inset-0" style="background: radial-gradient(circle at 50% 50%, #F1EEE6, #E8E4DA)"></div>

        <!-- Subtle water/wave pattern overlay -->
        <div class="absolute inset-0 opacity-10 pointer-events-none"
            style="background-image: url('data:image/svg+xml,<svg width="100" height="20" viewBox="0 0 100 20"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0,10 C20,5 40,15 60,10 C80,5 100,15 100,10 L100,20 L0,20 Z" fill="%236B7D5A" /></svg>
        </div>

        <!-- Floating eco elements -->
        <div class="absolute top-20 left-10 w-16 h-16 opacity-10 animate-float">
            <i class="fa-solid fa-droplet text-5xl" style="color: #8A9A7B"></i>
        </div>
        <div class="absolute bottom-20 right-12 w-20 h-20 opacity-10 animate-float" style="animation-delay: 1s">
            <i class="fa-solid fa-wind text-6xl" style="color: #9BAF8D"></i>
        </div>

        <!-- Subtle background image with very low opacity -->
        <div class="absolute inset-0 bg-center bg-contain bg-no-repeat opacity-5 mix-blend-soft-light"
            style="background-image: url('{{ Vite::asset('resources/images/viewport1/image-removebg-preview (12).png') }}');">
        </div>

        <div class="relative z-30 max-w-3xl mx-auto">



            <!-- Earthy call to action -->
            <div class="mb-16">


                <!-- Emotional heading -->
                <h3 class="font-serif text-3xl md:text-5xl font-light mb-12 leading-snug text-center px-6"
                    style="color: #5A6B4A; line-height: 1.3">
                    Make a difference<br>
                    <span class="italic font-normal" style="color: #8A9A7B">with Ecobrew</span>
                </h3>

                <!-- Gentle quote box -->
                <div class="max-w-lg mx-auto p-10 rounded-2xl relative"
                    style="background: rgba(255, 255, 255, 0.8); 
                border: 1px solid rgba(200, 213, 187, 0.4);
                backdrop-filter: blur(8px)">

                    <!-- Quote with soft spacing -->
                    <div class="space-y-6">
                        <p class="text-lg font-sans-serif italic leading-relaxed text-center"
                            style="color: #6B7D5A; line-height: 1.8">
                            "Sustainability isn't about being perfect.<br>
                            It's about being present.<br>
                            <span class="font-medium" style="color: #8A9A7B">One gentle choice at a time,</span><br>
                            we weave a kinder world together."
                        </p>

                        <div class="pt-6 border-t text-center" style="border-top-color: rgba(200, 213, 187, 0.3)">
                            <p class="text-sm font-light tracking-wide" style="color: rgba(107, 125, 90, 0.7)">
                                Welcome to a space where<br>
                                every small step is celebrated
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Olive Button Design -->
            <!-- Olive Button using your existing CSS classes -->
            <a href="/quests" class="btn-eco btn-olive w-67 py-3 px-8 text-base md:text-lg">
                <i class="fa-solid fa-seedling"></i>
                <span>Start Your First Quest</span>
            </a>


        </div>

    </section>

    <style>
        .pattern-bg {
            position: relative;
        }

        .pattern-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('{{ Vite::asset('resources/images/viewport1/patternn.webp') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            /* Adjust opacity here */
            z-index: 0;
        }
    </style>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
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
                "{{ Vite::asset('resources/images/leaves/coffee-bean.png') }}",
                "{{ Vite::asset('resources/images/leaves/coffee-bean2.png') }}"
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

            // ========== ADD THIS NEW FUNCTION ==========
            function showToastMessage(message, type = 'info', subtitle = '') {
                // Remove existing toast if present
                const existingToast = document.getElementById('dynamic-toast');
                if (existingToast) {
                    existingToast.remove();
                }

                // Create toast element with your consistent styling
                const toast = document.createElement('div');
                toast.id = 'dynamic-toast';

                // Base styling matching your feedback toast
                let baseClasses =
                    'fixed top-6 left-1/2 -translate-x-1/2 font-sans-serif font-bold italic text-lg shadow-md px-6 py-3 rounded-2xl z-[99999] transition-opacity duration-1000 ease-in-out opacity-100 backdrop-blur-sm';

                // Type-specific styling
                let typeClasses = '';
                let icon = '';

                switch (type) {
                    case 'verification':
                        typeClasses = 'bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919]';
                        icon =
                            `<svg class="w-5 h-5 inline-block"" fill="currentColor" viewBox="0 0 20 20"> <path d="M10 2a1 1 0 01.894.553l2.764 5.598 6.18.898a1 1 0 01.554 1.706l-4.472 4.356 1.055 6.16a1 1 0 01-1.451 1.054L10 18.347l-5.525 2.908a1 1 0 01-1.451-1.054l1.055-6.16L-.02 10.755a1 1 0 01.553-1.706l6.18-.898L9.105 2.553A1 1 0 0110 2z"/></svg>`;
                        break;

                    case 'success':
                        typeClasses = 'bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919]';
                        icon =
                            ` <svg class="w-3 h-3 inline-block"" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414-1.414L8 11.172 4.707 7.879A1 1 0 103.293 9.293l4 4a1 1 0 001.414 0l8-8z" clip-rule="evenodd"/></svg>`;
                        break;

                    case 'error':
                    case 'warning':
                        typeClasses = 'bg-[#fff5f5]/90 border border-[#d9534f]/40 text-[#d9534f]';
                        icon =
                            `<svg class="w-5 h-5 inline-block"" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 112 0 1 1 0 01-2 0zm0-6a1 1 0 112 0v4a1 1 0 01-2 0V7z" clip-rule="evenodd"/></svg> `;
                        break;

                    case 'info':
                    default:
                        typeClasses = 'bg-[#f5f8ef]/90 border border-[#5C7919]/40 text-[#5C7919]';
                        icon =
                            ` <svg class="w-5 h-5 inline-block"" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10A8 8 0 112 10a8 8 0 0116 0zM9 9a1 1 0 100 2h1v3a1 1 0 102 0V9a1 1 0 00-1-1H9zm1-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg> `;
                }


                toast.className = `${baseClasses} ${typeClasses}`;

                // Create content with optional subtitle
                let content = `${icon} ${message}`;
                if (subtitle) {
                    content += `<div class="text-sm font-normal not-italic mt-1 opacity-80">${subtitle}</div>`;
                }

                toast.innerHTML = content;

                // Add to body - ensure it's visible
                document.body.appendChild(toast);

                // Force reflow to trigger animation
                toast.getBoundingClientRect();

                // Auto-remove after 5 seconds
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 1000);
                }, 5000);
            }

            // ========== UPDATE sendTaps() FUNCTION ==========
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

                        // ========== HANDLE ALL NON-VERIFIED USER CASES ==========
                        // Check for "Only verified users" message OR if user is guest/unverified
                        const isGuest = window.isGuest === true;
                        const isUnverified = data.message && (
                            data.message.includes('Only verified users') ||
                            data.message.includes('verification') ||
                            data.message.includes('verify')
                        );

                        if (isGuest || isUnverified || data.message === 'Only verified users') {
                            // Determine message based on user status
                            let message = 'Only verified users can grow their tree';
                            let subtitle = 'Verify your account to nurture your eco-tree and earn points';

                            if (isGuest) {
                                message = 'Welcome to our growing community';
                                subtitle = 'Please log in to start nurturing your personal eco-tree';
                            }

                            showToastMessage(message, 'verification', subtitle);
                            return; // Stop further processing
                        }
                        // ========== END NON-VERIFIED HANDLING ==========

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
                    <span class="block text-[20px] text-[#9f8f6a]/70 font-normal mt-1">
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
                                        ' bg-gradient-to-br from-[#cbbfa8]/80 to-[#9f8f6a]/30 border border-[#cbbfa8]/50';
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
                            // Use new consistent toast instead of showIntegratedMessage
                            showToastMessage(data.message, 'info');
                        }
                    })
                    .catch(err => {
                        console.error("Tap failed:", err);
                        showToastMessage("Connection lost. Try again!", "error");
                    });
            }
            // ========== UPDATE showProgressBarMessage to use consistent styling ==========
            function showProgressBarMessage(msg, type = "info") {
                // Instead of the badge, use the consistent toast
                const toastType = type === 'warning' ? 'error' :
                    type === 'success' ? 'success' : 'info';

                showToastMessage(msg, toastType);
            }

            // ========== UPDATE showIntegratedMessage to use consistent styling ==========
            function showIntegratedMessage(msg, targetElement) {
                // Use toast instead of modifying the element
                showToastMessage(msg, 'info');

                // Optionally keep the original functionality for backward compatibility
                if (!targetElement) return;

                // Save original content
                const originalContent = targetElement.innerHTML;
                const originalClasses = targetElement.className;

                // Update with message (simpler version)
                targetElement.innerHTML = `
                    <div class="flex items-center gap-2 animate-pulse">
                        <span class="text-sm font-medium">${msg}</span>
                    </div>
                `;

                targetElement.className = originalClasses +
                    ' bg-gradient-to-r from-[#E8E2D5]/80 to-[#D8D1C1]/80 ' +
                    'border border-[#B8A992]/50 shadow-sm text-[#5C4E3F]';

                // Restore after 3 seconds
                setTimeout(() => {
                    targetElement.innerHTML = originalContent;
                    targetElement.className = originalClasses;
                }, 3000);
            }

            let levelUpEffectTriggered = false; // flag to ensure animation runs only once

            function createLevelUpEffect() {
                if (levelUpEffectTriggered) return; // exit if already triggered
                levelUpEffectTriggered = true; // mark as triggered

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

        document.addEventListener("DOMContentLoaded", () => {
            const btnLeft = document.getElementById("mobile-switch-left");
            const btnRight = document.getElementById("mobile-switch-right");

            const btnToggle = document.getElementById("mobile-panels-toggle");

            const leftPanel = document.getElementById("left-panel");
            const rightPanel = document.getElementById("right-panel");

            let activePanel = null;

            function hidePanels() {
                leftPanel.classList.add("hidden");
                rightPanel.classList.add("hidden");
                activePanel = null;
                btnToggle.textContent = "Show Available Quests";
            }

            function showLeft() {
                hidePanels();
                leftPanel.style.zIndex = "2000";
                leftPanel.classList.remove("hidden");
                activePanel = "left";
                btnToggle.textContent = "Hide Panels";
                btnRight.classList.remove("hidden");
                btnLeft.classList.add("hidden");
            }

            function showRight() {
                hidePanels();
                rightPanel.style.zIndex = "2000";
                rightPanel.classList.remove("hidden");
                activePanel = "right";
                btnToggle.textContent = "Hide Panels";
                btnLeft.classList.remove("hidden");
                btnRight.classList.add("hidden");

            }

            btnToggle.addEventListener("click", () => {
                if (activePanel === null) showLeft();
                else hidePanels();
            });

            btnLeft.addEventListener("click", () => showLeft());
            btnRight.addEventListener("click", () => showRight());
        });
    </script>
@endsection
