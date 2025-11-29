@extends('layouts.adminLayout')

@section('title', 'Rewards')

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
            <button class="btn-eco btn-sage compact" title="Quick Actions">
                <i class="fa-solid fa-bolt"></i>
                <span class="hidden xl:inline">Quick Actions</span>
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 w-full">
        <!-- SIDEBAR NAVIGATION -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] w-full lg:w-1/5">
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
                                class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans reward-search">
                            <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 shrink-0">
                            <button onclick="openAddVoucherModal()" class="btn-eco btn-leaf compact">
                                <i class="fa-solid fa-plus"></i>
                                <span class="hidden sm:inline">Add Voucher</span>
                            </button>
                            <button onclick="openQrScanner()" class="btn-eco btn-sand compact">
                                <i class="fa-solid fa-qrcode"></i>
                                <span class="hidden sm:inline">Scan Voucher</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 🏅 Reward Catalog -->
                <div id="catalogTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
                    <!-- Table Header -->
                    <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-gift text-[#7F8A4F] text-lg"></i>
                            <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">
                                Reward Collection <span class="text-[#6A8A52]">({{ $vouchers->where('is_active', true)->count() }})</span>
                            </h2>
                        </div>
                    </div>

                    <!-- Reward Catalog Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-[#4F3B2C] font-sans">
                            <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Reward Name</th>
                                    <th class="px-4 py-3 text-left font-semibold">Points Cost</th>
                                    <th class="px-4 py-3 text-left font-semibold">Discount</th>
                                    <th class="px-4 py-3 text-left font-semibold">Expiry</th>
                                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                                    <th class="px-4 py-3 text-left font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $voucher)
                                    @if ($voucher->is_active)
                                        <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                                            <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $voucher->title }}</td>
                                            <td class="px-4 py-3 font-semibold text-[#C37A49]">{{ $voucher->required_points }}</td>
                                            <td class="px-4 py-3 text-[#6A8A52]">{{ $voucher->discount_value }}%</td>
                                            <td class="px-4 py-3">{{ $voucher->expiry_date->format('M d, Y') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-[#F0F7E6] text-[#4F6B3F]">
                                                    Active
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex gap-2">
                                                    <button class="btn-action btn-edit compact" 
                                                            onclick='openEditVoucherModal({
                                                                voucher_id: {{ $voucher->voucher_id }},
                                                                title: "{{ $voucher->title }}",
                                                                description: "{{ $voucher->description }}",
                                                                required_points: {{ $voucher->required_points }},
                                                                discount_value: "{{ $voucher->discount_value }}",
                                                                is_active: {{ $voucher->is_active ? 1 : 0 }},
                                                                expiry_date: "{{ $voucher->expiry_date->format('Y-m-d') }}"
                                                            })'
                                                            title="Edit Voucher">
                                                        <i class="fas fa-edit"></i>
                                                        <span class="hidden sm:inline">Edit</span>
                                                    </button>
                                                    <form action="{{ route('rewards.delete', $voucher->voucher_id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn-action btn-archive compact" title="Archive Voucher">
                                                            <i class="fas fa-archive"></i>
                                                            <span class="hidden sm:inline">Archive</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 🎟️ Vouchers Redeemed -->
                <div id="redeemedTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                    <!-- Table Header -->
                    <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-ticket text-[#7F8A4F] text-lg"></i>
                            <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">
                                Vouchers Redeemed <span class="text-[#6A8A52]">({{ $redeemed->count() }})</span>
                            </h2>
                        </div>
                    </div>

                    <!-- Redeemed Vouchers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-[#4F3B2C] font-sans">
                            <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">User</th>
                                    <th class="px-4 py-3 text-left font-semibold">Reward</th>
                                    <th class="px-4 py-3 text-left font-semibold">Redeem Date</th>
                                    <th class="px-4 py-3 text-left font-semibold">Points Used</th>
                                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                                    <th class="px-4 py-3 text-left font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($redeemed as $r)
                                    <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                                        <td class="px-4 py-3">{{ $r->user->first_name }} {{ $r->user->last_name }}</td>
                                        <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $r->voucher->title }}</td>
                                        <td class="px-4 py-3">{{ $r->redeemed_date->format('m/d/Y') }}</td>
                                        <td class="px-4 py-3 font-semibold text-[#C37A49]">{{ $r->redeem_points_cost }}</td>
                                        <td class="px-4 py-3">
                                            @if ($r->status === 'active')
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-[#FEF3C7] text-[#D97706]">Pending</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-[#F0F7E6] text-[#4F6B3F]">Used</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <form action="{{ route('userVoucher.updateStatus', $r->redemption_id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="flex gap-2 items-center">
                                                    <select name="status" class="border border-[#7A8C4F] rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]">
                                                        <option value="active" {{ $r->status === 'active' ? 'selected' : '' }}>Pending</option>
                                                        <option value="used" {{ $r->status === 'used' ? 'selected' : '' }}>Used</option>
                                                    </select>
                                                    <button class="btn-action btn-edit compact" title="Save Status">
                                                        <i class="fas fa-save"></i>
                                                        <span class="hidden sm:inline">Save</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 📁 Archived / Inactive Vouchers -->
                <div id="archivedTable" class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7] hidden">
                    <!-- Table Header -->
                    <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-archive text-[#7F8A4F] text-lg"></i>
                            <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans">
                                Archived Vouchers <span class="text-[#6A8A52]">({{ $archived->count() }})</span>
                            </h2>
                        </div>
                    </div>

                    <!-- Archived Vouchers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-[#4F3B2C] font-sans">
                            <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Reward Name</th>
                                    <th class="px-4 py-3 text-left font-semibold">Points Cost</th>
                                    <th class="px-4 py-3 text-left font-semibold">Discount</th>
                                    <th class="px-4 py-3 text-left font-semibold">Expiry</th>
                                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                                    <th class="px-4 py-3 text-left font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($archived as $voucher)
                                    <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                                        <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $voucher->title }}</td>
                                        <td class="px-4 py-3 font-semibold text-[#C37A49]">{{ $voucher->required_points }}</td>
                                        <td class="px-4 py-3 text-[#6A8A52]">{{ $voucher->discount_value }}%</td>
                                        <td class="px-4 py-3">{{ $voucher->expiry_date->format('M d, Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700">Archived</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <form action="{{ route('rewards.recover', $voucher->voucher_id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <button class="btn-action btn-leaf compact" title="Recover Voucher">
                                                    <i class="fas fa-undo"></i>
                                                    <span class="hidden sm:inline">Recover</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 📱 QR Scanner Section -->
                <div id="scanSection" class="bg-white rounded-2xl shadow p-8 border border-[#E6EAD7] hidden text-center">
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

<style>
    /* Tab Styling */
    .tab-eco {
        @apply px-4 py-3 rounded-xl text-[#4F6B3F] hover:bg-[#E9F0E1] transition-all duration-200 cursor-pointer;
    }
    
    .tab-eco.bg-\[\#E9F0E1\] {
        @apply bg-[#E9F0E1] font-semibold;
    }

    /* Compact Action Buttons */
    .btn-action.compact {
        @apply px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-200;
    }

    .btn-edit {
        @apply bg-[#EFF6FF] text-[#1E40AF] hover:bg-[#DBEAFE];
    }

    .btn-archive {
        @apply bg-[#FEF2F2] text-[#DC2626] hover:bg-[#FECACA];
    }

    .btn-leaf {
        @apply bg-[#F0F7E6] text-[#4F6B3F] hover:bg-[#E9F0E1];
    }
</style>

    <!-- 📜 Section Toggle Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll('aside [data-section]');
            const tables = {
                catalog: document.getElementById('catalogTable'),
                redeemed: document.getElementById('redeemedTable'),
                archived: document.getElementById('archivedTable'),
                scan: document.getElementById('scanSection')
            };


            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const section = btn.dataset.section;
                    Object.values(tables).forEach(el => el.classList.add('hidden'));
                    if (tables[section]) tables[section].classList.remove('hidden');
                });
            });
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

@endsection

@include('modal.addVoucherModal')
