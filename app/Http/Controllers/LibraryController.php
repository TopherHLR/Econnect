<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcoLibrary;
use App\Models\UserLibrary;
use App\Models\EcoAction;
use App\Models\UserEcoAction;

class LibraryController extends Controller
{
    /**
     * Display a listing of all libraries (for users).
     */
    public function index(Request $request)
    {
        $query = EcoLibrary::query();

        // Optional filters: category or type
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
     * Display a single library by ID.
     */
    public function show($id)
    {
        $library = EcoLibrary::findOrFail($id);
        return response()->json($library);
    }

    /**
     * Save a library to user's collection.
     */
    public function saveLibrary($id)
    {
        $user = Auth::user();

        // Prevent duplicates
        $exists = UserLibrary::where('user_id', $user->user_id)
            ->where('library_id', $id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already saved'], 409);
        }

        UserLibrary::create([
            'user_id' => $user->user_id,
            'library_id' => $id,
            'saved_at' => now(),
        ]);

        return response()->json(['message' => 'Library saved successfully']);
    }

    /**
     * Unsave a library (remove from user's saved list).
     */
    public function unsaveLibrary($id)
    {
        $user = Auth::user();

        $deleted = UserLibrary::where('user_id', $user->user_id)
            ->where('library_id', $id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Library removed']);
        }

        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Get all saved libraries of the logged-in user.
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
        // Validate the input
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category'    => 'nullable|string|max:100',
            'type'        => 'nullable|string|max:50',
            'source_link' => 'nullable|url|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // ✅ validate image
        ]);

        try {
            // Handle image upload
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(resource_path('images/eco-library'), $imageName);
            }

            // Create EcoLibrary entry
            $library = EcoLibrary::create([
                'title'       => $request->title,
                'content'     => $request->content,
                'category'    => $request->category,
                'type'        => $request->type ?? 'Tip',
                'source_link' => $request->source_link,
                'image'       => $imageName,
                'created_by'  => Auth::id(),
                'created_at'  => now(),
            ]);

            return redirect()
                ->route('adminLifestyle')
                ->with('success', 'Eco Topic created successfully!');
                
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating Eco Topic: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create Eco Topics.Please try again.');
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
        ]);

        $library->update($request->only(['title', 'content', 'category', 'type', 'source_link']));

        // Redirect to admin home with a success message
        return redirect()
            ->route('admin.home') // 👈 change this to your actual admin home route name
            ->with('success', 'Eco Topic updated successfully!');
    }


    /**
     * Delete a library entry (Admin only).
     */
    public function destroy($id)
    {
        $library = EcoLibrary::findOrFail($id);
        $library->delete();

        return response()->json(['message' => 'Library deleted successfully']);
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
    public function adminIndex()
    {
        // Get topics from EcoLibrary
        $ecoTopics = EcoLibrary::where('type', 'Topic')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get actions from EcoAction
        $ecoActions = EcoAction::orderBy('created_at', 'desc')->get();

        return view('admin.adminLifestyle', compact('ecoTopics', 'ecoActions'));
    }

    public function lifestyle()
    {
        $ecoTopics = EcoLibrary::where('type', 'Topic')
            ->orderBy('created_at', 'desc')
            ->get();

        $ecoActions = EcoAction::where('type', 'Action')
            ->orderBy('created_at', 'desc')
            ->get();

        $savedLibraries = UserLibrary::with('ecoLibrary')
            ->where('user_id', Auth::id())
            ->get();

        $savedActions = UserEcoAction::with('ecoActions')
            ->where('user_id', Auth::id())
            ->get();


        // Separate saved topics and actions
        $savedTopics = $savedLibraries->filter(fn($lib) => $lib->ecoLibrary->type === 'Topic')->pluck('ecoLibrary');
        $savedActions = $savedActions->filter(fn($lib) => $lib->ecoAction->type === 'Action')->pluck('ecoAction');

        return view('lifestyle', compact('ecoTopics', 'ecoActions', 'savedTopics', 'savedActions'));
    }


}
