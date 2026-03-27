<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminTourController; 

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\RoomController;
use Illuminate\Support\Facades\Route;

// ================= CLIENT (Giao diện người dùng) =================

// Trang chủ chính thức theo style iVIVU (Banner + Search + DB Tours)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tìm kiếm Tour/Khách sạn từ Search Box
Route::get('/search', [HomeController::class, 'search'])->name('tours.search');

// Danh sách và chi tiết
Route::resource('rooms', RoomController::class)->only(['index', 'show']);


// ================= AUTH (Đăng nhập / Đăng ký) =================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ================= BOOKING (Chỉ dành cho người dùng đã đăng nhập) =================
Route::middleware('auth')->group(function () {
    Route::resource('bookings', BookingController::class);
});


// ================= ADMIN (Quản trị hệ thống) =================
Route::middleware(['web'])->group(function () {
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['auth', 'isAdmin'])
        ->group(function () {

            // Dashboard thống kê
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            // Quản lý Người dùng
            Route::resource('users', UserController::class);
            Route::post('users/{id}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');

            // Quản lý Phòng khách sạn
            Route::resource('rooms', AdminRoomController::class);


            // Quản lý Đơn đặt hàng (Bookings)
            Route::resource('bookings', AdminBookingController::class);
            Route::post('bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
            Route::post('bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
        });
});