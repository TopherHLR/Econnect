<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcoAction;
use App\Models\UserEcoAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Optional for simple logging

class ActionController extends Controller
{

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
                'type' => 'nullable|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('eco-actions', $imageName, 'public');

                Log::debug("Image uploaded: " . $imageName);
            }

            $action = EcoAction::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category ?? 'General',
                'type' => $request->type ?? 'General',
                'image' => $imageName,
                'created_by' => Auth::id(),
                'created_at' => now(),
            ]);

            Log::debug('EcoAction created', $action->toArray());

            return redirect()
                ->route('adminLifestyle')
                ->with('success', 'Eco Action created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create EcoAction', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $action->update($request->only([
            'title', 'description', 'category', 'type'
        ]));

        // IMAGE UPDATE — follow the same pattern as EcoTopic
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($action->image && Storage::disk('public')->exists('eco-actions/' . $action->image)) {
                Storage::disk('public')->delete('eco-actions/' . $action->image);
            }

            // Store new image in storage/app/public/eco-actions
            $filename = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('eco-actions', $filename, 'public');

            $action->image = $filename;
            $action->save();
        }

        return redirect()
            ->route('adminLifestyle')
            ->with('success', 'Eco Action updated successfully!');
    }

    // Archive an action
    public function archive($id)
    {
        $action = EcoAction::findOrFail($id);

        $action->update([
            'archive' => true,
            'archived_by' => Auth::id(),
            'archived_at' => now(),
        ]);

        return back()->with('success', 'Eco Action archived successfully.');
    }

    // Restore archived action
    public function restore($id)
    {
        $action = EcoAction::findOrFail($id);
        $action->update(['archive' => false]);

        return back()->with('success', 'Eco Action restored.');
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
        ]);

        return response()->json([
            'message' => 'Eco Action completed successfully!',
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
