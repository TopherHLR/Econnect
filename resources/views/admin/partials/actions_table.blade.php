<table class="min-w-full">
    <thead class="bg-[#FCF9EF]">
        <tr>
            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Image</th>
            <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Action</th>
            <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase">Actions
            </th>
        </tr>
    </thead>
    <tbody class="divide-y divide-[#E6EAD7]">
        @forelse($ecoActions as $action)
            <tr class="hover:bg-[#FAF8ED] group">
                <td class="px-6 py-5">
                    <img src="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : asset('images/default-action.jpg') }}"
                        alt="{{ $action->title }}" class="w-16 h-16 object-cover rounded-xl border">
                </td>
                <td class="px-6 py-5">
                    <h3 class="font-semibold text-[#4F6B3F]">{{ $action->title }}</h3>
                    <p class="text-sm text-[#6A8A52] line-clamp-2">{{ $action->description }}</p>
                </td>
                <td class="px-6 py-5 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick='openViewModal({{ $action->toJson() }}, "action")'
                            class="btn-action btn-view compact">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="btn-action btn-edit-eco-action compact"
                            data-action='@json($action)'
                            data-image="{{ $action->image ? asset('storage/eco-actions/' . $action->image) : '' }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.actions.archive', $action) }}" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" onclick="return confirm('Archive this action?')"
                                class="btn-action btn-archive compact">
                                <i class="fa-solid fa-box-archive"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center py-16 text-[#6A8A52]">No actions found</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $ecoActions->links('vendor.pagination.bootstrap_5') }}
