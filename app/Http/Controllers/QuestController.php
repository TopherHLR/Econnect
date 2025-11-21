<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestSubmission;
use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use App\Models\User;
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

        // Use custom category if provided
        $data['category'] = $data['custom_category'] ?? $data['category'];

        // Save new quest
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

        // ---- Notify all users ----
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

        return back()->with('success', 'Quest created successfully and notifications sent to users!');
    }
}
