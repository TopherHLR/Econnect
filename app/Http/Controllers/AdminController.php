<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Quest;
use App\Models\QuestSubmission;
use App\Models\Feedback;
use App\Models\UserPointsHistory;
use App\Models\UserLibrary;
use App\Models\UserAction;
use App\Models\EcoAction;
use App\Models\EcoLibrary;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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
        $pendingSubmissions = QuestSubmission::where('status', 'pending')->count();
        $overdueSubmissions = QuestSubmission::where('status', 'pending')
            ->where('date_submitted', '<', now()->subDays(3))
            ->count();

        // ======== VOUCHERS ========
        $vouchersThisWeek = UserVoucher::whereBetween('redeemed_date', [now()->startOfWeek(), now()])->count();
        $vouchersLastWeek = UserVoucher::whereBetween(
            'redeemed_date',
            [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]
        )->count();
        $voucherGrowth = $vouchersThisWeek - $vouchersLastWeek;

        // ======== ECO ACTIONS SUMMARY ========
        $ecoActionsLast7 = UserPointsHistory::where('activity_type', 'Tree Tap')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $avgDailyEcoActions = $ecoActionsLast7 / 7;

        $ecoActionsPrev7 = UserPointsHistory::where('activity_type', 'Tree Tap')
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->count();

        // ======== POINTS DISTRIBUTED (EARNED ONLY) ========
        $pointsDistributed = UserPointsHistory::where('voided', false)
            ->where('points_change', '>', 0) // exclude negative points
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('points_change');

        // ======== POINTS REDEEMED (SPENT) ========
        $pointsRedeemed = UserPointsHistory::where('activity_type', 'Voucher Redemption')
            ->where('voided', false)
            ->where('created_at', '>=', now()->subDays(7))
            ->sum(DB::raw('ABS(points_change)'));

        // ======== FEEDBACK ========
        $newFeedbackCount = Feedback::where('created_at', '>=', now()->subDays(7))->count();

        // ======== QUEST CATEGORIES ========
        $categories = Quest::distinct()->pluck('category')->filter()->values();

        // -------- ECO ACTIONS (Tree Tap only) --------
        $ecoActionsDailyRaw = UserPointsHistory::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('activity_type', 'Tree Tap')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $ecoActionsDaily = [];
        $dayLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $ecoActionsDaily[] = $ecoActionsDailyRaw[$day] ?? 0;
            $dayLabels[] = now()->subDays($i)->format('D'); // Mon, Tue, Wed...
        }

        // -------- POINTS DISTRIBUTED PER DAY (EARNED ONLY) --------
        $pointsDailyRaw = UserPointsHistory::selectRaw('DATE(created_at) as date, SUM(points_change) as total')
            ->where('voided', false)
            ->where('points_change', '>', 0)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $pointsDaily = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $pointsDaily[] = $pointsDailyRaw[$day] ?? 0;
        }

        // -------- POINTS REDEEMED PER DAY --------
        $pointsRedeemedDailyRaw = UserPointsHistory::selectRaw('DATE(created_at) as date, SUM(ABS(points_change)) as total')
            ->where('activity_type', 'Voucher Redemption')
            ->where('voided', false)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $pointsRedeemedDaily = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $pointsRedeemedDaily[] = $pointsRedeemedDailyRaw[$day] ?? 0;
        }

        // Total Quests Accomplished
        $questsAccomplished = QuestSubmission::where('status', 'completed')->count();

        // Total Vouchers Used (redeemed)
        $vouchersUsed = UserVoucher::whereNotNull('redeemed_date')->count();

        // ======== LEADERBOARD: MOST ACTIVE USERS ========
        $users = User::with(['pointsHistory', 'savedLibraries', 'savedEcoActions', 'userVouchers'])->get();

        $activeUsersLeaderboard = collect();

        foreach ($users as $user) {
            $lastActivityDates = collect();

            if ($user->pointsHistory->count()) $lastActivityDates->push($user->pointsHistory->max('created_at'));
            if ($user->savedLibraries->count()) $lastActivityDates->push($user->savedLibraries->max('saved_at'));
            if ($user->savedEcoActions->count()) $lastActivityDates->push($user->savedEcoActions->max('log_date'));
            if ($user->userVouchers->count()) $lastActivityDates->push($user->userVouchers->max('redeemed_date'));

            $lastActivity = $lastActivityDates->count() ? $lastActivityDates->max() : null;

            // Consider active if last activity within 6 months
            if ($lastActivity && \Carbon\Carbon::parse($lastActivity)->gte(now()->subMonths(6))) {
                $activityCount = $user->pointsHistory->count()
                    + $user->savedLibraries->count()
                    + $user->savedEcoActions->count()
                    + $user->userVouchers->count();

                $activeUsersLeaderboard->push((object)[
                    'user' => $user,
                    'activityCount' => $activityCount,
                ]);
            }
        }

        // Sort descending by activity count and take top 10
        $topActiveUsers = $activeUsersLeaderboard->sortByDesc('activityCount')->values()->take(10);

        // Most Saved Library Category (by saved libraries)
        $mostCategorySaved = UserLibrary::join('eco_library', 'user_libraries.library_id', '=', 'eco_library.library_id')
            ->select('eco_library.category', DB::raw('COUNT(*) as total'))
            ->groupBy('eco_library.category')
            ->orderByDesc('total')
            ->first();

        $mostCategorySavedName = $mostCategorySaved ? $mostCategorySaved->category : 'N/A';
        $topByPoints = $users->map(function($user) {
            $progressPoints = $user->pointsHistory->sum('points_change');
            return (object)[
                'user' => $user,
                'progressPoints' => $progressPoints,
            ];
        })->sortByDesc('progressPoints')->values()->take(10);
        $topByQuests = $users->map(function($user) {
            $questsCompleted = $user->pointsHistory->where('activity_type', 'Quest')->count()
                + $user->userVouchers->where('status', 'completed')->count(); // optional if you track completion elsewhere
            return (object)[
                'user' => $user,
                'questsCompleted' => $questsCompleted,
            ];
        })->sortByDesc('questsCompleted')->values()->take(10);
        $topDailyActions = $users->map(function($user) {
            $dailyEcoActions = $user->pointsHistory->where('activity_type', 'Tree Tap')
                ->where('created_at', '>=', now()->startOfDay())->count();
            return (object)[
                'user' => $user,
                'dailyEcoActions' => $dailyEcoActions,
            ];
        })->sortByDesc('dailyEcoActions')->values()->take(10);

        $topLibrarySavers = $users->map(function($user) {
            return (object)[
                'user' => $user,
                'librarySaves' => $user->savedLibraries->count(),
            ];
        })->sortByDesc('librarySaves')->values()->take(10);
        $topVoucherRedeemers = $users->map(function($user) {
            return (object)[
                'user' => $user,
                'vouchersRedeemed' => $user->userVouchers->whereNotNull('redeemed_date')->count(),
            ];
        })->sortByDesc('vouchersRedeemed')->values()->take(10);

        $topPointsLast7Days = $users->map(function($user) {
            $pointsEarned = $user->pointsHistory->where('created_at', '>=', now()->subDays(7))
                ->where('points_change', '>', 0)->sum('points_change');
            return (object)[
                'user' => $user,
                'pointsEarned' => $pointsEarned,
            ];
        })->sortByDesc('pointsEarned')->values()->take(10);

        $categoriesAction = EcoAction::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');
            
        $categoriesLibrary = EcoLibrary::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');
        // ======== MOST DESERVING PLAYER (Highest Points Earned in Last 7 Days) ========
        $mostDeserving = $users->map(function($user) {
            $pointsEarned = $user->pointsHistory->where('created_at', '>=', now()->subDays(7))
                ->where('points_change', '>', 0)
                ->sum('points_change');

            return (object)[
                'user' => $user,
                'pointsEarned' => $pointsEarned,
            ];
        })
        ->sortByDesc('pointsEarned')
        ->first(); // Top 1

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
            'pointsRedeemed',
            'newFeedbackCount',
            'categories',
            'categoriesAction',
            'categoriesLibrary',
            'ecoActionsDaily',
            'pointsDaily',
            'pointsRedeemedDaily',
            'dayLabels',
            'questsAccomplished',
            'vouchersUsed',
            'topActiveUsers',
            'mostCategorySavedName',
            'topByPoints',
            'topByQuests',
            'topDailyActions',
            'topLibrarySavers',
            'topVoucherRedeemers',
            'topPointsLast7Days',
            'mostDeserving'

        ));

    }

    public function index(Request $request)
    {
        $users = User::with([
            'savedLibraries.ecoLibrary',
            'savedEcoActions.ecoAction',
            'pointsHistory',
            'userVouchers.voucher',
            'feedbacks'
        ])->paginate(2);
        
        // Log the QR code for each user
        foreach ($users as $user) {
            Log::info('User QR Code', [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'qr_code' => $user->qr_code
            ]);
        }
        if ($request->ajax()) {
            return view('admin.partials.users_table', compact('users'))->render();
        }
        
        $categoriesAction = EcoAction::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');
            
        $categoriesLibrary = EcoLibrary::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');
        return view('admin.adminUsers', compact('users','categoriesLibrary','categoriesAction'));
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
        $pendingSubmissions = QuestSubmission::where('status', 'pending')->count();
        $overdueSubmissions = QuestSubmission::where('status', 'pending')
            ->where('date_submitted', '<', now()->subDays(3))
            ->count();

        // ======== VOUCHERS ========
        $vouchersThisWeek = UserVoucher::whereBetween('redeemed_date', [now()->startOfWeek(), now()])->count();
        $vouchersLastWeek = UserVoucher::whereBetween(
            'redeemed_date',
            [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]
        )->count();
        $voucherGrowth = $vouchersThisWeek - $vouchersLastWeek;

        // ======== ECO ACTIONS SUMMARY ========
        $ecoActionsLast7 = UserPointsHistory::where('activity_type', 'Tree Tap')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $avgDailyEcoActions = $ecoActionsLast7 / 7;

        $ecoActionsPrev7 = UserPointsHistory::where('activity_type', 'Tree Tap')
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->count();

        // ======== POINTS DISTRIBUTED (EARNED ONLY) ========
        $pointsDistributed = UserPointsHistory::where('voided', false)
            ->where('points_change', '>', 0) // exclude negative points
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('points_change');

        // ======== POINTS REDEEMED (SPENT) ========
        $pointsRedeemed = UserPointsHistory::where('activity_type', 'Voucher Redemption')
            ->where('voided', false)
            ->where('created_at', '>=', now()->subDays(7))
            ->sum(DB::raw('ABS(points_change)'));

        // ======== FEEDBACK ========
        $newFeedbackCount = Feedback::where('created_at', '>=', now()->subDays(7))->count();

        // ======== QUEST CATEGORIES ========
        $categories = Quest::distinct()->pluck('category')->filter()->values();

        // -------- ECO ACTIONS (Tree Tap only) --------
        $ecoActionsDailyRaw = UserPointsHistory::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('activity_type', 'Tree Tap')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $ecoActionsDaily = [];
        $dayLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $ecoActionsDaily[] = $ecoActionsDailyRaw[$day] ?? 0;
            $dayLabels[] = now()->subDays($i)->format('D'); // Mon, Tue, Wed...
        }

        // -------- POINTS DISTRIBUTED PER DAY (EARNED ONLY) --------
        $pointsDailyRaw = UserPointsHistory::selectRaw('DATE(created_at) as date, SUM(points_change) as total')
            ->where('voided', false)
            ->where('points_change', '>', 0)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $pointsDaily = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $pointsDaily[] = $pointsDailyRaw[$day] ?? 0;
        }

        // -------- POINTS REDEEMED PER DAY --------
        $pointsRedeemedDailyRaw = UserPointsHistory::selectRaw('DATE(created_at) as date, SUM(ABS(points_change)) as total')
            ->where('activity_type', 'Voucher Redemption')
            ->where('voided', false)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $pointsRedeemedDaily = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $pointsRedeemedDaily[] = $pointsRedeemedDailyRaw[$day] ?? 0;
        }

        // Total Quests Accomplished
        $questsAccomplished = QuestSubmission::where('status', 'completed')->count();

        // Total Vouchers Used (redeemed)
        $vouchersUsed = UserVoucher::whereNotNull('redeemed_date')->count();

        // ======== LEADERBOARD: MOST ACTIVE USERS ========
        $users = User::with(['pointsHistory', 'savedLibraries', 'savedEcoActions', 'userVouchers'])->get();

        $activeUsersLeaderboard = collect();

        foreach ($users as $user) {
            $lastActivityDates = collect();

            if ($user->pointsHistory->count()) $lastActivityDates->push($user->pointsHistory->max('created_at'));
            if ($user->savedLibraries->count()) $lastActivityDates->push($user->savedLibraries->max('saved_at'));
            if ($user->savedEcoActions->count()) $lastActivityDates->push($user->savedEcoActions->max('log_date'));
            if ($user->userVouchers->count()) $lastActivityDates->push($user->userVouchers->max('redeemed_date'));

            $lastActivity = $lastActivityDates->count() ? $lastActivityDates->max() : null;

            // Consider active if last activity within 6 months
            if ($lastActivity && \Carbon\Carbon::parse($lastActivity)->gte(now()->subMonths(6))) {
                $activityCount = $user->pointsHistory->count()
                    + $user->savedLibraries->count()
                    + $user->savedEcoActions->count()
                    + $user->userVouchers->count();

                $activeUsersLeaderboard->push((object)[
                    'user' => $user,
                    'activityCount' => $activityCount,
                ]);
            }
        }

        // Sort descending by activity count and take top 10
        $topActiveUsers = $activeUsersLeaderboard->sortByDesc('activityCount')->values()->take(10);

        // Most Saved Library Category (by saved libraries)
        $mostCategorySaved = UserLibrary::join('eco_library', 'user_libraries.library_id', '=', 'eco_library.library_id')
            ->select('eco_library.category', DB::raw('COUNT(*) as total'))
            ->groupBy('eco_library.category')
            ->orderByDesc('total')
            ->first();

        $mostCategorySavedName = $mostCategorySaved ? $mostCategorySaved->category : 'N/A';
        $topByPoints = $users->map(function($user) {
            $progressPoints = $user->pointsHistory->sum('points_change');
            return (object)[
                'user' => $user,
                'progressPoints' => $progressPoints,
            ];
        })->sortByDesc('progressPoints')->values()->take(10);
        $topByQuests = $users->map(function($user) {
            $questsCompleted = $user->pointsHistory->where('activity_type', 'Quest')->count()
                + $user->userVouchers->where('status', 'completed')->count(); // optional if you track completion elsewhere
            return (object)[
                'user' => $user,
                'questsCompleted' => $questsCompleted,
            ];
        })->sortByDesc('questsCompleted')->values()->take(10);
        $topDailyActions = $users->map(function($user) {
            $dailyEcoActions = $user->pointsHistory->where('activity_type', 'Tree Tap')
                ->where('created_at', '>=', now()->startOfDay())->count();
            return (object)[
                'user' => $user,
                'dailyEcoActions' => $dailyEcoActions,
            ];
        })->sortByDesc('dailyEcoActions')->values()->take(10);

        $topLibrarySavers = $users->map(function($user) {
            return (object)[
                'user' => $user,
                'librarySaves' => $user->savedLibraries->count(),
            ];
        })->sortByDesc('librarySaves')->values()->take(10);
        $topVoucherRedeemers = $users->map(function($user) {
            return (object)[
                'user' => $user,
                'vouchersRedeemed' => $user->userVouchers->whereNotNull('redeemed_date')->count(),
            ];
        })->sortByDesc('vouchersRedeemed')->values()->take(10);

        $topPointsLast7Days = $users->map(function($user) {
            $pointsEarned = $user->pointsHistory->where('created_at', '>=', now()->subDays(7))
                ->where('points_change', '>', 0)->sum('points_change');
            return (object)[
                'user' => $user,
                'pointsEarned' => $pointsEarned,
            ];
        })->sortByDesc('pointsEarned')->values()->take(10);

        // ======== MOST DESERVING PLAYER (Highest Points Earned in Last 7 Days) ========
        $mostDeserving = $users->map(function($user) {
            $pointsEarned = $user->pointsHistory->where('created_at', '>=', now()->subDays(7))
                ->where('points_change', '>', 0)
                ->sum('points_change');

            return (object)[
                'user' => $user,
                'pointsEarned' => $pointsEarned,
            ];
        })
        ->sortByDesc('pointsEarned')
        ->first(); // Top 1

        
        $categoriesAction = EcoAction::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');
            
        $categoriesLibrary = EcoLibrary::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');
        return view('admin.adminAnalytics', compact(
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
            'pointsRedeemed',
            'newFeedbackCount',
            'categories',
            'categoriesAction',
            'categoriesLibrary',
            'ecoActionsDaily',
            'pointsDaily',
            'pointsRedeemedDaily',
            'dayLabels',
            'questsAccomplished',
            'vouchersUsed',
            'topActiveUsers',
            'mostCategorySavedName',
            'topByPoints',
            'topByQuests',
            'topDailyActions',
            'topLibrarySavers',
            'topVoucherRedeemers',
            'topPointsLast7Days',
            'mostDeserving', // << Added
        ));

    }
    public function giveReward(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'voucher_id' => 'required|exists:vouchers,voucher_id',
        ]);

        $userVoucher = UserVoucher::create([
            'user_id' => $request->user_id,
            'voucher_id' => $request->voucher_id,
            'voucher_code' => strtoupper(Str::random(10)),
            'qr_code' => strtoupper(Str::random(10)),
            'redeemed_date' => now(), // Not redeemed yet
            'status' => 'active',
            'redeem_points_cost' => 0, // Free reward
        ]);

        // ---- Notification for Admin ----
        Notification::create([
            'user_id' =>$request->user_id, // Admin user_id (can be dynamic)
            'from_user_id' => 1,
            'type' => 'reward_given',
            'reference_id' => $userVoucher->redemption_id ?? $userVoucher->id, // Depending on your PK
            'title' => 'Reward Given',
            'message' => 'A reward has been given to you congratulations in your prize',
            'created_at' => now()
        ]);

        return back()->with('success', 'Reward successfully given to the player!');
    }
    public function filterUsers(Request $request)
    {
        $search = $request->search;
        $type = $request->type;
        $status = $request->status;

        $query = User::query()
            ->with(['pointsHistory', 'savedLibraries', 'savedEcoActions', 'userVouchers', 'feedbacks']);

        /* ---------------------------------------
            SEARCH
        ---------------------------------------*/
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        /* ---------------------------------------
            FILTER USER TYPE
        ---------------------------------------*/
        if ($type) {
            $query->where('user_type', $type);
        }

        /* ---------------------------------------
            FILTER STATUS
        ---------------------------------------*/
        if ($status) {
            if ($status === 'verified') {
                $query->where('is_verified', 1);
            } elseif ($status === 'unverified') {
                $query->where('is_verified', 0);
            } elseif ($status === 'active') {
                $query->where('is_active', 1);
            } elseif ($status === 'inactive') {
                $query->where('is_active', 0);
            }
        }

        $users = $query->get();


        /* ---------------------------------------
            BUILD TABLE ROWS
        ---------------------------------------*/
        $html = '';

        foreach ($users as $index => $user) {

            // Last Activity Check
            $lastActivityDates = collect();
            if ($user->pointsHistory->count()) $lastActivityDates->push($user->pointsHistory->max('created_at'));
            if ($user->savedLibraries->count()) $lastActivityDates->push($user->savedLibraries->max('saved_at'));
            if ($user->savedEcoActions->count()) $lastActivityDates->push($user->savedEcoActions->max('log_date'));
            if ($user->userVouchers->count()) $lastActivityDates->push($user->userVouchers->max('redeemed_date'));

            $lastActivity = $lastActivityDates->count() ? $lastActivityDates->max() : null;

            $inactiveMessage = '';
            if (!$user->is_active) {
                $inactiveMessage = 'Inactive';
            } elseif ($lastActivity && \Carbon\Carbon::parse($lastActivity)->lt(now()->subMonths(6))) {
                $inactiveMessage = 'Inactive for 6+ months';
            }

            // USER TYPE BADGE COLORS
            $userTypeColor =
                $user->user_type === "admin" ?
                    "bg-[#FFFBEB] text-[#D97706]" :
                ($user->user_type === "verified_user" ?
                    "bg-[#F0F7E6] text-[#4F6B3F]" :
                    "bg-[#EFF6FF] text-[#1E40AF]"
                );

            // BUILD ROW
            $html .= '
            <tr class="border-b border-[#E6EAD7] hover:bg-[#F5F7F0] transition">

                <td class="px-4 py-2">'.($index + 1).'</td>

                <td class="px-4 py-2 font-medium">'.$user->first_name.' '.$user->middle_name.' '.$user->last_name.'</td>

                <td class="px-4 py-2">'.$user->email.'</td>

                <!-- USER TYPE -->
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded-full text-xs font-medium '.$userTypeColor.'">
                        '.$user->user_type.'
                    </span>
                </td>

                <!-- ACTIVITY -->
                <td class="px-4 py-2">'.
                    ($inactiveMessage
                        ? '<span class="text-red-600 font-semibold px-2 py-1 rounded-full bg-red-50 text-xs">'.$inactiveMessage.'</span>'
                        : '<span class="text-green-600 font-semibold px-2 py-1 rounded-full bg-green-50 text-xs">Active</span>'
                    )
                .'</td>

                <!-- VERIFIED -->
                <td class="px-4 py-2">'.
                    ($user->is_verified
                        ? '<span class="text-green-600 font-semibold px-2 py-1 rounded-full bg-green-50 text-xs">Verified</span>'
                        : '<span class="text-red-600 font-semibold px-2 py-1 rounded-full bg-red-50 text-xs">Unverified</span>'
                    )
                .'</td>

                <td class="px-4 py-2">'.$user->created_at->format("Y-m-d").'</td>

                <!-- ACTION BUTTONS -->
                <td class="px-4 py-2">
                    <div class="flex flex-wrap gap-1.5">

                        <button class="btn-action btn-view compact"
                            onclick=\'openViewUserModal('.json_encode($user).')\'>
                            <i class="fas fa-eye"></i>
                            <span class="hidden sm:inline">View</span>
                        </button>'.

                        (!$user->is_verified
                            ? '<button class="btn-action btn-mint compact" onclick="alert(\'Verify '.$user->first_name.'\')">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="hidden sm:inline">Verify</span>
                            </button>'
                            : ''
                        )

                    .'</div>
                </td>

            </tr>';
        }

        return $html;
    }

    // Admin System Alerts
    public function systemAlerts()
    {
        // ========== NEEDS ATTENTION ==========

        // 1. Pending User Verifications (users not verified for 7 days)
        $pendingVerifications = User::where('is_verified', false)
            ->where('created_at', '<=', now()->subDays(7))
            ->count();

        // 2. High Invalid Submission Rate
        $totalSubmissions = QuestSubmission::count();
        $invalidSubmissions = QuestSubmission::where('status', 'invalid')->count();
        $invalidRate = $totalSubmissions > 0 ? round(($invalidSubmissions / $totalSubmissions) * 100) : 0;

        // 3. QR Scan Activity (Unusual patterns)
        $qrScansToCheck = UserPointsHistory::where('activity_type', 'QR Scan') 
            ->where('created_at', '>=', now()->subDay())
            ->count();


        // ========== FOR REVIEW ==========

        // 4. Quests ending soon
        $endingQuests = Quest::where('status', 'live')
            ->where('end_date', '<=', now()->addDays(3))
            ->count();

        // 5. Vouchers expiring soon
        $expiringVouchers = Voucher::where('expiry_date', '<=', now()->addDays(7))->count();


        // TOTAL ALERT COUNTS
        $needsAttentionCount = 0;
        if ($pendingVerifications > 0) $needsAttentionCount++;
        if ($invalidRate >= 30) $needsAttentionCount++;
        if ($qrScansToCheck > 0) $needsAttentionCount++;

        $forReviewCount = 0;
        if ($endingQuests > 0) $forReviewCount++;
        if ($expiringVouchers > 0) $forReviewCount++;

        $totalAlerts = $needsAttentionCount + $forReviewCount;


        return view('admin.adminSystemAlerts', compact(
            'pendingVerifications',
            'invalidRate',
            'qrScansToCheck',
            'endingQuests',
            'expiringVouchers',
            'needsAttentionCount',
            'forReviewCount',
            'totalAlerts'
        ));
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
