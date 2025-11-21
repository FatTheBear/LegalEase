<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $slots = AvailabilitySlot::where('lawyer_id', auth()->id())
            ->where('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('lawyers.schedule', compact('slots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
        ]);

        $date = $request->date;
        $start = Carbon::parse("$date {$request->start_time}");
        $end = $start->copy()->addHours(2);

        // Kiểm tra trùng
        $exists = AvailabilitySlot::where('lawyer_id', auth()->id())
            ->where('date', $date)
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start->format('H:i:s'), $end->format('H:i:s')])
                  ->orWhereBetween('end_time', [$start->format('H:i:s'), $end->format('H:i:s')])
                  ->orWhereRaw('? BETWEEN start_time AND end_time', [$start->format('H:i:s')]);
            })->exists();

        if ($exists) {
            return back()->with('error', 'This time slot overlaps with existing schedule!');
        }

        AvailabilitySlot::create([
            'lawyer_id' => auth()->id(),
            'date' => $date,
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'is_booked' => false,
        ]);

        return back()->with('success', 'Schedule added successfully!');
    }

    public function destroy($id)
    {
        $slot = AvailabilitySlot::where('lawyer_id', auth()->id())
            ->where('id', $id)
            ->where('is_booked', false)
            ->firstOrFail();

        $slot->delete();
        return back()->with('success', 'Slot removed!');
    }
}