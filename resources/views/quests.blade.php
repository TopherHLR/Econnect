@extends('layouts.mainLayout')

@section('content')
    <div class="max-w-6xl mx-auto px-6 md:px-12 py-12 mt-12">

        <div class="bg-[#F7F3E7] rounded-4xl shadow-md border border-green-100 overflow-hidden p-8">

            <!-- 🌿 Top Container: Columns -->
            <div class="flex flex-col md:flex-row gap-6">

                <!-- ✅ Left Column: Accepted Challenges -->
                <div
                    class="w-full md:w-1/4 bg-[#FCFFF6] rounded-2xl shadow-md p-4 max-h-[600px] overflow-y-auto flex flex-col justify-between">
                    <h2 class="text-lg font-semibold text-[#4F6B3F] mb-4 py-3 rounded-xl text-center"
                        style="font-family: var(--font-serif);">
                        Accepted Quests
                    </h2>

                    <div class="space-y-3 flex-1">
                        {{-- Pending Submissions --}}
                        @foreach ($quests as $quest)
                            @foreach ($quest->submissions as $submission)
                                @if ($submission->status === 'pending')
                                    <div class="flex justify-between items-center bg-white p-3 rounded-2xl shadow-sm border-l-4 border-[#da7a5f] hover:shadow-md transition cursor-pointer accepted-quest"
                                        data-submission-id="{{ $submission->submission_id }}"
                                        data-description="{{ $quest->description }}">
                                        <span class="text-sm font-medium text-[#4F6B3F]">{{ $quest->title }}</span>
                                        <small class="text-gray-500 text-xs">
                                            {{ $quest->end_date->isFuture() ? now()->diffInDays($quest->end_date) : 0 }} days left
                                        </small>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>

                    <!-- Completed Section -->
                    <div class="mt-6 border-t border-[#e0e0d6] pt-4 space-y-2">
                        <h3 class="text-sm font-semibold text-[#4F6B3F] mb-2">Completed Quests</h3>
                        @foreach ($quests as $quest)
                            @foreach ($quest->submissions as $submission)
                                @if ($submission->status === 'completed')
                                    <div class="flex justify-between items-center text-sm text-green-700 cursor-pointer completed-quest"
                                        data-submission-id="{{ $submission->submission_id }}"
                                        data-description="{{ $quest->description }}">
                                        <span>✅ {{ $quest->title }}</span>
                                        <small>
                                            {{ optional($submission->date_completed)->format('d/m/Y') ?? $submission->points_reward . ' pts' }}
                                        </small>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>

                    <!-- Rejected Section -->
                    <div class="mt-6 border-t border-[#e0e0d6] pt-4 space-y-2">
                        <h3 class="text-sm font-semibold text-[#4F6B3F] mb-2">Rejected Quests</h3>
                        @foreach ($quests as $quest)
                            @foreach ($quest->submissions as $submission)
                                @if ($submission->status === 'rejected')
                                    <div class="flex justify-between items-center text-sm text-red-500 cursor-pointer rejected-quest"
                                        data-submission-id="{{ $submission->submission_id }}"
                                        data-description="{{ $quest->description }}">
                                        <span>❌ {{ $quest->title }}</span>
                                        <small>
                                            {{ optional($submission->date_rejected)->format('d/m/Y') ?? 'Rejected' }}
                                        </small>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>

                </div>


                <!-- 🌱 Right Column: Active Challenges -->
                <div class="w-full md:w-3/4 bg-[#FCFFF6] rounded-2xl shadow-md p-5 flex flex-col">

                    <!-- Heading + All Button -->
                    <div class="flex justify-between items-center mb-6 gap-4">
                        <h2 class="px-6 py-2 text-[#4F6B3F] rounded-xl text-lg font-semibold text-center"
                            style="font-family: var(--font-serif);">
                            Active Eco-Quests
                        </h2>

                        <button class="text-sm bg-[#e8ead9] hover:bg-[#dfe1cc] px-4 py-2 rounded-full shadow transition">
                            All
                        </button>
                    </div>

                    <!-- Grid of Challenges -->
                    <div class="max-w-full max-h-[500px] overflow-y-auto pr-2 flex-1 custom-scroll">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">
                            {{-- Loop through all active quests --}}
                            @foreach ($quests as $quest)
                                @if ($quest->status === 'active')
                                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition transform hover:-translate-y-1 cursor-pointer eco-card"
                                        data-id="{{ $quest->quest_id }}" data-type="ecoQuest">
                                        <img src="{{ Vite::asset('resources/images/ecoChallenges/pollution.jpg') }}"
                                            alt="{{ $quest->title }}" class="h-28 w-full object-cover rounded-t-2xl">
                                        <div
                                            class="bg-gradient-to-t from-[#4a7144] to-[#6ea057] text-white p-3 flex flex-col justify-between rounded-b-2xl">
                                            <div>
                                                <h3 class="text-sm font-semibold truncate">{{ $quest->title }}</h3>
                                                @php
                                                    $daysLeft = $quest->end_date->isFuture()
                                                        ? now()->diffInDays($quest->end_date)
                                                        : 0;
                                                @endphp
                                                <p class="text-xs mt-1 opacity-80">Ends in {{ $daysLeft }} days</p>

                                            </div>
                                            <p class="text-sm mt-2 font-bold">{{ $quest->points_reward }} pts 🌱</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div> <!-- End Right Column -->

            </div> <!-- End Top Container Columns -->

            {{-- Bottom sections remain static or can also be dynamic later --}}

        </div> <!-- End Main Container -->

    </div>
    @include('modal.userQuestModal')
@endsection
