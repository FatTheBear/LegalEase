<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'document_type',
        'file_extension',
        'file_size',
    ];

    // Casts
    protected $casts = [
        'file_size' => 'integer',
    ];

    /**
     * Relationship với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor để lấy URL đầy đủ của file
     */
    public function getFileUrlAttribute()
    {
        // Dùng Storage::url để tương thích với disk hiện tại (public, s3, ...)
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    /**
     * Accessor để format file size (ví dụ: 1.23 MB)
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = (int) $this->file_size;

        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope để filter theo loại document
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('document_type', $type);
    }
}