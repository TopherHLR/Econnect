@extends('layouts.adminLayout')

@section('title', 'Users')

@section('content')
    @include('modal.userModal')
    <div class="space-y-6">
        <!-- Header Section with Quick Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">User Management</h1>
                <p class="font-sans text-[#6A8A52] mt-1">Manage user accounts, verification, and activity status.</p>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 justify-end">
                <button onclick="openUserQrScanner()" class="btn-eco btn-mint compact" title="Verify User">
                    <i class="fa-solid fa-qrcode"></i>
                    <span class="hidden lg:inline">Verify User</span>
                </button>
            </div>
        </div>
        <!-- 🔍 TABLE HEADER WITH TITLE, ALERTS & SEARCH -->
        <section class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7]">
            <div class="flex flex-col lg:flex-row gap-4 items-center">
                <!-- Table Title -->
                <div class="flex items-center gap-2 shrink-0">
                    <i class="fa-solid fa-users text-[#7F8A4F] text-lg"></i>
                    <h2 class="text-xl font-semibold text-[#4F6B3F] font-sans whitespace-nowrap">
                        User Accounts <span class="text-[#6A8A52]">({{ count($users) }})</span>
                    </h2>
                </div>

                <!-- Search Input -->
                <div class="relative flex-1 min-w-[250px]">
                    <input id="searchInput" type="text" placeholder="Search user or email..."
                        class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-xl 
               focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans">
                    <svg class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filter Dropdowns -->
                <div class="flex gap-2 shrink-0">
                    <select id="filterType"
                        class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-xl py-2 px-3">
                        <option value="">All Types</option>
                        <option value="admin">Admin</option>
                        <option value="verified_user">Verified User</option>
                        <option value="guest">Guest</option>
                    </select>


                    <select id="filterStatus"
                        class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-xl py-2 px-3">
                        <option value="">All Status</option>
                        <option value="verified">Verified</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

            </div>
        </section>

        <!-- 👥 USERS TABLE -->
        <div id="usersTablePagi">
            <div class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] overflow-x-auto h-[525px]" id="table-data-users">
                @include('admin.partials.users_table') 
            </div>
        </div>
    </div>

    <style>
        /* Compact button styles for table actions */
        .btn-action.compact {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            gap: 0.3rem;
        }

        /* Responsive table */
        @media (max-width: 768px) {
            .btn-action.compact span {
                display: none;
            }

            .btn-action.compact {
                padding: 0.5rem;
                min-width: 2.5rem;
            }

            table {
                font-size: 0.875rem;
            }

            th,
            td {
                padding: 0.5rem 0.25rem;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            function filterUsers() {
                let search = document.getElementById("searchInput").value;
                let type = document.getElementById("filterType").value;
                let status = document.getElementById("filterStatus").value;

                fetch(`/admin/users/filter?search=${search}&type=${type}&status=${status}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById("usersTableBody").innerHTML = html;
                    });
            }

            document.getElementById("searchInput").addEventListener("keyup", filterUsers);
            document.getElementById("filterType").addEventListener("change", filterUsers);
            document.getElementById("filterStatus").addEventListener("change", filterUsers);
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.inactive-toggle').forEach(el => {
                el.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    const span = this;

                    fetch(`/user/${userId}/set-inactive`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({})
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                span.textContent = 'Inactive';
                                span.classList.remove('text-red-600', 'bg-red-50');
                                span.classList.add('text-gray-500', 'bg-gray-100');
                            }
                        })
                        .catch(err => console.error(err));
                });
            });
        });

        function handlePendingVerifications() {
            // Filter to show only unverified users
            alert('Showing unverified users for review...');
            // Implementation for filtering unverified users
        }
        $(document).on('click', '#usersTablePagi .pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            $.get(url, function(data) {
                $('#table-data-users').html(data); // this is your collection table container
            });
        });
    </script>

@endsection
