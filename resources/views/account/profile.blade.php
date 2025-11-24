@extends('layouts.accountLayout')

@section('account_content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-green-900">Hello, {{ $user->first_name }}!</h1>
            <button id="edit-profile-btn"
                class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition">Edit Profile</button>
        </div>

        <!-- User Info + QR Code Card -->
        <form id="profile-form" action="{{ route('user.updateProfile') }}" method="POST"
            class="bg-white shadow-md rounded-2xl p-6 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
            @csrf
            @method('PUT')
            <div class="flex-shrink-0 text-center">
                <img src="{{ $user->profile_image ?? asset('images/default-avatar.png') }}" alt="Profile"
                    class="w-24 h-24 rounded-full border-2 border-green-700 mb-3">
                <!-- QR Code Container -->
                <div id="user-qr-code" class="mx-auto"></div>
                <p class="text-gray-600 text-sm mt-1 break-all">{{ $user->qr_code }}</p>
            </div>

            <div class="flex-1 space-y-2">
                <div>
                    <label class="font-semibold text-green-900">First Name</label>
                    <input type="text" name="first_name" value="{{ $user->first_name }}"
                        class="w-full border rounded px-3 py-2 mt-1" readonly>
                </div>
                <div>
                    <label class="font-semibold text-green-900">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ $user->middle_name }}"
                        class="w-full border rounded px-3 py-2 mt-1" readonly>
                </div>
                <div>
                    <label class="font-semibold text-green-900">Last Name</label>
                    <input type="text" name="last_name" value="{{ $user->last_name }}"
                        class="w-full border rounded px-3 py-2 mt-1" readonly>
                </div>
                <div>
                    <label class="font-semibold text-green-900">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                        class="w-full border rounded px-3 py-2 mt-1" readonly>
                </div>

                <button type="submit" id="save-btn"
                    class="mt-3 bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 transition hidden">Save
                    Changes</button>
                <button type="button" id="cancel-btn"
                    class="mt-3 bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition hidden">Cancel</button>
            </div>
        </form>



        <!-- Points & Badge -->
        <div
            class="bg-green-50 p-6 rounded-2xl flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-6">
            <div class="flex-1 text-center md:text-left">
                <p class="text-green-900 font-semibold">Your Points</p>
                <p class="text-2xl font-bold text-green-700">{{ $currentPoints }} pts</p>
                <p class="text-gray-600 text-sm">Total earned: {{ $progressPoints }} pts | Spent: {{ $pointsSpent ?? 0 }}
                    pts</p>
            </div>
            <div class="flex-1 text-center">
                <p class="text-green-900 font-semibold">Your Badge</p>
                <p class="text-xl mt-1">{{ $badgeLevel }}</p>
                @if ($earnedBadges > 0)
                    <div class="mt-2 flex justify-center space-x-1">
                        @for ($i = 0; $i < $earnedBadges; $i++)
                            <span class="text-2xl">🏆</span>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
        <div x-data="{ showChangePassword: false }">
            <!-- Toggle Button -->
            <button @click="showChangePassword = !showChangePassword"
                class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 transition mb-4">
                Change Password
            </button>

            <!-- Form -->
            <div x-show="showChangePassword" x-transition class="bg-white shadow-md rounded-2xl p-6 mt-6">
                <h2 class="text-2xl font-bold text-green-900 mb-4">Change Password</h2>
                <form action="{{ route('user.changePassword') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="font-semibold text-green-900">Current Password</label>
                        <input type="password" name="current_password" class="w-full border rounded px-3 py-2 mt-1"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="font-semibold text-green-900">New Password</label>
                        <input type="password" name="new_password" class="w-full border rounded px-3 py-2 mt-1" required>
                    </div>

                    <div class="mb-3">
                        <label class="font-semibold text-green-900">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="w-full border rounded px-3 py-2 mt-1"
                            required>
                    </div>

                    <button type="submit"
                        class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">

            <a href="/rewards"
                class="border border-green-700 text-green-700 px-6 py-3 rounded-lg hover:bg-green-50 transition text-center">My
                Vouchers</a>
            <a href="/quests"
                class="border border-green-700 text-green-700 px-6 py-3 rounded-lg hover:bg-green-50 transition text-center">My
                Quests</a>
        </div>
    </div>

    <!-- QR Code Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            generateUserQrCode('user-qr-code', '{{ $user->qr_code }}');

            function generateUserQrCode(elementId, qrCodeText) {
                const container = document.getElementById(elementId);
                if (!container) return;

                container.innerHTML = ''; // clear old QR

                new QRCode(container, {
                    text: qrCodeText,
                    width: 128,
                    height: 128,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            }

            // Enable editing
            const editBtn = document.getElementById('edit-profile-btn');
            const saveBtn = document.getElementById('save-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const inputs = document.querySelectorAll('#profile-form input');

            editBtn.addEventListener('click', () => {
                inputs.forEach(input => input.removeAttribute('readonly'));
                saveBtn.classList.remove('hidden');
                cancelBtn.classList.remove('hidden');
                editBtn.classList.add('hidden');
            });

            cancelBtn.addEventListener('click', () => {
                inputs.forEach(input => input.setAttribute('readonly', true));
                saveBtn.classList.add('hidden');
                cancelBtn.classList.add('hidden');
                editBtn.classList.remove('hidden');

                // Reset values to original
                inputs.forEach(input => {
                    input.value = input.defaultValue;
                });
            });
        });
    </script>
@endsection
