<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'title', 'slug', 'image', 'departure_point', 
        'duration', 'description', 'content', 'price', 
        'discount', 'is_hot', 'status'
    ];

    // Hàm lấy giá sau khi đã giảm
    public function getSalePriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->price;
    }
}