<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email | Econnect</title>
    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/auth.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .gradient-bg {
            background-image: url('/resources/images/backgrounds/viewport2_bg_coffee.png');
            background-repeat: no-repeat;
            background-position: center top;
            background-size: cover;

        }

        .verification-input:focus {
            box-shadow: 0 0 0 3px rgba(74, 102, 19, 0.1);
        }

        .verification-input {
            letter-spacing: 10px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .verification-input {
                letter-spacing: 8px;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .verification-input {
                letter-spacing: 6px;
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body class="gradient-bg">
    <div class="relative overflow-hidden min-h-screen flex items-center justify-center">

        <!-- Main Content Container -->
        <div class="relative z-10 w-full max-w-2xl px-4">
            <div
                class="flex flex-col lg:flex-row bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border border-[#dce2d0]/50">
                <!-- Left Side - Illustration -->
                <div
                    class="lg:w-1/2 bg-gradient-to-br from-[#4A6613]/10 to-[#C8D5BB]/10 p-8 flex flex-col items-center justify-center">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-[#4A6613] rounded-full mb-4">
                            <i class="fas fa-envelope-open-text text-3xl text-white"></i>
                        </div>
                        <h1 class="font-serif italic text-3xl font-bold text-[#4A6613] mb-2">
                            <i class="fas fa-leaf mr-2"></i>Econnect
                        </h1>
                        <p class="text-[#5A6B4A] text-sm">Sustainable Living Community</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-[#4A6613] text-white flex items-center justify-center">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span class="text-[#4E3A2E] text-sm">Secure email verification</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-[#4A6613] text-white flex items-center justify-center">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span class="text-[#4E3A2E] text-sm">Join our eco-community</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-[#4A6613] text-white flex items-center justify-center">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span class="text-[#4E3A2E] text-sm">Access sustainable features</span>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 border-4 border-[#9BAF8D] border-dashed rounded-full animate-pulse">
                            <i class="fas fa-lock text-2xl text-[#4A6613]"></i>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Verification Form -->
                <div class="lg:w-1/2 p-8 lg:p-10">
                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h2 class="font-serif italic text-3xl font-bold text-[#4A6613] mb-2">
                            Verify Your Email
                        </h2>
                        <div class="w-20 h-1 bg-gradient-to-r from-[#C8D5BB] to-[#9BAF8D] mx-auto mb-4"></div>
                        <p class="text-[#4E3A2E] text-sm mb-1">
                            Welcome to Econnect! We've sent a 6-digit code to your email.
                        </p>
                        <p class="text-[#8A9A7B] text-xs">
                            Check your inbox (and spam folder) for the verification code
                        </p>
                    </div>

                    <!-- Session Messages -->
                    @if (session('info'))
                        <div
                            class="mb-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('info') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('code'))
                        <div class="mb-4 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ $errors->first('code') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Verification Form -->
                    <form method="POST" action="{{ route('verify.email.submit') }}" class="space-y-6"
                        x-data="{ loading: false, code: '' }" @submit="loading = true">
                        @csrf

                        <!-- Code Input -->
                        <div>

                            <div class="relative">
                                <input type="text" name="code" x-model="code" maxlength="6" placeholder="••••••"
                                    class="w-full text-center text-2xl font-bold tracking-widest border-2 border-[#C8D5BB] rounded-xl px-4 py-3 text-[#4A6613] verification-input focus:border-[#4A6613] focus:outline-none transition-colors duration-300"
                                    required pattern="[0-9]{6}" title="Please enter a 6-digit code">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-shield-alt text-[#9BAF8D]"></i>
                                </div>
                            </div>

                            <!-- Digit Indicator -->
                            <div class="flex justify-center space-x-2 mt-3">
                                @for ($i = 0; $i < 6; $i++)
                                    <div class="w-8 h-1 rounded-full transition-all duration-300"
                                        :class="code.length > {{ $i }} ? 'bg-[#4A6613]' : 'bg-[#E8E4D7]'">
                                    </div>
                                @endfor
                            </div>

                            @error('code')
                                <div class="mt-2 flex items-center text-red-600 text-sm">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full group relative overflow-hidden bg-gradient-to-r from-[#4A6613] to-[#5A6B4A] hover:from-[#3a5010] hover:to-[#4a5b33] text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"
                            x-bind:disabled="loading" :class="loading ? 'opacity-75 cursor-not-allowed' : ''">
                            <div
                                class="absolute inset-0 w-3 bg-white/20 skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                            </div>
                            <span class="relative flex items-center justify-center">
                                <template x-if="!loading">
                                    <span>
                                        <i class="fas fa-user-check mr-2"></i>
                                        Verify & Join Community
                                    </span>
                                </template>
                                <template x-if="loading">
                                    <span class="flex items-center">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Verifying your account...
                                    </span>
                                </template>
                            </span>
                        </button>
                    </form>

                    <!-- Security Notice -->
                    <div class="mt-6 p-3 bg-[#F8F4E7] border border-[#C8D5BB] rounded-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5">
                                <i class="fas fa-info-circle text-[#4A6613]"></i>
                            </div>
                            <div class="ml-2">
                                <p class="text-xs text-[#4E3A2E]">
                                    <strong class="text-[#4A6613]">Security Tip:</strong> Never share your verification
                                    code.
                                    Econnect will never ask for this code via phone or email.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus the code input
            const codeInput = document.querySelector('input[name="code"]');
            if (codeInput) {
                codeInput.focus();

                // Format input - only allow numbers
                codeInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Auto-submit when 6 digits are entered
                    if (this.value.length === 6) {
                        // Optional: auto-submit
                        // this.form.submit();
                    }
                });
            }

        });
    </script>
</body>

</html>
