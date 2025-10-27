@extends('layouts.mainLayout')

@section('content')
<section class="relative overflow-hidden min-h-screen flex items-center justify-center bg-[#EEF5E6] px-6 py-10">
  <div class="bg-white rounded-3xl shadow-lg border border-green-100 max-w-4xl w-full p-8 relative">
    <a href="{{ route('lifestyle') }}" class="absolute top-6 left-6 text-[#5C7919] hover:text-[#6b9220]">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>

    <h1 class="text-3xl font-serif font-semibold text-center text-[#5C7919] mb-8">
      {{ $action['title'] }}
    </h1>

    <img src="{{ Vite::asset('resources/images/eco-actions/' . $action['image']) }}" 
         alt="{{ $action['title'] }}" 
         class="rounded-xl w-full max-h-[300px] object-cover mb-6">

    <div class="text-sm leading-relaxed text-gray-700 space-y-3">
      <p>Step 1: {{ $action['step1'] }}</p>
      <p>Step 2: {{ $action['step2'] }}</p>
      <p>Step 3: {{ $action['step3'] }}</p>
    </div>

    <div class="mt-8 text-center">
      <button class="mark-done-btn bg-[#5C7919]/10 text-[#5C7919] text-sm px-4 py-2 rounded-full hover:bg-[#5C7919]/20 transition">
        Mark as Done
      </button>
    </div>
  </div>
</section>
@endsection
