<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'specialization', 'experience', 'city', 'province',
        'verified', 'rating', 'bio', 'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

