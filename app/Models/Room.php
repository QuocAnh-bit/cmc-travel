<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'hotel_name',
        'location',
        'price',
        'discount',
        'image',
        'description',
        'amenities',
        'status',
        'is_featured'
    ];

    protected $casts = [
        'amenities' => 'array',
        'is_featured' => 'boolean'
    ];
}
