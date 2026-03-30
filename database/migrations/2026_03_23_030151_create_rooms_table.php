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
        $table->string('name');
        
        // Khai báo trực tiếp ở đây, KHÔNG cần file migration riêng lẻ nữa
        $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
        
        $table->integer('price');
        $table->integer('discount')->default(0);
        $table->string('image')->nullable();
        $table->text('description')->nullable();
        $table->json('amenities')->nullable();
        $table->string('status')->default('available');
        $table->boolean('is_featured')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Khi xóa bảng rooms, cần đảm bảo xóa sạch các ràng buộc
        Schema::dropIfExists('rooms');
    }
};