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

                <!-- System Actions -->
                <button class="btn-eco btn-sage compact" title="System Settings">
                    <i class="fa-solid fa-gear"></i>
                    <span class="hidden xl:inline">Settings</span>
                </button>
                <button class="btn-eco btn-clay compact" title="Pending Submissions">
                    <i class="fa-solid fa-hourglass-half"></i>
                    <span class="hidden xl:inline">Pending</span>
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
                            <div class="metric-value text-[#4F6B3F]" id="avgEcoActions">
                                {{ number_format($avgDailyEcoActions, 1) }}
                            </div>
                            <div class="metric-trend positive" id="ecoActionsTrend">
                                <i class="fa-solid fa-arrow-up"></i>
                                <span id="ecoActionsComparison">from {{ $ecoActionsPrev7 }} last week</span>
                            </div>
                        </div>

                        <!-- keep your static bars for now -->
                        <div class="h-20 flex items-end space-x-1 justify-center" id="ecoActionsChart">
                            <div class="w-3 bg-[#D8B08C] h-8 rounded-t bar-1"></div>
                            <div class="w-3 bg-[#C9A37E] h-10 rounded-t bar-2"></div>
                            <div class="w-3 bg-[#B48E6A] h-12 rounded-t bar-3"></div>
                            <div class="w-3 bg-[#A17856] h-16 rounded-t bar-4"></div>
                            <div class="w-3 bg-[#8B6543] h-20 rounded-t bar-5"></div>
                            <div class="w-3 bg-[#755330] h-24 rounded-t bar-6"></div>
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
                        <div class="metric-value text-[#4F6B3F]" id="pointsDistributed">{{ $pointsDistributed }} pts
                        </div>
                        <div class="metric-subtext" id="pointsPeriod">for the last 7 days</div>

                        <!-- static bars retained -->
                        <div class="mt-3 h-12 flex space-x-2 justify-center" id="pointsChart">
                            <div class="w-5 bg-[#C9A37E] h-8 rounded bar-1"></div>
                            <div class="w-5 bg-[#A46C47] h-10 rounded bar-2"></div>
                            <div class="w-5 bg-[#7F5C3A] h-12 rounded bar-3"></div>
                        </div>
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
