<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AvailabilitySlot;
use Carbon\Carbon;

class AvailabilitySlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả lawyer active
        $lawyers = User::where('role', 'lawyer')
                      ->where('status', 'active')
                      ->get();
        
        if ($lawyers->isEmpty()) {
            echo "⚠️ No active lawyers found. Please seed users first.\n";
            return;
        }

        // Xoá slot cũ
        AvailabilitySlot::whereIn('lawyer_id', $lawyers->pluck('id'))->delete();

        $totalSlots = 0;

        // Tạo slot cho từng lawyer
        foreach ($lawyers as $lawyer) {
            // Tạo slot cho hôm nay và các ngày tiếp theo
            $dates = [
                Carbon::today(),
                Carbon::today()->addDay(),
                Carbon::today()->addDays(2),
                Carbon::today()->addDays(3),
            ];

            $slots = [
                ['start_time' => '08:00', 'end_time' => '09:00'],
                ['start_time' => '10:00', 'end_time' => '11:00'],
                ['start_time' => '14:00', 'end_time' => '15:00'],
                ['start_time' => '16:00', 'end_time' => '17:00'],
            ];

            foreach ($dates as $date) {
                foreach ($slots as $slot) {
                    AvailabilitySlot::create([
                        'lawyer_id' => $lawyer->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                    ]);
                    $totalSlots++;
                }
            }
        }

        echo "✅ " . $totalSlots . " availability slots created successfully!\n";
        echo "👨‍⚖️ Total lawyers: " . $lawyers->count() . "\n";
        echo "🕐 Slots per lawyer: 16 (4 days × 4 slots/day)\n";
    }
}
