@extends('layouts.adminLayout')

@section('title', 'Rewards')

@section('content')
<div class="pl-4 pr-4 pt-2 pb-6 text-[#3B3B3B] font-sans min-h-[85vh] overflow-y-auto">

  <!-- 🌿 Header -->
  <div class="mb-6">
    <h1 class="text-3xl font-semibold text-[#4F3B2C]">Rewards</h1>
    <p class="text-[#6A8A52] mt-1 text-sm">Manage digital eco-vouchers and symbolic rewards.</p>
  </div>

  <!-- 📦 Layout Wrapper -->
  <div class="flex flex-col lg:flex-row gap-6">

  <aside class="w-full lg:w-1/4 max-w-xs bg-[#FCF9EF] rounded-2xl p-5 shadow-[0_4px_10px_#C6D0B2]/40 border border-[#C6D0B2]">
  <div class="flex flex-col gap-3">

    <!-- Grouped Navigation Buttons -->
    <button data-section="catalog"
      class="p-3 bg-[#7A8C4F] text-[#FCF9EF] font-medium rounded-lg shadow-sm hover:bg-[#6D7F47] hover:shadow-md transition">
      Reward Catalog
    </button>

    <button data-section="redeemed"
      class="p-3 bg-[#7A8C4F] text-[#FCF9EF] font-medium rounded-lg shadow-sm hover:bg-[#6D7F47] hover:shadow-md transition">
      Vouchers Redeemed
    </button>

    <!-- Accent Action (Different hierarchy) -->
    <button
      class="p-3 bg-[#C37A49] text-white font-medium rounded-lg shadow-md hover:bg-[#B46C3E] hover:shadow-lg transition flex items-center justify-center gap-2">
      <span>＋</span> Add New Reward
    </button>

    <!-- Supportive Secondary Action -->
    <button data-section="scan"
      class="p-3 bg-[#C6D0B2] text-[#4E3A2E] font-medium rounded-lg shadow-sm hover:bg-[#B7C39E] hover:shadow-md transition">
      Mark as Used
    </button>

  </div>
</aside>

    <!-- 🧾 Main Content -->
    <main class="flex-1 space-y-6">

      <!-- 🔍 Search and Export -->
      <div class="flex flex-wrap items-center justify-between gap-3">
        <div id="searchCatalog" class="relative w-full sm:w-72">
          <input
            type="text"
            placeholder="Search rewards..."
            class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]">
          <svg class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>

        <button class="flex items-center gap-2 bg-[#4F6B3F] text-[#F6F9EE] px-5 py-2.5 rounded-full shadow hover:bg-[#3E5730] transition font-medium text-sm">
          Export Rewards
        </button>
      </div>

      <!-- 📊 Reward Sections -->
      <div id="rewardTables" class="space-y-8">

        <!-- 🏅 Reward Catalog -->
        <div id="catalogTable" class="bg-white rounded-xl shadow p-5 border border-[#E6EAD7]">
          <h2 class="text-lg font-semibold text-[#4F6B3F] mb-3">Reward Catalog</h2>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-[#4F3B2C]">
              <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                <tr>
                  <th class="px-4 py-2 text-left font-semibold">Reward Name</th>
                  <th class="px-4 py-2 text-left font-semibold">Points Cost</th>
                  <th class="px-4 py-2 text-left font-semibold">Discount</th>
                  <th class="px-4 py-2 text-left font-semibold">Expiry</th>
                  <th class="px-4 py-2 text-left font-semibold">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b border-[#E6EAD7] hover:bg-[#F9FBF4] transition">
                  <td class="px-4 py-2 font-medium">Recycle Day Voucher</td>
                  <td class="px-4 py-2">150</td>
                  <td class="px-4 py-2">10%</td>
                  <td class="px-4 py-2">Dec 31, 2025</td>
                  <td class="px-4 py-2">
                    <span class="bg-[#6A8A52] text-white rounded-full px-3 py-1 text-xs">Active</span>
                  </td>
                </tr>
                <tr class="hover:bg-[#F9FBF4] transition">
                  <td class="px-4 py-2 font-medium">Tree Planting Voucher</td>
                  <td class="px-4 py-2">200</td>
                  <td class="px-4 py-2">15%</td>
                  <td class="px-4 py-2">Jan 10, 2026</td>
                  <td class="px-4 py-2">
                    <span class="bg-[#BDBDBD] text-white rounded-full px-3 py-1 text-xs">Inactive</span>
                  </td>
                </tr>
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
                </tr>
              </thead>
              <tbody>
                <tr class="border-b border-[#E6EAD7] hover:bg-[#F9FBF4] transition">
                  <td class="px-4 py-2">Allen James</td>
                  <td class="px-4 py-2">Recycle Day Voucher</td>
                  <td class="px-4 py-2">27/10/2025</td>
                  <td class="px-4 py-2">150</td>
                  <td class="px-4 py-2 text-[#A68A4F]">Pending</td>
                </tr>
                <tr class="hover:bg-[#F9FBF4] transition">
                  <td class="px-4 py-2">Shynne</td>
                  <td class="px-4 py-2">Recycle Day Voucher</td>
                  <td class="px-4 py-2">27/10/2025</td>
                  <td class="px-4 py-2">150</td>
                  <td class="px-4 py-2 text-[#6A8A52]">Used</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- 📱 Mark as Used -->
        <div id="scanSection" class="bg-white rounded-xl shadow p-8 border border-[#E6EAD7] hidden text-center">
          <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4">Scan Voucher QR Code</h2>
          <button class="bg-[#6A8A52] text-white px-6 py-2.5 rounded-lg hover:bg-[#809D5E] transition font-medium shadow">
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
@endsection
