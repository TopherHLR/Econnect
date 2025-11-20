<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\UserVoucher;
use App\Models\UserPointsHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserRewardsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch available vouchers
        $availableVouchers = Voucher::where('is_active', true)->get();

        // Fetch user's vouchers
        $myVouchers = UserVoucher::with('voucher')->where('user_id', $user->user_id)->get();

        // Calculate total points (for progress)
        $totalPoints = UserPointsHistory::where('user_id', $user->user_id)
            ->where('points_change', '>', 0) // only positive points
            ->sum('points_change');

        // Calculate points spent on vouchers
        $pointsSpent = UserVoucher::where('user_id', $user->user_id)
            ->sum('redeem_points_cost');

        // Current points (available for redemption)
        $currentPoints = $totalPoints - $pointsSpent;

        return view('account.rewards', compact(
            'availableVouchers',
            'myVouchers',
            'totalPoints',
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
        UserPointsHistory::create([
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

        return response()->json([
            'success' => 'Voucher redeemed!',
            'userVoucher' => $userVoucher,
            'currentPoints' => $currentPoints - $voucher->required_points
        ]);
    }
}
