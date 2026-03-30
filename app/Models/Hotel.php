<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    // Thêm dòng này để cho phép lưu dữ liệu vào các cột tương ứng
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}