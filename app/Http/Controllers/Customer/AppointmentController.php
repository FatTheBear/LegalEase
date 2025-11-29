<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // ==================== APPOINTMENT LIST ====================
    public function index()
    {
        $appointments = Appointment::where('client_id', Auth::id())
            ->orWhere('lawyer_id', Auth::id())
            ->with(['lawyer', 'client', 'rating'])
            ->latest()
            ->get();

        // ➜ Retrieve all rated feedbacks to pass to the view
        $feedbacks = $appointments->filter(function ($appt) {
            return $appt->rating !== null;
        });

        return view('appointments.index', compact('appointments', 'feedbacks'));
    }


    // ==================== CREATE REDIRECT ====================
    public function create($lawyer_id)
    {
        return redirect()->route('lawyers.show', $lawyer_id);
    }

    // ==================== CUSTOMER BOOKS APPOINTMENT ====================
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:users,id',
            'slot_id'   => 'required|exists:availability_slots,id',
        ]);

        // Get available slot
        $slot = AvailabilitySlot::where('id', $request->slot_id)
            ->where('lawyer_id', $request->lawyer_id)
            ->where('is_booked', false)
            ->firstOrFail();

        $client = Auth::user();

        // Avoid concatenating date + time if start_time/end_time are already datetime objects
        $appointment_time = $slot->start_time;
        $end_time         = $slot->end_time;

        // Create appointment
        $appointment = Appointment::create([
            'client_id'          => $client->id,
            'lawyer_id'          => $slot->lawyer_id,
            'slot_id'            => $slot->id,
            'appointment_time' => $appointment_time,
            'end_time'         => $end_time,
            'status'             => 'pending',
            'notes'              => $request->notes ?? null,
        ]);

        // Update slot
        $slot->update([
            'is_booked'      => true,
            'appointment_id' => $appointment->id,
        ]);

        // Send notification if notify function exists
        try {
            notify($slot->lawyer_id, 'New Booking', "Customer {$client->name} booked your slot!", 'booking');
        } catch (\Exception $e) {
            \Log::warning("Notification failed: " . $e->getMessage());
        }

        return redirect()->route('appointments.index')
                         ->with('success', 'Booking successful! Awaiting lawyer confirmation.');
    }

    // ==================== LAWYER CONFIRMATION ====================
    public function confirm($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('lawyer_id', Auth::id())
            ->firstOrFail();

        $appointment->update(['status' => 'confirmed']);

        $lawyer = Auth::user();
        $client = $appointment->client;

        // Notify the client
        try {
            notify(
                $client->id, // → send to client
                'Appointment Confirmed',
                "Your appointment with {$lawyer->name} has been confirmed.",
                'confirmed',
                ['appointment_id' => $appointment->id]
            );
        } catch (\Exception $e) {
            \Log::warning("Failed to notify client ID {$client->id}: " . $e->getMessage());
        }


        return back()->with('success', 'Appointment confirmed successfully!');
    }

    // ==================== CANCEL APPOINTMENT ====================
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

        // Re-open slot
        if ($appointment->slot) {
            $appointment->slot->update([
                'is_booked'      => false,
                'appointment_id' => null,
            ]);
        }

        $canceler = Auth::user();
        $receiverId = $canceler->role === 'lawyer' ? $appointment->client_id : $appointment->lawyer_id;

        // Notify the other party
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
    // ==================== RATING HISTORY (CLIENT) ====================
    public function history()
    {
        $feedbacks = Auth::user()
            ->feedbacks()   // relationship in User model
            ->with('lawyer') // load lawyer information
            ->latest()
            ->get();

        return view('appointments.history', compact('feedbacks'));
    }

}