@extends('layouts.mainLayout')

@section('content')
    <style>
        /* Default for large screens */
        .content-scroll-main {
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 6px;
        }

        /* Smaller screens (mobile + small tablets) */
        @media (max-width: 768px) {
            .content-scroll-main {
                height: 93%;
            }
        }
    </style>
    <main class="pt-12 px-6 flex min-h-screen ">

        <aside id="profileSidebarAccount"
            class="fixed md:static top-10 md:top-0 left-0 h-full mr-5 md:h-[calc(100vh-7rem)] w-80 md:w-110 bg-[#FCF9EF] overflow-y-auto   md:rounded-3xl shadow-md p-6 
           transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-[500]">
            @php
                $user = auth()->user();

                // Total eco points
                $progressPoints = \App\Models\UserPointsHistory::where('user_id', $user->user_id)
                    ->where('points_change', '>', 0)
                    ->where('voided', false)
                    ->sum('points_change');

                // Current points (for redemption)
                $currentPoints = $progressPoints; // adjust if you track spent points separately

                // Completed quests
                $completedQuests = \App\Models\QuestSubmission::where('user_id', $user->user_id)
                    ->where('status', 'completed')
                    ->count();

                // Earned badges
                $treeStages = [
                    0 => ['name' => 'Seed', 'icon' => '🌱'],
                    50 => ['name' => 'Sprout', 'icon' => '🌿'],
                    100 => ['name' => 'Seedling', 'icon' => '🍃'],
                    200 => ['name' => 'Sapling', 'icon' => '🌳'],
                    300 => ['name' => 'Young Tree', 'icon' => '🌲'],
                    450 => ['name' => 'Growing Tree', 'icon' => '🎋'],
                    550 => ['name' => 'Strong Tree', 'icon' => '🌴'],
                    700 => ['name' => 'Mature Tree', 'icon' => '🌳'],
                ];
                $earnedBadges = 0;
                $badgeLevel = 'Seed'; // Default to the first stage

                foreach ($treeStages as $points => $stage) {
                    if ($progressPoints >= $points) {
                        $earnedBadges++;
                        $badgeLevel = $stage['name']; // Always assign the latest unlocked stage
                    }
                }
                // Determine current tree stage
                $currentTreeStage = null;
                foreach ($treeStages as $points => $stage) {
                    if ($progressPoints >= $points) {
                        $currentTreeStage = $stage;
                    }
                }

                // Determine the stage index for GIF selection
                $treeStageKeys = array_keys($treeStages);
                $stageIndex = 0;
                foreach ($treeStageKeys as $i => $points) {
                    if ($progressPoints >= $points) {
                        $stageIndex = $i + 1; // e.g., 1.gif, 2.gif...
                    }
                }

                $treeGif = Vite::asset("resources/images/tree/{$stageIndex}.gif");
            @endphp
            <h2 class="text-3xl font-bold text-green-900  mb-4">Profile</h2>
            {{-- Profile Card --}}
            <div class="bg-white rounded-2xl shadow p-5  h-auto">
                <div class="flex items-center justify-between mb-2">

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-[#E0F2D4] rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#4F6B3F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-2xl text-gray-800">
                                    {{ $user->first_name . ' ' . $user->last_name ?? 'Guest User' }}
                                </h3>
                                <p class="text-sm text-gray-500">{{ $badgeLevel }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Dynamic Stats --}}
                <div class="text-sm text-gray-700 space-y-1 mt-3">
                    <p><span class="text-xl font-semibold text-[#4F6B3F]">Total Eco-points:</span> {{ $progressPoints }} pts
                    </p>
                    <p><span class="text-xl font-semibold text-[#4F6B3F]">Current Points:</span> {{ $currentPoints }} pts
                    </p>
                    <p><span class="text-xl font-semibold text-[#4F6B3F]">Earned badges:</span> {{ $earnedBadges }}</p>
                    <p><span class="text-xl font-semibold text-[#4F6B3F]">Quests completed:</span> {{ $completedQuests }}
                    </p>
                </div>
                {{-- Tree Display --}}
                <div class="mt-10 mb-4 text-center">
                    <h4 class="text-lg text-gray-600 mb-2">Your Tree Stage: 

                    <img id="plant-image" src="{{ $treeGif }}" alt="Plant"
                        class="mx-auto z-20 w-full max-w-[200px] transition-all duration-700 select-none
                            drop-shadow-[0_0_25px_rgba(92,121,25,0.3)]
                            hover:drop-shadow-[0_0_40px_rgba(159,143,106,0.6)]
                            hover:scale-[1.03]
                            active:scale-[0.98]
                            cursor-pointer
                            filter brightness-[1.05]
                            hover:brightness-[1.12]
                            relative
                            after:absolute after:inset-0 after:z-10
                            after:bg-gradient-to-b after:from-transparent after:via-transparent after:to-[#5C7919]/5
                            after:rounded-full after:pointer-events-none
                            group">
                </div>

                <div class="mt-4 bg-[#E6F0D9] p-3 rounded-xl text-center text-[#4F6B3F] text-sm font-medium">
                    {{ $badgeLevel }}
                </div>
                <a href="{{ route('account.show') }}"
                    class="block w-full text-center bg-[#4F6B3F] text-white mt-5 py-2 rounded-xl hover:bg-[#3B541F] transition">
                    Account
                </a>
                {{-- Buttons --}}
                <a href="/myprogress"
                    class="block w-full text-center bg-[#4F6B3F] text-white mt-2 py-2 rounded-xl hover:bg-[#3B541F] transition">
                    View Progress
                </a>
                <a href="/rewards"
                    class="block w-full text-center bg-[#4F6B3F] text-white mt-2 py-2 rounded-xl hover:bg-[#3B541F] transition">
                    View Rewards
                </a>
            </div>
        </aside>
        {{-- Overlay (mobile only) --}}
        <div id="profileOverlaySidebar" class="fixed inset-0 bg-black/40 hidden md:hidden z-[200]">
        </div>
        {{-- 🌱 Main Account Content --}}
        <!-- Mobile Toggle Button -->
        <!-- Mobile Toggle Button -->

        <section
            class="bg-[#FCF9EF] w-full max-w-[1400px] rounded-3xl shadow-md p-6 space-y-4 h-[calc(100vh-7rem)] overflow-y-auto     mx-auto">
            <button id="profileSidebarToggle"
                class="md:hidden block w-full sticky top-0 bg-[#4F6B3F] text-white px-2 py-2
               rounded-lg shadow z-[80]">
                ☰ Profile Details
            </button>
            <!-- Scroll Padding Wrapper -->
            <div class="content-scroll-main">
                @yield('account_content')
            </div>

        </section>
        <script>
            const profileSidebar = document.getElementById("profileSidebarAccount");
            const profileOverlay = document.getElementById("profileOverlaySidebar");
            const profileSidebarToggle = document.getElementById("profileSidebarToggle");

            function openProfileSidebar() {
                profileSidebar.classList.remove("-translate-x-full");
                profileOverlay.classList.remove("hidden");
            }

            function closeProfileSidebar() {
                profileSidebar.classList.add("-translate-x-full");
                profileOverlay.classList.add("hidden");
            }

            profileSidebarToggle.addEventListener("click", openProfileSidebar);
            profileOverlay.addEventListener("click", closeProfileSidebar);
        </script>


    </main>
@endsection
