<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LawyerScheduleController extends Controller
{
    public function index()
    {
        // Luật sư có ít nhất 1 slot rảnh sắp tới, sắp xếp slot gần nhất lên đầu, paginate 12 luật sư / trang
        $lawyersQuery = User::where('role', 'lawyer')
            ->whereHas('availabilitySlots', function ($q) {
                $q->where('is_booked', false)
                  ->where('date', '>=', Carbon::today());
            })
            ->with(['lawyerProfile', 'availabilitySlots' => function ($q) {
                $q->where('is_booked', false)
                  ->where('date', '>=', Carbon::today())
                  ->orderBy('date')
                  ->orderBy('start_time');
            }]);

        // Để sắp xếp theo slot gần nhất, dùng Collection sort sau khi paginate
        $lawyers = $lawyersQuery->get()
            ->sortBy(function($lawyer){
                return $lawyer->availabilitySlots->first() ? $lawyer->availabilitySlots->first()->date : Carbon::maxValue();
            });

        // Phân trang Collection manually
        $perPage = 12;
        $currentPage = request()->get('page', 1);
        $pagedLawyers = $lawyers->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $lawyersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedLawyers,
            $lawyers->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Upcoming slots toàn bộ luật sư, paginate 5 slot / trang
        $slots = AvailabilitySlot::where('is_booked', false)
                    ->where('date', '>=', Carbon::today())
                    ->with('lawyer', 'lawyer.lawyerProfile')
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->paginate(5);

        return view('admin.lawyer-schedules.index', [
            'lawyers' => $lawyersPaginated,
            'slots' => $slots
        ]);
    }

    // Lấy ngày có slot của luật sư
    public function getDates($lawyerId)
    {
        $dates = AvailabilitySlot::where('lawyer_id', $lawyerId)
            ->where('is_booked', false)
            ->where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->get()
            ->groupBy('date')
            ->map(function($group, $key){
                return [
                    'date' => $key,
                    'date_formatted' => \Carbon\Carbon::parse($key)->format('d/m/Y')
                ];
            })->values();

        return response()->json($dates);
    }

    // Lấy slot theo luật sư + ngày
    public function getSlotsByLawyerDate($lawyerId, $date)
    {
        $slots = AvailabilitySlot::where('lawyer_id', $lawyerId)
            ->where('date', $date)
            ->where('is_booked', false)
            ->orderBy('start_time')
            ->get()
            ->map(function($slot){
                return [
                    'id' => $slot->id,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                    'date_formatted' => \Carbon\Carbon::parse($slot->date)->format('d/m/Y')
                ];
            });

        return response()->json($slots);
    }

    public function deleteSlot($id)
    {
        $slot = AvailabilitySlot::findOrFail($id);
        $slot->delete();
        return response()->json(['success'=>true]);
    }
}
