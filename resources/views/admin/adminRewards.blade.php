@extends('layouts.adminLayout')

@section('title', 'Admin Rewards')

@section('content')

    <div class="space-y-6">
        <!-- Header Section with Quick Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Reward Management</h1>
                <p class="font-sans text-[#6A8A52] mt-1">Manage digital eco-vouchers and symbolic rewards.</p>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 justify-end">
                <button onclick="openAddVoucherModal()" class="btn-eco btn-mint compact" title="Add New Voucher">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span class="hidden lg:inline">New Voucher</span>
                </button>
                <button onclick="openQrScanner()" class="btn-eco btn-leaf compact" title="Scan QR Code">
                    <i class="fa-solid fa-qrcode"></i>
                    <span class="hidden xl:inline">Scan Voucher</span>
                </button>

            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 w-full">
            <!-- SIDEBAR NAVIGATION -->
            <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] w-full h-[690px] lg:w-1/5">
                <aside class="w-full">
                    <!-- Sidebar Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">Reward Sections</h2>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="space-y-2 mb-6">
                        <button data-section="catalog" class="tab-eco w-full text-left cursor-pointer">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-gift text-[#7F8A4F]"></i>
                                <span>Reward Catalog</span>
                            </div>
                        </button>

                        <button data-section="redeemed" class="tab-eco w-full text-left cursor-pointer">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-ticket text-[#7F8A4F]"></i>
                                <span>Vouchers Redeemed</span>
                            </div>
                        </button>

                        <button data-section="archived" class="tab-eco w-full text-left cursor-pointer">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-archive text-[#7F8A4F]"></i>
                                <span>Inactive | Archived</span>
                            </div>
                        </button>
                    </div>
                </aside>
            </div>

            <!-- MAIN CONTENT AREA -->
            <main class="flex-1 space-y-6 w-full lg:w-4/5">
                <!-- Reward Tables Container -->
                <div id="rewardTables" class="space-y-6">
                    <!-- 🔍 Search and Action Bar -->
                    <div id="searchSection" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
                        <div class="flex flex-col lg:flex-row gap-4 items-center">
                            <!-- Search Input -->
                            <div class="relative flex-1 min-w-[250px]">
                                <input type="text" placeholder="Search rewards..."
                                    class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-xl 
               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans table-search"
                                    data-table-id="catalogTable">
                                <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
                            </div>

                        </div>
                    </div>

                    <!-- 🏅 Reward Catalog -->
                    <div id="catalogTable" class="bg-white rounded-2xl shadow p-6 border h-[570px] border-[#E6EAD7]">
                        <!-- Table Header -->
                        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-gift text-[#7F8A4F] text-lg"></i>
                                <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">
                                    Reward Collection <span
                                        class="text-[#6A8A52]">({{ $vouchersList->where('is_active', true)->count() }})</span>
                                </h2>
                            </div>
                        </div>

                        <!-- Reward Catalog Table -->
                        <div id="rewardsTablePagi">
                            <div class="overflow-x-auto" id="table-data-rewards">
                                @include('admin.partials.rewards_table')

                            </div>
                        </div>

                    </div>

                    <!-- 🎟️ Vouchers Redeemed -->
                    <div id="redeemedTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                        <!-- Table Header -->
                        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-ticket text-[#7F8A4F] text-lg"></i>
                                <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">
                                    Vouchers Redeemed <span class="text-[#6A8A52]">({{ $redeemedList->count() }})</span>
                                </h2>
                            </div>
                        </div>

                        <!-- Redeemed Vouchers Table -->
                        <div id="redeemedTablePagi">
                            <div class="overflow-x-auto" id="table-data-redemeed">
                                @include('admin.partials.redemeed_table')
                            </div>
                        </div>
                    </div>

                    <!-- 📁 Archived / Inactive Vouchers -->
                    <div id="archivedTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                        <!-- Table Header -->
                        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-archive text-[#7F8A4F] text-lg"></i>
                                <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">
                                    Archived Vouchers <span class="text-[#6A8A52]">({{ $archivedList->count() }})</span>
                                </h2>
                            </div>
                        </div>

                        <!-- Archived Vouchers Table -->
                        <div id="archiveTablePagi">
                            <div class="overflow-x-auto" id="table-data-archive">
                                @include('admin.partials.archive_table')    
                            </div>
                        </div>

                    </div>

                    <!-- 📱 QR Scanner Section -->
                    <div id="scanSection"
                        class="bg-white rounded-2xl shadow p-8 border border-[#E6EAD7] hidden text-center">
                        <div class="flex flex-col items-center gap-4">
                            <i class="fa-solid fa-qrcode text-[#7F8A4F] text-4xl"></i>
                            <h2 class="text-xl font-semibold text-[#4F6B3F]">Scan Voucher QR Code</h2>
                            <button class="btn-eco btn-sand" onclick="openQrScanner()">
                                <i class="fa-solid fa-camera"></i>
                                Start Scanning
                            </button>
                            <p class="text-sm text-[#6A8A52] mt-2">Use your camera to verify redeemed vouchers.</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInputs = document.querySelectorAll('.table-search');

            searchInputs.forEach(input => {
                const tableId = input.dataset.tableId;
                const tableBody = document.querySelector(`#${tableId} tbody`);

                // Create a "No results found" row
                let emptyRow = document.createElement('tr');
                emptyRow.classList.add('no-results');
                emptyRow.innerHTML =
                    `<td colspan="6" class="px-4 py-2 text-center text-[#7A8C4F]">No rewards found</td>`;
                tableBody.appendChild(emptyRow);

                const updateVisibility = () => {
                    const filter = input.value.toLowerCase();
                    const rows = Array.from(tableBody.querySelectorAll('tr:not(.no-results)'));
                    let anyVisible = false;

                    if (rows.length === 0) {
                        emptyRow.style.display = '';
                        return;
                    }

                    rows.forEach(row => {
                        const rewardCell = row.cells[0]; // search by Reward Name column
                        const rewardText = rewardCell ? rewardCell.textContent.toLowerCase() :
                            '';

                        if (rewardText.includes(filter)) {
                            row.style.display = '';
                            anyVisible = true;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    emptyRow.style.display = anyVisible ? 'none' : '';
                };

                // Run on keyup
                input.addEventListener('keyup', updateVisibility);

                // Run on page load
                updateVisibility();
            });
        });

        $(document).ready(function() {
            const $catalogContainer = $('#table-data-rewards');
            const $redeemedContainer = $('#table-data-redemeed');
            const $archiveContainer = $('#table-data-archive');

            // Tab switching + load correct content via AJAX
            $('aside [data-section]').on('click', function() {
                const section = $(this).data('section');

                // Update active tab
                $('aside .tab-eco').removeClass('tab-eco-active');
                $(this).addClass('tab-eco-active');

                // Hide all sections
                $('#catalogTable, #redeemedTable, #archivedTable, #scanSection').addClass('hidden');

                // Show selected
                if (section === 'catalog') $('#catalogTable').removeClass('hidden');
                if (section === 'redeemed') $('#redeemedTable').removeClass('hidden');
                if (section === 'archived') $('#archivedTable').removeClass('hidden');
                if (section === 'scan') $('#scanSection').removeClass('hidden');
            });

            // Pagination for Catalog
            $(document).on('click', '#rewardsTablePagi .pagination a', function(e) {
                e.preventDefault();
                $.get(this.href, {
                    type: 'catalog'
                }, function(data) {
                    $catalogContainer.html(data);
                });
            });

            // Pagination for Redeemed
            $(document).on('click', '#redeemedTablePagi .pagination a', function(e) {
                e.preventDefault();
                $.get(this.href, {
                    type: 'redeemed'
                }, function(data) {
                    $redeemedContainer.html(data);
                });
            });
            $(document).on('click', '#archiveTablePagi .pagination a', function(e) {
                e.preventDefault();
                $.get(this.href, {
                    type: 'archived'
                }, function(data) {
                    $archiveContainer.html(data);
                });
            });

            // Optional: trigger catalog as default on load
            $('[data-section="catalog"]').addClass('tab-eco-active');
        });

        document.addEventListener("DOMContentLoaded", () => {
            // Get all sidebar tabs/buttons
            const tabs = document.querySelectorAll('aside .tab-eco');
            // Map tab keys to table/section IDs
            const rewardTables = {
                catalog: document.getElementById('catalogTable'),
                redeemed: document.getElementById('redeemedTable'),
                archived: document.getElementById('archivedTable'),
                scan: document.getElementById('scanSection'),
                add: null
            };


            function activateReward(key, clickedElement) {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('tab-eco-active'));
                // Add active class to clicked tab/button
                clickedElement.classList.add('tab-eco-active');

                // Hide all sections
                Object.values(rewardTables).forEach(section => {
                    if (section) section.classList.add('hidden');
                });

                // Show the selected section
                if (rewardTables[key]) rewardTables[key].classList.remove('hidden');
            }

            // Add click events to tabs
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const key = tab.dataset.section || (tab.textContent.includes('Add') ? 'add' :
                        '');
                    activateReward(key, tab);
                });
            });

            // Optional: set default active tab on page load
            if (tabs.length) {
                const firstTab = tabs[0];
                const key = firstTab.dataset.section || (firstTab.textContent.includes('Add') ? 'add' : '');
                activateReward(key, firstTab);
            }
        });
    </script>

    @include('modal.addVoucherModal')
@endsection
