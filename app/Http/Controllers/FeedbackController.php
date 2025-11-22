<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{


    // Store feedback from a form
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to submit feedback.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Feedback::create([
            'user_id' => Auth::user()->user_id,
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
