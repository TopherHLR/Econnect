<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcoLibrary;
use App\Models\EcoAction;
use App\Models\UserLibrary;
use App\Models\UserEcoAction;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    /**
     * Display the lifestyle page with topics and actions.
     */
    public function lifestyle(Request $request)
    {
        $search = $request->input('search'); // get search term
        $category = $request->input('category'); // optional category filter

        // Topics
        $ecoTopics = EcoLibrary::where('type', 'Topic')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Actions
        $ecoActions = EcoAction::when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Saved items logic (same as before)
        $savedTopics = collect();

        if (Auth::check()) {
            $savedLibraries = UserLibrary::with('ecoLibrary')
                ->where('user_id', Auth::id())
                ->get();

            foreach ($savedLibraries as $item) {
                if ($item->ecoLibrary) {
                    $savedTopics->push((object)[
                        'id' => $item->ecoLibrary->library_id,
                        'title' => $item->ecoLibrary->title,
                        'image' => $item->ecoLibrary->image,
                        'category' => $item->ecoLibrary->category,
                        'type' => 'ecoTopic',
                        'done' => false,
                    ]);
                }
            }

            $savedEcoActions = UserEcoAction::with('ecoAction')
                ->where('user_id', Auth::id())
                ->get();

            foreach ($savedEcoActions as $item) {
                if ($item->ecoAction) {
                    $savedTopics->push((object)[
                        'id' => $item->ecoAction->action_id,
                        'title' => $item->ecoAction->title,
                        'image' => $item->ecoAction->image,
                        'category' => $item->ecoAction->category,
                        'type' => 'ecoAction',
                        'done' => true,
                    ]);
                }
            }
        }

        return view('lifestyle', [
            'ecoTopics' => $ecoTopics,
            'ecoActions' => $ecoActions,
            'savedTopics' => $savedTopics,
        ]);
    }
    /**
     * API: Display a listing of all libraries.
     */
    public function index(Request $request)
    {
        $query = EcoLibrary::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $libraries = $query->orderBy('created_at', 'desc')->get();

        return response()->json($libraries);
    }

    /**
     * API: Display a single library by ID.
     */
    public function show($id)
    {
        $library = EcoLibrary::findOrFail($id);
        return response()->json($library);
    }

    /**
     * Save a library or action to user's collection.
     */
    public function saveLibrary(Request $request, $id)
    {
        $user = Auth::user();
        $type = $request->input('type'); // ecoTopic or ecoAction

        if ($type === 'ecoTopic') {
            // Save EcoLibrary (Topic)
            $item = EcoLibrary::where('type', 'Topic')->findOrFail($id);
            $exists = UserLibrary::where('user_id', $user->user_id)
                ->where('library_id', $id)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Already saved');
            }

            UserLibrary::create([
                'user_id' => $user->user_id,
                'library_id' => $id,
                'saved_at' => now(),
            ]);
        } elseif ($type === 'ecoAction') {
            // Save EcoAction
            $item = EcoAction::findOrFail($id);
            $exists = UserEcoAction::where('user_id', $user->user_id)
                ->where('action_id', $id)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Already saved');
            }

            UserEcoAction::create([
                'user_id' => $user->user_id,
                'action_id' => $id,
                'log_date' => now(),
            ]);
        } else {
            return redirect()->back()->with('error', 'Invalid item type');
        }

        return redirect()->back()->with('success', 'Library saved successfully');
    }

    /**
     * Unsave a library or action.
     */
    public function unsaveLibrary($id)
    {
        $user = Auth::user();

        // Try unsaving from UserLibrary (Topics)
        $deleted = UserLibrary::where('user_id', $user->user_id)
            ->where('library_id', $id)
            ->delete();

        // Try unsaving from UserEcoAction (Actions)
        if (!$deleted) {
            $deleted = UserEcoAction::where('user_id', $user->user_id)
                ->where('action_id', $id)
                ->delete();
        }

        if ($deleted) {
            return redirect()->back()->with('success', 'Library removed');
        }

        return redirect()->back()->with('error', 'Not found');
    }

    /**
     * Mark an eco action as done (log it in UserEcoAction).
     */
    public function markDone($id)
    {
        $user = Auth::user();
        $item = EcoAction::findOrFail($id);

        // Check if already logged
        $exists = UserEcoAction::where('user_id', $user->user_id)
            ->where('action_id', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Action already completed');
        }

        UserEcoAction::create([
            'user_id' => $user->user_id,
            'action_id' => $id,
            'log_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Action marked as done');
    }

    /**
     * API: Get all saved libraries of the logged-in user.
     */
    public function myLibraries()
    {
        $user = Auth::user();

        $savedLibraries = UserLibrary::with('ecoLibrary')
            ->where('user_id', $user->user_id)
            ->orderBy('saved_at', 'desc')
            ->get();

        return response()->json($savedLibraries);
    }

    // ==============================
    // ADMIN FUNCTIONS
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:50',
            'source_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $imageName = null;

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

                // Store in storage/app/public/eco-library
                $request->file('image')->storeAs('eco-library', $imageName, 'public');
            }

            $library = EcoLibrary::create([
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'type' => $request->type ?? 'Tip',
                'source_link' => $request->source_link,
                'image' => $imageName,
                'created_by' => Auth::id(),
                'created_at' => now(),
            ]);

            return redirect()
                ->route('adminLifestyle')
                ->with('success', 'Eco Topic created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating Eco Topic: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create Eco Topic. Please try again.');
        }
    }


    public function update(Request $request, $id)
    {
        $library = EcoLibrary::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:50',
            'source_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $library->update($request->only(['title', 'content', 'category', 'type', 'source_link']));

        // IMAGE UPDATE
        if ($request->hasFile('image')) {

            // Delete old image if exists
            if ($library->image && Storage::disk('public')->exists('eco-library/' . $library->image)) {
                Storage::disk('public')->delete('eco-library/' . $library->image);
            }

            // Store new image in storage/app/public/eco-library
            $filename = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('eco-library', $filename, 'public');

            $library->image = $filename;
            $library->save();
        }

        return redirect()
            ->route('adminLifestyle')
            ->with('success', 'Eco Topic updated successfully!');
    }

    // Archive a topic (soft "delete")
    public function archive($id)
    {
        $topic = EcoLibrary::findOrFail($id);
        
        $topic->update([
            'archive' => true,
            'archived_by' => Auth::id(), // optional: track who archived
            'archived_at' => now(),
        ]);

        return back()->with('success', 'Eco Topic archived successfully.');
    }

    // Optional: Restore archived topic
    public function restore($id)
    {
        $topic = EcoLibrary::findOrFail($id);
        $topic->update(['archive' => false]);

        return back()->with('success', 'Eco Topic restored.');
    }
    public function showTopics()
    {
        $ecoLibraries = EcoLibrary::where('type', 'Topic')->orderBy('created_at', 'desc')->get();
        $savedLibraries = UserLibrary::with('ecoLibrary')->where('user_id', Auth::id())->get();
        $categories = EcoLibrary::distinct()->pluck('category')->filter()->values();
        return view('lifestyle', compact('ecoLibraries', 'savedLibraries', 'categories'));
    }

    public function showActions()
    {
        $ecoLibraries = EcoLibrary::where('type', 'Action')->orderBy('created_at', 'desc')->get();
        $savedLibraries = UserLibrary::with('ecoLibrary')->where('user_id', Auth::id())->get();
        $categories = EcoLibrary::distinct()->pluck('category')->filter()->values();
        return view('lifestyle', compact('ecoLibraries', 'savedLibraries', 'categories'));
    }
    public function showAction($id)
    {
        $action = EcoAction::findOrFail($id);
        return response()->json($action);
    }
    public function adminIndex()
    {
        $ecoTopics = EcoLibrary::where('type', 'Topic')
            ->where('archive', 0) // ✅ only not archived
            ->orderBy('created_at', 'desc')
            ->get();

        $ecoActions = EcoAction::where('archive', 0) // ✅ only not archived
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.adminLifestyle', compact('ecoTopics', 'ecoActions'));
    }

    
}