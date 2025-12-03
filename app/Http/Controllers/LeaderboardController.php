<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPointsHistory;

class LeaderboardController extends Controller
{
    public function index()
    {
        // ---------- Top by Progress Points ----------
        $topByPoints = User::with('questSubmissions')
            ->where('user_type', '!=', 'admin')
            ->get()
            ->map(function ($user) {

                // ✔️ Same logic used in your original code
                $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
                    ->where('points_change', '>', 0)
                    ->where('voided', false)
                    ->sum('points_change');

                $questsCompleted = $user->questSubmissions
                    ->where('status', 'completed')
                    ->count();

                // Your formula
                $user->progressPoints = $progressPoints;

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
        $topDailyTaps = User::where('user_type', '!=', 'admin')
            ->withCount(['questSubmissions as dailyEcoTaps' => function ($query) {
                $query->where('status', 'completed')
                    ->whereHas('quest', fn ($q) => $q->where('title', 'Daily Eco Taps'));
            }])
            ->orderByDesc('dailyEcoTaps')
            ->take(10)
            ->get();

        $currentUser = auth()->user();

        // Current user's progress points (same logic as leaderboard)
        $myPoints = \App\Models\UserPointsHistory::where('user_id', $currentUser->user_id)
            ->where('points_change', '>', 0)
            ->where('voided', false)
            ->sum('points_change');

        $myQuests = $currentUser->questSubmissions()->where('status', 'completed')->count();

        $myDailyTaps = $currentUser
            ->questSubmissions()
            ->where('status', 'completed')
            ->whereHas('quest', fn ($q) => $q->where('title', 'Daily Eco Taps'))
            ->count();

        // Ranks calculation
        $rankPoints =
            \App\Models\User::where('user_type', '!=', 'admin')
                ->get()
                ->map(
                    fn ($u) => [
                        'id' => $u->user_id,
                        'points' => \App\Models\UserPointsHistory::where('user_id', $u->user_id)
                            ->where('points_change', '>', 0)
                            ->where('voided', false)
                            ->sum('points_change'),
                    ],
                )
                ->sortByDesc('points')
                ->pluck('id')
                ->search($currentUser->user_id) + 1;

        $rankQuests =
            \App\Models\User::where('user_type', '!=', 'admin')
                ->get()
                ->map(
                    fn ($u) => [
                        'id' => $u->user_id,
                        'quests' => $u->questSubmissions()->where('status', 'completed')->count(),
                    ],
                )
                ->sortByDesc('quests')
                ->pluck('id')
                ->search($currentUser->user_id) + 1;

        $rankTaps =
            \App\Models\User::where('user_type', '!=', 'admin')
                ->withCount([
                    'questSubmissions as taps' => fn ($q) => $q
                        ->where('status', 'completed')
                        ->whereHas('quest', fn ($qq) => $qq->where('title', 'Daily Eco Taps')),
                ])
                ->orderByDesc('taps')
                ->get()
                ->pluck('user_id')
                ->search($currentUser->user_id) + 1;

        // Tree Stage Logic
        $thresholds = [50, 100, 200, 300, 450, 550, 700];
        $stage = 1;
        foreach ($thresholds as $i => $t) {
            if ($myPoints < $t) {
                break;
            }
            $stage = $i + 2;
        }
        $currentThreshold = $thresholds[$stage - 2] ?? 0;
        $nextThreshold = $thresholds[$stage - 1] ?? end($thresholds);
        $progress =
            $nextThreshold > $currentThreshold
                ? (($myPoints - $currentThreshold) / ($nextThreshold - $currentThreshold)) * 100
                : 100;

        // In your LeaderboardController@index()
        $treeStageSvgs = [
            1 => null,
            2 => 'sprout.svg',
            3 => 'seedling.svg',
            4 => 'young_tree.svg',        // or whatever you named it
            5 => 'sapling.svg',
            6 => 'young_tree.svg',
            7 => 'growing_tree.svg',

        ];

        $treeNames = [
            1 => 'Seed',
            2 => 'Sprout',
            3 => 'Seedling',
            4 => 'Young Sapling',
            5 => 'Sapling',
            6 => 'Young Tree',
            7 => 'Growing Tree',

        ];
        $progressPercent = min(100, ($myPoints / $nextThreshold) * 100); // percentage
        $pointsRemaining = max(0, $nextThreshold - $myPoints);

        return view('leaderboard', compact(
            'treeStageSvgs',
            'treeNames',
            'stage',
            'nextThreshold',
            'progressPercent',
            'pointsRemaining',
            'thresholds',
            'myPoints',
            'rankPoints',
            'myDailyTaps',
            'rankTaps',
            'rankQuests',
            'myQuests',
            'progress',
            'topByPoints',
            'topByQuests',
            'topDailyTaps',

        ));
    }
}
