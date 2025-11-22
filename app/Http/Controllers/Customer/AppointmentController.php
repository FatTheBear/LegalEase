<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // ==================== DANH SÁCH LỊCH HẸN ====================
    public function index()
    {
        $appointments = Appointment::where('client_id', Auth::id())
            ->orWhere('lawyer_id', Auth::id())
            ->with(['lawyer', 'client'])
            ->latest()
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    // ==================== CHUYỂN HƯỚNG CREATE ====================
    public function create($lawyer_id)
    {
        return redirect()->route('lawyers.show', $lawyer_id);
    }

    // ==================== KHÁCH ĐẶT LỊCH ====================
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:users,id',
            'slot_id'   => 'required|exists:availability_slots,id',
        ]);

        // Lấy slot trống
        $slot = AvailabilitySlot::where('id', $request->slot_id)
            ->where('lawyer_id', $request->lawyer_id)
            ->where('is_booked', false)
            ->firstOrFail();

        $client = Auth::user();

        // Tránh ghép date + time nếu start_time/end_time đã là datetime
        $appointment_time = $slot->start_time;
        $end_time         = $slot->end_time;

        // Tạo appointment
        $appointment = Appointment::create([
            'client_id'        => $client->id,
            'lawyer_id'        => $slot->lawyer_id,
            'slot_id'          => $slot->id,
            'appointment_time' => $appointment_time,
            'end_time'         => $end_time,
            'status'           => 'pending',
            'notes'            => $request->notes ?? null,
        ]);

        // Cập nhật slot
        $slot->update([
            'is_booked'      => true,
            'appointment_id' => $appointment->id,
        ]);

        // Gửi thông báo nếu có hàm notify
        try {
            notify($slot->lawyer_id, 'New Booking', "Customer {$client->name} booked your slot!", 'booking');
        } catch (\Exception $e) {
            \Log::warning("Notification failed: " . $e->getMessage());
        }

        return redirect()->route('appointments.index')
                         ->with('success', 'Đặt lịch thành công! Chờ luật sư xác nhận.');
    }

    // ==================== LAWYER XÁC NHẬN ====================
    public function confirm($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('lawyer_id', Auth::id())
            ->firstOrFail();

        $appointment->update(['status' => 'confirmed']);

        $lawyer = Auth::user();
        $client = $appointment->client;

        // Thông báo cho khách hàng
        try {
            notify(
                $client->id, // → gửi cho khách hàng
                'Appointment Confirmed',
                "Lịch hẹn của bạn với {$lawyer->name} đã được xác nhận.",
                'confirmed',
                ['appointment_id' => $appointment->id]
            );
        } catch (\Exception $e) {
            \Log::warning("Failed to notify client ID {$client->id}: " . $e->getMessage());
        }


        return back()->with('success', 'Appointment confirmed successfully!');
    }

    // ==================== HỦY LỊCH ====================
    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::where('id', $id)
            ->where(function ($q) {
                $q->where('client_id', Auth::id())
                  ->orWhere('lawyer_id', Auth::id());
            })
            ->firstOrFail();

        $reason = $request->input('reason', 'No reason provided');

        $appointment->update([
            'status' => 'cancelled',
            'cancel_reason' => $reason
        ]);

        // Mở lại slot
        if ($appointment->slot) {
            $appointment->slot->update([
                'is_booked'      => false,
                'appointment_id' => null,
            ]);
        }

        $canceler = Auth::user();
        $receiverId = $canceler->role === 'lawyer' ? $appointment->client_id : $appointment->lawyer_id;

        // Thông báo cho người kia
        notify(
            $receiverId,
            'Appointment Cancelled',
            "{$canceler->name} has cancelled the appointment scheduled for " .
            $appointment->appointment_time->format('d/m/Y \a\t H:i') .
            ". Reason: {$reason}",
            'cancelled',
            ['appointment_id' => $appointment->id]
        );

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}
