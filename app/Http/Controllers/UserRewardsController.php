<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\UserVoucher;
use App\Models\UserPointsHistory;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UserRewardsController extends Controller
{
    public function index()
    {
        Log::info('RewardsController@index called');

        $user = Auth::user();

        // ✅ Available vouchers (active only)
        $availableVouchers = Voucher::withCount('userVouchers') // count all redemptions
                                    ->where('is_active', 1)
                                    ->get();

        // ✅ User's vouchers
        $myVouchers = UserVoucher::with('voucher')
                        ->where('user_id', $user->user_id)
                        ->get();

        // ✅ Optionally, get the most popular voucher(s)
        $popularVouchers = $availableVouchers->sortByDesc('user_vouchers_count');
        // POINTS LOGIC (unchanged)
        $progressPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '>', 0)
            ->where('voided', false)
            ->sum('points_change');

        $pointsSpent = abs(
            UserPointsHistory::where('user_id', $user->user_id)
                ->where('points_change', '<', 0)
                ->where('voided', false)
                ->sum('points_change')
        );

        $currentPoints = $progressPoints - $pointsSpent;

        return view('account.rewards', compact(
            'availableVouchers',
            'myVouchers',
            'popularVouchers',
            'progressPoints',
            'currentPoints'
        ));
    }


    public function redeemVoucher(Request $request, $voucherId)
    {
        $user = Auth::user();
        $voucher = Voucher::findOrFail($voucherId);

        // Calculate current points
        $totalPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '>', 0)
            ->sum('points_change');

        $pointsSpent = UserVoucher::where('user_id', $user->user_id)
            ->sum('redeem_points_cost');

        $currentPoints = $totalPoints - $pointsSpent;

        // Check if user has enough points
        if ($currentPoints < $voucher->required_points) {
            return response()->json(['error' => 'Not enough points'], 400);
        }

        // Deduct points by logging a negative record
        $history = UserPointsHistory::create([
            'user_id' => $user->user_id,
            'activity_type' => 'Voucher Redemption',
            'source_id' => $voucher->voucher_id,
            'points_change' => -$voucher->required_points,
            'created_at' => now(),
        ]);

        // Create a user voucher record
        $userVoucher = UserVoucher::create([
            'user_id' => $user->user_id,
            'voucher_id' => $voucher->voucher_id,
            'voucher_code' => strtoupper(Str::random(10)),
            'qr_code' => strtoupper(Str::random(10)),
            'redeemed_date' => now(),
            'status' => 'active',
            'redeem_points_cost' => $voucher->required_points
        ]);

        // ---- Notification for Admin ----
        Notification::create([
            'user_id' => 1, // Admin user_id (can be dynamic)
            'from_user_id' => $user->user_id,
            'type' => 'voucher_redeem',
            'reference_id' => $userVoucher->redemption_id,
            'title' => 'Voucher Redeemed',
            'message' => $user->name . ' has redeemed a voucher: ' . $voucher->title,
            'created_at' => now()
        ]);

        return response()->json([
            'success' => 'Voucher redeemed!',
            'userVoucher' => $userVoucher,
            'currentPoints' => $currentPoints - $voucher->required_points
        ]);
    }
}
