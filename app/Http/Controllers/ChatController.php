<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::id() === 1) {
            // Admin: danh sách người chat
            $conversations = User::whereHas('sentMessages', fn($q) => $q->where('receiver_id', 1))
                ->orWhereHas('receivedMessages', fn($q) => $q->where('sender_id', 1))
                ->withCount(['unreadMessages' => fn($q) => $q->where('receiver_id', 1)])
                ->orderByDesc('unread_messages_count')
                ->get();

            return view('chat.index', compact('conversations'));
        }

        // User thường: chat với admin
        $messages = Message::where(function ($q) {
            $q->where('sender_id', Auth::id())->where('receiver_id', 1);
        })->orWhere(function ($q) {
            $q->where('sender_id', 1)->where('receiver_id', Auth::id());
        })
        ->with('sender')
        ->oldest()
        ->get();

        return view('chat.index', compact('messages'));
    }

    // Gửi tin nhắn
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $receiverId = Auth::id() === 1 ? $request->user_id : 1;

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $receiverId,
            'message'     => $request->message,
        ]);

        return response()->json(['status' => 'sent']);
    }

    // Load tin nhắn cho admin
    public function conversation($userId)
    {
        $messages = Message::where(function ($q) use ($userId) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', Auth::id());
        })
        ->with('sender')
        ->oldest()
        ->get();

        // Đánh dấu đã đọc
        Message::where('sender_id', $userId)
               ->where('receiver_id', Auth::id())
               ->update(['is_read' => true]);

        $html = view('chat.partials.admin-messages', compact('messages'))->render();

        return response()->json(['html' => $html]);
    }

    // Trả HTML tin nhắn cho user thường
    public function userMessagesView()
    {
        $messages = Message::where(function ($q) {
            $q->where('sender_id', Auth::id())->where('receiver_id', 1);
        })->orWhere(function ($q) {
            $q->where('sender_id', 1)->where('receiver_id', Auth::id());
        })
        ->with('sender')
        ->oldest()
        ->get();

        return view('chat.partials.messages', compact('messages'));
    }
}