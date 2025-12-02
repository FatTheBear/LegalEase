<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    protected $fillable = ['lawyer_id', 'date', 'start_time', 'end_time', 'is_booked', 'appointment_id'];
    // app/Models/AvailabilitySlot.php
    protected $dates = ['date']; // hoặc
    protected $casts = [
        'date' => 'date:Y-m-d', // Khi trả JSON sẽ là "YYYY-MM-DD"
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}