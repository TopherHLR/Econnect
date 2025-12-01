<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\UserVoucher;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Show Rewards Page
     */
    public function index(Request $request)
    {
        // Default: active vouchers (paginated)
        $vouchers = Voucher::where('is_active', true)
            ->orderBy('voucher_id', 'DESC')
            ->paginate(4);

        $archived = Voucher::where('is_active', 0)->get();

        // Redeemed vouchers – also paginated so we can use Laravel links()
        $redeemed = UserVoucher::with(['user', 'voucher'])
            ->orderBy('redemption_id', 'DESC')
            ->when($request->has('search'), function ($q) use ($request) {
                $term = $request->get('search');
                $q->whereHas('user', function ($sq) use ($term) {
                    $sq->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$term}%"]);
                })->orWhereHas('voucher', function ($sq) use ($term) {
                    $sq->where('title', 'like', "%{$term}%");
                });
            })
            ->paginate(5); // you can change per-page value

        // AJAX handling
        if ($request->ajax()) {
            $type = $request->get('type'); // "catalog" or "redeemed"

            if ($type === 'redeemed') {
                return view('admin.partials.redemeed_table', compact('redeemed'))->render();
            }

            // default = catalog
            return view('admin.partials.rewards_table', compact('vouchers'))->render();
        }

        return view('admin.adminRewards', compact('vouchers', 'redeemed', 'archived'));
    }
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

            // Create voucher
            $voucher = Voucher::create([
                'title'           => $request->title,
                'description'     => $request->description,
                'required_points' => $request->required_points,
                'discount_value'  => $request->discount_value,
                'expiry_date'     => $request->expiry_date,
                'is_active'       => $request->is_active,
                'created_by'      => Auth::id(),
            ]);

            // ---- Notify all users about the new voucher ----
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->user_id,
                    'from_user_id' => Auth::id(),
                    'type' => 'new_voucher',
                    'reference_id' => $voucher->voucher_id,
                    'title' => 'New Voucher Available!',
                    'message' => 'A new voucher "' . $voucher->title . '" has been added. Check it out!',
                    'created_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Voucher added successfully and notifications sent!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add voucher. Error: ' . $e->getMessage());
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

    public function redeemByQrCode(Request $request, $qr_code)
    {
        $voucher = UserVoucher::with('user')->where('qr_code', $qr_code)->first();

        if (!$voucher) {
            return response()->json(['error' => 'Voucher not found'], 404);
        }

        if ($voucher->status === 'used') {
            return response()->json(['error' => 'Voucher already used'], 400);
        }

        // Mark voucher as used
        $voucher->status = 'used';
        $voucher->save();

        // ---- Notify the user ----
        Notification::create([
            'user_id' => $voucher->user_id,      // user receives notification
            'from_user_id' => null,              // system-triggered
            'type' => 'voucher_redeemed',
            'source_table' => 'user_vouchers',
            'source_id' => $voucher->redemption_id,
            'title' => 'Voucher Redeemed Successfully',
            'message' => 'Your voucher "' . $voucher->voucher->title . '" has been successfully redeemed.',
            'created_at' => now(),
        ]);

        return response()->json(['success' => 'Voucher redeemed successfully and user notified']);
    }
    public function recover($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->is_active = 1; // reactivate
        $voucher->save();

        return back()->with('success', 'Voucher recovered!');
    }

}
