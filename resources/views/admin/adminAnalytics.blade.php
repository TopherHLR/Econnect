@extends('layouts.adminLayout')

@section('title', 'Admin Analytics')

@section('content')
    @include('modal.AddVoucherModal')
    @include('modal.deservingPlayerModal')
    <div class="space-y-6 ">
        <!-- ===== PAGE NAVIGATION TABS ===== -->
        <div class="page-navigation">
            <div class="flex justify-between items-center gap-2 border-b border-[#E6EAD7] mb-3">
                <!-- Left Tabs -->
                <div class="flex gap-2">
                    <button onclick="switchPage(1)" id="page1-tab" class="page-tab page-tab-active">
                        <i class="fa-solid fa-chart-line mr-3"></i>
                        Analytics Dashboard
                    </button>
                    <button onclick="switchPage(2)" id="page2-tab" class="page-tab">
                        <i class="fa-solid fa-trophy mr-2"></i>
                        Leaderboards
                    </button>
                </div>

                <!-- Right Date -->
                <div class="text-sm text-[#6A8A52] flex items-center">
                    <i class="fa-solid fa-calendar-alt mr-2"></i>
                    Updated {{ now()->format('M d, Y') }}
                </div>
            </div>
        </div>


        <!-- ===== PAGE 1: ANALYTICS DASHBOARD ===== -->
        <div id="page1-content" class="page-content active">

            <!-- 📊 METRICS DASHBOARD SECTION -->
            <section>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-8 gap-6">
                    <!-- 🟢 HIGH PRIORITY CARDS (Top Row) -->

                        <div class="metric-card">
                            <h3 class="metric-title">Most Deserving Player</h3>

                            <div class="mt-2">
                                <p><strong>Name:</strong> {{ $mostDeserving->user->first_name }}
                                    {{ $mostDeserving->user->last_name }}</p>
                                <p><strong>Points Earned (Last 7 Days):</strong> {{ $mostDeserving->pointsEarned }}</p>
                            </div>

                            <!-- Reward Button -->
                            <button onclick="openRewardModal()"
                                class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
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
                            <i class="fa-solid fa-inbox text-[#DC2626] text-lg"></i>
                        </div>
                        <div class="mt-4">
                            <div class="metric-value text-[#DC2626]" id="pendingSubmissionsCount">
                                {{ $pendingSubmissions }}
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
                            <div class="metric-value text-[#4F6B3F]" id="vouchersRedeemedCount">{{ $vouchersThisWeek }}
                            </div>
                            <div class="metric-subtext" id="vouchersPeriod">this week</div>
                        </div>
                        <div class="metric-trend positive" id="voucherGrowthTrend">
                            <i class="fa-solid fa-arrow-up"></i>
                            <span id="voucherGrowthText">{{ $voucherGrowth }} vs last week</span>
                        </div>
                    </div>

                    <!-- 🟡 SECONDARY CARDS (Bottom Row) -->
                    <!-- Feedback -->
                    <div class="metric-card">
                        <div class="flex justify-between items-start">
                            <h3 class="metric-title">New Feedback</h3>
                            <i class="fa-solid fa-comment text-[#7F8A4F] text-lg"></i>
                        </div>
                        <div class="mt-4">
                            <div class="metric-value text-[#4F6B3F]" id="newFeedbackCount">{{ $newFeedbackCount }}
                            </div>
                            <div class="metric-subtext" id="feedbackStatus">awaiting review</div>
                        </div>
                    </div>

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
                                        points="{{ implode(' ', $points) }}" stroke-linecap="round"
                                        stroke-linejoin="round">
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
                    <div class="metric-card lg:col-span-2">
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


                </div>
            </section>

        </div>

        <!-- ===== PAGE 2: LEADERBOARDS ===== -->
        <div id="page2-content" class="page-content">
            <div class="space-y-8">
                <!-- ===== ENHANCED LEADERBOARDS SECTION ===== -->
                <section class="mt-3">
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-6 gap-6">

                        <!-- Most Active Users Card -->
                        <div class="leaderboard-card">
                            <div class="leaderboard-header">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-fire text-[#DC2626]"></i>
                                    <h3 class="leaderboard-title">Most Active Users</h3>
                                </div>
                                <span class="leaderboard-subtitle">Total Activities Completed</span>
                            </div>
                            <div class="leaderboard-content">
                                @foreach ($topActiveUsers as $rank => $entry)
                                    <div class="leaderboard-item {{ $rank < 3 ? 'top-three' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="rank-badge rank-{{ $rank + 1 }}">
                                                {{ $rank + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-xs text-[#4F6B3F]">
                                                    {{ $entry->user->first_name }} {{ $entry->user->last_name }}
                                                </div>
                                                <div class="text-[10px] text-[#6A8A52]">
                                                    User ID: {{ $entry->user->user_id }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leaderboard-value">
                                            {{ $entry->activityCount }}
                                            <span class="text-sm text-[#6A8A52] ml-1">activities</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Top Points Earned Card -->
                        <div class="leaderboard-card">
                            <div class="leaderboard-header">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-coins text-[#C37A49]"></i>
                                    <h3 class="leaderboard-title">Top Points Earned</h3>
                                </div>
                                <span class="leaderboard-subtitle">All Time Total</span>
                            </div>
                            <div class="leaderboard-content">
                                @foreach ($topByPoints as $rank => $entry)
                                    <div class="leaderboard-item {{ $rank < 3 ? 'top-three' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="rank-badge rank-{{ $rank + 1 }}">
                                                {{ $rank + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-xs text-[#4F6B3F]">
                                                    {{ $entry->user->first_name }} {{ $entry->user->last_name }}
                                                </div>
                                                <div class="text-[10px] text-[#6A8A52]">
                                                    {{ $entry->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leaderboard-value">
                                            {{ number_format($entry->progressPoints) }}
                                            <span class="text-sm text-[#6A8A52] ml-1">pts</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Top Completed Quests Card -->
                        <div class="leaderboard-card">
                            <div class="leaderboard-header">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-check-circle text-[#4F6B3F]"></i>
                                    <h3 class="leaderboard-title">Top Quest Completers</h3>
                                </div>
                                <span class="leaderboard-subtitle">Quests Completed</span>
                            </div>
                            <div class="leaderboard-content">
                                @foreach ($topByQuests as $rank => $entry)
                                    <div class="leaderboard-item {{ $rank < 3 ? 'top-three' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="rank-badge rank-{{ $rank + 1 }}">
                                                {{ $rank + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-xs text-[#4F6B3F]">
                                                    {{ $entry->user->first_name }} {{ $entry->user->last_name }}
                                                </div>
                                                <div class="text-[10px] text-[#6A8A52]">
                                                    Completion Rate:
                                                    {{ round(($entry->questsCompleted / $totalQuests) * 100) }}%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leaderboard-value">
                                            {{ $entry->questsCompleted }}
                                            <span class="text-sm text-[#6A8A52] ml-1">quests</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Top Daily Eco Actions Card -->
                        <div class="leaderboard-card">
                            <div class="leaderboard-header">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-bolt text-[#7F8A4F]"></i>
                                    <h3 class="leaderboard-title">Top Daily Eco Actions</h3>
                                </div>
                                <span class="leaderboard-subtitle">Daily Activity Average</span>
                            </div>
                            <div class="leaderboard-content">
                                @foreach ($topDailyActions as $rank => $entry)
                                    <div class="leaderboard-item {{ $rank < 3 ? 'top-three' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="rank-badge rank-{{ $rank + 1 }}">
                                                {{ $rank + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-xs text-[#4F6B3F]">
                                                    {{ $entry->user->first_name }} {{ $entry->user->last_name }}
                                                </div>
                                                <div class="text-[10px] text-[#6A8A52]">
                                                    {{ $entry->user->created_at->format('M Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leaderboard-value">
                                            {{ $entry->dailyEcoActions }}
                                            <span class="text-sm text-[#6A8A52] ml-1">actions/day</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Top Library Savers Card -->
                        <div class="leaderboard-card">
                            <div class="leaderboard-header">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-bookmark text-[#4F6B3F]"></i>
                                    <h3 class="leaderboard-title">Top Library Savers</h3>
                                </div>
                                <span class="leaderboard-subtitle">Resources Bookmarked</span>
                            </div>
                            <div class="leaderboard-content">
                                @foreach ($topLibrarySavers as $rank => $entry)
                                    <div class="leaderboard-item {{ $rank < 3 ? 'top-three' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="rank-badge rank-{{ $rank + 1 }}">
                                                {{ $rank + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-xs text-[#4F6B3F]">
                                                    {{ $entry->user->first_name }} {{ $entry->user->last_name }}
                                                </div>
                                                <div class="text-[10px] text-[#6A8A52]">
                                                    Learner Level: {{ $rank < 3 ? 'Expert' : 'Advanced' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leaderboard-value">
                                            {{ $entry->librarySaves }}
                                            <span class="text-sm text-[#6A8A52] ml-1">saves</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Top Voucher Redeemers Card -->
                        <div class="leaderboard-card">
                            <div class="leaderboard-header">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-gift text-[#C37A49]"></i>
                                    <h3 class="leaderboard-title">Top Voucher Redeemers</h3>
                                </div>
                                <span class="leaderboard-subtitle">Rewards Claimed</span>
                            </div>
                            <div class="leaderboard-content">
                                @foreach ($topVoucherRedeemers as $rank => $entry)
                                    <div class="leaderboard-item {{ $rank < 3 ? 'top-three' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="rank-badge rank-{{ $rank + 1 }}">
                                                {{ $rank + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-[#4F6B3F]">
                                                    {{ $entry->user->first_name }} {{ $entry->user->last_name }}
                                                </div>
                                                <div class="text-xs text-[#6A8A52]">
                                                    Points Spent: {{ number_format($entry->vouchersRedeemed * 100) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="leaderboard-value">
                                            {{ $entry->vouchersRedeemed }}
                                            <span class="text-sm text-[#6A8A52] ml-1">vouchers</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- ===== CATEGORY & WEEKLY PERFORMANCE SECTION ===== -->
                    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mt-2">

                        <!-- Top Points Last 7 Days Card -->
                        <div class="weekly-card">
                            <div class="weekly-scroll">
                                <div class="flex justify-between items-center mb-1">
                                    <div>
                                        <h3 class="text-lg font-bold text-[#4F6B3F]">Weekly Leaders</h3>
                                        <p class="text-sm text-[#6A8A52]">Top Points Earned (Last 7 Days)</p>
                                    </div>
                                    <div class="px-3 py-1 bg-[#7F8A4F] text-white text-sm rounded-full">
                                        This Week
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    @foreach ($topPointsLast7Days as $rank => $entry)
                                        <div class="weekly-item">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="weekly-rank">{{ $rank + 1 }}</div>
                                                    <div>
                                                        <div class="font-medium text-[#4F6B3F]">
                                                            {{ $entry->user->first_name }} {{ $entry->user->last_name }}
                                                        </div>
                                                        <div class="text-xs text-[#6A8A52]">
                                                            {{ $entry->pointsEarned / 7 }} pts/day average
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="weekly-points">
                                                    {{ $entry->pointsEarned }}
                                                    <span class="text-sm text-[#6A8A52]">pts</span>
                                                </div>
                                            </div>
                                            <!-- Progress Bar -->
                                            @php
                                                $maxPoints =
                                                    max(array_column($topPointsLast7Days->toArray(), 'pointsEarned')) ?:
                                                    1;
                                                $percentage = ($entry->pointsEarned / $maxPoints) * 100;
                                            @endphp
                                            <div class="mt-2">
                                                <div class="progress-bar">
                                                    <div class="progress-fill" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>


    <style>
        /* ===== ECO NAVIGATION STYLES ===== */
        .page-navigation {
            top: 0;
            z-index: 50;
            background: #FCF9EF;
        }

        /* Tab Buttons */
        .page-tab {
            @apply text-sm font-medium;
            color: #6A8A52;
            padding: 0.65rem 1.25rem;
            border-radius: 0.75rem;
            transition:
                background 0.25s ease,
                color 0.25s ease,
                transform 0.2s ease;
        }

        .page-tab:hover {
            background: #E9F2DB;
            color: #4F6B3F;
            transform: translateY(-1px);
            box-shadow: 0 1px 4px rgba(79, 107, 63, 0.15);
        }

        /* Active Tab */
        .page-tab-active {
            background: #4F6B3F;
            color: #FCF9EF;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(79, 107, 63, 0.28);
        }

        /* Remove bottom border line style */
        .page-tab-active:hover {
            background: #4F6B3F;
        }

        /* Page Content Animation */
        .page-content {
            display: none;
            opacity: 0;
            transform: translateY(12px);
            transition: opacity 0.35s ease, transform 0.35s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .page-content.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }


        /* ===== EXISTING STYLES (KEEP ALL YOUR ORIGINAL STYLES) ===== */
        /* Button Styles */
        .btn-eco {
            @apply px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .btn-sage {
            @apply bg-[#7A8C4F] text-white hover:bg-[#6A7A45] focus:ring-[#7A8C4F];
        }

        .compact {
            @apply px-3 py-2;
        }

        /* Custom scrollbar styling */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #7A8C4F;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #6B7B43;
        }

        /* Table scroll styling */
        .h-64::-webkit-scrollbar {
            width: 6px;
        }

        .h-64::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .h-64::-webkit-scrollbar-thumb {
            background: #7A8C4F;
            border-radius: 3px;
        }

        /* Metric Card Styles */
        .metric-card {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
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
            font-size: 1rem;
            font-weight: 620;
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

        /* LEADERBOARD STYLES */
        .leaderboard-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #E6EAD7;
            box-shadow: 0 2px 12px rgba(79, 107, 63, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .leaderboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(79, 107, 63, 0.12);
        }

        .leaderboard-header {
            background: linear-gradient(135deg, #F0F7E6 0%, #E6F0E0 100%);
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid #E6EAD7;
        }

        .leaderboard-title {
            font-size: 1rem;
            font-weight: 700;
            color: #4F6B3F;
        }

        .leaderboard-subtitle {
            font-size: 0.875rem;
            color: #6A8A52;
            margin-top: 0.25rem;
        }

        .leaderboard-content {
            padding: 0.75rem;
            max-height: 270px;
            overflow-y: auto;
        }

        .leaderboard-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .leaderboard-item:hover {
            background: #F9FBFF;
            border-color: #E6EAD7;
        }

        .leaderboard-item.top-three {
            background: linear-gradient(135deg, #F9FBFF 0%, #F0F7E6 100%);
            border: 1px solid #E6EAD7;
        }

        .rank-badge {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .rank-1 {
            background: linear-gradient(135deg, #FFD700 0%, #FFED4E 100%);
            color: #8B6508;
            border: 2px solid #FFD700;
        }

        .rank-2 {
            background: linear-gradient(135deg, #C0C0C0 0%, #E8E8E8 100%);
            color: #5A5A5A;
            border: 2px solid #C0C0C0;
        }

        .rank-3 {
            background: linear-gradient(135deg, #CD7F32 0%, #E8B886 100%);
            color: #8B4513;
            border: 2px solid #CD7F32;
        }

        .rank-4,
        .rank-5,
        .rank-6 {
            background: #F0F7E6;
            color: #6A8A52;
            border: 1px solid #E6EAD7;
        }

        .leaderboard-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #4F6B3F;
            text-align: right;
        }

        /* Weekly Performance Card */
        .weekly-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #E6EAD7;
            box-shadow: 0 2px 12px rgba(79, 107, 63, 0.08);
            padding: 1.5rem;
            max-height: 260px;
            /* optional */
        }

        /* Scroll Container */
        .weekly-scroll {
            max-height: 220px;
            /* adjust as needed */
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 4px;
            /* prevent scrollbar overlap */
        }

        /* Items */
        .weekly-item {
            padding: 1rem;
            border-radius: 0.75rem;
            background: #F9FBFF;
            margin-bottom: 0.5rem;
            border: 1px solid #E6EAD7;
        }

        /* Rank Badge */
        .weekly-rank {
            width: 36px;
            height: 36px;
            background: #4F6B3F;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        /* Pretty Scrollbar (optional) */
        .weekly-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .weekly-scroll::-webkit-scrollbar-thumb {
            background: #4F6B3F;
            border-radius: 4px;
        }

        .weekly-scroll::-webkit-scrollbar-track {
            background: #E6EAD7;
        }


        .weekly-points {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4F6B3F;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #E6EAD7;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #7F8A4F 0%, #4F6B3F 100%);
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        /* Custom scrollbar for leaderboard content */
        .leaderboard-content::-webkit-scrollbar {
            width: 6px;
        }

        .leaderboard-content::-webkit-scrollbar-track {
            background: #F0F7E6;
            border-radius: 3px;
        }

        .leaderboard-content::-webkit-scrollbar-thumb {
            background: #7F8A4F;
            border-radius: 3px;
        }

        .leaderboard-content::-webkit-scrollbar-thumb:hover {
            background: #6B7B43;
        }
    </style>

    <!-- ===== JAVASCRIPT FOR PAGE SWITCHING ===== -->
    <script>
        // Page switching functionality
        function switchPage(pageNumber) {
            // Hide all pages
            document.querySelectorAll('.page-content').forEach(page => {
                page.classList.remove('active');
            });

            // Remove active class from all tabs
            document.querySelectorAll('.page-tab').forEach(tab => {
                tab.classList.remove('page-tab-active');
            });

            // Show selected page
            document.getElementById(`page${pageNumber}-content`).classList.add('active');

            // Activate selected tab
            document.getElementById(`page${pageNumber}-tab`).classList.add('page-tab-active');

        }

        // Initialize first page as active
        document.addEventListener('DOMContentLoaded', function() {
            switchPage(1);
        });

        // Optional: Add keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                if (event.key === '1') {
                    event.preventDefault();
                    switchPage(1);
                } else if (event.key === '2') {
                    event.preventDefault();
                    switchPage(2);
                }
            }
        });

        // Optional: Save last viewed page in localStorage
        function saveCurrentPage(pageNumber) {
            if (typeof(Storage) !== "undefined") {
                localStorage.setItem('adminAnalyticsPage', pageNumber);
            }
        }

        function loadLastPage() {
            if (typeof(Storage) !== "undefined") {
                const lastPage = localStorage.getItem('adminAnalyticsPage');
                if (lastPage) {
                    switchPage(parseInt(lastPage));
                }
            }
        }

        // Uncomment to enable page persistence
        // document.addEventListener('DOMContentLoaded', loadLastPage);
    </script>

    <!-- Add this to your layout file or before the closing </body> tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


@endsection
