<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'lawyer_id', 'start_time', 'end_time', 'is_active'
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }
}
