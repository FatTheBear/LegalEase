<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['lawyer_id', 'client_id', 'rating', 'comment', 'appointment_id'];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}