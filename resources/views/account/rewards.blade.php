@extends('layouts.accountLayout')

@section('account_content')
    @include('modal.userVoucherModal')
    <script>
        const availableVouchers = @json($availableVouchers);
        const myVouchers = @json($myVouchers);
        const progressPoints = {{ $progressPoints }};
        const currentPoints = {{ $currentPoints }};
    </script>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-[#4b3f2f] flex items-center">
                Celebrate Your Effort
            </h1>
            <p class="text-[#6b665e] mt-2 text-lg max-w-2xl">
                Redeem your eco-points for digital rewards and recognition. Every action counts!
            </p>
        </div>
        <div
            class="bg-gradient-to-r from-[#a86f46] to-[#bd845a] text-white rounded-full px-6 py-3 flex items-center space-x-3 shadow-lg">
            <span class="font-bold text-xl">{{ $currentPoints }} Eco Points</span>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[#e8e6dc] mt-4">
        <div class="flex justify-between items-center mb-3">
            <span class="text-[#4b3f2f] font-medium">Your Rewards Progress</span>
            <span class="text-[#6b665e] text-sm">
                {{ $progressPoints }}/60 points to next reward
            </span>
        </div>
        @php
            $progress = min(100, ($progressPoints / 60) * 100);
        @endphp
        <div class="w-full bg-[#e8e6dc] rounded-full h-3">
            <div class="bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] h-3 rounded-full" style="width: {{ $progress }}%">
            </div>
        </div>
    </div>
    <!-- Main Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">

        <!-- Rewards Section -->
        <div class="lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#4b3f2f]">Available Rewards</h2>
                <div class="flex space-x-2">
                    <button onclick="showAll()"
                        class="filter-btn bg-[#e8e6dc] text-[#4b3f2f] px-3 py-1 rounded-full text-sm font-medium hover:bg-[#d8d6cc] transition-colors">
                        All
                    </button>

                    <button onclick="showAffordable()"
                        class="filter-btn bg-white text-[#6b665e] px-3 py-1 rounded-full text-sm font-medium hover:bg-[#e8e6dc] transition-colors">
                        Affordable
                    </button>

                    <button onclick="showPopular()"
                        class="filter-btn bg-white text-[#6b665e] px-3 py-1 rounded-full text-sm font-medium hover:bg-[#e8e6dc] transition-colors">
                        Popular
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($availableVouchers as $voucher)
                    @php
                        $redeemed = $myVouchers->contains(fn($uv) => $uv->voucher_id === $voucher->voucher_id);
                        $maxRedemptions = $availableVouchers->max('user_vouchers_count');
                    @endphp


                    <div class="voucher-card rounded-2xl p-6 flex flex-col justify-between shadow-lg transform transition-all duration-300
                    {{ $redeemed ? 'bg-gray-300 cursor-not-allowed opacity-70' : 'bg-gradient-to-br from-[#9bb48b] to-[#8aa87a] text-white hover:shadow-xl hover:scale-[1.02]' }}"
                        data-points="{{ $voucher->required_points }}"
                        data-popular="{{ $voucher->user_vouchers_count == $maxRedemptions ? '1' : '0' }}">
                        <div>
                            <div class="flex justify-between items-start mb-3">

                                {{-- ⭐ MOST POPULAR if widely used --}}
                                @if ($voucher->user_vouchers_count == $maxRedemptions)
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold {{ $redeemed ? 'bg-gray-400/50' : 'bg-white/20' }}">
                                        Most Popular
                                    </span>
                                @endif


                                <span class="text-sm {{ $redeemed ? 'text-gray-600' : 'text-white/80' }}">
                                    {{ $voucher->category ?? 'General' }}
                                </span>
                            </div>

                            <h2
                                class="text-2xl font-bold leading-tight mb-2 
                            {{ $redeemed ? 'text-gray-700' : 'text-white' }}">
                                {{ $voucher->title }}
                            </h2>

                            <p class="text-sm mb-4 {{ $redeemed ? 'text-gray-600' : 'text-white/90' }}">
                                {{ $voucher->description }}
                            </p>
                        </div>

                        <div class="flex justify-between items-center">
                            <button {{ $redeemed ? 'disabled' : '' }}
                                onclick="{{ $redeemed ? '' : "openVoucherModal({$voucher->voucher_id})" }}"
                                class="px-5 py-2.5 rounded-lg font-semibold shadow-md transform transition
                            {{ $redeemed ? 'bg-gray-400 text-gray-700 cursor-not-allowed' : 'bg-gradient-to-r from-[#d1703d] to-[#e1804d] text-white hover:shadow-lg hover:scale-105' }}">
                                {{ $redeemed ? 'Redeemed' : 'REDEEM' }}
                            </button>

                            <span
                                class="font-bold rounded-full px-4 py-2 shadow-md 
                            {{ $redeemed ? 'text-gray-700 bg-gray-200' : 'text-[#4b3f2f] bg-white/90' }}">
                                {{ $voucher->required_points }} pts
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- My Vouchers Section -->
        <div
            class="bg-gradient-to-b from-[#fdfcf8] to-[#f8f6f0] rounded-2xl shadow-lg p-6 flex flex-col border border-[#e8e6dc] h-fit">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-[#4b3f2f]">My Vouchers</h2>
                <span class="bg-[#e8e6dc] text-[#4b3f2f] rounded-full px-3 py-1 text-sm font-semibold">
                    {{ $myVouchers->count() }} Active
                </span>
            </div>

            <div class="space-y-4 flex-1">
                @foreach ($myVouchers as $uv)
                    @php $used = $uv->status === 'used'; @endphp
                    <div onclick="{{ $used ? '' : "openVoucherUsageModal('{$uv->voucher_code}')" }}"
                        class="rounded-xl p-4 shadow-md transform transition
                    {{ $used ? 'bg-gray-300 cursor-not-allowed opacity-70' : 'bg-gradient-to-r from-[#9bb48b] to-[#8aa87a] text-white hover:shadow-lg hover:scale-[1.02] cursor-pointer' }}">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-bold text-lg {{ $used ? 'text-gray-700' : '' }}">
                                {{ $uv->voucher->title }}
                            </span>

                            <span
                                class="rounded-full px-2 py-1 text-xs font-semibold 
                            {{ $used ? 'bg-gray-400 text-gray-700' : 'bg-white/20' }}">
                                {{ ucfirst($uv->status) }}
                            </span>
                        </div>

                        <p class="text-sm mb-3 {{ $used ? 'text-gray-600' : 'text-white/90' }}">
                            {{ $uv->voucher->description }}
                        </p>

                        <div class="flex justify-between items-center text-xs">
                            <span>Expires: {{ \Carbon\Carbon::parse($uv->voucher->expiry_date)->format('M d, Y') }}</span>
                            <span class="rounded px-2 py-1 {{ $used ? 'bg-gray-200 text-gray-700' : 'bg-white/20' }}">
                                Tap to use
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Footer Note -->
    <div class="text-center pt-6 border-t border-[#e8e6dc]">
        <p class="text-[#6b665e] italic">
            "Every eco-action brings us closer to a sustainable future. Thank you for making a difference!"
        </p>
    </div>
    <script>
        const currentPointsUser = {{ $currentPoints ?? 0 }}; // user points from PHP

        function showAffordable() {
            document.querySelectorAll('.voucher-card').forEach(card => {
                const requiredPoints = parseInt(card.dataset.points, 10);
                console.log('Card points:', requiredPoints, 'User points:', currentPointsUser); // debug
                card.style.display = requiredPoints <= currentPointsUser ? 'block' : 'none';
            });
        }

        function showAll() {
            document.querySelectorAll('.voucher-card').forEach(card => {
                card.style.display = 'block';
            });
        }

        function showPopular() {
            document.querySelectorAll('.voucher-card').forEach(card => {
                card.style.display = card.dataset.popular === '1' ? 'block' : 'none';
            });
        }
    </script>
@endsection
