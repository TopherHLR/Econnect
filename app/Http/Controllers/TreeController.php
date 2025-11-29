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
                    'tap_progress' => 0,
                    'progressPoints' => 0, // ensure defined
                ], 200);
            }

            if (!$user) {
                return response()->json([
                    'message' => 'Please log in to track taps and earn points.',
                    'has_quest' => false,
                    'tap_progress' => $tapCount,
                    'progressPoints' => 0,
                ], 200);
            }

            $today = \Carbon\Carbon::today();

            // Safe to use $user->pointsHistory() now
            $todayPoints = $user->pointsHistory()
                ->whereDate('created_at', $today)
                ->sum('points_change');

            $pointsToGive = floor($tapCount / 100);

            if ($todayPoints >= 2) {
                $pointsToGive = 0;
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

            // Fetch active daily quest
            $dailyQuest = \App\Models\Quest::where('category', 'Small Quest')
                ->where('title', 'Daily Eco Taps')
                ->whereDate('start_date', $today)
                ->first();

            $smallQuestSubmission = null;
            $message = 'Current tap progress: 0';

            if ($dailyQuest) {
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

                // Reset tap_progress if it was already >=100 but still pending
                if ($smallQuestSubmission->status === 'pending' && ($smallQuestSubmission->tap_progress ?? 0) >= 100) {
                    $smallQuestSubmission->tap_progress = 0;
                    $smallQuestSubmission->save();
                }

                if ($smallQuestSubmission->status === 'completed') {
                    $message = 'You have already completed today\'s tree-tapping mission. Come back tomorrow for a new mission!';
                } else {
                    $smallQuestSubmission->tap_progress = ($smallQuestSubmission->tap_progress ?? 0) + $tapCount;

                    if ($smallQuestSubmission->tap_progress >= 100 && $smallQuestSubmission->status !== 'completed') {
                        $smallQuestSubmission->status = 'completed';
                        $smallQuestSubmission->date_completed = now();
                        $smallQuestSubmission->save();

                        // Add 5 points for completing the quest
                        \App\Models\UserPointsHistory::create([
                            'user_id' => $user->user_id,
                            'points_change' => 5,
                            'created_at' => now(),
                        ]);
                    }

                    $smallQuestSubmission->save();
                    $message = 'Current tap progress: ' . $smallQuestSubmission->tap_progress;
                }
            }

            // Total points earned today
            $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
                ->whereDate('created_at', $today)
                ->sum('points_change');

            return response()->json([
                'message' => $message,
                'points_awarded' => $smallQuestSubmission && $smallQuestSubmission->status === 'completed' ? 5 : 0,
                'has_quest' => (bool) $smallQuestSubmission,
                'quest_status' => $smallQuestSubmission?->status ?? null,
                'tap_progress' => $smallQuestSubmission?->tap_progress ?? $tapCount,
                'progressPoints' => $progressPoints,
            ]);

        } catch (\Throwable $e) {
            \Log::error('Tree Tap Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }







}
