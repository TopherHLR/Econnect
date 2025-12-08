@extends('layouts.adminLayout')

@section('title', 'Admin Home')

@section('content')
    @include('modal.userModal')
    @include('modal.AddVoucherModal')
    @include('modal.deservingPlayerModal')
    <div class="space-y-6 ">
        <!-- Header Section with ALL Quick Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Admin Dashboard</h1>
                <p class=" font-sans  text-[#6A8A52] mt-1">Welcome back! Here's your platform overview.</p>
            </div>

            <!-- ALL Quick Actions - Compact, beside header -->
            <div class="flex flex-wrap gap-2 justify-end">
                <!-- Secondary Actions -->
                <button onclick="openUserQrScanner()" class="btn-eco btn-sand compact" title="Verify User">
                    <i class="fa-solid fa-user-check"></i>

                    <span class="hidden xl:inline">Verify User</span>
                </button>
                <button onclick="openUserQrScannerModal()" class="btn-eco btn-mint compact" title="Scan User QR">
                    <i class="fa-solid fa-qrcode"></i>
                    <span class="hidden xl:inline">QR Quests</span>
                </button>
                <button onclick="openQrScanner()" class="btn-eco btn-leaf compact" title="Scan QR Code">
                    <i class="fa-solid fa-qrcode"></i>
                    <span class="hidden xl:inline">Scan Voucher</span>
                </button>
                <!-- Primary Actions -->
                <button onclick="openQuestModal()" class="btn-eco btn-mint compact" title="Create New Quest">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span class="hidden lg:inline">New Quest</span>
                </button>
                <button onclick="openCreateEcoTopicModal()" class="btn-eco btn-leaf compact" title="Add Eco Topic">
                    <i class="fa-solid fa-leaf"></i>
                    <span class="hidden lg:inline">Eco Topic</span>
                </button>
                <button onclick="openEcoActionModal()" class="btn-eco btn-olive compact" title="Add Eco Action">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span class="hidden lg:inline">Eco Action</span>
                </button>




            </div>
        </div>

        <!-- 📊 METRICS DASHBOARD SECTION -->
        <section>

            <!-- TOP PERFORMERS TICKER -->
            <div
                class="bg-gradient-to-r mb-3 from-[#4F6B3F]/10 to-[#7F8A4F]/10 rounded-xl p-3 border border-[#E6EAD7] shadow-sm">
                <div class="flex items-center overflow-hidden">
                    <span
                        class="flex-shrink-0 animate-pulse bg-[#4F6B3F] px-4 py-1.5 rounded-xl text-sm text-white font-semibold">
                        <i class="fa-solid fa-chart-line mr-2"></i>LIVE TOP PERFORMERS
                    </span>
                    <div class="ticker-wrapper whitespace-nowrap ml-4 flex-1 overflow-hidden">
                        <div class="ticker-content inline-block animate-ticker">
                            @php
                                $currentUserId = auth()->check() ? auth()->user()->user_id : null;
                                $items = collect();

                                // Top Points
                                foreach ($topByPoints->take(3) as $i => $u) {
                                    // ✅ Skip admins, only show verified users
                                    if ($u->user->user_type !== 'verified_user') {
                                        continue;
                                    }

                                    $isYou = $currentUserId && $u->user->user_id == $currentUserId;

                                    $items->push([
                                        'icon' => $isYou ? 'star' : 'trophy',
                                        'label' => '#' . ($i + 1) . ' Points',
                                        'name' => $u->user->first_name . ' ' . substr($u->user->last_name, 0, 1) . '.',
                                        'value' => number_format($u->progressPoints) . ' pts',
                                        'is_you' => $isYou,
                                    ]);
                                }

                                // Top Quests
                                foreach ($topByQuests->take(3) as $i => $u) {
                                    // ✅ Skip admins
                                    if ($u->user->user_type !== 'verified_user') {
                                        continue;
                                    }

                                    $isYou = $currentUserId && $u->user->user_id == $currentUserId;

                                    $items->push([
                                        'icon' => $isYou ? 'star' : 'check',
                                        'label' => '#' . ($i + 1) . ' Quests',
                                        'name' => $u->user->first_name . ' ' . substr($u->user->last_name, 0, 1) . '.',
                                        'value' => $u->questsCompleted . ' completed',
                                        'is_you' => $isYou,
                                    ]);
                                }

                                // Top Eco-Taps
                                foreach ($topDailyActions->take(3) as $i => $u) {
                                    // ✅ Skip admins
                                    if ($u->user->user_type !== 'verified_user') {
                                        continue;
                                    }

                                    $isYou = $currentUserId && $u->user->user_id == $currentUserId;

                                    $items->push([
                                        'icon' => $isYou ? 'star' : 'globe',
                                        'label' => '#' . ($i + 1) . ' Eco-Taps',
                                        'name' => $u->user->first_name . ' ' . substr($u->user->last_name, 0, 1) . '.',
                                        'value' => $u->dailyEcoActions . ' taps',
                                        'is_you' => $isYou,
                                    ]);
                                }
                            @endphp

                            <!-- Render items twice for seamless loop -->
                            @foreach ([$items, $items] as $set)
                                @foreach ($set as $item)
                                    <span
                                        class="mx-8 inline-flex items-center gap-3 {{ $item['is_you'] ? 'animate-pulse font-extrabold drop-shadow-lg' : '' }}">
                                        @if ($item['icon'] === 'star')
                                            <i class="fa-solid fa-star text-yellow-400 text-lg drop-shadow"></i>
                                        @elseif($item['icon'] === 'trophy')
                                            <i class="fa-solid fa-trophy text-yellow-300 text-lg"></i>
                                        @elseif($item['icon'] === 'check')
                                            <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
                                        @elseif($item['icon'] === 'globe')
                                            <i class="fa-solid fa-earth-americas text-cyan-400 text-lg"></i>
                                        @endif

                                        <span
                                            class="font-bold text-[#4F6B3F] {{ $item['is_you'] ? 'text-[#C37A49]' : '' }}">
                                            {{ $item['label'] }}
                                        </span>
                                        <span
                                            class="font-medium {{ $item['is_you'] ? 'text-[#C37A49] underline decoration-2 underline-offset-2 font-bold' : 'text-gray-700' }}">
                                            {{ $item['name'] }} @if ($item['is_you'])
                                                (You!)
                                            @endif
                                        </span>
                                        <span class="text-[#6A8A52] font-medium">{{ $item['value'] }}</span>
                                        <span class="mx-4 text-gray-400">|</span>
                                    </span>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <!-- 🟢 HIGH PRIORITY CARDS (Top Row) -->

                    <div class="metric-card">
                        <h3 class="text-lg font-semibold text-[#4A6613]">Most Deserving Player</h3>

                        <div class="mt-2">
                            <p><strong>Name:</strong> {{ $mostDeserving->user->first_name }}
                                {{ $mostDeserving->user->last_name }}</p>
                            <p><strong>Points Earned (Last 7 Days):</strong> {{ $mostDeserving->pointsEarned }}</p>
                        </div>

                        <!-- Reward Button -->
                        <button onclick="openRewardModal()"
                            class="mt-3 px-4 py-2 bg-[#4A6613] text-white rounded hover:bg-[#95a379] ">
                            Give Reward
                        </button>

                    </div>


                <!-- Total Verified Users -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Total Verified Users</h3>
                        <i class="fa-solid fa-users text-[#7F8A4F] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]" id="verifiedUsersCount">{{ $verifiedUsers }}</div>
                        <div class="metric-subtext" id="totalUsersText">/{{ $totalUsers }} total users</div>
                    </div>
                    <div class="metric-trend positive" id="userGrowthTrend">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span id="userGrowthText">+{{ $userGrowth }}% vs last week</span>
                    </div>
                </div>

                <!-- Pending Submissions - URGENT -->
                <div class="metric-card urgent">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Pending Submissions</h3>
                        <i class="fa-solid fa-inbox text-[#D97706] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#D97706]" id="pendingSubmissionsCount">{{ $pendingSubmissions }}
                        </div>
                        <div class="metric-subtext italic">
                            "Behind every submission is someone choosing sustainability."
                        </div>
                    </div>
                    <div class="metric-trend warning" id="overdueSubmissions">
                        <i class="fa-solid fa-clock"></i>
                        <span id="overdueCount">{{ $overdueSubmissions }}</span> overdue
                    </div>
                </div>

                <!-- Active Quests -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Active Quests</h3>
                        <i class="fa-solid fa-bullseye text-[#7F8A4F] text-lg"></i>
                    </div>

                    <div class="metric-value text-[#4F6B3F] mt-2" id="totalQuestsCount">{{ $liveQuests }}</div>
                </div>

                <!-- Vouchers Redeemed -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Vouchers Redeemed</h3>
                        <i class="fa-solid fa-gift text-[#7F8A4F] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]" id="vouchersRedeemedCount">{{ $vouchersThisWeek }}</div>
                        <div class="metric-subtext" id="vouchersPeriod">this week</div>
                    </div>
                    <div class="metric-trend positive" id="voucherGrowthTrend">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span id="voucherGrowthText">{{ $voucherGrowth }} vs last week</span>
                    </div>
                </div>

                <!-- 🟡 SECONDARY CARDS (Bottom Row) -->

                <!-- Average Daily Eco-Actions -->
                <div class="metric-card lg:col-span-2">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Avg. Daily Eco-Taps</h3>
                        <i class="fa-solid fa-chart-bar text-[#7F8A4F] text-lg"></i>
                    </div>
                    <div class="mt-4">

                        <div class="flex justify-between items-end mb-3">
                            <div class="metric-value text-[#4F6B3F]">
                                {{ number_format($avgDailyEcoActions, 1) }}
                            </div>

                            <div class="metric-trend positive">
                                <i class="fa-solid fa-arrow-up"></i>
                                <span>from {{ $ecoActionsPrev7 }} last week</span>
                            </div>
                        </div>

                        <!-- SVG Line Chart -->
                        @php
                            // Prepare values for line chart
                            $max = max($ecoActionsDaily) ?: 1;
                            $points = [];
                            $w = 260; // width
                            $h = 100; // height
                            $step = $w / (count($ecoActionsDaily) - 1);

                            foreach ($ecoActionsDaily as $i => $v) {
                                $x = $i * $step;
                                $y = $h - ($v / $max) * $h;
                                $points[] = "$x,$y";
                            }
                        @endphp

                        <div class="relative w-full flex justify-center">
                            <svg width="100%" height="120" viewBox="0 0 {{ $w }} 120"
                                class="overflow-visible">

                                <!-- Grid lines -->
                                <line x1="0" y1="100" x2="{{ $w }}" y2="100"
                                    stroke="#dee2d6" stroke-width="1" />
                                <line x1="0" y1="50" x2="{{ $w }}" y2="50"
                                    stroke="#edf0e6" stroke-width="1" />

                                <!-- Line Path -->
                                <polyline fill="none" stroke="#7F8A4F" stroke-width="3"
                                    points="{{ implode(' ', $points) }}" stroke-linecap="round" stroke-linejoin="round">
                                </polyline>

                                <!-- Points with hover tooltips -->
                                @foreach ($points as $i => $p)
                                    @php [$x, $y] = explode(',', $p); @endphp

                                    <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="#7F8A4F">
                                        <title>{{ $ecoActionsDaily[$i] }} taps</title>
                                    </circle>
                                @endforeach

                            </svg>
                        </div>

                        <!-- Day Labels -->
                        <div class="flex justify-between text-xs text-[#4F6B3F] mt-2 px-1">
                            @foreach ($dayLabels as $d)
                                <span>{{ $d }}</span>
                            @endforeach
                        </div>

                    </div>

                </div>

                <!-- Points Distributed -->
                <div class="metric-card lg:col-span-2">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Points Distributed</h3>
                        <i class="fa-solid fa-coins text-[#C37A49] text-lg"></i>
                    </div>

                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]">
                            {{ $pointsDistributed }} pts
                        </div>
                        <div class="metric-subtext" id="pointsPeriod">for the last 7 days</div>

                        <!-- SVG Line Chart for Points -->
                        @php
                            $maxPoints = max($pointsDaily) ?: 1;
                            $pointsCoords = [];
                            $w = 260;
                            $h = 100;
                            $step = $w / (count($pointsDaily) - 1);

                            foreach ($pointsDaily as $i => $v) {
                                $x = $i * $step;
                                $y = $h - ($v / $maxPoints) * $h;
                                $pointsCoords[] = "$x,$y";
                            }
                        @endphp

                        <div class="relative w-full flex justify-center mt-4">
                            <svg width="100%" height="120" viewBox="0 0 {{ $w }} 120"
                                class="overflow-visible">

                                <!-- Grid lines -->
                                <line x1="0" y1="100" x2="{{ $w }}" y2="100"
                                    stroke="#e2dcdc" stroke-width="1" />
                                <line x1="0" y1="50" x2="{{ $w }}" y2="50"
                                    stroke="#f4f1f1" stroke-width="1" />

                                <!-- Line Path -->
                                <polyline fill="none" stroke="#C37A49" stroke-width="3"
                                    points="{{ implode(' ', $pointsCoords) }}" stroke-linecap="round"
                                    stroke-linejoin="round"></polyline>

                                <!-- Points with tooltips -->
                                @foreach ($pointsCoords as $i => $p)
                                    @php [$x, $y] = explode(',', $p); @endphp
                                    <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="#C37A49">
                                        <title>{{ $pointsDaily[$i] }} pts</title>
                                    </circle>
                                @endforeach

                            </svg>
                        </div>

                        <!-- Day Labels -->
                        <div class="flex justify-between text-xs text-[#4F3B2C] mt-2 px-1">
                            @foreach ($dayLabels as $d)
                                <span>{{ $d }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Points Redeemed -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Points Redeemed</h3>
                        <i class="fa-solid fa-gift text-[#D97706] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between items-end mb-3">
                            <div class="metric-value text-[#D97706]">{{ $pointsRedeemed }} pts</div>
                            <div class="metric-subtext">redeemed in the last 7 days</div>
                        </div>

                        <!-- Dynamic bar chart -->
                        <div class="h-28 flex items-end justify-center space-x-3">
                            @php $max = max($pointsRedeemedDaily) ?: 1; @endphp

                            @foreach ($pointsRedeemedDaily as $i => $value)
                                @php $height = ($value / $max) * 100; @endphp

                                <div class="flex flex-col items-center">
                                    <div class="relative group">
                                        <!-- Bar -->
                                        <div class="w-5 bg-[#D97706] rounded transition-all duration-500"
                                            style="height: {{ $height }}px">
                                        </div>

                                        <!-- Tooltip -->
                                        <span
                                            class="absolute -top-6 left-1/2 -translate-x-1/2
                             px-2 py-1 text-xs rounded bg-black text-white opacity-0 
                             group-hover:opacity-100 transition">{{ $value }}
                                            pts</span>
                                    </div>

                                    <!-- Day Label -->
                                    <div class="text-xs mt-1 text-[#4F3B2C]">{{ $dayLabels[$i] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </section>


        <!-- Example of how to update dynamically later -->
        <script>
            // This is just a template - won't run until you add backend data
            function updateDashboardData(data) {
                // Example updates:
                document.getElementById('verifiedUsersCount').textContent = data.verifiedUsers;
                document.getElementById('pendingSubmissionsCount').textContent = data.pendingSubmissions;
                document.getElementById('overdueCount').textContent = data.overdueCount;
                // ... and so on for all elements with IDs
            }
        </script>

        <style>
            /* Chart bars animation for when data loads */
            .bar-1,
            .bar-2,
            .bar-3,
            .bar-4,
            .bar-5,
            .bar-6 {
                transition: all 0.5s ease-in-out;
            }

            /* For dynamic data updates */
            .metric-value,
            .metric-subtext,
            .metric-trend span {
                transition: all 0.3s ease;
            }

            /* Metric Card Styles */
            .metric-card {
                background: white;
                border-radius: 1rem;
                padding: 1.5rem;
                border: 1px solid #E6EAD7;
                box-shadow: 0 2px 8px rgba(79, 107, 63, 0.08);
                transition: all 0.3s ease;
            }

            .metric-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(79, 107, 63, 0.12);
            }

            .metric-card.urgent {
                border-left: 4px solid #FEF3C7;
            }

            .metric-title {
                font-size: 0.95rem;
                font-weight: 600;
                color: #4F6B3F;
                margin: 0;
            }

            .metric-value {
                font-size: 2.5rem;
                font-weight: 700;
                line-height: 1;
            }

            .metric-subtext {
                font-size: 0.875rem;
                color: #6A8A52;
                margin-top: 0.25rem;
            }

            .metric-trend {
                display: inline-flex;
                align-items: center;
                gap: 0.25rem;
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
                border-radius: 1rem;
                margin-top: 0.5rem;
            }

            .metric-trend.positive {
                background: #F0F7E6;
                color: #4F6B3F;
            }

            .metric-trend.warning {
                background: #FEF3C7;
                color: #D97706;
            }

            /* Quest Funnel Styles */
            .quest-funnel-item {
                padding: 0.5rem 0.75rem;
                background: #F7F9F3;
                border-radius: 0.75rem;
                font-size: 0.875rem;
                text-align: center;
                transition: all 0.2s ease;
            }

            .quest-funnel-item.active {
                background: #4F6B3F;
                color: white;
                font-weight: 600;
            }



            /* Responsive Design */
            @media (max-width: 768px) {
                .metric-value {
                    font-size: 2rem;
                }

                .btn-eco {
                    padding: 0.6rem 1.2rem;
                    font-size: 0.9rem;
                }
            }

            @media (max-width: 480px) {
                .metric-card {
                    padding: 1rem;
                }

                .btn-eco {
                    padding: 0.75rem;
                    min-width: 3rem;
                }
            }
        </style>

        @include('modal.createQuestModal')
    @endsection
