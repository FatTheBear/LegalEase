<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // List of appointments
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

    // CUSTOMER BOOKS APPOINTMENT → Send notification + email to LAWYER
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
            'client_id'          => $client->id,
            'lawyer_id'          => $request->lawyer_id,
            'appointment_time' => \Carbon\Carbon::parse("{$slot->date} {$slot->start_time}"),
            'end_time'           => \Carbon\Carbon::parse("{$slot->date} {$slot->end_time}"),
            'status'             => 'pending',
            'notes'              => $request->notes ?? null,
        ]);

        $slot->update([
            'is_booked'       => true,
            'appointment_id'  => $appointment->id,
        ]);

        // Send notification (if notify function exists)
        try {
            notify($request->lawyer_id, 'New Booking', "Customer {$client->name} booked your slot!", 'booking');
        } catch (\Exception $e) {
            \Log::warning("Notification failed: " . $e->getMessage());
        }

        return redirect()->route('appointments.index')
                         ->with('success', 'Booking successful! Awaiting lawyer confirmation.');
    }

    // LAWYER CONFIRMS → Send notification + email to CUSTOMER
    public function confirm($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('lawyer_id', Auth::id())
            ->firstOrFail();

        $appointment->update(['status' => 'confirmed']);

        $lawyer = Auth::user();
        $client = $appointment->client;

        // NOTIFY CUSTOMER: "Appointment confirmed"
        // This notification logic appears to be notifying the LAWYER in the original code, 
        // so I'm translating the original intent but keeping the notification parameters as is 
        // to maintain the original code flow, assuming the notification recipient ID is incorrect in the original.
        // If the intent was to notify the CLIENT, the first argument should be $client->id.
        try {
            notify(
                $lawyer->id, // NOTE: This should likely be $client->id to notify the customer
                'Appointment Confirmed',
                "Your appointment with Lawyer {$lawyer->name} on " .
                \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y \a\t H:i') . 
                " has been confirmed.",
                'confirmed',
                ['appointment_id' => $appointment->id]
            );
        } catch (\Exception $e) {
            \Log::warning("Failed to send confirmation notification to client ID {$client->id}: " . $e->getMessage());
        }

        return back()->with('success', 'Appointment confirmed successfully!');
    }

    // CANCEL APPOINTMENT (Both Lawyer and Customer can cancel)
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
            'cancel_reason' => $reason // if this column exists, otherwise remove
        ]);

        // RE-OPEN SLOT
        if ($appointment->slot) {
            $appointment->slot->update([
                'is_booked' => false,
                'appointment_id' => null,
            ]);
        }

        $canceler = Auth::user();
        $receiverId = $canceler->role === 'lawyer' ? $appointment->client_id : $appointment->lawyer_id;

        // NOTIFY THE OTHER PARTY: "Appointment cancelled"
        try {
            notify(
                $receiverId,
                'Appointment Cancelled',
                "{$canceler->name} has cancelled the appointment scheduled for " .
                \Carbon\Carbon::parse($appointment->appointment_time)->format('d/m/Y \a\t H:i') .
                ". Reason: {$reason}",
                'cancelled',
                ['appointment_id' => $appointment->id]
            );
        } catch (\Exception $e) {
             \Log::warning("Failed to send cancellation notification to user ID {$receiverId}: " . $e->getMessage());
        }


        return back()->with('success', 'Appointment cancelled successfully.');
    }
    
}