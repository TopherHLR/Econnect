<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use Illuminate\Support\Facades\Auth;

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

            // Earned points
            $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
                ->where('points_change', '>', 0)
                ->sum('points_change');

            // Spent points
            $pointsSpent = abs(
                UserPointsHistory::where('user_id', $user->user_id)
                    ->where('points_change', '<', 0)
                    ->sum('points_change')
            );

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
            if ($progressPoints >= $threshold) {
                $stage = $index + 1;
            } else {
                break;
            }
        }

        // Current stage max for progress bar
        $growthMax = $stageThresholds[$stage - 1];

        // Growth percentage relative to current stage
        $prevThreshold = $stage > 1 ? $stageThresholds[$stage - 2] : 0;
        $growthPercent = $growthMax - $prevThreshold > 0
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




}
