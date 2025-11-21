<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LawyerController extends Controller
{
    /**
     * Danh sách luật sư (public - customer xem)
     * Hỗ trợ tìm kiếm theo chuyên môn + tỉnh/thành phố
     */
    public function index(Request $request)
    {
        $specialty = $request->query('specialization');
        $province  = $request->query('province');

        $query = User::where('role', 'lawyer')
                     ->where('status', 'active')
                     ->with(['lawyerProfile', 'ratings']);

        if ($specialty) {
            $query->whereHas('lawyerProfile', function ($q) use ($specialty) {
                $q->where('specialization', 'like', '%' . $specialty . '%');
            });
        }

        if ($province) {
            $query->whereHas('lawyerProfile', function ($q) use ($province) {
                $q->where('province', 'like', '%' . $province . '%');
            });
        }

        $lawyers = $query->paginate(9)->withQueryString();

        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Trang chi tiết luật sư + chọn slot đặt lịch
     */
    public function show($id)
    {
        $lawyer = User::where('role', 'lawyer')
                    ->where('status', 'active')
                    ->with(['lawyerProfile', 'ratings'])
                    ->findOrFail($id);

        $availableSlots = AvailabilitySlot::where('lawyer_id', $id)
            ->where('is_booked', false)
            ->where('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('lawyers.show', compact('lawyer', 'availableSlots'));
    }

    /**
     * Dashboard của Lawyer
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Chỉ lấy các cuộc hẹn sắp tới (>= hiện tại) và status = pending hoặc confirmed
        $appointments = Appointment::where('lawyer_id', $user->id)
            ->where('appointment_time', '>=', Carbon::now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['client'])
            ->orderBy('appointment_time')
            ->get();

        // Thông báo chưa đọc
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        // Thống kê
        $totalAppointments = Appointment::where('lawyer_id', $user->id)->count();
        $pendingAppointments = Appointment::where('lawyer_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $confirmedAppointments = Appointment::where('lawyer_id', $user->id)
            ->where('status', 'confirmed')
            ->count();

        // Điểm đánh giá trung bình
        $averageRating = $user->ratings()->avg('rating') ?? 0;
        $averageRating = $averageRating > 0 ? number_format($averageRating, 1) : null;

        return view('lawyers.dashboard', compact(
            'appointments',
            'notifications',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'averageRating'
        ));
    }
}
