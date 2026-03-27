<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\RoomController;
use Illuminate\Support\Facades\Route;

// ================= CLIENT =================
Route::get('/', [RoomController::class, 'index'])->name('home');

Route::resource('rooms', RoomController::class);

// ================= AUTH =================
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'handleLogin'])->name('login.post');

Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register',[AuthController::class,'handleRegister'])->name('register.post');

// logout chuẩn (POST)
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

// ================= BOOKING =================
Route::middleware('auth')->group(function () {
    Route::resource('bookings', BookingController::class);
});

// ================= ADMIN =================
Route::middleware(['web'])->group(function () {
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','isAdmin'])
    ->group(function () {

        // dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // users
        Route::resource('users', UserController::class);

        // rooms
         Route::resource('rooms', AdminRoomController::class);

        // bookings
        Route::resource('bookings', AdminBookingController::class);

        // action riêng
        Route::post('bookings/{id}/confirm', [AdminBookingController::class, 'confirm']);
        Route::post('bookings/{id}/cancel', [AdminBookingController::class, 'cancel']);


        // user actions
        
        Route::post('users/{id}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    });
});