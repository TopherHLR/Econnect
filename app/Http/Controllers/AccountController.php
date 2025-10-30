<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // --- Total Eco Points ---
        $totalPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->sum('points_change');

        // --- Badges Logic ---
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

        // --- Completed Quests ---
        // You can connect this to a real model later; for now use dummy data
        $completedQuests = 0;

        return view('account.profile', [
            'user' => $user,
            'totalPoints' => $totalPoints,
            'earnedBadges' => $earnedBadges,
            'badgeLevel' => $badgeLevel,
            'completedQuests' => $completedQuests,
        ]);
    }
    
    public function myProgress()
    {
        $user = Auth::user();

        // Example values (replace with real logic)
        $totalPoints = \App\Models\UserPointsHistory::where('user_id', $user->user_id)
            ->sum('points_change');

        $earnedBadges = 3;
        $completedQuests = 5;

        if ($totalPoints < 200) {
            $badgeLevel = '🌱 Seed Sprouter';
        } elseif ($totalPoints < 500) {
            $badgeLevel = '🌿 Eco Explorer';
        } else {
            $badgeLevel = '🌳 Green Guardian';
        }

        return view('account.myprogress', compact(
            'user',
            'totalPoints',
            'earnedBadges',
            'completedQuests',
            'badgeLevel'
        ));
    }
}
