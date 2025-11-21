<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewNotificationMail;

class Notification extends Model
{
    protected $fillable = ['user_id', 'title', 'message', 'type', 'is_read', 'data'];

    protected $casts = ['data' => 'array', 'is_read' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Gửi email tự động khi tạo thông báo
    public static function boot()
    {
        parent::boot();

        static::created(function ($notification) {
            if ($notification->user && $notification->user->email) {
                try {
                    Mail::to($notification->user->email)->queue(new NewNotificationMail($notification));
                } catch (\Exception $e) {
                    \Log::error("Failed to send notification email: " . $e->getMessage());
                }
            }
        });
    }
}