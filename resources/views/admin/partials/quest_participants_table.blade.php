<table class="min-w-full bg-white border border-[#D8E2CA] rounded-2xl overflow-hidden shadow-sm">
    <thead class="bg-[#FCF9EF] border-b border-[#D8E2CA]">
        <tr>
            <th class="px-4 py-3 text-left font-semibold w-16">#</th>
            <th class="px-4 py-3 text-left font-semibold">Participant</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
            <th class="px-4 py-3 text-left font-semibold">Checked By</th>
        </tr>
    </thead>
    <tbody>
        {{-- Case: No submissions at all --}}
        @if ($quest->submissions->isEmpty())
            <tr>
                <td colspan="4" class="text-center py-12 text-[#6A8A52] text-lg">
                    <i class="fa-solid fa-inbox text-4xl opacity-30 mb-3 block"></i>
                    No participants have joined this quest yet.
                </td>
            </tr>
        @else
            @foreach ($quest->submissions as $index => $submission)
                <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition participant-row cursor-pointer"
                    data-submission-id="{{ $submission->submission_id }}" data-status="{{ $submission->status }}"
                    data-proof-link="{{ $submission->proof_link ?? '' }}"
                    data-proof-image="{{ $submission->proof_image ?? '' }}"
                    data-submitted-at="{{ $submission->date_submitted?->format('Y-m-d H:i:s') ?? '1970-01-01 00:00:00' }}">

                    <td class="px-4 py-3">
                        {{ $quest->submissions->firstItem() + $index }}
                    </td>

                    <td class="px-4 py-3 text-[#7A8C4F] hover:underline participant-name font-medium">
                        {{ $submission->user->first_name }} {{ $submission->user->last_name }}
                    </td>

                    <td class="px-4 py-3">
                        @php
                            $hasProof = !empty($submission->proof_link) || !empty($submission->proof_image);
                            $isSubmittedWithProof = $submission->status === 'pending' && $hasProof;
                        @endphp

                        <select
                            class="submission-status border border-[#7A8C4F] rounded-lg px-3 py-1.5 text-sm text-[#4F6B3F] bg-white focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]"
                            data-submission-id="{{ $submission->submission_id }}"
                            data-current-status="{{ $submission->status }}">

                            <option value="pending"
                                {{ $submission->status === 'pending' && !$hasProof ? 'selected' : '' }}>
                                Pending
                            </option>

                            @if ($isSubmittedWithProof)
                                <option value="pending" selected class="font-medium text-amber-700 bg-amber-50">
                                    Submitted (Has Proof)
                                </option>
                            @endif

                            <option value="completed" {{ $submission->status === 'completed' ? 'selected' : '' }}
                                class="font-medium text-green-700">
                                Completed
                            </option>

                            <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}
                                class="font-medium text-red-700">
                                Rejected
                            </option>
                        </select>
                    </td>
                    <td class="px-4 py-3 text-[#4F6B3F]">
                        @if ($submission->status === 'completed' && $submission->verifier)
                            <span class="text-green-600 font-medium">
                                Verified by {{ $submission->verifier->first_name }}
                                {{ $submission->verifier->last_name }}
                            </span>
                        @elseif ($submission->status === 'rejected' && $submission->verifier)
                            <span class="text-red-600 font-medium">
                                Rejected by {{ $submission->verifier->first_name }}
                                {{ $submission->verifier->last_name }}
                            </span>
                        @else
                            <span class="text-gray-500">Not verified yet</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $quest->submissions->links('vendor.pagination.bootstrap_5') }}
