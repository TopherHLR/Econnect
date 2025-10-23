@extends('layouts.mainLayout')

@section('content')
@section('content')
<section class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">
    <!-- Clouds -->
    <img 
        src="{{ Vite::asset('resources/images/viewport1/realistic-cloud.png') }}" 
        alt="cloud" 
        class="absolute top-[-150px] left-0 w-[1000px] opacity-80 animate-[cloud1_60s_linear_infinite]
               max-md:top-[-100px] max-md:w-[700px]
               max-sm:top-[-50px] max-sm:w-[500px]" 
    />

    <img 
        src="{{ Vite::asset('resources/images/viewport1/realistic-cloud2.png') }}" 
        alt="cloud" 
        class="absolute top-50 right-0 w-[1000px] opacity-80 animate-[cloud2_60s_linear_infinite]
               max-md:top-[0px] max-md:w-[700px]
               max-sm:top-[50px] max-sm:w-[500px]" 
    />
</section>

<section class="relative -top-70 min-h-[100vh] flex items-center justify-center viewport2BG">

</section>
@endsection

