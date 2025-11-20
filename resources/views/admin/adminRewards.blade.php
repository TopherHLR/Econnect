@extends('layouts.adminLayout')

@section('title', 'Rewards')

@section('content')
    <div class="pl-4 pr-4 pt-2 pb-10 text-[#3B3B3B] font-sans min-h-[85vh] overflow-y-auto">

        <!-- 🌿 Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-[#4F3B2C]">Rewards</h1>
            <p class="text-[#6A8A52] mt-1 text-sm">Manage digital eco-vouchers and symbolic rewards.</p>
        </div>

        <!-- 📦 Layout Wrapper -->
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- ✅ Sidebar -->
            <aside
                class="w-full lg:w-1/4 max-w-xs bg-[#FCF9EF] rounded-2xl p-5 shadow-[0_4px_10px_#C6D0B2]/40 border border-[#C6D0B2]">
                <div class="flex flex-col gap-3">
                    <button data-section="catalog" class="tab-eco w-full flex justify-center items-center">
                        Reward Catalog
                    </button>

                    <button data-section="redeemed" class="tab-eco w-full flex justify-center items-center">
                        Vouchers Redeemed
                    </button>



                    <button data-section="redeemed" class="tab-eco w-full flex justify-center items-center">
                        Used Vouchers
                    </button>
                </div>
            </aside>


            <!-- 🧾 Main Content -->
            <main class="flex-1 space-y-6 max-w-8xl mx-auto pt-7 pl-5 pr-5">

                <!-- 🔍 Top Action Bar -->
                <div class="flex flex-wrap items-center gap-3 mb-4">

                    <!-- Search bar on the left (fixed width) -->
                    <div id="searchCatalog" class="relative w-72">
                        <input type="text" placeholder="Search rewards..."
                            class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]">
                        <svg class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Action buttons beside search bar -->
                    <div class="flex gap-3">


                        <button onclick="openAddVoucherModal()" class="btn-eco btn-leaf">
                            <i class="fa-solid fa-plus"></i> Add Voucher
                        </button>


                        <button id="scanVoucherBtn" class="btn-eco btn-sand">
                            <i class="fa-solid fa-qrcode"></i>
                            <span>Scan Voucher </span>
                        </button>


                    </div>

                </div>


                <!-- 📊 Reward Sections -->
                <div id="rewardTables" class="space-y-8">

                    <!-- 🏅 Reward Catalog -->
                    <div id="catalogTable" class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
                        <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Reward Collection</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-[#4F3B2C]">
                                <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                    <tr>
                                        <th class="px-4 py-2 text-left font-semibold">Reward Name</th>
                                        <th class="px-4 py-2 text-left font-semibold">Points Cost</th>
                                        <th class="px-4 py-2 text-left font-semibold">Discount</th>
                                        <th class="px-4 py-2 text-left font-semibold">Expiry</th>
                                        <th class="px-4 py-2 text-left font-semibold">Status</th>
                                        <th class="px-4 py-2 text-left font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $voucher)
                                        <tr class="border-b hover:bg-[#F9FBF4] transition">
                                            <td class="px-4 py-2 font-medium">{{ $voucher->title }}</td>
                                            <td class="px-4 py-2">{{ $voucher->required_points }}</td>
                                            <td class="px-4 py-2">{{ $voucher->discount_value }}%</td>
                                            <td class="px-4 py-2">{{ $voucher->expiry_date->format('M d, Y') }}</td>
                                            <td class="px-4 py-2">
                                                @if ($voucher->is_active)
                                                    <span
                                                        class="bg-[#6A8A52] text-white rounded-full px-3 py-1 text-xs">Active</span>
                                                @else
                                                    <span
                                                        class="bg-gray-400 text-white rounded-full px-3 py-1 text-xs">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="flex gap-1.5">
                                                    <button onclick="openEditVoucherModal({{ $voucher }})"
                                                        class="btn-action btn-edit">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>

                                                    <form action="{{ route('rewards.delete', $voucher->voucher_id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn-action btn-delete">
                                                            <i class="fas fa-archive"></i> Archive
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>


                    <!-- 🎟️ Vouchers Redeemed -->
                    <div id="redeemedTable" class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7] hidden">
                        <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Vouchers Redeemed</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-[#4F3B2C]">
                                <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                    <tr>
                                        <th class="px-4 py-2 text-left font-semibold">User</th>
                                        <th class="px-4 py-2 text-left font-semibold">Reward</th>
                                        <th class="px-4 py-2 text-left font-semibold">Redeem Date</th>
                                        <th class="px-4 py-2 text-left font-semibold">Points Used</th>
                                        <th class="px-4 py-2 text-left font-semibold">Status</th>
                                        <th class="px-4 py-2 text-left font-semibold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($redeemed as $r)
                                        <tr class="border-b hover:bg-[#F9FBF4] transition">
                                            <td class="px-4 py-2">{{ $r->user->first_name }}</td>
                                            <td class="px-4 py-2">{{ $r->voucher->title }}</td>
                                            <td class="px-4 py-2">{{ $r->redeemed_date->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">{{ $r->redeem_points_cost }}</td>

                                            <td class="px-4 py-2">
                                                @if ($r->status === 'Pending')
                                                    <span class="text-[#A68A4F]">Pending</span>
                                                @else
                                                    <span class="text-[#6A8A52]">Used</span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-2">
                                                <form action="{{ route('userVoucher.updateStatus', $r->redemption_id) }}"
                                                    method="POST">
                                                    @csrf @method('PUT')
                                                    <select name="status" class="border rounded p-1 text-sm">
                                                        <option value="Pending"
                                                            {{ $r->status === 'Pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="Used"
                                                            {{ $r->status === 'Used' ? 'selected' : '' }}>Used</option>
                                                    </select>
                                                    <button class="btn-action btn-edit mt-1">
                                                        <i class="fas fa-save"></i> Save
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- 📱 Mark as Used -->
                    <div id="scanSection"
                        class="bg-white rounded-xl shadow p-8 pb-10 border border-[#E6EAD7] hidden text-center">
                        <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4">Scan Voucher QR Code</h2>
                        <button
                            class="bg-[#6A8A52] text-white px-6 py-2.5 rounded-lg hover:bg-[#809D5E] transition font-medium shadow">
                            📷 Start Scanning
                        </button>
                        <p class="text-sm text-[#6D7058] mt-3">Use your camera to verify redeemed vouchers.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- 📜 Section Toggle Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll('aside [data-section]');
            const tables = {
                catalog: document.getElementById('catalogTable'),
                redeemed: document.getElementById('redeemedTable'),
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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Get all sidebar tabs/buttons
            const tabs = document.querySelectorAll('aside .tab-eco');
            // Map tab keys to table/section IDs
            const rewardTables = {
                catalog: document.getElementById('catalogTable'),
                redeemed: document.getElementById('redeemedTable'),
                scan: document.getElementById('scanSection'),
                add: null // "Add New Reward" doesn't have a table
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
