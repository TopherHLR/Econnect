<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPointsHistory;
use App\Models\QuestSubmission;

class LeaderboardController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        // ---------- Top by Progress Points ----------
        $topByPoints = User::with('questSubmissions')
            ->where('user_type', '!=', 'admin')
            ->get()
            ->map(function ($user) {
                $progressPoints = UserPointsHistory::where('user_id', $user->user_id ?? 0)
                    ->where('points_change', '>', 0)
                    ->where('voided', false)
                    ->sum('points_change');

                $questsCompleted = $user->questSubmissions
                    ? $user->questSubmissions->where('status', 'completed')->count()
                    : 0;

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
                $user->questsCompleted = $user->questSubmissions
                    ? $user->questSubmissions->where('status', 'completed')->count()
                    : 0;
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

        // Safely handle current user being null
        $myPoints = $myQuests = $myDailyTaps = $rankPoints = $rankQuests = $rankTaps = 0;

        if ($currentUser) {
            $myPoints = UserPointsHistory::where('user_id', $currentUser->user_id)
                ->where('points_change', '>', 0)
                ->where('voided', false)
                ->sum('points_change');

            $myQuests = $currentUser->questSubmissions()
                ? $currentUser->questSubmissions()->where('status', 'completed')->count()
                : 0;

            $myDailyTaps = $currentUser->questSubmissions()
                ? $currentUser->questSubmissions()
                    ->where('status', 'completed')
                    ->whereHas('quest', fn ($q) => $q->where('title', 'Daily Eco Taps'))
                    ->count()
                : 0;

            // Ranks calculation safely
            $rankPoints = User::where('user_type', '!=', 'admin')->get()
                ->map(fn($u) => [
                    'id' => $u->user_id,
                    'points' => UserPointsHistory::where('user_id', $u->user_id)
                        ->where('points_change', '>', 0)
                        ->where('voided', false)
                        ->sum('points_change'),
                ])
                ->sortByDesc('points')
                ->pluck('id')
                ->search($currentUser->user_id) + 1;

            $rankQuests = User::where('user_type', '!=', 'admin')->get()
                ->map(fn($u) => [
                    'id' => $u->user_id,
                    'quests' => $u->questSubmissions ? $u->questSubmissions()->where('status', 'completed')->count() : 0,
                ])
                ->sortByDesc('quests')
                ->pluck('id')
                ->search($currentUser->user_id) + 1;

            $rankTaps = User::where('user_type', '!=', 'admin')
                ->withCount(['questSubmissions as taps' => fn($q) => $q
                    ->where('status', 'completed')
                    ->whereHas('quest', fn($qq) => $qq->where('title', 'Daily Eco Taps'))])
                ->orderByDesc('taps')
                ->get()
                ->pluck('user_id')
                ->search($currentUser->user_id) + 1;
        }

        // Tree Stage Logic
        $thresholds = [50, 100, 200, 300, 450, 550, 700];
        $stage = 1;
        foreach ($thresholds as $i => $t) {
            if ($myPoints < $t) break;
            $stage = $i + 2;
        }

        $currentThreshold = $thresholds[$stage - 2] ?? 0;
        $nextThreshold = $thresholds[$stage - 1] ?? end($thresholds);
        $progress = $nextThreshold > $currentThreshold
            ? (($myPoints - $currentThreshold) / ($nextThreshold - $currentThreshold)) * 100
            : 100;

        $treeStageSvgs = [
            1 => 'seed.svg',
            2 => 'sprout.svg',
            3 => 'seedling.svg',
            4 => 'young_tree.svg',
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

        $progressPercent = $nextThreshold ? min(100, ($myPoints / $nextThreshold) * 100) : 0;
        $pointsRemaining = max(0, $nextThreshold - $myPoints);
        // Count pending quests for this user
        $pendingQuests = QuestSubmission::where('user_id', $user->id ?? 0)
                            ->where('status', 'pending')
                            ->count();

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
            'pendingQuests',
        ));
    }
}
