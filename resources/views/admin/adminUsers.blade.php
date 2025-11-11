@extends('layouts.adminLayout')

@section('title', 'Users')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-semibold text-[#4F6B3F]">Users</h1>
        <p class="text-[#6A8A52] mt-1">Manage user accounts and verification status.</p>
    </div>

   <!-- Search and Actions -->
<div class="flex flex-wrap items-center gap-4">
    <!-- Left Side: Search & Filter -->
    <div class="flex items-center gap-3">
        <!-- Search Input -->
        <div class="relative w-104">
            <input 
                type="text" 
                placeholder="Search user or email..."
                class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B]"
            >
            <svg 
                class="absolute right-3 top-3 w-4 h-4 text-[#7A8C4F]" 
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" 
                />
            </svg>
        </div>

        <!-- Filter Dropdown -->
        <select 
            class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2 px-4 
                   focus:outline-none focus:ring-2 focus:ring-[#7A8C4F]"
        >
            <option value="">All Types</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
            <option value="guest">Guest</option>
        </select>

        <!-- Verify Button -->
        <button onclick="openVerifyModal()" class="btn-eco btn-sand">
            <i class="fa-solid fa-qrcode"></i>
            <span>Verify User</span>
        </button>
    </div>
</div>


    

    <!-- Users Table -->
<div class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7]">
    <table class="min-w-full text-sm text-[#4F3B2C]">
  <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
    <tr>
      <th class="px-4 py-3 text-left font-semibold">#</th>
      <th class="px-4 py-3 text-left font-semibold">Name</th>
      <th class="px-4 py-3 text-left font-semibold">Email</th>
      <th class="px-4 py-3 text-left font-semibold">User Type</th>
      <th class="px-4 py-3 text-left font-semibold">Verified</th>
      <th class="px-4 py-3 text-left font-semibold">Registered</th>
      <th class="px-4 py-3 text-left font-semibold">Actions</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($users as $index => $user)
    <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">
      <td class="px-4 py-2">{{ $index + 1 }}</td>
      <td class="px-4 py-2">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
      <td class="px-4 py-2">{{ $user->email }}</td>
      <td class="px-4 py-2">{{ $user->user_type }}</td>
      <td class="px-4 py-2">{{ $user->is_verified ? 'Yes' : 'No' }}</td>
      <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>

      <td class="px-4 py-2 flex flex-wrap gap-1.5">
        <!-- View -->
        <button
          class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-medium text-[#4F3B2C] shadow-sm transition-all duration-300 bg-gradient-to-br from-[#E0E5D8] to-[#BFD8B8] hover:from-[#DEE8D2] hover:to-[#B4D2A8]"
          title="View User"
          onclick="alert('View user {{ $user->first_name }}')">
          <i class="fas fa-eye text-[0.8rem]"></i> View
        </button>

        <!-- Edit -->
        <button
          class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-medium text-[#4F6B3F] shadow-sm transition-all duration-300 bg-gradient-to-br from-[#E0E5D8] to-[#D0DAC7] hover:from-[#D8E2CA] hover:to-[#C6D4B8]"
          title="Edit User"
          onclick="alert('Edit user {{ $user->first_name }}')">
          <i class="fas fa-edit text-[0.8rem]"></i> Edit
        </button>

        <!-- Delete -->
        <button
          class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-medium text-[#4F3B2C] shadow-sm transition-all duration-300 bg-gradient-to-br from-[#D8B08C] to-[#C89E7B] hover:from-[#E0B996] hover:to-[#C89E7B]"
          title="Delete User"
          onclick="if(confirm('Are you sure you want to delete {{ $user->first_name }}?')){ alert('Deleted {{ $user->first_name }}'); }">
          <i class="fas fa-trash text-[0.8rem]"></i> Delete
        </button>

        <!-- Verify -->
        @if(!$user->is_verified)
        <button
          class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-medium text-[#4F3B2C] shadow-sm transition-all duration-300 bg-gradient-to-br from-[#D4C1A3] to-[#C4B094] hover:from-[#E1D1B7] hover:to-[#CDB799]"
          title="Verify User"
          onclick="alert('Verified {{ $user->first_name }}')">
          <i class="fas fa-check-circle text-[0.8rem]"></i> Verify
        </button>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>


    </div>
</div>
@endsection
@include('modal.verifyUserModal')