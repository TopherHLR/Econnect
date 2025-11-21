<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // 🔹 Shared logic for user account data
    private function getAccountData()
    {
        $user = Auth::user();

        $totalPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->sum('points_change');

        $earnedBadges = 0;
        $badgeLevel = null;

        if ($totalPoints >= 1000) {
            $earnedBadges = 3;
            $badgeLevel = '🌿 Eco Legend (1000+ pts)';
        } elseif ($totalPoints >= 500) {
            $earnedBadges = 2;
            $badgeLevel = '🌱 Green Guardian (500+ pts)';
        } elseif ($totalPoints >= 200) {
            $earnedBadges = 1;
            $badgeLevel = '🌸 Eco Starter (200+ pts)';
        } else {
            $badgeLevel = 'Keep going! Earn more points to unlock your first badge.';
        }

        // Dummy data for now
        $completedQuests = 0;

        return compact('user', 'totalPoints', 'earnedBadges', 'badgeLevel', 'completedQuests');
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
