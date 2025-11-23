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
            $tapCount = $request->taps ?? 0;

            // Early exit if no taps
            if ($tapCount <= 0) {
                return response()->json([
                    'message' => 'No taps detected.',
                    'has_quest' => false,
                    'tap_progress' => 0
                ], 200);
            }

            // Get authenticated user
            $user = auth()->user();
            if (!$user) {
                // Safe JSON response for guests
                return response()->json([
                    'message' => 'Please log in to track taps and earn points.',
                    'has_quest' => false,
                    'tap_progress' => $tapCount
                ], 200); // 200 so your frontend can still read the response safely
            }

            // From here on, $user is guaranteed
            $today = \Carbon\Carbon::today();

            // Safe to use $user->pointsHistory() now
            $todayPoints = $user->pointsHistory()
                ->whereDate('created_at', $today)
                ->sum('points_change');

            $pointsToGive = floor($tapCount / 100);
            if ($todayPoints >= 2) {
                $pointsToGive = 0; // Already reached daily max
            } else {
                $pointsToGive = min($pointsToGive, 2 - $todayPoints);
            }

            // Save points if any
            if ($pointsToGive > 0) {
                \App\Models\UserPointsHistory::create([
                    'user_id' => $user->user_id,
                    'points_change' => $pointsToGive,
                    'created_at' => now(),
                ]);
            }

            // Fetch the active "Daily Eco Action" quest
            $dailyQuest = \App\Models\Quest::where('category', 'Small Quest')
                ->where('title', 'Daily Eco Action')
                ->whereDate('start_date', $today)
                ->first();

            $smallQuestSubmission = null;
            $message = 'Current tap progress: 0';

            if ($dailyQuest) {
                // Get or create the user's QuestSubmission for this quest
                $smallQuestSubmission = \App\Models\QuestSubmission::firstOrCreate(
                    [
                        'user_id' => $user->user_id,
                        'quest_id' => $dailyQuest->quest_id
                    ],
                    [
                        'status' => 'pending',
                        'date_submitted' => now(),
                    ]
                );

                // If already completed, show a message and do not increment taps
                if ($smallQuestSubmission->status === 'completed') {
                    $message = 'You have already completed today\'s tree-tapping mission. Come back tomorrow for a new mission!';
                } else {
                    // Add cumulative taps
                    $smallQuestSubmission->tap_progress = ($smallQuestSubmission->tap_progress ?? 0) + $tapCount;

                    // Complete the quest if cumulative taps >= 100
                    if ($smallQuestSubmission->tap_progress >= 100 && $smallQuestSubmission->status !== 'completed') {
                        $smallQuestSubmission->status = 'completed';
                        $smallQuestSubmission->date_completed = now();
                    }

                    $smallQuestSubmission->save();
                    $message = 'Current tap progress: ' . $smallQuestSubmission->tap_progress;
                }
            }

            return response()->json([
                'message' => $message,
                'points_awarded' => $pointsToGive,
                'has_quest' => (bool) $smallQuestSubmission,
                'quest_status' => $smallQuestSubmission?->status ?? null,
                'tap_progress' => $smallQuestSubmission?->tap_progress ?? $tapCount,
            ]);

        } catch (\Throwable $e) {
            \Log::error('Tree Tap Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }






}
