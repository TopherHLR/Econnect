<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;

use App\Models\UserVoucher;
use App\Models\Voucher;

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
