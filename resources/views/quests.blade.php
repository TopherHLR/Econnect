@extends('layouts.mainLayout')

@section('content')
<div class="max-w-6xl mx-auto px-12 py-12 mt-15">

  <div class="bg-[#F7F3E7] rounded-4xl shadow-sm border border-green-100 overflow-hidden p-8">

    <!-- 🌿 Top Container: Columns -->
    <div class="flex flex-col md:flex-row gap-6">

      <!-- ✅ Left Column -->
      <div class="w-full md:w-1/4 bg-[#FCFFF6] rounded-2xl shadow-md p-4 max-h-[600px] overflow-y-auto flex flex-col justify-between">
        <h2 class="text-lg font-extrabold text-center text-[#FCFFF6] mb-4 bg-[#5C7919] py-2 rounded-xl" style="font-family: var(--font-serif);">
          Accepted Challenges
        </h2>

        <div class="space-y-3 flex-1">
          <div class="flex justify-between items-center bg-white p-2 rounded-lg shadow-sm border-l-4 border-[#da7a5f]">
            <span>Plastic-Free Lunch Challenge</span>
            <small class="text-gray-500">1 day left</small>
          </div>
          <div class="flex justify-between items-center bg-white p-2 rounded-lg shadow-sm border-l-4 border-[#db8863]">
            <span>Eco Outfit Day</span>
            <small class="text-gray-500">1 day left</small>
          </div>
          <div class="flex justify-between items-center bg-white p-2 rounded-lg shadow-sm border-l-4 border-[#dba363]">
            <span>Clean Corner Project</span>
            <small class="text-gray-500">3 days left</small>
          </div>
          <div class="flex justify-between items-center bg-white p-2 rounded-lg shadow-sm border-l-4 border-[#b1c768]">
            <span>Green Commute Day</span>
            <small class="text-gray-500">3 days left</small>
          </div>
          <div class="flex justify-between items-center bg-white p-2 rounded-lg shadow-sm border-l-4 border-[#7ca86c]">
            <span>Paper Reuse Art</span>
            <small class="text-gray-500">3 days left</small>
          </div>
        </div>

        <!-- Completed Section -->
        <div class="mt-4 border-t border-[#e0e0d6] pt-3 space-y-2">
          <div class="flex justify-between items-center text-sm text-gray-700">
            <span>✅ Plastic-Free Lunch</span>
            <small>12/10/2025</small>
          </div>
          <div class="flex justify-between items-center text-sm text-gray-700">
            <span>✅ Plastic-Free Lunch</span>
            <small>13pts</small>
          </div>
        </div>
      </div>

      <!-- 🌱 Right Column -->
      <div class="w-full md:w-3/4 bg-[#FCFFF6] rounded-2xl shadow-md p-5 flex flex-col">

        <!-- Heading + All Button -->
        <div class="flex justify-center items-center mb-6 gap-4">
          <h2 class="px-6 py-2 text-[#FCFFF6] rounded-xl text-xl font-extrabold text-center"
    style="font-family: var(--font-serif); background: linear-gradient(to right, #A16A44, #3B2719);">
  Active Eco-Challenges
</h2>

          <button class="text-sm bg-[#e8ead9] hover:bg-[#dfe1cc] px-3 py-1 rounded-full shadow">
            All
          </button>
        </div>

        <!-- Grid of Challenges -->
        <div class="max-w-[95%] max-h-[500px] overflow-y-auto pr-2 mx-auto flex-1">
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
            @for ($i = 0; $i < 8; $i++)
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition cursor-pointer eco-card" data-type="ecoAction" data-id="{{ $i }}">
              <img src="{{ Vite::asset('resources/images/ecoChallenges/pollution.jpg') }}" alt="Challenge" class="h-28 w-full object-cover">
              <div class="bg-[#4a7144] text-white p-3 flex flex-col justify-between">
                <div>
                  <h3 class="text-sm font-semibold">Digital Declutter Challenge</h3>
                  <p class="text-xs mt-1 opacity-80">Ends in 3 days</p>
                </div>
                <p class="text-sm mt-2 font-bold">3pts 🌱</p>
              </div>
            </div>
            @endfor
          </div>
        </div>

      </div> <!-- End Right Column -->

    </div> <!-- End Top Container Columns -->

    <!-- 🌸 Bottom Sections: Outside columns, aligned center under each column -->
    <div class="flex flex-col md:flex-row gap-6 mt-6">

      <!-- Left Bottom -->
      <div class="w-full md:w-1/4 flex flex-col items-center">
        <p class="text-xs text-[#a67c52] mb-1 text-center">Want to view all your progress?</p>
        <button class="bg-[#c4b48a] hover:bg-[#b3a175] text-white px-3 py-1 rounded-lg text-sm">
          Go to My Progress
        </button>
      </div>

      <!-- Right Bottom -->
      <div class="w-full md:w-3/4 flex flex-col items-center">
        <p class="text-sm text-[#7a6f59] italic mb-4 text-center">Your progress can turn into discount badges (go to Rewards tab when clicked)</p>
        <div class="flex justify-center gap-6 mb-4 flex-wrap">
          @for ($i = 0; $i < 4; $i++)
          <div class="flex flex-col items-center">
            <img src="{{ Vite::asset('resources/images/icons/sprout-badge.svg') }}" alt="Badge" class="h-10 mb-1">
            <p class="text-sm font-semibold text-[#4b3f2f]">10% discount</p>
          </div>
          @endfor
        </div>
      </div>

    </div> <!-- End Bottom Sections -->

  </div> <!-- End Main Container -->

</div>
@endsection
