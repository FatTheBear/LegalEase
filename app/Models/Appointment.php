<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'lawyer_id', 'slot_id',
        'appointment_time', 'status', 'note'
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'slot_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}
