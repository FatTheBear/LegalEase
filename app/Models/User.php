<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailNotification;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'status', 'email_verified_at', 'approval_status'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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
    // Thêm vào model User.php

}
