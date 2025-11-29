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
        return view('lawyers.schedule');
    }

    // JSON cho FullCalendar
    public function getSlots()
    {
        $slots = AvailabilitySlot::where('lawyer_id', auth()->id())->get();
        $events = [];

        foreach ($slots as $slot) {
            $events[] = [
                'id'    => $slot->id,
                'title' => Carbon::parse($slot->start_time)->format('H:i')
                            . " - " . Carbon::parse($slot->end_time)->format('H:i'),
                'start' => $slot->date . " " . $slot->start_time,
                'end'   => $slot->date . " " . $slot->end_time,
            ];
        }

        return response()->json($events);
    }

    // JSON slot theo ngày
    public function getSlotsByDay($date)
    {
        $slots = AvailabilitySlot::where('lawyer_id', auth()->id())
            ->where('date', $date)
            ->orderBy('start_time')
            ->get();

        return response()->json($slots);
    }

    // Thêm slot tùy chọn
    public function store(Request $request)
    {
        $request->validate([
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        $start = Carbon::parse("{$request->date} {$request->start_time}");
        $end   = Carbon::parse("{$request->date} {$request->end_time}");

        $exists = AvailabilitySlot::where('lawyer_id', auth()->id())
            ->where('date', $request->date)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start->format('H:i:s'), $end->format('H:i:s')])
                  ->orWhereBetween('end_time', [$start->format('H:i:s'), $end->format('H:i:s')])
                  ->orWhereRaw('? BETWEEN start_time AND end_time', [$start->format('H:i:s')]);
            })
            ->exists();

        if ($exists) return response()->json(['error'=>"Time slot exists"],422);

        AvailabilitySlot::create([
            'lawyer_id' => auth()->id(),
            'date'      => $request->date,
            'start_time'=> $start->format('H:i:s'),
            'end_time'  => $end->format('H:i:s'),
            'is_booked' => false,
        ]);

        return response()->json(['ok'=>true]);
    }

    // Thêm 4 slot hành chính 8h–17h
    public function storeDay(Request $request)
    {
        $request->validate(['date'=>'required|date|after_or_equal:today']);

        $date = $request->date;
        $ranges = [
            [8,10],
            [10,12],
            [13,15],
            [15,17]
        ];

        foreach ($ranges as $range) {
            $start = Carbon::parse("$date {$range[0]}:00");
            $end   = Carbon::parse("$date {$range[1]}:00");

            $exists = AvailabilitySlot::where('lawyer_id', auth()->id())
                ->where('date', $date)
                ->where('start_time', $start->format('H:i:s'))
                ->exists();

            if (!$exists) {
                AvailabilitySlot::create([
                    'lawyer_id'=>auth()->id(),
                    'date'=>$date,
                    'start_time'=>$start->format('H:i:s'),
                    'end_time'=>$end->format('H:i:s'),
                    'is_booked'=>false
                ]);
            }
        }

        return response()->json(['ok'=>true]);
    }

    // Xóa 1 slot
    public function destroy($id)
    {
        $slot = AvailabilitySlot::where('lawyer_id', auth()->id())
            ->where('is_booked', false)
            ->findOrFail($id);

        $slot->delete();
        return response()->json(['ok'=>true]);
    }

    // Xóa tất cả slot của 1 ngày
    public function destroyDay($date)
    {
        AvailabilitySlot::where('lawyer_id', auth()->id())
            ->where('date', $date)
            ->where('is_booked', false)
            ->delete();

        return response()->json(['ok'=>true]);
    }
}
