<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
        {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/auth.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="relative overflow-hidden min-h-screen flex items-center justify-center viewport1BG">
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
        <div class="relative bg-white shadow-2xl rounded-2xl p-10 w-full max-w-md border border-[#dce2d0]">
            
            <!-- 🌿 Title -->
            <h2 class="text-2xl font-serif italic font-bold text-center text-[#5a6b3e] mb-4">
                Verify Your Email
            </h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                Please enter the 6-digit code we sent to your email to complete your registration.
            </p>

            <!-- ✅ Session Message -->
            @if(session('info'))
                <div class="bg-green-50 border border-green-300 text-green-800 text-sm text-center rounded-lg px-4 py-2 mb-4">
                    {{ session('info') }}
                </div>
            @endif
            @if ($errors->has('code'))
                <div class="bg-red-100 text-red-700 p-3 rounded-md text-center mb-4">
                    {{ $errors->first('code') }}
                </div>
            @endif

            <!-- ✉️ Verification Form -->
            <form 
                method="POST" 
                action="{{ route('verify.email.submit') }}" 
                class="space-y-5" 
                x-data="{ loading: false }" 
                @submit="loading = true"
            >
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Verification Code
                    </label>
                    <input 
                        type="text" 
                        name="code" 
                        maxlength="6"
                        placeholder="Enter 6-digit code"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#5a6b3e] focus:border-[#5a6b3e] outline-none transition" 
                        required
                    >
                    @error('code') 
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full bg-[#5a6b3e] hover:bg-[#4a5b33] text-white font-semibold py-2 rounded-full transition duration-200 shadow-sm relative"
                    x-bind:disabled="loading"
                    @click="if(loading) { $event.preventDefault(); alert('Please wait, verifying your email...'); }"
                >
                    <span x-show="!loading">Verify & Create Account</span>
                    <span x-show="loading">Please wait, verifying your email...</span>
                </button>
            </form>


            <!-- 🌱 Footer -->
            <p class="text-center text-xs text-gray-500 mt-6">
                Didn’t receive the code? 
                <a href="{{ route('register') }}" class="text-[#5a6b3e] hover:underline font-medium">
                    Try registering again
                </a>
            </p>
        </div>
    </div>

</body>
</html>

