                        <table class="min-w-full">
                            <thead class="bg-[#FCF9EF]">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Image</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[#6A8A52] uppercase">Topic</th>
                                    <th class="px-6 py-4 text-right text-xs font-medium text-[#6A8A52] uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#E6EAD7]">
                                @forelse($ecoTopics as $topic)
                                    <tr class="hover:bg-[#FAF8ED] group">
                                        <td class="px-6 py-5">
                                            <img src="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : asset('images/default.jpg') }}"
                                                alt="{{ $topic->title }}" class="w-16 h-16 object-cover rounded-xl border">
                                        </td>
                                        <td class="px-6 py-5">
                                            <h3 class="font-semibold text-[#4F6B3F]">{{ $topic->title }}</h3>
                                            <p class="text-sm text-[#6A8A52] line-clamp-2">{{ $topic->description }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <div class="flex justify-end gap-2">
                                                <!-- View -->
                                                <button onclick='openViewModal({{ $topic->toJson() }}, "topic")'
                                                    class="btn-action btn-view compact" title="View">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <!-- Edit -->
                                                <button class="btn-action btn-edit-eco compact"
                                                    data-topic='@json($topic)'
                                                    data-image="{{ $topic->image ? asset('storage/eco-library/' . $topic->image) : '' }}"
                                                    title="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>

                                                <!-- Archive -->
                                                <form method="POST" action="{{ route('admin.libraries.archive', $topic) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        onclick="return confirm('Archive this topic? It will disappear from users.')"
                                                        class="btn-action btn-archive compact" title="Archive Topic">
                                                        <i class="fa-solid fa-box-archive"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-16 text-[#6A8A52]">No topics found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $ecoTopics->links('vendor.pagination.bootstrap_5') }}