<!-- resources/views/modal/authModal.blade.php -->
<div 
    x-data 
    x-show="$store.authModal.open"
    @keydown.escape.window="$store.authModal.open = false"
    x-transition.opacity
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]"
>
    <!-- 🪶 Modal Container -->
    <div @click.outside="$store.authModal.open = false" id="authModalContainer" class="relative w-[850px] h-[470px] bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="container text-sm" id="container":class="{ 'right-panel-active': $store.authModal.mode === 'signup' }">

            <!-- 🌱 Sign Up -->
            <div class="form-container sign-up-container"  x-data="{ loading: false }">
                <form action="{{ route('register') }}" method="POST" class="space-y-2 px-6" @submit="loading = true">
                    @csrf
                    <h1 class="text-xl mb-1">Create Account</h1>

                    {{-- <div class="social-container mb-2">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    </div>

                    <span class="text-xs mb-2 block">or use your email for registration</span> --}}

                    <div class="grid grid-cols-3 gap-2">
                        <div class="infield">
                            <input type="text" name="first_name" placeholder="First Name" required class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                        <div class="infield">
                            <input type="text" name="middle_name" placeholder="Middle Name" class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                        <div class="infield">
                            <input type="text" name="last_name" placeholder="Last Name" required class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                    </div>

                    <div class="infield">
                        <input type="email" name="email" placeholder="Email" required class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="infield">
                            <input type="password" name="password" placeholder="Password" required class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                        <div class="infield">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                    </div>

                    <div class="pt-1">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @error('g-recaptcha-response')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="mt-2 text-sm py-2 px-4 rounded-full bg-[#b36b35] hover:bg-[#a55f2d] text-white font-semibold transition"
                        x-bind:disabled="loading"
                    >
                        <span x-show="!loading">Sign Up</span>
                        <span x-show="loading">Please wait, sending OTP in your email...</span>
                    </button>

                    <p class="mt-2 text-xs">
                        Already have an account?
                        <a href="#" @click.prevent="$store.authModal.mode = 'signin'" class="text-green-700 hover:underline">Login</a>
                    </p>
                </form>
            </div>

            <!-- 🌿 Sign In -->
            <div class="form-container sign-in-container" x-data="{ loading: false }">
                <form 
                    action="{{ route('login.submit') }}" 
                    method="POST" 
                    class="space-y-2 px-6"
                    @submit="loading = true"
                >
                    @csrf
                    <h1 class="text-xl mb-1">Log in your Account</h1>

                    {{-- <div class="social-container mb-2">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    </div>

                    <span class="text-xs mb-2 block">or use your account</span> --}}
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="infield">
                        <input type="email" name="email" placeholder="Email" required class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                    </div>
                    <div class="infield">
                        <input type="password" name="password"  placeholder="Password" required class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                    </div>

                    <a href="#" class="forgot text-xs">Forgot your password?</a>
                            <!-- Submit Button -->
                    <button type="submit" 
                        class="mt-2 text-sm py-2 px-4 rounded-full bg-[#b36b35] hover:bg-[#a55f2d] text-white font-semibold transition"
                        x-bind:disabled="loading"
                    >
                        <span x-show="!loading">Log In</span>
                        <span x-show="loading">Please wait, logging in...</span>
                    </button>
                    <p class="mt-2 text-xs">
                        Don't have an account yet?
                        <a href="#" @click.prevent="$store.authModal.mode = 'signup'" class="text-green-700 hover:underline"> Register now</a>
                    </p>
                </form>
            </div>

            <!-- 🌸 Overlay -->
            <div class="overlay-container" id="overlayCon">
                <div class="overlay text-sm">
                    <div class="overlay-panel overlay-left">
                        <h1 class="text-3xl mb-2">Hello, Friend!</h1>
                        <p class="mb-3">Enter your personal details, you’re one step away from caring!</p>
                        <button @click="$store.authModal.mode = 'signin'" class="text-sm py-2 px-4 rounded-full bg-[#5a6b3e] hover:bg-[#4a5b33] text-white font-semibold transition">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1 class="text-3xl mb-2">Welcome Back!</h1>
                        <p class="mb-3">Remember, small steps create meaningful change.</p>
                        <button @click="$store.authModal.mode = 'signup'" class="text-sm py-2 px-4 rounded-full bg-[#5a6b3e] hover:bg-[#4a5b33] text-white font-semibold transition">Sign Up</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</div>


<script src="https://www.google.com/recaptcha/api.js" async defer></script>