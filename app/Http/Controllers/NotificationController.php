<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        auth()->user()->notifications()->update(['is_read' => true]); // Đánh dấu đã đọc
        return view('notifications.index', compact('notifications'));
    }
}
