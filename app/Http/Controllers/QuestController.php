<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\QuestSubmission;
use Illuminate\Http\Request;

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

        return view('admin.adminQuests', compact('quests', 'categories'));
    }

    public function archive($id)
    {
        $quest = Quest::findOrFail($id);
        $quest->status = 'archived';
        $quest->save();

        return redirect()->back()->with('success', 'Quest archived successfully.');
    }
    public function recover($id)
    {
        $quest = Quest::findOrFail($id);
        $quest->status = 'active'; // make it active again
        $quest->save();

        return redirect()->back()->with('success', 'Quest recovered successfully.');
    }
    public function updateStatus(Request $request, $id)
    {
        $quest = Quest::findOrFail($id);
        $request->validate([
            'status' => 'required|in:active,ending_soon,closed',
        ]);
        $quest->status = $request->status;
        $quest->save();

        return redirect()->back()->with('success', 'Quest status updated successfully.');
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
        Quest::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'points_reward' => $data['points_reward'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'],
            'created_by' => auth()->id(), // match model relationship
        ]);

        return back()->with('success', 'Quest created successfully!');
    }
}
