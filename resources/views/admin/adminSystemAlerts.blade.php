@extends('layouts.adminLayout')

@section('title', 'System Alerts')

@section('content')
    <div class="space-y-6">
        <!-- 🌿 Header with Alert Stats -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="space-y-2">
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">System Alerts</h1>
                <p class="font-sans text-[#6A8A52]">Stay informed about important system notifications and updates.</p>
            </div>

            <!-- Alert Summary Stats -->
            <div class="flex flex-wrap gap-3">
                <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                    <div class="text-2xl font-bold text-[#4F6B3F]">{{ $totalAlerts }}</div>
                    <div class="text-sm text-[#6A8A52]">Total Alerts</div>
                </div>
                <div class="bg-[#FFFBEB] rounded-xl px-4 py-3 border border-[#FDE68A]">
                    <div class="text-2xl font-bold text-[#D97706]">{{ $needsAttentionCount }}</div>

                    <div class="text-sm text-[#D97706]">Needs Attention</div>
                </div>
                <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                    <div class="text-2xl font-bold text-[#4F6B3F]">{{ $forReviewCount }}</div>
                    <div class="text-sm text-[#6A8A52]">For Review</div>
                </div>
            </div>
        </div>

        <!-- 🔔 Control Bar -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <!-- Search + Filter Group -->
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center flex-1">
                    <!-- Search -->
                    <div class="relative flex-1 min-w-[250px]">
                        <input type="text" placeholder="Search alerts..."
                            class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans">
                        <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
                    </div>

                    <!-- Filter -->
                    <select
                        class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2.5 px-4 
                           focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans">
                        <option value="">All Alerts</option>
                        <option value="attention">Needs Attention</option>
                        <option value="review">For Review</option>
                    </select>
                </div>

                <!-- Action Buttons Group -->
                <div class="flex gap-2 shrink-0">
                    <button class="btn-eco btn-sage compact" title="Mark All as Read">
                        <i class="fa-solid fa-check-double"></i>
                        <span class="hidden sm:inline">Mark All Read</span>
                    </button>
                    <button class="btn-eco btn-leaf compact" title="Refresh Alerts">
                        <i class="fa-solid fa-rotate"></i>
                        <span class="hidden sm:inline">Refresh</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ⭐ Needs Attention Alerts -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-star text-[#D97706] text-xl"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Needs Attention</h2>
                <span class="bg-[#D97706] text-white text-sm font-medium px-3 py-1 rounded-full">3 Alerts</span>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <!-- Pending Verifications -->
                <div class="bg-white rounded-2xl shadow p-6 border-2 border-[#FDE68A] hover:shadow-md transition-all">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-user-clock text-[#D97706]"></i>
                                <h3 class="text-lg font-semibold text-[#4F6B3F]">Pending User Verifications</h3>
                            </div>
                            <p class="text-sm text-[#6A8A52] mb-3">
                                {{ $pendingVerifications }} users have been waiting for verification for over 7 days.
                            </p>

                            <div class="flex items-center gap-4 text-xs text-[#7A8C4F]">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-clock"></i>
                                    Updated 5 mins ago
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-users"></i>
                                    {{ $pendingVerifications }} users waiting
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <span
                                class="bg-[#FFFBEB] text-[#D97706] text-xs font-semibold px-3 py-1.5 rounded-full border border-[#FDE68A]">
                                ATTENTION NEEDED
                            </span>
                            <button class="btn-action btn-view compact">
                                <i class="fa-solid fa-user-check"></i>
                                <span class="hidden xs:inline">Verify</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- High Invalid Submissions -->
                <div class="bg-white rounded-2xl shadow p-6 border-2 border-[#FDE68A] hover:shadow-md transition-all">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-chart-line text-[#D97706]"></i>
                                <h3 class="text-lg font-semibold text-[#4F6B3F]">Submission Review Needed</h3>
                            </div>
                            <p class="text-sm text-[#6A8A52] mb-3">Higher than usual submission rate requires quality check.
                            </p>
                            <div class="flex items-center gap-4 text-xs text-[#7A8C4F]">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-clock"></i>
                                    Updated 1 hr ago
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    {{ $invalidRate }}% review rate
                                </span>

                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <span
                                class="bg-[#FFFBEB] text-[#D97706] text-xs font-semibold px-3 py-1.5 rounded-full border border-[#FDE68A]">
                                ATTENTION NEEDED
                            </span>
                            <button class="btn-action btn-view compact">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="hidden xs:inline">Review</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- QR Scan Activity -->
                <div class="bg-white rounded-2xl shadow p-6 border-2 border-[#FDE68A] hover:shadow-md transition-all">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-qrcode text-[#D97706]"></i>
                                <h3 class="text-lg font-semibold text-[#4F6B3F]">QR Scan Activity</h3>
                            </div>
                            <p class="text-sm text-[#6A8A52] mb-3">Unusual scan patterns detected that may need
                                verification.</p>
                            <div class="flex items-center gap-4 text-xs text-[#7A8C4F]">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-clock"></i>
                                    Updated 10 mins ago
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                    {{ $qrScansToCheck }} scans to check
                                </span>

                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <span
                                class="bg-[#FFFBEB] text-[#D97706] text-xs font-semibold px-3 py-1.5 rounded-full border border-[#FDE68A]">
                                ATTENTION NEEDED
                            </span>
                            <button class="btn-action btn-edit compact">
                                <i class="fa-solid fa-shield-check"></i>
                                <span class="hidden xs:inline">Check</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 📋 For Review Alerts -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-clipboard-list text-[#7A8C4F] text-xl"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">For Review</h2>
                <span class="bg-[#7A8C4F] text-white text-sm font-medium px-3 py-1 rounded-full">2 Alerts</span>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <!-- Expiring Quests -->
                <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hover:shadow-md transition-all">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-hourglass text-[#7A8C4F]"></i>
                                <h3 class="text-lg font-semibold text-[#4F6B3F]">Upcoming Quest Deadlines</h3>
                            </div>
                            <p class="text-sm text-[#6A8A52] mb-3">3 quests are ending soon - consider extensions or new
                                content.</p>
                            <div class="flex items-center gap-4 text-xs text-[#7A8C4F]">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-clock"></i>
                                    Updated 30 mins ago
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-flag"></i>
                                    {{ $endingQuests }} quests ending
                                </span>

                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <span
                                class="bg-[#F0F7E6] text-[#7A8C4F] text-xs font-semibold px-3 py-1.5 rounded-full border border-[#D8E2CA]">
                                FOR REVIEW
                            </span>
                            <button class="btn-action btn-edit compact">
                                <i class="fa-solid fa-list-check"></i>
                                <span class="hidden xs:inline">Review</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Expiring Vouchers -->
                <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hover:shadow-md transition-all">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-ticket text-[#7A8C4F]"></i>
                                <h3 class="text-lg font-semibold text-[#4F6B3F]">Voucher Expiry Notice</h3>
                            </div>
                            <p class="text-sm text-[#6A8A52] mb-3">15 unused vouchers will expire soon - notify users or
                                extend.</p>
                            <div class="flex items-center gap-4 text-xs text-[#7A8C4F]">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-clock"></i>
                                    Updated 2 hrs ago
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-ticket"></i>
                                    {{ $expiringVouchers }} vouchers
                                </span>

                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <span
                                class="bg-[#F0F7E6] text-[#7A8C4F] text-xs font-semibold px-3 py-1.5 rounded-full border border-[#D8E2CA]">
                                FOR REVIEW
                            </span>
                            <button class="btn-action btn-edit compact">
                                <i class="fa-solid fa-eye"></i>
                                <span class="hidden xs:inline">Check</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ Completed Items (Collapsible) -->
        <div class="space-y-4">
            <div class="flex items-center gap-3 cursor-pointer" onclick="toggleResolvedAlerts()">
                <i class="fa-solid fa-chevron-down text-[#7A8C4F] transition-transform" id="resolvedArrow"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Recently Completed</h2>
                <span class="bg-[#6A8A52] text-white text-sm font-medium px-3 py-1 rounded-full">8 Items</span>
            </div>

            <div id="resolvedAlerts" class="grid grid-cols-1 xl:grid-cols-2 gap-4 hidden">
                <!-- Sample Completed Item -->
                <div class="bg-[#F8F9F5] rounded-2xl shadow p-6 border border-[#E6EAD7]">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fa-solid fa-check-circle text-[#6A8A52]"></i>
                                <h3 class="text-lg font-semibold text-[#4F6B3F]">System Performance</h3>
                            </div>
                            <p class="text-sm text-[#6A8A52] mb-3">All systems are operating at optimal performance levels.
                            </p>
                            <div class="flex items-center gap-4 text-xs text-[#7A8C4F]">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    Completed 2 days ago
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <span class="bg-[#F0F7E6] text-[#6A8A52] text-xs font-semibold px-3 py-1.5 rounded-full">
                                COMPLETED
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Button Styles */
        .btn-eco {
            @apply px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .btn-leaf {
            @apply bg-[#6A8A52] text-white hover:bg-[#5C7919] focus:ring-[#6A8A52];
        }

        .btn-sage {
            @apply bg-[#7A8C4F] text-white hover:bg-[#6A7A45] focus:ring-[#7A8C4F];
        }

        .btn-action {
            @apply px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1;
        }

        .btn-view {
            @apply bg-[#F0F7E6] text-[#4F6B3F] hover:bg-[#E9F0E1] focus:ring-[#4F6B3F];
        }

        .btn-edit {
            @apply bg-[#EFF6FF] text-[#1E40AF] hover:bg-[#DBEAFE] focus:ring-[#1E40AF];
        }

        .compact {
            @apply px-2.5 py-1.5;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .btn-action span {
                display: none;
            }

            .btn-action {
                @apply px-2 py-2;
            }
        }
    </style>

    <script>
        function toggleResolvedAlerts() {
            const resolvedSection = document.getElementById('resolvedAlerts');
            const arrow = document.getElementById('resolvedArrow');

            resolvedSection.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Optional: Add alert filtering
        document.querySelector('select').addEventListener('change', function() {
            const priority = this.value;
            const alerts = document.querySelectorAll('.grid > div');

            alerts.forEach(alert => {
                if (!priority || alert.querySelector('span').textContent.includes(priority.toUpperCase())) {
                    alert.style.display = '';
                } else {
                    alert.style.display = 'none';
                }
            });
        });

        // Search functionality
        document.querySelector('input[type="text"]').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const alerts = document.querySelectorAll('.grid > div');

            alerts.forEach(alert => {
                const text = alert.textContent.toLowerCase();
                alert.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endsection
