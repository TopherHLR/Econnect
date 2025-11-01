<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcoAction;
use App\Models\UserEcoAction;
use Illuminate\Support\Facades\Auth;

class ActionController extends Controller
{
    /**
     * Display all active eco actions for users.
     */
    public function index()
    {
        $actions = EcoAction::where('is_active', true)
            ->orderBy('category')
            ->get();

        return view('actions.index', compact('actions'));
    }

    /**
     * Display all eco actions (admin view).
     */
    public function adminIndex()
    {
        $actions = EcoAction::orderBy('created_by')
            ->orderBy('category')
            ->get();

        return view('admin.actions.index', compact('actions'));
    }

    /**
     * Show a single eco action’s details.
     */
    public function show($id)
    {
        $action = EcoAction::findOrFail($id);
        return view('actions.show', compact('action'));
    }

    /**
     * Create a new eco action (admin only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'category'     => 'nullable|string|max:100',
            'points_value' => 'required|integer|min:1',
            'is_active'    => 'boolean',
        ]);

        $action = EcoAction::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'category'     => $request->category ?? 'General',
            'points_value' => $request->points_value,
            'is_active'    => $request->is_active ?? true,
            'created_by'   => Auth::id(),
            'created_at'   => now(), // Add this
        ]);

        return redirect()
            ->route('adminHome')
            ->with('success', 'Eco Action created successfully!');
    }


    /**
     * Update an existing eco action (admin only).
     */
    public function update(Request $request, $id)
    {
        $action = EcoAction::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'category'     => 'nullable|string|max:100',
            'points_value' => 'required|integer|min:1',
            'is_active'    => 'boolean',
        ]);

        $action->update($request->only([
            'title', 'description', 'category', 'points_value', 'is_active'
        ]));

        return response()->json([
            'message' => 'Eco Action updated successfully.',
            'data' => $action
        ]);
    }

    /**
     * Delete an eco action (admin only).
     */
    public function destroy($id)
    {
        $action = EcoAction::findOrFail($id);
        $action->delete();

        return response()->json(['message' => 'Eco Action deleted successfully.']);
    }

    /**
     * User logs completion of an eco action.
     */
    public function completeAction($id)
    {
        $user = Auth::user();
        $action = EcoAction::findOrFail($id);

        // Prevent duplicate logs for the same day
        $alreadyLogged = UserEcoAction::where('user_id', $user->user_id)
            ->where('action_id', $id)
            ->whereDate('log_date', now()->toDateString())
            ->exists();

        if ($alreadyLogged) {
            return response()->json(['message' => 'You already completed this action today.'], 400);
        }

        // Log the user’s eco action
        $log = UserEcoAction::create([
            'user_id' => $user->user_id,
            'action_id' => $id,
            'log_date' => now(),
            'points_earned' => $action->points_value,
        ]);

        return response()->json([
            'message' => 'Eco Action completed successfully!',
            'points_earned' => $action->points_value,
            'log' => $log
        ]);
    }

    /**
     * Get all actions completed by the current user.
     */
    public function myActions()
    {
        $user = Auth::user();

        $completedActions = UserEcoAction::with('ecoAction')
            ->where('user_id', $user->user_id)
            ->orderByDesc('log_date')
            ->get();

        return view('actions.my-actions', compact('completedActions'));
    }
}
