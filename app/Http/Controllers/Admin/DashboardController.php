<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
{
    // Lấy dữ liệu 7 ngày gần nhất
    $days = collect(range(6, 0))->map(function($i) {
        return now()->subDays($i)->format('d/m');
    });

    $bookingCounts = collect(range(6, 0))->map(function($i) {
        return Booking::whereDate('created_at', now()->subDays($i))->count();
    });

    return view('admin.dashboard', [
        'totalUsers' => User::count(),
        'totalRooms' => Room::count(),
        'totalBookings' => Booking::count(),
        'confirmedBookings' => Booking::where('status','confirmed')->count(),
        'chartLabels' => $days,
        'chartData' => $bookingCounts,
    ]);
}
}