@extends('layouts.mainLayout')

@section('content')
<section class="relative overflow-hidden min-h-screen flex items-center justify-center bg-[#EEF5E6] px-6 py-10">
  <div class="bg-white rounded-3xl shadow-lg border border-green-100 max-w-4xl w-full p-8 relative">
    <!-- Back button -->
    <a href="{{ route('lifestyle') }}" class="absolute top-6 left-6 text-[#5C7919] hover:text-[#6b9220]">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>

    <!-- Title -->
    <h1 class="text-3xl font-serif font-semibold text-center text-[#5C7919] mb-8">
      {{ $topic['title'] }}
    </h1>

    <!-- Image -->
    <img src="{{ Vite::asset('resources/images/eco-topics/' . $topic['image']) }}" 
         alt="{{ $topic['title'] }}" 
         class="rounded-xl w-full max-h-[300px] object-cover mb-6">

    <!-- Content -->
    <div class="text-sm leading-relaxed text-gray-700 space-y-4">
      <p>{{ $topic['content'] }}</p>
    </div>

    <!-- Bookmark -->
    <button class="absolute top-6 right-6 text-yellow-500 hover:text-yellow-600">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
      </svg>
    </button>

    <!-- Footer -->
    <div class="text-center mt-10 text-xs text-gray-500 italic">
      “You don’t have to know everything today — one tip at a time is enough.”
    </div>
  </div>
</section>
@endsection
