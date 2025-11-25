<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPointsHistory;
use App\Models\QuestSubmission;
use App\Models\Quest;
use App\Models\UserEcoAction;
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

        // Total eco points
        $ecoPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->sum('points_change');

        // Today's Completed Daily Eco-Action Submissions
        $todayActions = QuestSubmission::where('user_id', $user->user_id)
            ->where('status', 'completed')
            ->whereDate('date_completed', today())
            ->whereHas('quest', function ($q) {
                $q->where('title', 'Daily Eco Action'); 
            })
            ->count();

        // Convert to Tree Progress (example: 1 daily action = 20%)
        $treePercent = min($todayActions * 20, 100);

        // Total eco actions
        $ecoActions = UserEcoAction::where('user_id', $user->user_id)->count();
        $actionsPercent = min(100, ($ecoActions / 20) * 100);

        // Quests completed
        $completedQuestsByUser = QuestSubmission::where('user_id', $user->user_id)
                            ->where('status', 'completed')
                            ->count();

        $totalQuests = Quest::count();
        $questsPercent = $totalQuests > 0 ? ($completedQuestsByUser / $totalQuests) * 100 : 0;
        \Log::info("Completed Quests: $completedQuestsByUser, Total Quests: $totalQuests");

        // Recent quest submissions
        $recentSubmissions = QuestSubmission::with('quest')
            ->where('user_id', $user->user_id)
            ->orderBy('date_submitted', 'desc')
            ->limit(5)
            ->get();


        // Recent Activity (History table)
        $recentHistory = UserPointsHistory::where('user_id', $user->user_id)
            ->with('questSubmission.quest') // load submission + quest
            ->latest()
            ->limit(10)
            ->get();


        // DEBUG LOG
        \Log::info('Recent History:', $recentHistory->toArray());


        // Daily Eco Action Streak Calculation
        $streak = 0;
        $day = 0;

        while (true) {
            $dateToCheck = now()->subDays($day)->toDateString();

            $completed = QuestSubmission::where('user_id', $user->user_id)
                ->where('status', 'completed')
                ->whereDate('date_completed', $dateToCheck)
                ->whereHas('quest', function ($q) {
                    $q->where('title', 'Daily Eco Action');
                })
                ->exists();

            if ($completed) {
                $streak++;   // count the day
                $day++;      // go back 1 more day
            } else {
                break;       // streak broken
            }
        }

        // final streak value
        $currentStreak = $streak;

        return view('account.myprogress', compact(
            'ecoPoints',
            'treePercent',

            'actionsPercent',
            'questsPercent',
            'ecoActions',
            'completedQuestsByUser',
            'recentSubmissions',
            'recentHistory',
            'currentStreak'
        ));
    }


    // --- Rewards Page ---
    public function rewards()
    {
        return view('account.rewards', $this->getAccountData());
    }
}
