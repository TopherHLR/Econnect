<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use App\Models\QuestSubmission;
use App\Models\Quest;
use App\Models\UserEcoAction;
use App\Models\User;
use App\Models\UserLibrary;
use Illuminate\Support\Facades\Password; // ← add this
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // 🔹 Shared logic for user account data
    private function getAccountData()
    {
        $user = Auth::user();

        // Total earned points (sum of all positive points)
        $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '>', 0)
            ->sum('points_change');

        // Points spent on vouchers (absolute value of negative points)
        $pointsSpent = abs(UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '<', 0)
            ->sum('points_change'));

        // Current points available for redemption
        $currentPoints = $progressPoints - $pointsSpent;

        // Badges based on total earned points
        $earnedBadges = 0;
        $badgeLevel = null;

        if ($progressPoints >= 1000) {
            $earnedBadges = 3;
            $badgeLevel = '🌿 Eco Legend (1000+ pts)';
        } elseif ($progressPoints >= 500) {
            $earnedBadges = 2;
            $badgeLevel = '🌱 Green Guardian (500+ pts)';
        } elseif ($progressPoints >= 200) {
            $earnedBadges = 1;
            $badgeLevel = '🌸 Eco Starter (200+ pts)';
        } else {
            $badgeLevel = 'Keep going! Earn more points to unlock your first badge.';
        }

        // Dummy data for now
        $completedQuests = 0;

        return compact('user', 'progressPoints', 'currentPoints', 'earnedBadges', 'badgeLevel', 'completedQuests');
    }
        // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
        ]);

        $user->update($request->only('first_name','middle_name','last_name','email'));

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Send password reset email
    public function sendPasswordResetEmail(Request $request)
    {
        $user = Auth::user();
        Password::sendResetLink(['email' => $user->email]);

        return redirect()->back()->with('success', 'Password reset email sent to ' . $user->email);
    }
    
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = $request->new_password;
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    // --- Profile Page ---
    public function show()
    {
        return view('account.profile', $this->getAccountData());
    }

    public function myProgress()
    {
        $user = auth()->user();

        // ---------- Existing code ----------
        $ecoPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->sum('points_change');

        $todayActions = QuestSubmission::where('user_id', $user->user_id)
            ->where('status', 'completed')
            ->whereDate('date_completed', today())
            ->whereHas('quest', fn($q) => $q->where('title', 'Daily Eco Taps'))
            ->count();

        $treePercent = min($todayActions * 20, 100);

        $ecoActions = UserEcoAction::where('user_id', $user->user_id)->count();
        $actionsPercent = min(100, ($ecoActions / 20) * 100);

        $completedQuestsByUser = QuestSubmission::where('user_id', $user->user_id)
            ->where('status', 'completed')
            ->count();

        $totalQuests = Quest::count();
        $questsPercent = $totalQuests > 0 ? ($completedQuestsByUser / $totalQuests) * 100 : 0;

        $recentSubmissions = QuestSubmission::with('quest')
            ->where('user_id', $user->user_id)
            ->orderBy('date_submitted', 'desc')
            ->limit(5)
            ->get();

        // ---------- RECENT HISTORY WITH VOUCHER FIX ----------
            $recentHistory = UserPointsHistory::where('user_id', $user->user_id)
                ->with([
                    'questSubmission.quest',
                    'source.voucher'   // <-- add this!
                ])
                ->latest()
                ->limit(10)
                ->get()

            ->map(function ($row) {
                // Compute display reason for Blade template
                if ($row->activity_type === 'Voucher Redemption') {
                    if ($row->source) {
                        $voucher = $row->source->voucher;
                        $voucherTitle = $voucher ? $voucher->title : 'Unknown Voucher';
                        $points = abs($row->points_change);
                        $status = ucfirst($row->source->status); // Active / Used

                        if ($row->source->status === 'active') {
                            $row->display_reason = "Redeemed Voucher | {$voucherTitle} (-{$points} pts) [{$status}]";
                        } elseif ($row->source->status === 'used') {
                            $row->display_reason = "Used Voucher | {$voucherTitle} (-{$points} pts) [{$status}]";
                        } else {
                            $row->display_reason = "Voucher Redemption | {$voucherTitle} ";
                        }
                    } else {
                        $row->display_reason = "Voucher Redemption ";
                    }
                } elseif ($row->activity_type === 'Quest' && $row->questSubmission) {
                    $questTitle = $row->questSubmission->quest
                        ? $row->questSubmission->quest->title
                        : 'Unknown Quest';
                    $row->display_reason = 'Quest #' . $row->questSubmission->quest_id
                        . ' | ' . $questTitle
                        . ' - ' . ucfirst($row->questSubmission->status);
                } else {
                    $row->display_reason = 'Activity';
                }

                // DEBUG LOG
                \Log::info('UserPointsHistory Row:', [
                    'history_id' => $row->history_id,
                    'activity_type' => $row->activity_type,
                    'points_change' => $row->points_change,
                    'source_id' => $row->source_id,
                    'source_exists' => $row->source ? true : false,
                    'source_data' => $row->source ? $row->source->toArray() : null,
                    'display_reason' => $row->display_reason,
                ]);

                return $row;
            });

        // ---------- DAILY STREAK ----------
        $streak = 0;
        $day = 0;
        while (true) {
            $dateToCheck = now()->subDays($day)->toDateString();
            $completed = QuestSubmission::where('user_id', $user->user_id)
                ->where('status', 'completed')
                ->whereDate('date_completed', $dateToCheck)
                ->whereHas('quest', fn($q) => $q->where('title', 'Daily Eco Taps'))
                ->exists();

            if ($completed) {
                $streak++;
                $day++;
            } else {
                break;
            }
        }
        $currentStreak = $streak;

        // ---------- LEADERBOARD ----------
        $leaderboard = User::where('user_type', '!=', 'admin')
            ->with('pointsHistory', 'questSubmissions')
            ->get()
            ->map(function ($u) {
                $ecoPoints = $u->pointsHistory->where('points_change', '>', 0)->sum('points_change');
                $questsCompleted = $u->questSubmissions->where('status', 'completed')->count();
                $u->progressPoints = $ecoPoints + ($questsCompleted * 10);
                return $u;
            })
            ->sortByDesc('progressPoints')
            ->values()
            ->take(10);

        // ---------- BADGES ----------
        $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '>', 0)
            ->where('voided', false)
            ->sum('points_change');

        $stageThresholds = [50, 100, 200, 300, 450, 550, 700];
        $stage = 1;
        foreach ($stageThresholds as $index => $threshold) {
            if ($progressPoints < $threshold) break;
            $stage = $index + 2;
        }
        $growthMax = $stageThresholds[$stage - 1] ?? end($stageThresholds);
        $prevThreshold = $stage > 1 ? $stageThresholds[$stage - 2] : 0;
        $growthPercent = ($growthMax - $prevThreshold) > 0
            ? (($progressPoints - $prevThreshold) / ($growthMax - $prevThreshold)) * 100
            : 0;
        $growthPercent = min(100, max(0, $growthPercent));

        // TREE STAGES
        $treeStages = [
            0     => ['name' => 'Seed', 'icon' => '🌱'],
            50    => ['name' => 'Sprout', 'icon' => '🌿'],
            100   => ['name' => 'Seedling', 'icon' => '🍃'],
            200   => ['name' => 'Sapling', 'icon' => '🌳'],
            300  => ['name' => 'Young Tree', 'icon' => '🌲'],
            450  => ['name' => 'Growing Tree', 'icon' => '🎋'],
            550  => ['name' => 'Strong Tree', 'icon' => '🌴'],
            700  => ['name' => 'Mature Tree', 'icon' => '🌳'],

        ];
        $treeBadges = [];
        foreach ($treeStages as $points => $stage) {
            $treeBadges[] = [
                'type' => 'tree',
                'name' => $stage['name'],
                'icon' => $stage['icon'],
                'required_points' => $points,
                'unlocked' => $progressPoints >= $points,
                'unlocked_at' => $progressPoints >= $points ? now()->toDateString() : null,
            ];
        }

        // QUEST BADGES
        $questMilestones = [
            1  => ['name' => 'Eco-Novice', 'icon' => '🌱'],
            5  => ['name' => 'Eco-Explorer', 'icon' => '🌿'],
            15 => ['name' => 'Eco-Enthusiast', 'icon' => '🍃'],
            30 => ['name' => 'Eco-Advocate', 'icon' => '🌎'],
            50 => ['name' => 'Eco-Guardian', 'icon' => '🛡️'],
        ];
        $userCompletedQuests = QuestSubmission::where('user_id', $user->user_id)
            ->where('status', 'completed')
            ->count();
        $questBadges = [];
        foreach ($questMilestones as $required => $badge) {
            $questBadges[] = [
                'type' => 'quest',
                'name' => $badge['name'],
                'icon' => $badge['icon'],
                'required' => $required,
                'unlocked' => $userCompletedQuests >= $required,
                'unlocked_at' => $userCompletedQuests == $required ? now()->toDateString() : null,
            ];
        }

        $badges = array_merge($treeBadges, $questBadges);
        $unlockedCount = collect($badges)->where('unlocked', true)->count();
        $totalBadges = count($badges);

        return view('account.myprogress', compact(
            'ecoPoints',
            'progressPoints',
            'treePercent',
            'actionsPercent',
            'questsPercent',
            'ecoActions',
            'completedQuestsByUser',
            'recentSubmissions',
            'recentHistory',
            'currentStreak',
            'leaderboard',
            'badges',
            'unlockedCount',
            'totalBadges',
            'growthPercent',
            'growthMax'
        ));
    }




    // --- Rewards Page ---
    public function rewards()
    {
        return view('account.rewards', $this->getAccountData());
    }
}
