<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\UserVoucher;
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
        try
        {
            // Validate form inputs with custom messages
            $request->validate([
                'title'           => 'required|string|max:150',
                'description'     => 'nullable|string',
                'required_points' => 'required|integer|min:1',
                'discount_value'  => 'nullable|string|max:50',
                'expiry_date'     => 'required|date|after:today',
                'is_active'       => 'required|boolean',
            ], [
                'title.required'           => 'The voucher title is required.',
                'title.max'                => 'The title must not exceed 150 characters.',
                'required_points.required' => 'Points required is needed.',
                'required_points.min'      => 'Points required must be at least 1.',
                'expiry_date.after'        => 'The expiry date must be a future date.',
                'is_active.required'       => 'Please select the voucher status.',
            ]);

            // Create voucher
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

        } 
        catch (\Exception $e) {
            // Catch unexpected errors and show detailed error message
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
     * Update User Voucher Status (Used / Pending)
     */
    public function updateUserVoucherStatus(Request $request, $id)
    {
        $voucher = UserVoucher::findOrFail($id);
        $voucher->status = $request->status;
        $voucher->save();

        return back()->with('success', 'Voucher status updated.');
    }
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

        return response()->json(['success' => 'Voucher redeemed successfully']);
    }

}
