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
                        @foreach ($archived as $voucher)
                            <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                                <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $voucher->title }}</td>
                                <td class="px-4 py-3 font-semibold text-[#C37A49]">
                                    {{ $voucher->required_points }}</td>
                                <td class="px-4 py-3 text-[#6A8A52]">{{ $voucher->discount_value }}%</td>
                                <td class="px-4 py-3">{{ $voucher->expiry_date->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700">Archived</span>
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
                {{ $archived->links('vendor.pagination.bootstrap_5') }}
