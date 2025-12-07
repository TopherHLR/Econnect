<!-- resources/views/modal/authModal.blade.php -->
<script>
    window.authModalOpen = {{ session('auth_modal_open') ? 'true' : 'false' }};
    window.authModalMode = "{{ session('auth_mode') ?? '' }}";
</script>

<div x-data x-show="$store.authModal.open" @keydown.escape.window="$store.authModal.open = false" x-transition.opacity
    x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1200]">

    <!-- Modal Container -->
    <div @click.outside="$store.authModal.open = false" id="authModalContainer"
        class="relative w-[850px] h-[470px] bg-white rounded-2xl shadow-xl overflow-hidden">

        <div class="container text-sm" id="container"
            :class="{ 'right-panel-active': $store.authModal.mode === 'signup' }">

            <!-- Sign Up -->
            <div class="form-container sign-up-container" x-data="{ loading: false, showPass: false, showConfirm: false }">
                <form action="{{ route('register') }}" method="POST" class="space-y-2 px-6" @submit="loading = true">
                    @csrf
                    <h1 class="text-xl mb-1">Create Account</h1>

                    <div class="grid grid-cols-3 gap-2">
                        <div class="infield">
                            <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}"
                                class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                        <div class="infield">
                            <input type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}"
                                class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                        <div class="infield">
                            <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}"
                                class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                        </div>
                    </div>

                    <div class="infield">
                        <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}"
                            class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <!-- Password -->
                        <div class="infield relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" placeholder="Password"
                                required
                                class="text-[13px] py-1 px-2 pr-11 border border-gray-300 rounded 
                                       focus:ring-green-600 focus:border-green-600 outline-none w-full 
                                       transition-all duration-200" />

                            <div @click="showPass = !showPass"
                                class="absolute inset-y-0 right-3 flex items-center pr-3 
                                       text-gray-500 hover:text-gray-700 
                                       cursor-pointer select-none transition-colors">

                                <!-- Eye Open -->
                                <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <!-- Eye Closed with Slash -->
                                <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="infield relative">
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                                placeholder="Confirm Password" required
                                class="text-[13px] py-1 px-2 pr-11 border border-gray-300 rounded 
                                       focus:ring-green-600 focus:border-green-600 outline-none w-full 
                                       transition-all duration-200" />

                            <div @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-3 flex items-center pr-3 
                                       text-gray-500 hover:text-gray-700 
                                       cursor-pointer select-none transition-colors">

                                <!-- Eye Open -->
                                <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <!-- Eye Closed with Slash -->
                                <svg x-show="showConfirm" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="pt-1">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @error('g-recaptcha-response')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="mt-2 text-sm py-2 px-4 rounded-full bg-[#b36b35] hover:bg-[#a55f2d] text-white font-semibold transition relative"
                        x-bind:disabled="loading">
                        <span x-show="!loading">Sign Up</span>
                        <span x-show="loading">Please wait, sending OTP in your email...</span>
                    </button>

                    <p class="mt-2 text-xs">
                        Already have an account?
                        <a href="#" @click.prevent="$store.authModal.mode = 'signin'"
                            class="text-green-700 hover:underline">Login</a>
                    </p>
                </form>
   
            </div>

            <!-- Sign In -->
            <div class="form-container sign-in-container" x-data="{ loading: false, showPass: false }">
                <form action="{{ route('login.submit') }}" method="POST" class="space-y-2 px-6"
                    @submit="loading = true">
                    @csrf
                    <h1 class="text-xl mb-1">Log in your Account</h1>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="infield">
                        <input type="email" name="email" placeholder="Email" required   value="{{ old('email') }}"
                            class="text-[13px] py-1 px-2 border border-gray-300 rounded focus:ring-green-600 focus:border-green-600 outline-none w-full" />
                    </div>

                    <!-- Password with Show/Hide -->
                    <div class="infield relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" placeholder="Password" required
                            class="text-[13px] py-1 px-2 pr-11 border border-gray-300 rounded 
                                   focus:ring-green-600 focus:border-green-600 outline-none w-full 
                                   transition-all duration-200" />

                        <div @click="showPass = !showPass"
                            class="absolute inset-y-0 right-3 flex items-center pr-3 
                                   text-gray-500 hover:text-gray-700 
                                   cursor-pointer select-none transition-colors">
                            <!-- Eye Open -->
                            <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Closed with Slash -->
                            <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </div>
                    </div>

                    <a href="{{ route('password.request') }}" class="forgot text-xs text-green-700 hover:underline">
                        Forgot your password?
                    </a>

                    <button type="submit"
                        class="mt-2 text-sm py-2 px-4 rounded-full bg-[#b36b35] hover:bg-[#a55f2d] text-white font-semibold transition relative"
                        x-bind:disabled="loading">
                        <span x-show="!loading">Log In</span>
                        <span x-show="loading">Please wait, logging in...</span>
                    </button>

                    <p class="mt-2 text-xs">
                        Don't have an account yet?
                        <a href="#" @click.prevent="$store.authModal.mode = 'signup'"
                            class="text-green-700 hover:underline">Register now</a>
                    </p>
                </form>
            </div>

            <!-- Overlay -->
            <div class="overlay-container" id="overlayCon">
                <div class="overlay text-sm">
                    <div class="overlay-panel overlay-left">
                        <h1 class="text-3xl mb-2">Hello, Friend!</h1>
                        <p class="mb-3">Enter your personal details, you’re one step away from caring!</p>
                        <button @click="$store.authModal.mode = 'signin'"
                            class="text-sm py-2 px-4 rounded-full bg-[#5a6b3e] hover:bg-[#4a5b33] text-white font-semibold transition">Sign
                            In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1 class="text-3xl mb-2">Welcome Back!</h1>
                        <p class="mb-3">Remember, small steps create meaningful change.</p>
                        <button @click="$store.authModal.mode = 'signup'"
                            class="text-sm py-2 px-4 rounded-full bg-[#5a6b3e] hover:bg-[#4a5b33] text-white font-semibold transition">Sign
                            Up</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
