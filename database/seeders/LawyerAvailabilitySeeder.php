<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AvailabilitySlot;
use Carbon\Carbon;

class LawyerAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả users có role lawyer
        $lawyers = User::where('role', 'lawyer')->get();

        foreach ($lawyers as $lawyer) {
            // Tạo lịch làm việc trong 7 ngày tới, 2 slot mỗi ngày
            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::today()->addDays($i);

                AvailabilitySlot::create([
                    'lawyer_id' => $lawyer->id,
                    'date' => $date->toDateString(),
                    'start_time' => '09:00:00',
                    'end_time' => '11:00:00',
                    'is_booked' => false,
                ]);

                AvailabilitySlot::create([
                    'lawyer_id' => $lawyer->id,
                    'date' => $date->toDateString(),
                    'start_time' => '14:00:00',
                    'end_time' => '16:00:00',
                    'is_booked' => false,
                ]);
            }
        }

        $this->command->info("✅ Availability slots created for all lawyers!");
    }
}
