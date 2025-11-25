<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPointsHistory;
use App\Models\QuestSubmission;
use App\Models\UserEcoAction;

class LeaderboardController extends Controller
{
    public function index()
    {
        // ---------- Top by Progress Points ----------
        $topByPoints = User::with(['pointsHistory', 'questSubmissions'])
            ->where('user_type', '!=', 'admin')
            ->get()
            ->map(function ($user) {
                $ecoPoints = $user->pointsHistory->where('points_change', '>', 0)->sum('points_change');
                $questsCompleted = $user->questSubmissions->where('status', 'completed')->count();

                $user->progressPoints = $ecoPoints + ($questsCompleted * 10); // adjust formula
                return $user;
            })
            ->sortByDesc('progressPoints')
            ->values()
            ->take(10);

        // ---------- Top by Completed Quests ----------
        $topByQuests = User::with('questSubmissions')
            ->where('user_type', '!=', 'admin')
            ->get()
            ->map(function ($user) {
                $user->questsCompleted = $user->questSubmissions->where('status', 'completed')->count();
                return $user;
            })
            ->sortByDesc('questsCompleted')
            ->values()
            ->take(10);

        // ---------- Top by Daily Eco Actions ----------
        $topDailyActions = User::where('user_type', '!=', 'admin')
            ->withCount(['questSubmissions as dailyEcoActions' => function ($query) {
                $query->where('status', 'completed')
                    ->whereHas('quest', fn($q) => $q->where('title', 'Daily Eco Action'));
            }])
            ->orderByDesc('dailyEcoActions')
            ->take(10)
            ->get();



        return view('leaderboard', compact(
            'topByPoints',
            'topByQuests',
            'topDailyActions',

        ));
    }

}

