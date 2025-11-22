<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use App\Models\Quest;
use Carbon\Carbon;
use Auth;

class TreeController extends Controller
{
    public function tapTree(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $today = \Carbon\Carbon::today();
            $tapCount = $request->taps ?? 0;

            // How many points to give based on taps
            $pointsToGive = floor($tapCount / 100);
            if ($pointsToGive <= 0) {
                return response()->json(['message' => 'Not enough taps', 'has_quest' => false], 200);
            }

            // Daily tap points limit
            $todayPoints = \App\Models\UserPointsHistory::where('user_id', $user->user_id)
                ->whereDate('created_at', $today)
                ->where('source', 'tree_tap')
                ->sum('points_change');

            if ($todayPoints >= 2) {
                return response()->json(['message' => 'Daily tree tap limit reached', 'has_quest' => true], 200);
            }

            $allowed = 2 - $todayPoints;
            $pointsToGive = min($pointsToGive, $allowed);

            // Save points
            \App\Models\UserPointsHistory::create([
                'user_id' => $user->user_id,
                'points_change' => $pointsToGive,
                'source' => 'tree_tap',
                'created_at' => now(),
            ]);

            // Check if the user has an active Daily Eco Action quest today
            $smallQuestSubmission = \App\Models\QuestSubmission::where('user_id', $user->user_id)
                ->whereHas('quest', function ($q) use ($today) {
                    $q->where('category', 'Small Quest')
                    ->where('title', 'Daily Eco Action')
                    ->whereDate('start_date', $today);
                })
                ->first();

            // If the user completed the taps (example: 100 taps = 1 point), mark quest as completed
            if ($smallQuestSubmission && $tapCount >= 100) { // adjust 100 if your goal is different
                $smallQuestSubmission->status = 'completed';
                $smallQuestSubmission->date_completed = now();
                $smallQuestSubmission->save();
            }

            return response()->json([
                'message' => 'Points added successfully',
                'points_awarded' => $pointsToGive,
                'has_quest' => (bool) $smallQuestSubmission,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Tree Tap Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error: '.$e->getMessage()], 500);
        }
    }

}
