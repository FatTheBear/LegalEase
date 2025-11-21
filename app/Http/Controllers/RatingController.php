<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:users,id',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'lawyer_id' => $request->lawyer_id,
            'client_id' => Auth::id(),
            'rating'    => $request->rating,
            'comment'   => $request->comment,
            'appointment_id' => $request->appointment_id,
        ]);
        notify(
            $rating->lawyer_id,
            'Bạn nhận được đánh giá mới',
            "Khách hàng đã đánh giá bạn {$rating->rating} sao!",
            'rating'
        );
        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
}