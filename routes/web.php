<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\UserController;

// CLIENT
Route::get('/', [RoomController::class, 'index']);
Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);

// ADMIN
Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
});
