<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPointsHistory;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = User::with('pointsHistory')
            ->where('user_type', '!=', 'admin') // 🚫 exclude admins
            ->get()
            ->map(function ($user) {
                $user->progressPoints = $user->pointsHistory
                    ->where('points_change', '>', 0)
                    ->sum('points_change');

                return $user;
            })
            ->sortByDesc('progressPoints')
            ->values();

        return view('leaderboard', compact('leaderboard'));
    }


}

