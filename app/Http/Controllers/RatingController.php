<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store a new rating
     */
    public function store(Request $request, $appointment_id)
    {
        // Validate input
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Find appointment + security check
        $appointment = Appointment::where('id', $appointment_id)
            ->where('client_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        // Prevent double rating
        if ($appointment->rating()->exists()) {
            return back()->with('error', 'You have already rated this appointment.');
        }

        // Create rating
        Rating::create([
            'appointment_id' => $appointment->id,
            'lawyer_id'      => $appointment->lawyer_id,
            'client_id'      => Auth::id(),
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        // Optional: send notification to lawyer
        try {
            notify(
                $appointment->lawyer_id,
                'New Review Received',
                "You received a {$request->rating}-star rating!",
                'rating'
            );
        } catch (\Exception $e) {
            \Log::warning('Rating notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for your review!');
    } // ← ĐÂY LÀ DÒNG BẠN THIẾU TRƯỚC ĐÓ!
    
}