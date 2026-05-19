<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);
        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);
        $notification->delete();
        return back()->with('success', 'Notification deleted.');
    }
}
