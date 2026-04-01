<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hotel_id',     // Đây là "danh mục" chính
        'price',
        'discount',
        'image',
        'description',
        'amenities',
        'status',
        'is_featured',
        
    ];

    protected $casts = [
        'amenities' => 'array',
        'is_featured' => 'boolean',
        'price' => 'integer',
        'discount' => 'integer',
    ];

    /**
     * Lấy thông tin khách sạn sở hữu phòng này
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailableFor($checkIn, $checkOut, $ignoreBookingId = null): bool
    {
        $query = $this->bookings()
            ->active()
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);

        if ($ignoreBookingId) {
            $query->whereKeyNot($ignoreBookingId);
        }

        return ! $query->exists();
    }

    /**
     * Helper để lấy địa điểm từ khách sạn (thay cho cột location cũ)
     */
    public function getLocationAttribute()
    {
        return $this->hotel ? $this->hotel->address : 'Chưa xác định';
    }
    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotel_id');
    }
}
