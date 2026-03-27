<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('rooms', function (Blueprint $table) {
    $table->id();
    $table->string('name');             // Tên phòng (VD: Premier Ocean View)
    $table->string('hotel_name');       // Tên khách sạn/Resort (VD: Fusion Suites Vũng Tàu)
    $table->string('location');         // Địa điểm (Vũng Tàu, Phú Quốc...)
    $table->integer('price');           // Giá mỗi đêm
    $table->integer('discount')->default(0); // % Giảm giá
    $table->string('image')->nullable();
    $table->text('description')->nullable(); 
    $table->json('amenities')->nullable(); // Các tiện ích (Wifi, Bể bơi, Ăn sáng...)
    $table->string('status')->default('available'); // available, booked, maintenance
    $table->boolean('is_featured')->default(false); // Hiện ở mục "Combo tốt nhất"
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
