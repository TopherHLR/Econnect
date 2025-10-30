<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EcoLibrary;
use App\Models\UserLibrary;

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

    /**
     * Store a new eco library (Admin only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:50',
        ]);

        $library = EcoLibrary::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'type' => $request->type ?? 'Tip',
            'created_by' => Auth::id(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Library created successfully',
            'data' => $library
        ], 201);
    }

    /**
     * Update an existing library (Admin only).
     */
    public function update(Request $request, $id)
    {
        $library = EcoLibrary::findOrFail($id);

        $library->update($request->only(['title', 'content', 'category', 'type']));

        return response()->json([
            'message' => 'Library updated successfully',
            'data' => $library
        ]);
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

}
