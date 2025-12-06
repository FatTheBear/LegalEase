<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'status', 'email_verified_at', 'approval_status', 'last_login_at', 'avatar'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function lawyerProfile()
    {
        return $this->hasOne(LawyerProfile::class);
    }

    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class, 'lawyer_id');
    }

    public function appointmentsAsLawyer()
    {
        return $this->hasMany(Appointment::class, 'lawyer_id');
    }

    public function appointmentsAsCustomer()
    {
        return $this->hasMany(Appointment::class, 'customer_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id');
    }

    public function documentUploads()
    {
        return $this->hasMany(DocumentUpload::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'lawyer_id');
    }

    public function givenRatings()
    {
        return $this->hasMany(Rating::class, 'client_id');
    }

    // Relationship cho documents upload
    public function documents()
    {
        return $this->hasMany(DocumentUpload::class);
    }

    // Helper methods
    public function isLawyer()
    {
        return $this->role === 'lawyer';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Mark the user's email as verified.
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function hasVerifiedEmail()
    {
        return null !== $this->email_verified_at;
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }
    // Relationships for messaging system
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'sender_id') // từ user gửi
                    ->where('receiver_id', 1) // admin nhận
                    ->where('is_read', false);
    }

    /**
     * Check if user has a valid avatar
     */
    public function hasAvatar()
    {
        if (empty($this->avatar)) {
            return false;
        }

        // Check if file exists in storage
        return Storage::disk('public')->exists($this->avatar);
    }

    /**
     * Get avatar URL or null if not exists
     */
    public function getAvatarUrl()
    {
        if ($this->hasAvatar()) {
            return asset('storage/' . $this->avatar);
        }
        return null;
    }
}
