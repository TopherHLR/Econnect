@extends('layouts.adminLayout')

@section('title', 'Home')

@section('content')
    <div class="space-y-6">
        <!-- Header Section with ALL Quick Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Admin Dashboard</h1>
                <p class=" font-sans  text-[#6A8A52] mt-1">Welcome back! Here's your platform overview.</p>
            </div>

            <!-- ALL Quick Actions - Compact, beside header -->
            <div class="flex flex-wrap gap-2 justify-end">
                <!-- Primary Actions -->
                <button onclick="openQuestModal()" class="btn-eco btn-mint compact" title="Create New Quest">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span class="hidden lg:inline">New Quest</span>
                </button>
                <button onclick="openEcoTopicModal()" class="btn-eco btn-leaf compact" title="Add Eco Topic">
                    <i class="fa-solid fa-leaf"></i>
                    <span class="hidden lg:inline">Eco Topic</span>
                </button>
                <button onclick="openEcoActionModal()" class="btn-eco btn-olive compact" title="Add Eco Action">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span class="hidden lg:inline">Eco Action</span>
                </button>

                <!-- Secondary Actions -->
                <button onclick="openVerifyModal()" class="btn-eco btn-sand compact" title="Verify User">
                    <i class="fa-solid fa-qrcode"></i>
                    <span class="hidden xl:inline">Verify</span>
                </button>
                <button onclick="openUserQrScannerModal()" class="btn-eco btn-leaf compact" title="Scan User QR">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="hidden xl:inline">Scan QR</span>
                </button>
            </div>
        </div>

        <!-- 📊 METRICS DASHBOARD SECTION -->
        <section>
            <h2 class="text-xl font-semibold text-[#4F6B3F] mb-6 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-[#7F8A4F]"></i>
                Platform Metrics
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- 🟢 HIGH PRIORITY CARDS (Top Row) -->

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
                        <i class="fa-solid fa-inbox text-[#DC2626] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#DC2626]" id="pendingSubmissionsCount">{{ $pendingSubmissions }}
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
                    <div class="metric-value text-[#4F6B3F] mt-2" id="totalQuestsCount">{{ $totalQuests }}</div>
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
                <div class="metric-card">
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
                        <i class="fa-solid fa-gift text-[#DC2626] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between items-end mb-3">
                            <div class="metric-value text-[#DC2626]">{{ $pointsRedeemed }} pts</div>
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
                                        <div class="w-5 bg-[#DC2626] rounded transition-all duration-500"
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

                <!-- Quests Accomplished -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Quests Accomplished</h3>
                        <i class="fa-solid fa-check-circle text-[#4F6B3F] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]">{{ $questsAccomplished }}</div>
                    </div>
                </div>

                <!-- Vouchers Used -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Vouchers Used</h3>
                        <i class="fa-solid fa-ticket text-[#4F6B3F] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]">{{ $vouchersUsed }}</div>
                    </div>
                </div>
                <div class="metric-card"">
                    <h2 class="text-2xl font-bold text-green-800 mb-6">Top Active Users</h2>

                    <div class="grid grid-cols-3 text-center text-xl font-semibold text-black border-b pb-3 mb-3">
                        <p>Rank</p>
                        <p>User</p>
                        <p>Total Activities</p>
                    </div>

                    @foreach ($topActiveUsers as $index => $entry)
                        <div class="grid grid-cols-3 text-center py-3 border-b hover:bg-green-50 cursor-pointer"
                            onclick="window.location='{{ route('myprogress') }}'">
                            <p class="font-semibold">{{ $index + 1 }}</p>
                            <p>{{ $entry->user->first_name }} {{ $entry->user->last_name }}</p>
                            <p class="font-semibold text-green-800">{{ $entry->activityCount }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Total Active Users -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Total Active Users</h3>
                        <i class="fa-solid fa-users text-[#7F8A4F] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]">
                            {{ $topActiveUsers->count() }} <!-- Count of active users in leaderboard -->
                        </div>
                    </div>
                </div>

                <!-- Most Saved Category -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">Most Saved Category</h3>
                        <i class="fa-solid fa-layer-group text-[#4F6B3F] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]">{{ $mostCategorySavedName }}</div>
                    </div>
                </div>

                <!-- Feedback -->
                <div class="metric-card">
                    <div class="flex justify-between items-start">
                        <h3 class="metric-title">New Feedback</h3>
                        <i class="fa-solid fa-comment text-[#7F8A4F] text-lg"></i>
                    </div>
                    <div class="mt-4">
                        <div class="metric-value text-[#4F6B3F]" id="newFeedbackCount">{{ $newFeedbackCount }}</div>
                        <div class="metric-subtext" id="feedbackStatus">awaiting review</div>
                    </div>
                </div>

            </div>
            <!-- ===== Leaderboards Section ===== -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">

                <!-- Most Active Users -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Most Active Users</h3>
                    <ul class="space-y-2">
                        @foreach ($topActiveUsers as $rank => $entry)
                            <li class="flex justify-between items-center">
                                <span>{{ $rank + 1 }}. {{ $entry->user->first_name }}
                                    {{ $entry->user->last_name }}</span>
                                <span class="font-semibold">{{ $entry->activityCount }} activities</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Top Points Earned -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Top Points Earned (All Time)</h3>
                    <ul class="space-y-2">
                        @foreach ($topByPoints as $rank => $entry)
                            <li class="flex justify-between items-center">
                                <span>{{ $rank + 1 }}. {{ $entry->user->first_name }}
                                    {{ $entry->user->last_name }}</span>
                                <span class="font-semibold">{{ $entry->progressPoints }} pts</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Top Completed Quests -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Top Quest Completers</h3>
                    <ul class="space-y-2">
                        @foreach ($topByQuests as $rank => $entry)
                            <li class="flex justify-between items-center">
                                <span>{{ $rank + 1 }}. {{ $entry->user->first_name }}
                                    {{ $entry->user->last_name }}</span>
                                <span class="font-semibold">{{ $entry->questsCompleted }} quests</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Top Daily Eco Actions -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Top Daily Eco Actions</h3>
                    <ul class="space-y-2">
                        @foreach ($topDailyActions as $rank => $entry)
                            <li class="flex justify-between items-center">
                                <span>{{ $rank + 1 }}. {{ $entry->user->first_name }}
                                    {{ $entry->user->last_name }}</span>
                                <span class="font-semibold">{{ $entry->dailyEcoActions }} actions</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Top Library Savers -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Top Library Savers</h3>
                    <ul class="space-y-2">
                        @foreach ($topLibrarySavers as $rank => $entry)
                            <li class="flex justify-between items-center">
                                <span>{{ $rank + 1 }}. {{ $entry->user->first_name }}
                                    {{ $entry->user->last_name }}</span>
                                <span class="font-semibold">{{ $entry->librarySaves }} saves</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Top Voucher Redeemers -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Top Voucher Redeemers</h3>
                    <ul class="space-y-2">
                        @foreach ($topVoucherRedeemers as $rank => $entry)
                            <li class="flex justify-between items-center">
                                <span>{{ $rank + 1 }}. {{ $entry->user->first_name }}
                                    {{ $entry->user->last_name }}</span>
                                <span class="font-semibold">{{ $entry->vouchersRedeemed }} vouchers</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Most Saved Library Category -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Most Saved Library Category</h3>
                    <div class="text-[#4F6B3F] font-semibold text-center">{{ $mostCategorySavedName }}</div>
                </div>

                <!-- Top Points Earned (Last 7 Days) -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-bold text-[#4F6B3F] mb-3">Top Points Earned (Last 7 Days)</h3>
                    <ul class="space-y-2">
                        @foreach ($topPointsLast7Days as $rank => $entry)
                            <li class="flex justify-between items-center">
                                <span>{{ $rank + 1 }}. {{ $entry->user->first_name }}
                                    {{ $entry->user->last_name }}</span>
                                <span class="font-semibold">{{ $entry->pointsEarned }} pts</span>
                            </li>
                        @endforeach
                    </ul>
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
                border-left: 4px solid #DC2626;
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

            /* Your Original Button Styles - Preserved */
            .btn-eco {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                font-size: 1rem;
                padding: 0.75rem 1.5rem;
                border-radius: 1.5rem;
                transform: translateY(0);
                transition: all 0.3s ease-out;
                cursor: pointer;
                font-weight: 500;
                border: none;
                outline: none;
                min-width: fit-content;
            }

            .btn-eco {
                box-shadow:
                    inset 2px 2px 4px rgba(140, 160, 130, 0.25),
                    inset -2px -2px 4px rgba(255, 255, 255, 0.6);
            }

            .btn-eco:hover {
                transform: translateY(-1px);
                box-shadow:
                    -2px -2px 4px rgba(255, 255, 255, 0.7),
                    2px 2px 4px rgba(160, 180, 150, 0.25);
                filter: brightness(1.03);
            }

            .btn-eco:active {
                transform: translateY(1px);
                box-shadow:
                    inset 3px 3px 5px rgba(120, 140, 110, 0.3),
                    inset -2px -2px 4px rgba(255, 255, 255, 0.5);
                filter: brightness(0.97);
            }

            .btn-mint {
                background: rgba(122, 140, 79, 0.95);
                color: white;
            }

            .btn-leaf {
                background: rgba(106, 138, 82, 0.9);
                color: white;
            }

            .btn-olive {
                background: rgba(127, 138, 79, 0.9);
                color: white;
            }

            .btn-sand {
                background: rgba(195, 122, 73, 0.1);
                color: #4F6B3F;
            }

            .btn-sage {
                background: rgba(79, 107, 63, 0.1);
                color: #4F6B3F;
            }

            .btn-clay {
                background: rgba(195, 122, 73, 0.15);
                color: #A46C47;
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
