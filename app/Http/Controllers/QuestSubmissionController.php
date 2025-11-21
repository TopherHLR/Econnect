<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestSubmission;
use Illuminate\Support\Facades\Auth;

class QuestSubmissionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'quest_id' => 'required|exists:quests,quest_id',
            ]);
            // Check if the user already accepted this quest
            $existing = QuestSubmission::where('quest_id', $request->quest_id)
                                    ->where('user_id', Auth::id())
                                    ->first();
            if ($existing) {
                return redirect()->back()->with('error', 'You have already accepted this quest.');
            }

            // Create QuestSubmission
            QuestSubmission::create([
                'quest_id' => $request->quest_id,
                'user_id' => Auth::id(),
                'status' => 'pending', // default
                'date_submitted' => now(),
            ]);

            return redirect()->back()->with('success', 'Quest accepted successfully!');

        } catch (\Exception $e) {
            // Catch any unexpected error and show a detailed error message
            return redirect()->back()->with('error', 'Failed to accept quest. Error: ' . $e->getMessage());
        }
    }

    public function submit(Request $request)
    {
        try {
            $request->validate([
                'submission_id' => 'required|exists:quest_submissions,submission_id',
                'proof_link' => 'nullable|url',
                'proof_image' => 'nullable|image|max:5120', // 5MB
            ]);
            $submission = QuestSubmission::findOrFail($request->submission_id);

            // Save link if provided
            if ($request->filled('proof_link')) {
                $submission->proof_link = $request->proof_link;
            }

            // Save image if uploaded
            if ($request->hasFile('proof_image')) {
                $imagePath = $request->file('proof_image')->store('quest_proofs', 'public');
                $submission->proof_image = $imagePath;
            }

            $submission->status = 'pending';
            $submission->date_completed = now();
            $submission->save();

            return redirect()->back()->with('success', 'Quest progress submitted successfully!');

        } catch (\Exception $e) {
            // Catch unexpected errors and show detailed error message
            return redirect()->back()->with('error', 'Failed to submit quest progress. Error: ' . $e->getMessage());
        }
    }
}
