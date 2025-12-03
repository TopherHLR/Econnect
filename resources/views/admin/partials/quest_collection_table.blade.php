<table id="collectionTable" class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
    <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
        <tr>
            <th class="px-4 py-3 text-left font-semibold w-16">#</th>
            <th class="px-4 py-3 text-left font-semibold">Quest Title</th>
            <th class="px-4 py-3 text-left font-semibold">Description</th>
            <th class="px-4 py-3 text-left font-semibold">Category</th>
            <th class="px-4 py-3 text-left font-semibold">Points</th>
            <th class="px-4 py-3 text-left font-semibold">Start Date</th>
            <th class="px-4 py-3 text-left font-semibold">End Date</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
            <th class="px-4 py-3 text-left font-semibold">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quests->where('status', '!=', 'archived') as $index => $quest)
            <tr data-quest-id="{{ $quest->quest_id }}" class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 font-medium text-[#4F6B3F]">{{ $quest->title }}</td>
                <td class="px-4 py-3 text-[#6A8A52]">
                    {{ Str::limit($quest->description, 50) }}
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-[#F0F7E6] text-[#4F6B3F]">
                        {{ $quest->category }}
                    </span>
                </td>
                <td class="px-4 py-3 font-semibold text-[#C37A49]">
                    {{ $quest->points_reward }}
                </td>
                <td class="px-4 py-3">
                    {{ \Carbon\Carbon::parse($quest->start_date)->format('m/d/Y') }}</td>
                <td class="px-4 py-3">
                    {{ \Carbon\Carbon::parse($quest->end_date)->format('m/d/Y') }}</td>
                <td class="px-4 py-3">
                    <select
                        class="status-dropdown border border-[#7A8C4F] rounded-lg px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] 
                                        {{ $quest->status === 'active'
                                            ? 'text-green-600'
                                            : ($quest->status === 'ending_soon'
                                                ? 'text-orange-600'
                                                : 'text-gray-600') }}"
                        data-quest-id="{{ $quest->quest_id }}">
                        <option value="active" {{ $quest->status === 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="ending_soon" {{ $quest->status === 'ending_soon' ? 'selected' : '' }}>Ending
                            Soon</option>
                        <option value="closed" {{ $quest->status === 'closed' ? 'selected' : '' }}>Closed
                        </option>
                    </select>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <button class="btn-action btn-edit compact" data-quest='@json($quest)' data-quest-id="{{ $quest->quest_id }}
                            title="Edit Quest">
                            <i class="fas fa-edit"></i>
                            <span class="hidden sm:inline">Edit</span>
                        </button>
                        <button class="btn-action btn-archive compact" data-quest-id="{{ $quest->quest_id }}"
                            title="Archive Quest">
                            <i class="fas fa-archive"></i>
                            <span class="hidden sm:inline">Archive</span>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>
{{ $quests->links('vendor.pagination.bootstrap_5') }}
