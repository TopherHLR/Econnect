<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quest;
use App\Models\QuestSubmission;
use App\Models\Feedback;
use App\Models\UserPointsHistory;
use App\Models\UserVoucher;
use App\Models\Notification;

use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Admin Home
    public function home()
    {
        // ======== USERS ========
        $totalUsers = User::count();
        $verifiedUsers = User::where('is_verified', true)->count();

        // User verification growth (last 7 days vs previous 7 days)
        $verifiedLast7 = User::where('is_verified', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $verifiedPrev7 = User::where('is_verified', true)
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->count();

        $userGrowth = $verifiedPrev7 > 0
            ? round((($verifiedLast7 - $verifiedPrev7) / $verifiedPrev7) * 100)
            : $verifiedLast7;


        // ======== QUESTS ========
        $liveQuests = Quest::where('status', 'live')->count();
        $upcomingQuests = Quest::where('status', 'upcoming')->count();
        $totalQuests = Quest::count();

        // Pending submissions
        $pendingSubmissions = QuestSubmission::where('status', 'pending')->count();

        // Overdue → pending more than 3 days
        $overdueSubmissions = QuestSubmission::where('status', 'pending')
            ->where('date_submitted', '<', now()->subDays(3))
            ->count();


        // ======== VOUCHERS ========
        $vouchersThisWeek = UserVoucher::whereBetween('redeemed_date', [now()->startOfWeek(), now()])
            ->count();

        $vouchersLastWeek = UserVoucher::whereBetween('redeemed_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        $voucherGrowth = $vouchersThisWeek - $vouchersLastWeek;


        // ======== ECO ACTIONS ========
        $ecoActionsLast7 = UserPointsHistory::where('activity_type', 'Tree Tap')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // Average daily eco actions
        $avgDailyEcoActions = $ecoActionsLast7 / 7;

        // Comparison: last week
        $ecoActionsPrev7 = UserPointsHistory::where('activity_type', 'Eco Action')
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->count();


        // ======== POINTS DISTRIBUTED ========
        $pointsDistributed = UserPointsHistory::where('voided', false)
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('points_change');


        // ======== FEEDBACK ========
        $newFeedbackCount = Feedback::where('created_at', '>=', now()->subDays(7))
            ->count();


        // ======== QUEST CATEGORIES ========
        $categories = Quest::distinct()->pluck('category')->filter()->values();

        // ======== ECO ACTIONS - PER DAY (7 days) ========
        $ecoActionsDaily = [];
        for ($i = 6; $i >= 0; $i--) {
            $ecoActionsDaily[] = UserPointsHistory::where('activity_type', 'Tree Tap')
                ->whereDate('created_at', now()->subDays($i))
                ->count();
        }

        // ======== POINTS DISTRIBUTED - PER DAY (7 days) ========
        $pointsDaily = [];
        for ($i = 6; $i >= 0; $i--) {
            $pointsDaily[] = UserPointsHistory::where('voided', false)
                ->whereDate('created_at', now()->subDays($i))
                ->sum('points_change');
        }



        return view('admin.adminHome', compact(
            'totalUsers',
            'verifiedUsers',
            'userGrowth',
            'liveQuests',
            'upcomingQuests',
            'totalQuests',
            'pendingSubmissions',
            'overdueSubmissions',
            'vouchersThisWeek',
            'voucherGrowth',
            'avgDailyEcoActions',
            'ecoActionsPrev7',
            'pointsDistributed',
            'newFeedbackCount',
            'categories',
            'ecoActionsDaily',   // <-- add this
            'pointsDaily'        // <-- add this
        ));
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
