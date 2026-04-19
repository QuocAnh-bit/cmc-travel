<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'transaction_id',
        'bank_code',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    // ===== RELATION =====

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
