<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Hiển thị form đặt lịch
     */
    public function create($lawyer_id)
    {
        $slots = AvailabilitySlot::where('lawyer_id', $lawyer_id)->where('is_active', true)->get();
        return view('appointments.create', compact('lawyer_id', 'slots'));
    }

    /**
     * Đặt lịch hẹn
     */
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'lawyer_id' => $request->lawyer_id,
            'client_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'appointment_created',
            'content' => 'Lịch hẹn của Energex đã được tạo và đang chờ xác nhận.',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $request->lawyer_id,
            'type' => 'appointment_request',
            'content' => 'Bạn nhận được yêu cầu lịch hẹn mới từ khách hàng.',
            'is_read' => false,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Đặt lịch thành công!');
    }

    /**
     * Xác nhận lịch hẹn (luật sư)
     */
    public function confirm($id)
    {
        $appointment = Appointment::where('lawyer_id', Auth::id())->findOrFail($id);
        $appointment->update(['status' => 'confirmed']);

        Notification::create([
            'user_id' => $appointment->client_id,
            'type' => 'appointment_confirmed',
            'content' => 'Lịch hẹn của bạn đã được xác nhận.',
            'is_read' => false,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Xác nhận lịch hẹn thành công!');
    }

    /**
     * Hủy lịch hẹn
     */
    public function cancel($id)
    {
        $appointment = Appointment::where('client_id', Auth::id())
            ->orWhere('lawyer_id', Auth::id())
            ->findOrFail($id);

        $appointment->update(['status' => 'cancelled']);

        Notification::create([
            'user_id' => $appointment->client_id,
            'type' => 'appointment_cancelled',
            'content' => 'Lịch hẹn của bạn đã bị hủy.',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $appointment->lawyer_id,
            'type' => 'appointment_cancelled',
            'content' => 'Lịch hẹn với khách hàng đã bị hủy.',
            'is_read' => false,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Hủy lịch thành công!');
    }

    /**
     * Đổi lịch hẹn
     */
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $appointment = Appointment::where('client_id', Auth::id())
            ->orWhere('lawyer_id', Auth::id())
            ->findOrFail($id);

        $appointment->update([
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
        ]);

        Notification::create([
            'user_id' => $appointment->client_id,
            'type' => 'appointment_rescheduled',
            'content' => 'Lịch hẹn của bạn đã được đổi lịch.',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $appointment->lawyer_id,
            'type' => 'appointment_rescheduled',
            'content' => 'Lịch hẹn với khách hàng đã được đổi lịch.',
            'is_read' => false,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Đổi lịch thành công!');
    }

    /**
     * Hiển thị danh sách lịch hẹn cá nhân
     */
    public function index()
    {
        $appointments = Appointment::where('client_id', Auth::id())
            ->orWhere('lawyer_id', Auth::id())
            ->with(['lawyer.user', 'client.user'])
            ->get();
        return view('appointments.index', compact('appointments'));
    }
}