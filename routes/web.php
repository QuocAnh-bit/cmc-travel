<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminTourController;
use App\Http\Controllers\Admin\ContactManagerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RevenueReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\HotelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\Client\SearchController::class, 'index'])->name('client.search');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/lien-he', [ContactController::class, 'index'])->name('clients.contacts.index');
Route::post('/lien-he', [ContactController::class, 'store'])->name('clients.contacts.store');

Route::middleware('auth')->group(function () {
    // Tích hợp vn pay
    Route::post('/vnpay_payment', [CheckoutController::class, 'vnpay_payment']);
    Route::get('/checkout', [CheckoutController::class, 'return']);

    Route::post('/rooms/{room}/availability', [BookingController::class, 'availability'])->name('rooms.availability');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::resource('bookings', BookingController::class);
    Route::resource('profile', ProfileController::class);
});

Route::middleware(['web'])->group(function () {
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['auth', 'isAdmin'])
        ->group(function () {
            Route::resource('contacts', ContactManagerController::class)->only(['index', 'show', 'destroy']);
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('reports/revenue', [RevenueReportController::class, 'index'])->name('reports.revenue');

            Route::resource('users', UserController::class)->except(['show']);
            Route::post('users/{id}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');

            Route::resource('rooms', AdminRoomController::class);
            Route::resource('hotels', AdminHotelController::class)->only(['index', 'store', 'destroy']);
            Route::resource('bookings', AdminBookingController::class);
            Route::post('bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
            Route::post('bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
        });
});
