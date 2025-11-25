<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestSubmission;
use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Notification; // make sure to import at the top

class QuestController extends Controller
{
    public function index()
    {
        $quests = Quest::with('submissions.user') // load users for submissions
                    ->orderBy('start_date', 'desc')
                    ->get();

        $categories = Quest::distinct()
                        ->pluck('category')
                        ->filter()
                        ->values();

                // Get all submissions grouped by quest
        $questSubmissions = [];

        foreach ($quests as $quest) {
            foreach ($quest->submissions as $submission) {
                $questSubmissions[$quest->quest_id][] = [
                    'id' => $submission->submission_id,
                    'user' => $submission->user->first_name . ' ' . $submission->user->last_name,
                    'status' => $submission->status,
                    'proof_link' => $submission->proof_link,
                    'proof_image' => $submission->proof_image,
                ];
            }
        }


        return view('admin.adminQuests', compact('quests', 'categories', 'questSubmissions'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:quest_submissions,submission_id',
            'action' => 'required|in:verify,reject',
            'verified_by' => 'required_if:action,verify|string|max:255',
        ]);

        $submission = QuestSubmission::findOrFail($request->submission_id);

        if ($request->action === 'verify') {
            $submission->status = 'completed';
            $submission->verified_by = $request->verified_by;
            $submission->save();

            // Add points history record
            UserPointsHistory::create([
                'user_id' => $submission->user_id,
                'activity_type' => 'Quest',
                'source_id' => $submission->submission_id,
                'points_change' => $submission->quest->points_reward,
                'created_at' => now(),
            ]);

            // ---- Notification for user ----
            Notification::create([
                'user_id' => $submission->user_id, // receiver
                'from_user_id' => auth()->id(),    // admin who verified
                'type' => 'quest_verified',
                'reference_id' => $submission->submission_id,
                'title' => 'Quest Submission Verified',
                'message' => "Your submission for '{$submission->quest->title}' has been verified by {$request->verified_by}. You earned {$submission->quest->points_reward} points!",
                'created_at' => now(),
            ]);
        }

        elseif ($request->action === 'reject') {
            $submission->status = 'rejected';
            $submission->verified_by = $request->verified_by;
            $submission->save();

            // ---- Notification for user ----
            Notification::create([
                'user_id' => $submission->user_id,
                'from_user_id' => auth()->id(),
                'type' => 'quest_rejected',
                'reference_id' => $submission->submission_id,
                'title' => 'Quest Submission Rejected',
                'message' => "Your submission for '{$submission->quest->title}' has been rejected by {$request->verified_by}.",
                'created_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', "Submission has been {$request->action}d.");
    }

    public function userQuests()
    {
        $quests = Quest::with('submissions.user') // load users for submissions
                    ->orderBy('start_date', 'desc')
                    ->get();

        $categories = Quest::distinct()
                        ->pluck('category')
                        ->filter()
                        ->values();

        return view('quests', compact('quests', 'categories'));
    }
    public function recover2($id)
    {
        $quest = Quest::findOrFail($id);
        $quest->status = 'active';
        $quest->save();

        return response()->json(['success' => true]);
    }

    public function recover($id)
    {
        $quest = Quest::findOrFail($id);
        $quest->status = 'active'; // make it active again
        $quest->save();

        return redirect()->back()->with('success', 'Quest recovered successfully.');
    }
    public function archive($id)
    {
        $quest = Quest::findOrFail($id);
        $quest->status = 'archived';
        $quest->save();

        return response()->json(['success' => 'Quest archived successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $quest = Quest::findOrFail($id);
        $request->validate([
            'status' => 'required|in:active,ending_soon,closed',
        ]);
        $quest->status = $request->status;
        $quest->save();

        return response()->json(['success' => 'Quest status updated successfully.']);
    }
    public function updateStatusQuestAdmin(Request $request, $submissionId)
    {
        \Log::info('updateStatusQuestAdmin called', [
            'submissionId' => $submissionId,
            'requestedStatus' => $request->status,
            'adminId' => auth()->id(),
        ]);

        $request->validate([
            'status' => 'required|in:pending,completed,rejected',
        ]);

        $submission = QuestSubmission::findOrFail($submissionId);
        $oldStatus = $submission->status;
        $newStatus = $request->status;
        $points = $submission->quest->points_reward;

        \Log::info('Submission loaded', [
            'oldStatus' => $oldStatus,
            'newStatus' => $newStatus,
            'pointsReward' => $points,
            'userId' => $submission->user_id,
        ]);

        // Update submission status
        $submission->status = $newStatus;
        $submission->save();

        \Log::info('Submission status updated', [
            'submissionId' => $submission->submission_id,
            'newStatus' => $submission->status,
        ]);

        // Fetch existing quest points history
        $pointsRecord = UserPointsHistory::where('activity_type', 'Quest')
            ->where('source_id', $submission->submission_id)
            ->where('user_id', $submission->user_id)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | CASE 1: Marking as COMPLETED
        |--------------------------------------------------------------------------
        */
        if ($oldStatus !== 'completed' && $newStatus === 'completed') {

            // Award or unvoid points
            if ($pointsRecord) {
                $pointsRecord->voided = false;
                $pointsRecord->save();
            } else {
                UserPointsHistory::create([
                    'user_id' => $submission->user_id,
                    'activity_type' => 'Quest',
                    'source_id' => $submission->submission_id,
                    'points_change' => $points,
                    'voided' => false,
                    'created_at' => now(),
                ]);
            }

            \Log::info('Points added/unvoided', [
                'userId' => $submission->user_id,
                'points' => $points,
            ]);

            // Notify quest completion
            Notification::create([
                'user_id' => $submission->user_id,
                'from_user_id' => auth()->id(),
                'type' => 'quest_verified',
                'reference_id' => $submission->submission_id,
                'title' => 'Quest Submission Verified',
                'message' => "Your submission for '{$submission->quest->title}' has been verified. You earned {$points} points!",
                'created_at' => now(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | BADGE MILESTONE SYSTEM
            |--------------------------------------------------------------------------
            | Award ONLY when hitting *exact milestones*:
            | 1, 5, 15, 30, 50 completed quests
            |--------------------------------------------------------------------------
            */

            $completedQuests = QuestSubmission::where('user_id', $submission->user_id)
                ->where('status', 'completed')
                ->count();

            $badgeMilestones = [
                1  => 'Eco-Novice',
                5  => 'Eco-Explorer',
                15 => 'Eco-Enthusiast',
                30 => 'Eco-Advocate',
                50 => 'Eco-Guardian',
            ];

            if (isset($badgeMilestones[$completedQuests])) {

                $badgeName = $badgeMilestones[$completedQuests];

                Notification::create([
                    'user_id' => $submission->user_id,
                    'from_user_id' => auth()->id(),
                    'type' => 'badge_unlocked',
                    'reference_id' => null,
                    'title' => 'New Badge Unlocked!',
                    'message' => "Congratulations! You unlocked the '{$badgeName}' badge. Check it in your My Progress page!",
                    'created_at' => now(),
                ]);

                \Log::info("Badge unlocked: {$badgeName}", [
                    'userId' => $submission->user_id,
                    'completedQuests' => $completedQuests,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CASE 2: Reverting or Rejecting
        |--------------------------------------------------------------------------
        | Admin sets COMPLETED → PENDING or COMPLETED → REJECTED
        | We VOID points (do not delete)
        | No badge changes, no badge removal.
        |--------------------------------------------------------------------------
        */
        elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {

            if ($pointsRecord) {
                $pointsRecord->voided = true;
                $pointsRecord->save();
            }

            \Log::info('Points record voided', [
                'userId' => $submission->user_id,
                'points' => $points,
            ]);

            Notification::create([
                'user_id' => $submission->user_id,
                'from_user_id' => auth()->id(),
                'type' => 'quest_status_changed',
                'reference_id' => $submission->submission_id,
                'title' => $newStatus === 'pending'
                    ? 'Quest Submission Reverted to Pending'
                    : 'Quest Submission Rejected',
                'message' => "The status of your submission for '{$submission->quest->title}' has been changed to '{$newStatus}'. Points have been adjusted accordingly.",
                'created_at' => now(),
            ]);
        }


        \Log::info('updateStatusQuestAdmin finished', [
            'submissionId' => $submission->submission_id,
            'finalStatus' => $submission->status,
        ]);

        return response()->json(['success' => true, 'status' => $newStatus]);
    }






    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'category' => 'nullable|string',
            'custom_category' => 'nullable|string',
            'points_reward' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,ending_soon,closed',
        ]);

        $data['category'] = $data['custom_category'] ?? $data['category'];

        $quest = Quest::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'points_reward' => $data['points_reward'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'],
            'created_by' => auth()->id(),
        ]);

        $users = User::where('user_type', 'guest')->get();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->user_id,
                'from_user_id' => auth()->id(),
                'type' => 'new_quest',
                'reference_id' => $quest->quest_id,
                'title' => 'New Quest Available!',
                'message' => "A new quest \"{$quest->title}\" has been added. Check it out!",
                'created_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Quest created successfully and notifications sent to users!',
            'quest' => $quest
        ]);
    }


    public function update(Request $request, Quest $quest)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'points_reward' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,ending_soon,closed',
        ]);

        $quest->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Quest updated successfully!',
                'quest' => $quest
            ]);
        }

        return redirect()->back()->with('success', 'Quest updated successfully!');
    }

    // QuestController.php
    public function getPendingQuestsByQr($qr_code)
    {
        Log::info("Fetching pending quests for QR code: {$qr_code}");

        $user = User::where('qr_code', $qr_code)->first();

        if (!$user) {
            Log::warning("User not found for QR code: {$qr_code}");
            return response()->json([
                'error' => 'User not found for QR code: '.$qr_code
            ], 404);
        }

        $pendingQuests = $user->questSubmissions()
            ->where('status', 'pending')
            ->with('quest')
            ->get();

        Log::info("User found: {$user->user_id} - {$user->first_name} {$user->last_name}");
        Log::info("Pending quests count: " . $pendingQuests->count());

        return response()->json([
            'user' => [
                'id' => $user->user_id,
                'name' => "{$user->first_name} {$user->last_name}",
                'email' => $user->email,
            ],
            'pendingQuests' => $pendingQuests,
        ]);
    }

}
