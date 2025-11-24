<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use Illuminate\Support\Facades\Password; // ← add this
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // 🔹 Shared logic for user account data
    private function getAccountData()
    {
        $user = Auth::user();

        // Total earned points (sum of all positive points)
        $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '>', 0)
            ->sum('points_change');

        // Points spent on vouchers (absolute value of negative points)
        $pointsSpent = abs(UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '<', 0)
            ->sum('points_change'));

        // Current points available for redemption
        $currentPoints = $progressPoints - $pointsSpent;

        // Badges based on total earned points
        $earnedBadges = 0;
        $badgeLevel = null;

        if ($progressPoints >= 1000) {
            $earnedBadges = 3;
            $badgeLevel = '🌿 Eco Legend (1000+ pts)';
        } elseif ($progressPoints >= 500) {
            $earnedBadges = 2;
            $badgeLevel = '🌱 Green Guardian (500+ pts)';
        } elseif ($progressPoints >= 200) {
            $earnedBadges = 1;
            $badgeLevel = '🌸 Eco Starter (200+ pts)';
        } else {
            $badgeLevel = 'Keep going! Earn more points to unlock your first badge.';
        }

        // Dummy data for now
        $completedQuests = 0;

        return compact('user', 'progressPoints', 'currentPoints', 'earnedBadges', 'badgeLevel', 'completedQuests');
    }
        // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
        ]);

        $user->update($request->only('first_name','middle_name','last_name','email'));

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Send password reset email
    public function sendPasswordResetEmail(Request $request)
    {
        $user = Auth::user();
        Password::sendResetLink(['email' => $user->email]);

        return redirect()->back()->with('success', 'Password reset email sent to ' . $user->email);
    }
    
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = $request->new_password;
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    // --- Profile Page ---
    public function show()
    {
        return view('account.profile', $this->getAccountData());
    }

    // --- My Progress Page ---
    public function myProgress()
    {
        return view('account.myprogress', $this->getAccountData());
    }

    // --- Rewards Page ---
    public function rewards()
    {
        return view('account.rewards', $this->getAccountData());
    }
}
