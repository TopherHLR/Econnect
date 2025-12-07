@extends('layouts.accountLayout')
@section('title', 'Profile')
@section('account_content')
    <div class="space-y-6">
        <!-- Page Header -->

    </div>

    <!-- QR + Profile Fields (Stacked Layout) -->
    <div class="space-y-6">

        <!-- QR CODE CARD -->
        <div class="bg-white shadow-md rounded-2xl p-6 w-full md:w-[1300px] mx-auto">

            <div class="flex items-center justify-between">

                <!-- LEFT: QR CODE + TEXT -->
                <div class="flex flex-col items-center">
                    <div id="user-qr-code" class="w-[210px] h-[210px] bg-gray-300 ml-[60px] mt-[15px]"></div>

                    <p class="text-gray-600 text-sm mt-2 break-all w-[180px] text-center ml-[60px]">
                        {{ $user->qr_code }}
                    </p>
                </div>

                <!-- CENTER: MESSAGE -->
                <div class="ml-30 mt-10">
                    <div class="flex items-center justify-between">
                        <h1 class="text-4xl font-bold text-green-900 w-[200px] -mt-25 -ml-70">
                            Hello, {{ $user->first_name }}!
                        </h1>
                    </div>

                    <p class="mb-4 -ml-70 text-lg text-green-900">
                            At EcoBrew, a café on a mission, we serve quality food and drinks<br> while caring for the environment. <br>
                        Use this QR code to verify your account <br> and help us continue our eco-friendly initiatives.
                    </p>
                </div>



                <!-- RIGHT: BUTTONS (UPDATED) -->
                <div class="flex flex-col space-y-3 mr-[50px]">
                    <a href="/rewards" class="bg-[#4F6B3F] text-white px-6 py-2 rounded-lg text-center">
                        My Vouchers
                    </a>

                    <a href="/quests" class="bg-[#4F6B3F] text-white px-6 py-2 rounded-lg text-center">
                        My Quests
                    </a>

                    <button id="edit-profile-btn"
                        class="bg-[#4F6B3F] text-white px-4 py-2 rounded-lg hover:bg-[#3B541F] transition">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>


        <!-- PROFILE FORM -->
        <form id="profile-form" action="{{ route('user.updateProfile') }}" method="POST"
            class="bg-white shadow-md rounded-2xl p-6 flex flex-col space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-2">
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
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-3 py-2 mt-1"
                        readonly>
                </div>

                <button type="submit" id="save-btn"
                    class="mt-3 bg-[#4F6B3F] text-white px-6 py-2 rounded-lg hover:bg-[#3B541F] transition hidden">
                    Save Changes
                </button>

                <button type="button" id="cancel-btn"
                    class="mt-3 bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition hidden">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password Section -->
    <div x-data="{ showChangePassword: false }">
        <button @click="showChangePassword = !showChangePassword"
            class="bg-[#4F6B3F] text-white px-6 py-2 rounded-lg hover:bg-[#3B541F] transition mb-4">
            Change Password
        </button>

        <div x-show="showChangePassword" x-transition class="bg-white shadow-md rounded-2xl p-6 mt-6">
            <h2 class="text-2xl font-bold text-green-900 mb-4">Change Password</h2>

            <form action="{{ route('user.changePassword') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="font-semibold text-green-900">Current Password</label>
                    <input type="password" name="current_password" class="w-full border rounded px-3 py-2 mt-1" required>
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

                <button type="submit" class="bg-[#4F6B3F] text-white px-6 py-2 rounded-lg hover:bg-[#3B541F] transition">
                    Update Password
                </button>
            </form>
        </div>
    </div>
    </div>

    <!-- QR Code Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            generateUserQrCode('user-qr-code', '{{ $user->qr_code }}');

            function generateUserQrCode(elementId, qrCodeText) {
                const container = document.getElementById(elementId);
                if (!container) return;
                container.innerHTML = '';
                new QRCode(container, {
                    text: qrCodeText,
                    width: 250,
                    height: 250,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            }

            // ELEMENTS
            const editBtn = document.getElementById('edit-profile-btn');
            const saveBtn = document.getElementById('save-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const inputs = document.querySelectorAll('#profile-form input');

            // --- ENABLE EDIT MODE ---
            editBtn.addEventListener('click', function () {
                inputs.forEach(input => input.removeAttribute('readonly'));

                saveBtn.classList.remove('hidden');
                cancelBtn.classList.remove('hidden');
                editBtn.classList.add('hidden');
            });

            // --- CANCEL EDIT ---
            cancelBtn.addEventListener('click', function () {
                // restore original values
                inputs.forEach(input => {
                    input.value = input.defaultValue;
                    input.setAttribute('readonly', true);
                });

                saveBtn.classList.add('hidden');
                cancelBtn.classList.add('hidden');
                editBtn.classList.remove('hidden');
            });

        });
    </script>

@endsection