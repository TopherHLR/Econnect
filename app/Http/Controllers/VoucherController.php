<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\UserVoucher;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Show Rewards Page
     */
    public function index()
    {
        $vouchers = Voucher::orderBy('voucher_id', 'DESC')->get();

        $redeemed = UserVoucher::with(['user', 'voucher'])
            ->orderBy('redemption_id', 'DESC')
            ->get();

        return view('admin.adminRewards', compact('vouchers', 'redeemed'));
    }

    /**
     * Store a newly created voucher.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'           => 'required|string|max:150',
                'description'     => 'nullable|string',
                'required_points' => 'required|integer|min:1',
                'discount_value'  => 'nullable|string|max:50',
                'expiry_date'     => 'required|date|after:today',
                'is_active'       => 'required|boolean',
            ]);

            Voucher::create([
                'title'           => $request->title,
                'description'     => $request->description,
                'required_points' => $request->required_points,
                'discount_value'  => $request->discount_value,
                'expiry_date'     => $request->expiry_date,
                'is_active'       => $request->is_active,
                'created_by'      => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Voucher added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit quest progress. Error: ' . $e->getMessage());
        }
    }

    /**
     * Update Voucher
     */
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update($request->all());

        return back()->with('success', 'Voucher updated!');
    }

    /**
     * Archive / Deactivate Voucher
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->is_active = 0; // or false
        $voucher->save();

        return back()->with('success', 'Voucher archived!');
    }

    /**
     * Update User Voucher Status (Used / Pending) → notify user
     */
    public function updateUserVoucherStatus(Request $request, $id)
    {
        $voucher = UserVoucher::findOrFail($id);
        $voucher->status = $request->status;
        $voucher->save();

        // ✅ Notify the user that admin updated their voucher
        Notification::create([
            'user_id' => $voucher->user_id,      // user receives
            'from_user_id' => Auth::id(),        // admin triggered
            'type' => 'voucher_update',
            'source_table' => 'user_vouchers',
            'source_id' => $voucher->redemption_id,
            'title' => 'Voucher Status Updated',
            'message' => 'Admin has updated the status of your voucher to ' . $voucher->status,
        ]);

        return back()->with('success', 'Voucher status updated.');
    }

    /**
     * Redeem a voucher via QR code → notify admin
     */
    public function redeemByQrCode(Request $request, $qr_code)
    {
        $voucher = UserVoucher::where('qr_code', $qr_code)->first();

        if (!$voucher) {
            return response()->json(['error' => 'Voucher not found'], 404);
        }

        if ($voucher->status === 'used') {
            return response()->json(['error' => 'Voucher already used'], 400);
        }

        $voucher->status = 'used';
        $voucher->save();

        // ✅ Notify admin that user redeemed voucher
        Notification::create([
            'user_id' => 1,                       // admin receives (adjust if multiple admins)
            'from_user_id' => $voucher->user_id,  // user triggered
            'type' => 'voucher_redeem',
            'source_table' => 'user_vouchers',
            'source_id' => $voucher->redemption_id,
            'title' => 'Voucher Redeemed',
            'message' => 'User ' . $voucher->user->name . ' redeemed a voucher.',
        ]);

        return response()->json(['success' => 'Voucher redeemed successfully']);
    }
}
