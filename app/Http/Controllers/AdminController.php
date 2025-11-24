<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quest;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Admin Home
    public function home()
    {
                // Get distinct categories from already stored quests
        $categories = Quest::distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('admin.adminHome', compact('categories'));
    }
    public function index()
    {
        $users = User::with([
            'savedLibraries.ecoLibrary',
            'savedEcoActions.ecoAction',
            'pointsHistory',
            'userVouchers.voucher',
            'feedbacks'
        ])->get();

        // Log the QR code for each user
        foreach ($users as $user) {
            Log::info('User QR Code', [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'qr_code' => $user->qr_code
            ]);
        }

        return view('admin.adminUsers', compact('users'));
    }
    public function setInactive(User $user)
    {
        \Log::info('User ID received:', ['id' => $user->id ?? 'none']);

        $user->is_active = 0;
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Fetch single user (optional AJAX)
     */
    public function show($id)
    {
        Log::info("Fetching user with ID: {$id}");

        $user = User::with([
            'savedLibraries.ecoLibrary',
            'savedEcoActions.ecoAction',
            'pointsHistory',
            'userVouchers.voucher',
            'feedbacks'
        ])->findOrFail($id);

        Log::info("User {$id} loaded", [
            'savedLibraries' => $user->savedLibraries->toArray(),
            'savedEcoActions' => $user->savedEcoActions->toArray(),
            'pointsHistory' => $user->pointsHistory->toArray(),
            'userVouchers' => $user->userVouchers->toArray(),
            'feedbacks' => $user->feedbacks->toArray(),
        ]);

        return response()->json($user);
    }
    // Admin Quests
    public function quests()
    {
        return view('admin.adminQuests');
    }

    // Admin Rewards
    public function rewards()
    {
        return view('admin.adminRewards');
    }

    // Admin Analytics
    public function analytics()
    {
        return view('admin.adminAnalytics');
    }

    // Admin System Alerts
    public function systemAlerts()
    {
        return view('admin.adminSystemAlerts');
    }

    // Admin Settings
    public function settings()
    {
        return view('admin.adminSettings');
    }

    // Admin Lifestyle
    public function lifestyle()
    {
        return view('admin.adminLifestyle');
    }
    public function verifyUser($qr)
    {
        // Find user by QR
        $user = User::where('qr_code', $qr)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update user type + verification status
        $user->update([
            'user_type' => 'verified_user',
            'is_verified' => true,
        ]);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
