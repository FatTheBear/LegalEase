<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image', 'type', 'created_by'];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
