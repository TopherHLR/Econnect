<table class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
    <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
        <tr>
            <th class="px-4 py-3 text-left font-semibold">#</th>
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
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-3">{{ $r->user->first_name }}
                    {{ $r->user->last_name }}
                </td>
                <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $r->voucher->title }}
                </td>
                <td class="px-4 py-3">
                    {{ $r->redeemed_date ? $r->redeemed_date->format('m/d/Y') : 'Not Redeemed' }}
                </td>

                <td class="px-4 py-3 font-semibold text-[#C37A49]">
                    {{ $r->redeem_points_cost }}</td>
                <td class="px-4 py-3">
                    @if ($r->status === 'active')
                        <span
                            class="px-2 py-1 rounded-full text-xs font-medium bg-[#FEF3C7] text-[#D97706]">Pending</span>
                    @elseif ($r->status === 'used')
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-[#F0F7E6] text-[#4F6B3F]">Used</span>
                    @elseif ($r->status === 'expired')
                        <span
                            class="px-2 py-1 rounded-full text-xs font-medium bg-[#FEE2E2] text-[#B91C1C]">Expired</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <form action="{{ route('userVoucher.updateStatus', $r->redemption_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex gap-2 items-center">
                            <select name="status"
                                class="border border-[#7A8C4F] rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]">

                                <option value="active" {{ $r->status === 'active' ? 'selected' : '' }}>Pending</option>
                                <option value="used" {{ $r->status === 'used' ? 'selected' : '' }}>Used</option>
                                <option value="expired" {{ $r->status === 'expired' ? 'selected' : '' }}>Expired
                                </option>

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
{{ $redeemed->links('vendor.pagination.bootstrap_5') }}
