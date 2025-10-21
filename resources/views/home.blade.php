@extends('layouts.mainLayout')

@section('content')
<div 
    class="min-h-screen flex flex-col items-center justify-center text-center bg-cover bg-center bg-no-repeat" 
    style="background-image: url('{{ Vite::asset('resources/images/backgrounds/bgRed.png') }}');"
>
    <div class="bg-white/70 backdrop-blur-sm p-10 rounded-2xl shadow-lg max-w-2xl">
        <h1 class="text-4xl font-bold text-green-900 mb-4">Welcome to Econnect 🎉</h1>
        <p class="text-gray-700 mb-8">
            If you can see this styled properly, Tailwind + Vite are working!
        </p>

        <button class="bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded-full shadow transition">
            Test Tailwind Button
        </button>
    </div>
</div>

@endsection
