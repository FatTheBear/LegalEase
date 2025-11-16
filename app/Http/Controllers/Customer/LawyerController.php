<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerController extends Controller
{
    /**
     * Tìm kiếm luật sư theo chuyên ngành
     */
    public function index(Request $request)
    {
        $query = Lawyer::whereHas('user', function ($q) {
            $q->where('role', 'lawyer')->where('status', 'active');
        });

        if ($request->has('specialty')) {
            $query->where('specialty', 'like', '%' . $request->specialty . '%');
        }

        $lawyers = $query->with('user')->get();
        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Xem profile luật sư
     */
    public function show($id)
    {
        $lawyer = Lawyer::whereHas('user', function ($q) {
            $q->where('role', 'lawyer')->where('status', 'active');
        })->with('user')->findOrFail($id);

        return view('lawyers.show', compact('lawyer'));
    }
    public function dashboard()
    {
        $user = Auth::user();

        // Lấy lịch hẹn sắp tới của luật sư
        $appointments = Appointment::where('lawyer_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['client.user'])
            ->latest()
            ->take(10)
            ->get();

        // Thống kê
        $totalAppointments = Appointment::where('lawyer_id', $user->id)->count();
        $pendingAppointments = Appointment::where('lawyer_id', $user->id)->where('status', 'pending')->count();
        $averageRating = $user->ratings()->avg('rating') ?? null;

        // Thông báo chưa đọc
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        return view('lawyers.dashboard', compact('appointments', 'totalAppointments', 'pendingAppointments', 'averageRating', 'notifications'));
    }
}