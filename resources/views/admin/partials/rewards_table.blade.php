<table class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
    <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
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
                    <td class="px-4 py-3 font-medium text-[#4F6B3F]">
                        {{ $voucher->title }}
                    </td>
                    <td class="px-4 py-3 font-semibold text-[#C37A49]">
                        {{ $voucher->required_points }}</td>
                    <td class="px-4 py-3 text-[#6A8A52]">
                        {{ Str::contains($voucher->discount_value, '%') ? $voucher->discount_value : $voucher->discount_value . '%' }}
                    </td>

                    <td class="px-4 py-3">{{ $voucher->expiry_date->format('M d, Y') }}
                    </td>
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
{{ $vouchers->links('vendor.pagination.bootstrap_5') }}
