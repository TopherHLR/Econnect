<!-- resources/views/admin/partials/archived_quests_table.blade.php -->
<div id="archive-table-container">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
            <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
                <tr class="text-left text-[#4F6B3F] text-sm font-semibold">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Points</th>
                    <th class="px-4 py-3">Start Date</th>
                    <th class="px-4 py-3">End Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($archivedQuests as $index => $quest)
                    <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                        <td class="px-4 py-3">{{ $archivedQuests->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $quest->title }}</td>
                        <td class="px-4 py-3 text-[#6A8A52]">{{ Str::limit($quest->description, 50) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-[#F0F7E6] text-[#4F6B3F]">
                                {{ $quest->category ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-[#C37A49]">{{ $quest->points_reward }}</td>
                        <td class="px-4 py-3">{{ $quest->start_date->format('m/d/Y') }}</td>
                        <td class="px-4 py-3">{{ $quest->end_date->format('m/d/Y') }}</td>
                        <td class="px-4 py-3"><span
                                class="text-gray-600 font-medium">{{ ucfirst($quest->status) }}</span></td>
                        <td class="px-4 py-3">
                            <form action="{{ route('quests.recover', $quest->quest_id) }}" method="POST"
                                onsubmit="return confirm('Recover this quest?')">
                                @csrf
                                <button type="submit"
                                    class="text-green-600 hover:text-green-800 font-semibold text-sm">
                                    Recover
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-[#6A8A52]">
                            <i class="fa-solid fa-inbox text-2xl opacity-50"></i>
                            <div class="mt-2">No archived quests</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination — MUST be inside the container that gets replaced -->
        <div class="mt-6">
            {{ $archivedQuests->appends(['archived' => 1])->links('vendor.pagination.bootstrap_5') }}
        </div>
    </div>
</div>
