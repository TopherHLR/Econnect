<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcoAction;
use App\Models\UserEcoAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Optional for simple logging

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

    public function store(Request $request)
    {
        try {
            // Debug: check if method is called
            Log::debug('EcoAction store() method called', [
                'request_data' => $request->all()
            ]);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'nullable|string|max:100',
                'points_value' => 'required|integer|min:1',
                'is_active' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(resource_path('images/eco-actions'), $imageName);

                // Debug: log image upload
                Log::debug("Image uploaded: " . $imageName);
            }

            $action = EcoAction::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category ?? 'General',
                'points_value' => $request->points_value,
                'is_active' => $request->is_active ?? true,
                'image' => $imageName,
                'created_by' => Auth::id(),
                'created_at' => now(),
            ]);

            // Debug: log the newly created action
            Log::debug('EcoAction created', $action->toArray());

            return redirect()
                ->route('adminLifestyle')
                ->with('success', 'Eco Action created successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to create EcoAction', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Redirect back with an error message
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create Eco Action. Please try again.');
        }
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
