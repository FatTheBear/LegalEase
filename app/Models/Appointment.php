<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // ĐÃ ĐỒNG BỘ 100% VỚI MIGRATION MỚI
    protected $fillable = [
        'client_id',
        'lawyer_id',
        'slot_id',
        'date',
        'start_time',
        'appointment_time',
        'end_time',           // ← THÊM MỚI
        'status',
        'notes',              // ← ĐỔI TỪ note → notes (chuẩn Laravel)
        'cancel_reason',      // ← THÊM MỚI
    ];

    protected $casts = [
        'appointment_time' => 'datetime',
        'end_time'         => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    // Luật sư
    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    // Khách hàng (đổi tên từ customer → client cho nhất quán)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Slot trống mà khách đã book
    public function slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'slot_id');
    }

    // Đánh giá sau khi hoàn thành (nếu có)
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    // ==================== HELPER METHODS ====================

    // Kiểm tra xem có phải là lịch của người đang đăng nhập không
    public function belongsToCurrentUser()
    {
        return auth()->id() == $this->client_id || auth()->id() == $this->lawyer_id;
    }

    // Format thời gian đẹp để hiển thị
    public function getFormattedTime()
    {
        return $this->appointment_time->format('d/m/Y H:i') . 
               ' → ' . 
               optional($this->end_time)->format('H:i');
    }

    // Trạng thái có thể hủy không
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }
    
}
