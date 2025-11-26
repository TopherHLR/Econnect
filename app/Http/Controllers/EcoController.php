<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\QuestSubmission;
use App\Models\Notification;
use App\Models\Quest;
use App\Models\User;

class EcoController extends Controller
{
    
    public function getRandomWidgets()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $ecoAction = \App\Models\UserEcoAction::with('ecoAction')
                ->where('user_id', $user->user_id)
                ->inRandomOrder()
                ->first();

            $ecoTopic = \App\Models\UserLibrary::with('ecoLibrary')
                ->where('user_id', $user->user_id)
                ->inRandomOrder()
                ->first();

            return response()->json([
                'eco_action' => $ecoAction && $ecoAction->ecoAction ? [
                    'id' => $ecoAction->ecoAction->action_id,
                    'title' => $ecoAction->ecoAction->title,
                ] : null,
                'eco_topic' => $ecoTopic && $ecoTopic->ecoLibrary ? [
                    'id' => $ecoTopic->ecoLibrary->library_id,
                    'title' => $ecoTopic->ecoLibrary->title,
                ] : null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Earned points (ignore voided)
            $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
                ->where('points_change', '>', 0)
                ->where('voided', false)
                ->sum('points_change');

            // Spent points (ignore voided)
            $pointsSpent = abs(
                UserPointsHistory::where('user_id', $user->user_id)
                    ->where('points_change', '<', 0)
                    ->where('voided', false)
                    ->sum('points_change')
            );
            if ($user) {
                // Automatically assign a small quest if applicable
                $this->autoAssignSmallQuest($user->user_id);
            }
            $currentPoints = $progressPoints - $pointsSpent;
        } else {
            // Default values for guests
            $progressPoints = 0;
            $pointsSpent = 0;
            $currentPoints = 0;
        }

        // Tree stages
        $treeStages = 7;

        // Define points required per stage
        $stageThresholds = [50, 100, 200, 300, 450, 550, 700];

        // Determine current stage
        $stage = 1;
        foreach ($stageThresholds as $index => $threshold) {
            if ($progressPoints < $threshold) {
                break;
            }
            $stage = $index + 2; // Stage shifts up by 1
        }

        // Current stage's next target (growth max)
        $growthMax = $stageThresholds[$stage - 1] ?? end($stageThresholds);

        // Previous threshold for this stage
        $prevThreshold = $stage > 1
            ? $stageThresholds[$stage - 2]
            : 0;

        // Compute percentage within the stage
        $growthPercent = ($growthMax - $prevThreshold) > 0
            ? (($progressPoints - $prevThreshold) / ($growthMax - $prevThreshold)) * 100
            : 0;

        $growthPercent = min(100, max(0, $growthPercent));

        // ⭐ FETCH FEEDBACK (merging FeedbackController logic)
        $feedback = \App\Models\Feedback::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('home', compact(
            'currentPoints',
            'growthPercent',
            'progressPoints',
            'growthMax',
            'stage',
            'treeStages',
            'feedback' // ← now passed to the view
        ));
    }
    

    private function autoAssignSmallQuest($creatorUserId)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow(); // 24-hour duration

        // Check if a "Daily Eco Action" already exists globally
        $existingQuest = Quest::where('title', 'Daily Eco Action')
            ->whereDate('start_date', $today)
            ->whereDate('end_date', $tomorrow)
            ->first();

        if ($existingQuest) {
            return; // Quest already exists, do not create
        }

        // Create the global daily quest
        $quest = Quest::create([
            'title' => 'Daily Eco Action',
            'description' => 'Complete a small eco-action today! Get 100 Tree taps today.',
            'category' => 'Small Quest',
            'points_reward' => 5,
            'start_date' => $today,
            'end_date' => $tomorrow,
            'status' => 'active',
            'created_by' => '2'
        ]);

        // Get all guest users
        $users = User::where('user_type', 'guest')->get();

        foreach ($users as $user) {
            // Create a QuestSubmission for each user with pending status
            QuestSubmission::create([
                'user_id' => $user->user_id,
                'quest_id' => $quest->quest_id,
                'status' => 'pending',
                'date_submitted' => now(),
            ]);

            // Notify the user
            Notification::create([
                'user_id' => $user->user_id,
                'from_user_id' => $creatorUserId,
                'type' => 'new_quest',
                'reference_id' => $quest->quest_id,
                'title' => 'New Quest Available!',
                'message' => "A new quest \"{$quest->title}\" has been assigned to you. Complete it within 24 hours!",
                'created_at' => now(),
            ]);
        }
    }


}
