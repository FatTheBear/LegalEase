<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Hiển thị danh sách thông báo
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->latest()->get();
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Đánh dấu thông báo là đã đọc
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Đánh dấu thông báo là đã đọc!');
    }
}