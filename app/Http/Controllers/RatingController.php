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
        $stars = str_repeat('★', $request->rating);

        $title = "New {$request->rating}-star review {$stars}";

        $message = "Client {$appointment->client->name} just gave you a {$request->rating}-star rating.\n\n";

        $message .= $request->filled('comment')
            ? "Review:\n\"{$request->comment}\""
            : "No written review was provided.";

        notify(
            $appointment->lawyer_id,
            $title,
            $message,
            'rating',
            [
                'appointment_id' => $appointment->id,
                'rating'        => $request->rating,
            ]
        );
    } catch (\Exception $e) {
        \Log::warning('Rating notification failed: ' . $e->getMessage());
    }

        return back()->with('success', 'Thank you for your review!');
    } // ← ĐÂY LÀ DÒNG BẠN THIẾU TRƯỚC ĐÓ!
    
}