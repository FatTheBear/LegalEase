<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AvailabilitySlot;
use Carbon\Carbon;

class JohnSmithSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy John Smith
        $lawyer = User::where('name', 'John Smith')->first();
        
        if (!$lawyer) {
            echo "⚠️ John Smith not found.\n";
            return;
        }

        // Xoá slot cũ nếu có
        AvailabilitySlot::where('lawyer_id', $lawyer->id)->delete();

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

        $totalSlots = 0;
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

        echo "✅ " . $totalSlots . " slots created for John Smith!\n";
        echo "📅 Lawyer: " . $lawyer->name . "\n";
        echo "🕐 Available from today to 3 days later\n";
    }
}
