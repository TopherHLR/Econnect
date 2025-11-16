<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    public function index()
    {
        // Get distinct categories from already stored quests
        $categories = Quest::distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('admin.adminQuests', compact('categories'));
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
