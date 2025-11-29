<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Danh sách lịch hẹn
    public function index()
    {
        $appointments = Appointment::where('client_id', Auth::id())
            ->orWhere('lawyer_id', Auth::id())
            ->with(['lawyer', 'client', 'rating'])
            ->latest()
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    public function create($lawyer_id)
    {
        return redirect()->route('lawyers.show', $lawyer_id);
    }

    // KHÁCH ĐẶT LỊCH → Gửi thông báo + email cho LAWYER
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:users,id',
            'slot_id'   => 'required|exists:availability_slots,id',
        ]);

        $slot = AvailabilitySlot::where('id', $request->slot_id)
            ->where('lawyer_id', $request->lawyer_id)
            ->where('is_booked', false)
            ->firstOrFail();

        $client = Auth::user();

        $appointment = Appointment::create([
            'client_id'        => $client->id,
            'lawyer_id'        => $request->lawyer_id,
            'appointment_time' => \Carbon\Carbon::parse("{$slot->date} {$slot->start_time}"),
            'end_time'         => \Carbon\Carbon::parse("{$slot->date} {$slot->end_time}"),
            'status'           => 'pending',
            'notes'            => $request->notes ?? null,
        ]);

        $slot->update([
            'is_booked'       => true,
            'appointment_id'  => $appointment->id,
        ]);

        // Gửi thông báo (nếu có hàm notify)
        try {
            notify($request->lawyer_id, 'New Booking', "Customer {$client->name} booked your slot!", 'booking');
        } catch (\Exception $e) {
            \Log::warning("Notification failed: " . $e->getMessage());
        }

        return redirect()->route('appointments.index')
                        ->with('success', 'Đặt lịch thành công! Chờ luật sư xác nhận.');
    }

    // LAWYER XÁC NHẬN → Gửi thông báo + email cho CUSTOMER
    public function confirm($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('lawyer_id', Auth::id())
            ->firstOrFail();

        $appointment->update(['status' => 'confirmed']);

        $lawyer = Auth::user();
        $client = $appointment->client;

        // THÔNG BÁO CHO CUSTOMER: "Lịch đã được xác nhận"
        // Trong store() – sau khi tạo appointment + khóa slot
        try {
            notify(
                $lawyer->id,
                'New Appointment Request',
                "Client {$client->name} booked a consultation on " .
                \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y \a\t H:i'),
                'booking',
                ['appointment_id' => $appointment->id]
            );
        } catch (\Exception $e) {
            \Log::warning("Failed to send notification to lawyer ID {$lawyer->id}: " . $e->getMessage());
            // Không làm gì cả → vẫn cho book thành công!
        }

        return back()->with('success', 'Appointment confirmed successfully!');
    }

    // HỦY LỊCH (cả Lawyer và Customer đều hủy được)
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
            'cancel_reason' => $reason // nếu có cột này, nếu không thì bỏ
        ]);

        // MỞ LẠI SLOT
        if ($appointment->slot) {
            $appointment->slot->update([
                'is_booked' => false,
                'appointment_id' => null,
            ]);
        }

        $canceler = Auth::user();
        $receiverId = $canceler->role === 'lawyer' ? $appointment->client_id : $appointment->lawyer_id;

        // THÔNG BÁO CHO NGƯỜI KIA: "Lịch bị hủy"
        notify(
            $receiverId,
            'Appointment Cancelled',
            "{$canceler->name} has cancelled the appointment scheduled for " .
            \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y \a\t H:i') .
            ". Reason: {$reason}",
            'cancelled',
            ['appointment_id' => $appointment->id]
        );

        return back()->with('success', 'Appointment cancelled successfully.');
    }
    
}