<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestSubmission;
use Illuminate\Support\Facades\Auth;

class QuestSubmissionController extends Controller
{
    public function store(Request $request)
    {
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
    }
    public function submit(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:quest_submissions,submission_id',
            'proof_link' => 'nullable|url',
            'proof_image' => 'nullable|image|max:2048', // max 2MB
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
    }


}
