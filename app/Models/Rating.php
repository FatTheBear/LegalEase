<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['appointment_id', 'lawyer_id', 'client_id', 'rating', 'comment'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}