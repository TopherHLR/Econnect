<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Fetch all notifications for logged-in user
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    /**
     * Mark a notification as read
     */
    // Mark single notification as read
    public function markAsRead($id)
    {
        $notification = Notification::where('notification_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // Mark all notifications as read
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
    /**
     * Create a notification (used by backend events)
     */
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'from_user_id' => 'nullable|exists:users,user_id',
            'type' => 'required|string',
            'source_table' => 'nullable|string',
            'source_id' => 'nullable|integer',
            'title' => 'required|string',
            'message' => 'nullable|string',
        ]);

        $notification = Notification::create($request->all());

        return response()->json($notification);
    }
}
