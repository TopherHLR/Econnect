@extends('layouts.accountLayout')

@section('account_content')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
      <div class="flex flex-col">
        <h1 class="text-3xl font-bold text-[#4b3f2f] flex items-center">
          Celebrate Your Effort 
          <span class="ml-3 text-2xl">🎉</span>
        </h1>
        <p class="text-[#6b665e] mt-2 text-lg max-w-2xl">Redeem your eco-points for digital rewards and recognition. Every action counts!</p>
      </div>
      <div class="bg-gradient-to-r from-[#a86f46] to-[#bd845a] text-white rounded-full px-6 py-3 flex items-center space-x-3 shadow-lg">
        <span class="text-xl">🌿</span>
        <span class="font-bold text-xl">13 Eco Points</span>
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#e8e6dc]">
      <div class="flex justify-between items-center mb-3">
        <span class="text-[#4b3f2f] font-medium">Your Rewards Progress</span>
        <span class="text-[#6b665e] text-sm">13/60 points to next reward</span>
      </div>
      <div class="w-full bg-[#e8e6dc] rounded-full h-3">
        <div class="bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] h-3 rounded-full" style="width: 22%"></div>
      </div>
    </div>

    <!-- Main Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- Rewards Section -->
      <div class="lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-[#4b3f2f]">Available Rewards</h2>
          <div class="flex space-x-2">
            <button class="bg-[#e8e6dc] text-[#4b3f2f] px-3 py-1 rounded-full text-sm font-medium hover:bg-[#d8d6cc] transition-colors">All</button>
            <button class="bg-white text-[#6b665e] px-3 py-1 rounded-full text-sm font-medium hover:bg-[#e8e6dc] transition-colors">Affordable</button>
            <button class="bg-white text-[#6b665e] px-3 py-1 rounded-full text-sm font-medium hover:bg-[#e8e6dc] transition-colors">Popular</button>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <!-- Reward Card 1 -->
            <div onclick="openVoucherModal(2)" class="bg-gradient-to-br from-[#9bb48b] to-[#8aa87a] rounded-2xl text-white p-6 flex flex-col justify-between shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
              <div>
                <div class="flex justify-between items-start mb-3">
                  <span class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Most Popular</span>
                  <span class="text-white/80 text-sm">Cafe Partner</span>
                </div>
                <h2 class="text-2xl font-bold leading-tight mb-2">One Free Coffee</h2>
                <p class="text-white/90 text-sm mb-4">Enjoy a complimentary coffee at our partner eco-cafes</p>
              </div>
              <div class="flex justify-between items-center">
                <button onclick="openVoucherModal(1)" class="bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105">
                  REDEEM
                </button>
                <span class="text-[#4b3f2f] font-bold bg-white/90 rounded-full px-4 py-2 shadow-md">60 pts</span>
              </div>
            </div>

            <!-- Reward Card 2 -->
            <div onclick="openVoucherModal(2)" class="bg-gradient-to-br from-[#9bb48b] to-[#8aa87a] rounded-2xl text-white p-6 flex flex-col justify-between shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
              <div>
                <div class="flex justify-between items-start mb-3">
                  <span class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">New</span>
                  <span class="text-white/80 text-sm">Store Partner</span>
                </div>
                <h2 class="text-2xl font-bold leading-tight mb-2">10% Total Discount</h2>
                <p class="text-white/90 text-sm mb-4">Get 10% off your entire purchase at eco-friendly stores</p>
              </div>
              <div class="flex justify-between items-center">
                <button onclick="openVoucherModal(2)" class="bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                  Need 87 pts
                </button>
                <span class="text-[#4b3f2f] font-bold bg-white/90 rounded-full px-4 py-2 shadow-md">100 pts</span>
              </div>
            </div>

            <!-- Reward Card 3 -->
            <div onclick="openVoucherModal(2)" class="bg-gradient-to-br from-[#9bb48b] to-[#8aa87a] rounded-2xl text-white p-6 flex flex-col justify-between shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
              <div>
                <div class="flex justify-between items-start mb-3">
                  <span class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Limited</span>
                  <span class="text-white/80 text-sm">Eco Store</span>
                </div>
                <h2 class="text-2xl font-bold leading-tight mb-2">Reusable Bottle</h2>
                <p class="text-white/90 text-sm mb-4">Get a stylish reusable water bottle</p>
              </div>
              <div class="flex justify-between items-center">
                <button onclick="openVoucherModal(3)" class="bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                  Need 137 pts
                </button>
                <span class="text-[#4b3f2f] font-bold bg-white/90 rounded-full px-4 py-2 shadow-md">150 pts</span>
              </div>
            </div>

            <!-- Reward Card 4 -->
            <div onclick="openVoucherModal(2)" class="bg-gradient-to-br from-[#9bb48b] to-[#8aa87a] rounded-2xl text-white p-6 flex flex-col justify-between shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
              <div>
                <div class="flex justify-between items-start mb-3">
                  <span class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Digital</span>
                  <span class="text-white/80 text-sm">Exclusive</span>
                </div>
                <h2 class="text-2xl font-bold leading-tight mb-2">Eco Warrior Badge</h2>
                <p class="text-white/90 text-sm mb-4">Unlock exclusive Eco Warrior profile badge</p>
              </div>
              <div class="flex justify-between items-center">
                <button onclick="openVoucherModal(4)" class="bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105">
                  REDEEM
                </button>
                <span class="text-[#4b3f2f] font-bold bg-white/90 rounded-full px-4 py-2 shadow-md">10 pts</span>
              </div>
            </div>

            <!-- Reward Card 5 -->
            <div onclick="openVoucherModal(2)" class="bg-gradient-to-br from-[#9bb48b] to-[#8aa87a] rounded-2xl text-white p-6 flex flex-col justify-between shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
              <div>
                <div class="flex justify-between items-start mb-3">
                  <span class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Special</span>
                  <span class="text-white/80 text-sm">Partner Offer</span>
                </div>
                <h2 class="text-2xl font-bold leading-tight mb-2">Plant a Tree</h2>
                <p class="text-white/90 text-sm mb-4">We'll plant a tree in your name</p>
              </div>
              <div class="flex justify-between items-center">
                <button onclick="openVoucherModal(5)" class="bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                  Need 187 pts
                </button>
                <span class="text-[#4b3f2f] font-bold bg-white/90 rounded-full px-4 py-2 shadow-md">200 pts</span>
              </div>
            </div>

            <!-- Reward Card 6 -->
            <div onclick="openVoucherModal(2)" class="bg-gradient-to-br from-[#9bb48b] to-[#8aa87a] rounded-2xl text-white p-6 flex flex-col justify-between shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
              <div>
                <div class="flex justify-between items-start mb-3">
                  <span class="bg-white/20 rounded-full px-3 py-1 text-xs font-semibold">Featured</span>
                  <span class="text-white/80 text-sm">Local Business</span>
                </div>
                <h2 class="text-2xl font-bold leading-tight mb-2">Organic Snack Box</h2>
                <p class="text-white/90 text-sm mb-4">Curated selection of organic snacks</p>
              </div>
              <div class="flex justify-between items-center">
                <button onclick="openVoucherModal(6)" class="bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white px-5 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                  Need 237 pts
                </button>
                <span class="text-[#4b3f2f] font-bold bg-white/90 rounded-full px-4 py-2 shadow-md">250 pts</span>
              </div>
            </div>
        </div>
      </div>

      <!-- My Vouchers Section -->
      <div class="bg-gradient-to-b from-[#fdfcf8] to-[#f8f6f0] rounded-2xl shadow-lg p-6 flex flex-col border border-[#e8e6dc] h-fit">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold text-[#4b3f2f]">My Vouchers</h2>
          <span class="bg-[#e8e6dc] text-[#4b3f2f] rounded-full px-3 py-1 text-sm font-semibold">3 Active</span>
        </div>
        
        <div class="space-y-4 flex-1">
          <!-- Voucher 1 -->
          <!-- In My Vouchers section, replace the voucher divs with: -->
          <div onclick="openVoucherUsageModal('ECOCAFE123')" class="bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] text-white rounded-xl p-4 shadow-md cursor-pointer hover:shadow-lg transform transition hover:scale-[1.02]">
            <div class="flex justify-between items-start mb-2">
              <span class="font-bold text-lg">One Free Coffee</span>
              <span class="bg-white/20 rounded-full px-2 py-1 text-xs font-semibold">Active</span>
            </div>
            <p class="text-white/90 text-sm mb-3">Redeem at any partner cafe</p>
            <div class="flex justify-between items-center text-xs">
              <span>Expires: Dec 15, 2025</span>
              <span class="bg-white/20 rounded px-2 py-1">Tap to use</span>
            </div>
          </div>
          <!-- Voucher 2 -->
         <!-- In My Vouchers section, replace the voucher divs with: -->
          <div onclick="openVoucherUsageModal('ECOCAFE123')" class="bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] text-white rounded-xl p-4 shadow-md cursor-pointer hover:shadow-lg transform transition hover:scale-[1.02]">
            <div class="flex justify-between items-start mb-2">
              <span class="font-bold text-lg">One Free Coffee</span>
              <span class="bg-white/20 rounded-full px-2 py-1 text-xs font-semibold">Active</span>
            </div>
            <p class="text-white/90 text-sm mb-3">Redeem at any partner cafe</p>
            <div class="flex justify-between items-center text-xs">
              <span>Expires: Dec 15, 2025</span>
              <span class="bg-white/20 rounded px-2 py-1">Tap to use</span>
            </div>
          </div>

          <!-- Voucher 3 -->
          <div class="bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] text-white rounded-xl p-4 shadow-md opacity-60">
            <div class="flex justify-between items-start mb-2">
              <span class="font-bold text-lg">One Free Coffee</span>
              <span class="bg-white/20 rounded-full px-2 py-1 text-xs font-semibold">Used</span>
            </div>
            <p class="text-white/90 text-sm mb-3">Redeemed on Nov 5, 2025</p>
            <div class="flex justify-between items-center text-xs">
              <span>Expired</span>
              <span class="bg-white/20 rounded px-2 py-1">Completed</span>
            </div>
          </div>
        </div>

        <!-- How to Earn More Points -->
        <div class="mt-8 pt-6 border-t border-[#e8e6dc]">
          <h3 class="text-lg font-semibold text-[#4b3f2f] mb-3">Earn More Points</h3>
          <div class="space-y-2 text-sm text-[#6b665e]">
            <div class="flex items-center space-x-2">
              <span class="text-[#9bb48b]">•</span>
              <span>Complete daily eco-actions (+5 pts)</span>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-[#9bb48b]">•</span>
              <span>Finish quests (+10-20 pts)</span>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-[#9bb48b]">•</span>
              <span>Maintain streak (+3 pts/day)</span>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Footer Note -->
    <div class="text-center pt-6 border-t border-[#e8e6dc]">
      <p class="text-[#6b665e] italic">
        "Every eco-action brings us closer to a sustainable future. Thank you for making a difference!"
      </p>
    </div>

  </div>
</div>

<!-- Reward Voucher Modal -->
<div id="voucherModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-bold text-[#4b3f2f]">Redeem Voucher</h3>
      <button onclick="closeVoucherModal()" class="text-[#6b665e] hover:text-[#4b3f2f] text-2xl">&times;</button>
    </div>
    
    <!-- Voucher Details -->
    <div class="space-y-4">
      <div class="bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] rounded-xl p-4 text-white">
        <h4 id="modalVoucherTitle" class="text-lg font-bold mb-2">One Free Coffee</h4>
        <p id="modalVoucherDesc" class="text-sm opacity-90">Enjoy a complimentary coffee at our partner eco-cafes</p>
      </div>
      
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
          <p class="text-[#6b665e]">Required Points</p>
          <p id="modalRequiredPoints" class="font-semibold text-[#4b3f2f]">60 pts</p>
        </div>
        <div>
          <p class="text-[#6b665e]">Discount Value</p>
          <p id="modalDiscountValue" class="font-semibold text-[#4b3f2f]">100%</p>
        </div>
        <div>
          <p class="text-[#6b665e]">Expiry Date</p>
          <p id="modalExpiryDate" class="font-semibold text-[#4b3f2f]">Dec 15, 2025</p>
        </div>
        <div>
          <p class="text-[#6b665e]">Status</p>
          <p id="modalStatus" class="font-semibold text-green-600">Active</p>
        </div>
      </div>
      
      <div class="bg-[#f9f8f4] rounded-lg p-4">
        <p class="text-sm text-[#6b665e] mb-2">You currently have: <span class="font-semibold text-[#4b3f2f]">13 points</span></p>
        <p class="text-xs text-[#6b665e]">After redemption, you'll have: <span class="font-semibold text-[#4b3f2f]">-47 points</span></p>
      </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex space-x-3 mt-6">
      <button onclick="closeVoucherModal()" class="flex-1 bg-[#e8e6dc] text-[#4b3f2f] py-3 rounded-lg font-semibold hover:bg-[#d8d6cc] transition-colors">
        Cancel
      </button>
      <button id="redeemButton" onclick="redeemVoucher()" class="flex-1 bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
        Redeem Now
      </button>
    </div>
  </div>
</div>

<!-- My Vouchers Usage Modal -->
<div id="voucherUsageModal" class="fixed inset-0 h-screen w-screen bg-black bg-opacity-50 flex items-center justify-center z-100 hidden">
  <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-bold text-[#4b3f2f]">Use Voucher</h3>
      <button onclick="closeVoucherUsageModal()" class="text-[#6b665e] hover:text-[#4b3f2f] text-2xl">&times;</button>
    </div>
    
    <!-- Voucher Details -->
    <div class="text-center mb-6">
      <h4 id="usageVoucherTitle" class="text-lg font-bold text-[#4b3f2f] mb-2">One Free Coffee</h4>
      <p class="text-sm text-[#6b665e]">Show this QR code to the cashier</p>
    </div>
    
    <!-- QR Code -->
    <div class="bg-white p-4 rounded-xl border-2 border-dashed border-[#e8e6dc] mb-4 flex justify-center">
      <div class="bg-gray-100 p-4 rounded-lg">
        <!-- Placeholder for QR code -->
        <div class="w-48 h-48 bg-gray-200 flex items-center justify-center text-[#6b665e] text-sm">
          QR Code Display<br>
          (Static View)
        </div>
      </div>
    </div>
    
    <!-- Voucher Code -->
    <div class="bg-[#f9f8f4] rounded-lg p-4 text-center mb-4">
      <p class="text-sm text-[#6b665e] mb-1">Voucher Code</p>
      <p id="voucherCode" class="text-lg font-mono font-bold text-[#4b3f2f]">ECOCAFE123</p>
    </div>
    
    <!-- Voucher Info -->
    <div class="space-y-2 text-sm text-[#6b665e] mb-6">
      <div class="flex justify-between">
        <span>Expires:</span>
        <span id="usageExpiryDate" class="font-semibold text-[#4b3f2f]">Dec 15, 2025</span>
      </div>
      <div class="flex justify-between">
        <span>Status:</span>
        <span id="usageStatus" class="font-semibold text-green-600">Ready to use</span>
      </div>
      <div class="flex justify-between">
        <span>Redeemed:</span>
        <span id="redeemedDate" class="font-semibold text-[#4b3f2f]">Nov 10, 2025</span>
      </div>
    </div>
    
    <!-- Usage Instructions -->
    <div class="bg-[#ecf4e7] rounded-lg p-3 mb-4">
      <p class="text-xs text-[#4b3f2f] text-center">
        📱 Present this QR code at any partner cafe to redeem your voucher
      </p>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex space-x-3">
      <button onclick="closeVoucherUsageModal()" class="flex-1 bg-[#e8e6dc] text-[#4b3f2f] py-3 rounded-lg font-semibold hover:bg-[#d8d6cc] transition-colors">
        Close
      </button>

    </div>


<script>
// Voucher data structure (static data)
const vouchers = [
  {
    voucher_id: 1,
    title: "One Free Coffee",
    description: "Enjoy a complimentary coffee at our partner eco-cafes",
    required_points: 60,
    discount_value: "100%",
    expiry_date: "Dec 15, 2025",
    is_active: true
  },
  {
    voucher_id: 2,
    title: "10% Total Discount",
    description: "Get 10% off your entire purchase at eco-friendly stores",
    required_points: 100,
    discount_value: "10%",
    expiry_date: "Jan 20, 2026",
    is_active: true
  },
  {
    voucher_id: 3,
    title: "Eco Warrior Badge",
    description: "Unlock exclusive Eco Warrior profile badge",
    required_points: 10,
    discount_value: "Digital Badge",
    expiry_date: "Never expires",
    is_active: true
  }
];

const userVouchers = [
  {
    user_id: 1,
    voucher_id: 1,
    voucher_code: "ECOCAFE123",
    qr_code: "qr_code_1",
    redeemed_date: "Nov 10, 2025",
    status: "active",
    redeem_points_cost: 60
  },
  {
    user_id: 1,
    voucher_id: 3,
    voucher_code: "BADGE456",
    qr_code: "qr_code_3",
    redeemed_date: "Nov 08, 2025",
    status: "active",
    redeem_points_cost: 10
  }
];

// Modal Functions
function openVoucherModal(voucherId) {
  const voucher = vouchers.find(v => v.voucher_id === voucherId);
  if (!voucher) return;
  
  // Populate modal with voucher data
  document.getElementById('modalVoucherTitle').textContent = voucher.title;
  document.getElementById('modalVoucherDesc').textContent = voucher.description;
  document.getElementById('modalRequiredPoints').textContent = voucher.required_points + ' pts';
  document.getElementById('modalDiscountValue').textContent = voucher.discount_value;
  document.getElementById('modalExpiryDate').textContent = voucher.expiry_date;
  document.getElementById('modalStatus').textContent = voucher.is_active ? 'Active' : 'Inactive';
  
  // Enable/disable redeem button based on points
  const userPoints = 13; // Static user points
  const redeemButton = document.getElementById('redeemButton');
  if (userPoints >= voucher.required_points && voucher.is_active) {
    redeemButton.disabled = false;
    redeemButton.textContent = 'Redeem Now';
  } else {
    redeemButton.disabled = true;
    if (!voucher.is_active) {
      redeemButton.textContent = 'Not Available';
    } else {
      redeemButton.textContent = `Need ${voucher.required_points - userPoints} more pts`;
    }
  }
  
  document.getElementById('voucherModal').classList.remove('hidden');
}

function closeVoucherModal() {
  document.getElementById('voucherModal').classList.add('hidden');
}

function openVoucherUsageModal(voucherCode) {
  const userVoucher = userVouchers.find(uv => uv.voucher_code === voucherCode);
  const voucher = vouchers.find(v => v.voucher_id === userVoucher.voucher_id);
  
  if (!userVoucher || !voucher) return;
  
  // Populate modal with user voucher data
  document.getElementById('usageVoucherTitle').textContent = voucher.title;
  document.getElementById('voucherCode').textContent = userVoucher.voucher_code;
  document.getElementById('usageExpiryDate').textContent = voucher.expiry_date;
  document.getElementById('usageStatus').textContent = userVoucher.status === 'active' ? 'Ready to use' : 'Used';
  document.getElementById('redeemedDate').textContent = userVoucher.redeemed_date;
  
  // Update status color
  const statusElement = document.getElementById('usageStatus');
  if (userVoucher.status === 'used') {
    statusElement.classList.remove('text-green-600');
    statusElement.classList.add('text-gray-600');
  } else {
    statusElement.classList.remove('text-gray-600');
    statusElement.classList.add('text-green-600');
  }
  
  document.getElementById('voucherUsageModal').classList.remove('hidden');
}

function closeVoucherUsageModal() {
  document.getElementById('voucherUsageModal').classList.add('hidden');
}

// Action Functions
function redeemVoucher() {
  // Static redemption function
  alert('Voucher redeemed successfully! Check "My Vouchers" to use it.');
  closeVoucherModal();
}

function markVoucherAsUsed() {
  // Static function to mark voucher as used
  alert('Voucher marked as used! Thank you for your eco-friendly purchase.');
  closeVoucherUsageModal();
}

// Close modals when clicking outside
document.getElementById('voucherModal').addEventListener('click', function(e) {
  if (e.target === this) closeVoucherModal();
});

document.getElementById('voucherUsageModal').addEventListener('click', function(e) {
  if (e.target === this) closeVoucherUsageModal();
});
</script>
@endsection