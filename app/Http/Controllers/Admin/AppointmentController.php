<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of all appointments
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['client', 'lawyer', 'lawyer.lawyerProfile']);
        
        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'upcoming') {
                // Upcoming: pending or confirmed appointments with future date
                $query->whereIn('status', ['pending', 'confirmed'])
                      ->whereHas('slot', function($q) {
                          $q->where('date', '>=', Carbon::today()->toDateString());
                      });
            } elseif ($status === 'ongoing') {
                // Ongoing: confirmed appointments happening today
                $query->where('status', 'confirmed')
                      ->whereHas('slot', function($q) {
                          $today = Carbon::today()->toDateString();
                          $now = Carbon::now();
                          $q->where('date', $today)
                            ->where('start_time', '<=', $now->format('H:i:s'))
                            ->where('end_time', '>=', $now->format('H:i:s'));
                      });
            } elseif ($status === 'completed') {
                $query->where('status', 'completed');
            } elseif ($status === 'cancelled') {
                $query->where('status', 'cancelled');
            } else {
                // Fallback to exact status match
                $query->where('status', $status);
            }
        }
        
        // Filter by lawyer
        if ($request->filled('lawyer_id')) {
            $query->where('lawyer_id', $request->lawyer_id);
        }
        
        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('lawyer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('appointment_time', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('appointment_time', '<=', $request->end_date);
        }
        
        // Sort
        $sortBy = $request->input('sort_by', 'appointment_time');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $appointments = $query->paginate(15);
        
        // Get data for filters
        $lawyers = User::where('role', 'lawyer')->with('lawyerProfile')->get();
        $clients = User::where('role', 'client')->get();
        
        // Get statistics
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.appointments.index', compact(
            'appointments',
            'lawyers',
            'clients',
            'stats'
        ));
    }

    /**
     * Display the specified appointment details
     */
    public function show($id)
    {
        $appointment = Appointment::with(['client', 'lawyer', 'lawyer.lawyerProfile', 'slot'])->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment
     */
    public function edit($id)
    {
        $appointment = Appointment::with(['client', 'lawyer'])->findOrFail($id);
        $lawyers = User::where('role', 'lawyer')->with('lawyerProfile')->get();
        $clients = User::where('role', 'client')->get();
        
        return view('admin.appointments.edit', compact(
            'appointment',
            'lawyers',
            'clients'
        ));
    }

    /**
     * Update the appointment status or information
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'appointment_time' => 'nullable|date_format:Y-m-d H:i',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $oldStatus = $appointment->status;
        $appointment->update($validated);
        
        // Create notification when status changes
        if ($oldStatus !== $validated['status']) {
            $this->createStatusChangeNotifications($appointment, $oldStatus, $validated['status']);
        }
        
        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Confirm the appointment
     */
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);

        $oldStatus = $appointment->status;

        // Update status to confirmed
        $appointment->status = 'confirmed';
        $appointment->save();

        // Send notification using try-catch
        try {
            notify(
                $appointment->client_id,
                'Appointment Confirmed',
                "Your appointment with {$appointment->lawyer->name} on {$appointment->appointment_time} has been confirmed!",
                'appointment_confirmed'
            );
        } catch (\Exception $e) {
            \Log::warning("Notification to client failed: " . $e->getMessage());
        }

        try {
            notify(
                $appointment->lawyer_id,
                'Appointment Confirmed',
                "The appointment with {$appointment->client->name} on {$appointment->appointment_time} has been confirmed!",
                'appointment_confirmed'
            );
        } catch (\Exception $e) {
            \Log::warning("Notification to lawyer failed: " . $e->getMessage());
        }

        // Redirect back to appointment list page (or previous page)
        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment confirmed and notifications sent!');
    }


    /**
     * Cancel the appointment
     */
    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        if ($appointment->status !== 'cancelled') {
            $appointment->update([
                'status' => 'cancelled',
                'notes' => $validated['reason'] ?? $appointment->notes,
            ]);

            $reason = $validated['reason'] ?? 'No reason provided';

            // Send notification to client
            try {
                notify(
                    $appointment->client_id,
                    'Appointment Cancelled',
                    "The appointment on {$appointment->appointment_time} has been cancelled. Reason: {$reason}",
                    'appointment_cancelled'
                );
            } catch (\Exception $e) {
                \Log::warning("Notification to client failed: " . $e->getMessage());
            }

            // Send notification to lawyer
            try {
                notify(
                    $appointment->lawyer_id,
                    'Appointment Cancelled',
                    "The appointment with {$appointment->client->name} on {$appointment->appointment_time} has been cancelled. Reason: {$reason}",
                    'appointment_cancelled'
                );
            } catch (\Exception $e) {
                \Log::warning("Notification to lawyer failed: " . $e->getMessage());
            }

            return redirect()->route('admin.appointments.index')
                             ->with('success', 'Appointment successfully cancelled and users notified!');
        }

        return redirect()->route('admin.appointments.index')
                         ->with('error', 'This appointment is already cancelled!');
    }


    /**
     * Delete the appointment
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        
        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Appointment successfully deleted!');
    }

    /**
     * Retrieve appointment statistics data
     */
    public function getStatistics()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        return [
            'today_count' => Appointment::whereDate('appointment_time', $today)->count(),
            'today_pending' => Appointment::whereDate('appointment_time', $today)
                                          ->where('status', 'pending')->count(),
            'today_confirmed' => Appointment::whereDate('appointment_time', $today)
                                            ->where('status', 'confirmed')->count(),
            'this_month_count' => Appointment::whereBetween('appointment_time', [$thisMonth, $thisMonth->endOfMonth()])->count(),
            'upcoming' => Appointment::where('appointment_time', '>', now())
                                     ->where('status', '!=', 'cancelled')
                                     ->count(),
            'overdue' => Appointment::where('appointment_time', '<', now())
                                    ->where('status', 'pending')->count(),
        ];
    }

    /**
     * Helper: Create notifications when status changes
     */
    private function createStatusChangeNotifications($appointment, $oldStatus, $newStatus)
    {
        $statusMessages = [
            'pending' => 'pending',
            'confirmed' => 'confirmed',
            'completed' => 'completed',
            'cancelled' => 'cancelled',
        ];
        
        $message = 'The appointment status has changed from ' . $statusMessages[$oldStatus] . ' to ' . $statusMessages[$newStatus];
        
        Notification::create([
            'user_id' => $appointment->client_id,
            'type' => 'appointment_status_changed',
            'message' => $message,
        ]);
        
        Notification::create([
            'user_id' => $appointment->lawyer_id,
            'type' => 'appointment_status_changed',
            'message' => $message,
        ]);
    }
}