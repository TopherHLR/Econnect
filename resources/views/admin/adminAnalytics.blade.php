@extends('layouts.adminLayout')

@section('title', 'Admin Analytics')

@section('content')
    <div class="space-y-6">
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
    </div>

    <style>
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
    </style>
    <!-- Add this to your layout file or before the closing </body> tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Optional: Add smooth scrolling and navigation indicators
        document.addEventListener('DOMContentLoaded', function() {
            const scrollContainer = document.querySelector('.overflow-x-auto');

            // Add navigation buttons (optional enhancement)
            const navButtons = `
        <div class="flex justify-center gap-2 mt-4">
            <button onclick="scrollGraphs(-1)" class="px-4 py-2 bg-[#7A8C4F] text-white rounded-full text-sm hover:bg-[#6B7B43] transition">Previous</button>
            <button onclick="scrollGraphs(1)" class="px-4 py-2 bg-[#7A8C4F] text-white rounded-full text-sm hover:bg-[#6B7B43] transition">Next</button>
        </div>
    `;

            // Uncomment below if you want navigation buttons
            // scrollContainer.parentNode.insertAdjacentHTML('afterend', navButtons);
        });

        function scrollGraphs(direction) {
            const container = document.querySelector('.overflow-x-auto');
            const scrollAmount = 650; // Adjust based on card width + gap
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

    <!-- Add this script section to your existing file -->
    <script>
        function generateUserActivityPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Eco-themed header
            doc.setFillColor(79, 107, 63);
            doc.rect(0, 0, 210, 40, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(20);
            doc.text('User Activity Report', 105, 20, {
                align: 'center'
            });

            // Subtitle
            doc.setFontSize(12);
            doc.text('EcoPlatform Analytics Dashboard', 105, 30, {
                align: 'center'
            });

            // Report period
            doc.setTextColor(106, 138, 82);
            doc.setFontSize(10);
            doc.text(`Report Period: ${new Date().toLocaleDateString()}`, 15, 50);

            // Key metrics section
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(16);
            doc.text('Key User Metrics', 15, 70);

            // Metrics table
            const metrics = [
                ['Total Active Users', '1,284'],
                ['New Users This Month', '156'],
                ['Avg. Session Duration', '12.4 min'],
                ['User Retention Rate', '78%'],
                ['Mobile App Usage', '64%']
            ];

            let yPos = 85;
            metrics.forEach(([label, value]) => {
                doc.setFontSize(10);
                doc.setTextColor(100, 100, 100);
                doc.text(label, 20, yPos);
                doc.setTextColor(79, 107, 63);
                doc.text(value, 80, yPos);
                yPos += 8;
            });

            // User activity chart placeholder
            doc.setDrawColor(122, 140, 79);
            doc.setLineWidth(0.5);
            doc.rect(15, 130, 180, 60);
            doc.setTextColor(122, 140, 79);
            doc.setFontSize(8);
            doc.text('User Activity Trend Chart (Last 30 Days)', 105, 135, {
                align: 'center'
            });

            // Top active users
            yPos = 200;
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(14);
            doc.text('Top Active Users', 15, yPos);
            yPos += 10;

            const topUsers = [
                ['Sarah Chen', '42 eco-actions', '3,850 pts'],
                ['Miguel Rodriguez', '38 eco-actions', '3,420 pts'],
                ['Emma Wilson', '35 eco-actions', '3,150 pts'],
                ['James Kumar', '33 eco-actions', '2,970 pts'],
                ['Lisa Thompson', '30 eco-actions', '2,700 pts']
            ];

            topUsers.forEach(([name, actions, points]) => {
                doc.setFontSize(9);
                doc.setTextColor(79, 107, 63);
                doc.text(name, 20, yPos);
                doc.setTextColor(100, 100, 100);
                doc.text(actions, 70, yPos);
                doc.text(points, 120, yPos);
                yPos += 6;
            });

            // Footer
            doc.setFontSize(8);
            doc.setTextColor(150, 150, 150);
            doc.text('Generated by EcoPlatform Analytics • ' + new Date().toLocaleString(), 105, 290, {
                align: 'center'
            });

            doc.save('user-activity-report.pdf');
        }
    </script>


    <script>
        function generateImpactAnalysisPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Header
            doc.setFillColor(106, 138, 82);
            doc.rect(0, 0, 210, 40, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(20);
            doc.text('Environmental Impact Report', 105, 20, {
                align: 'center'
            });
            doc.setFontSize(12);
            doc.text('Quantifying Eco-Action Contributions', 105, 30, {
                align: 'center'
            });

            // Impact summary
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(16);
            doc.text('Environmental Impact Summary', 15, 55);

            const impactData = [
                ['CO₂ Reduction', '24.8 tons', 'Equivalent to 52 trees planted'],
                ['Plastic Waste Saved', '1,240 kg', '12,400 plastic bottles'],
                ['Energy Conserved', '18,500 kWh', 'Power for 15 homes/month'],
                ['Water Saved', '84,000 liters', '168,000 bottles of water']
            ];

            let yPos = 70;
            impactData.forEach(([metric, value, equivalent]) => {
                doc.setFontSize(11);
                doc.setTextColor(79, 107, 63);
                doc.text(metric, 20, yPos);
                doc.setFontSize(10);
                doc.setTextColor(106, 138, 82);
                doc.text(value, 70, yPos);
                doc.setTextColor(100, 100, 100);
                doc.text(equivalent, 110, yPos);
                yPos += 15;
            });

            // Top impact categories
            yPos = 140;
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(14);
            doc.text('Impact by Category', 15, yPos);

            const categories = [
                ['Waste Reduction', '38%', '4,720 kg'],
                ['Energy Conservation', '29%', '18.5 MWh'],
                ['Carbon Reduction', '22%', '24.8 tons'],
                ['Water Conservation', '11%', '84k liters']
            ];

            yPos += 10;
            categories.forEach(([category, percentage, total]) => {
                doc.setFontSize(9);
                doc.setTextColor(79, 107, 63);
                doc.text(category, 20, yPos);
                doc.setTextColor(106, 138, 82);
                doc.text(percentage, 80, yPos);
                doc.setTextColor(100, 100, 100);
                doc.text(total, 110, yPos);
                yPos += 7;
            });

            // Community impact
            yPos = 185;
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(14);
            doc.text('Community Participation', 15, yPos);

            const communityStats = [
                ['Total Participants', '1,284 users'],
                ['Average Impact/User', '19.3 kg CO₂ reduction'],
                ['Most Active Region', 'Southeast District'],
                ['Group Challenges Completed', '47 events']
            ];

            yPos += 10;
            communityStats.forEach(([stat, value]) => {
                doc.setFontSize(9);
                doc.setTextColor(100, 100, 100);
                doc.text(stat, 20, yPos);
                doc.setTextColor(79, 107, 63);
                doc.text(value, 70, yPos);
                yPos += 7;
            });

            doc.save('impact-analysis-report.pdf');
        }
    </script>

    <script>
        function generateQuestPerformancePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Header
            doc.setFillColor(122, 140, 79);
            doc.rect(0, 0, 210, 40, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(20);
            doc.text('Quest Performance Report', 105, 20, {
                align: 'center'
            });
            doc.setFontSize(12);
            doc.text('Completion Rates & User Engagement', 105, 30, {
                align: 'center'
            });

            // Performance overview
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(16);
            doc.text('Quest Performance Overview', 15, 55);

            const overview = [
                ['Total Active Quests', '24'],
                ['Average Completion Rate', '76%'],
                ['Total Participants', '8,420'],
                ['Avg. Points per Quest', '245 pts']
            ];

            let yPos = 70;
            overview.forEach(([metric, value]) => {
                doc.setFontSize(10);
                doc.setTextColor(100, 100, 100);
                doc.text(metric, 20, yPos);
                doc.setTextColor(79, 107, 63);
                doc.text(value, 80, yPos);
                yPos += 8;
            });

            // Top performing quests
            yPos = 105;
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(14);
            doc.text('Top Performing Quests', 15, yPos);

            const topQuests = [
                ['Plastic-Free Week', '92%', '420 users', '1,050 pts'],
                ['Community Clean-Up', '88%', '370 users', '880 pts'],
                ['Tree Planting Drive', '85%', '310 users', '775 pts'],
                ['Energy Saving Challenge', '83%', '295 users', '738 pts'],
                ['Water Conservation', '81%', '280 users', '700 pts']
            ];

            yPos += 10;
            doc.setFontSize(8);
            doc.setTextColor(100, 100, 100);
            doc.text('Quest Name', 20, yPos);
            doc.text('Completion', 80, yPos);
            doc.text('Participants', 110, yPos);
            doc.text('Avg. Points', 150, yPos);
            yPos += 5;

            topQuests.forEach(([name, completion, users, points]) => {
                doc.setTextColor(79, 107, 63);
                doc.text(name, 20, yPos);
                doc.setTextColor(106, 138, 82);
                doc.text(completion, 80, yPos);
                doc.setTextColor(100, 100, 100);
                doc.text(users, 110, yPos);
                doc.text(points, 150, yPos);
                yPos += 6;
            });

            // Quest categories performance
            yPos = 165;
            doc.setTextColor(79, 107, 63);
            doc.setFontSize(14);
            doc.text('Performance by Category', 15, yPos);

            const categories = [
                ['Waste Reduction', '84%', '6/7 quests'],
                ['Energy & Carbon', '79%', '5/8 quests'],
                ['Community Action', '76%', '4/5 quests'],
                ['Education & Awareness', '72%', '3/4 quests']
            ];

            yPos += 10;
            categories.forEach(([category, successRate, activeQuests]) => {
                doc.setFontSize(9);
                doc.setTextColor(79, 107, 63);
                doc.text(category, 20, yPos);
                doc.setTextColor(106, 138, 82);
                doc.text(successRate, 80, yPos);
                doc.setTextColor(100, 100, 100);
                doc.text(activeQuests, 110, yPos);
                yPos += 7;
            });

            doc.save('quest-performance-report.pdf');
        }
    </script>
@endsection
