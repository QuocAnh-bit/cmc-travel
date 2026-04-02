<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $days = collect(range(6, 0))->map(fn ($i) => now()->subDays($i));

        $bookingCounts = $days->map(function ($date) {
            return Booking::whereDate('created_at', $date->toDateString())->count();
        });

        $revenueSeries = $days->map(function ($date) {
            return (int) Booking::where('status', 'confirmed')
                ->whereDate('created_at', $date->toDateString())
                ->sum('total_price');
        });

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalRooms' => Room::count(),
            'totalBookings' => Booking::count(),
            'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
            'revenueToday' => (int) Booking::where('status', 'confirmed')
                ->whereDate('created_at', $today->toDateString())
                ->sum('total_price'),
            'revenueThisMonth' => (int) Booking::where('status', 'confirmed')
                ->whereDate('created_at', '>=', $monthStart->toDateString())
                ->sum('total_price'),
            'confirmedRevenue' => (int) Booking::where('status', 'confirmed')->sum('total_price'),
            'pendingRevenue' => (int) Booking::where('status', 'pending')->sum('total_price'),
            'chartLabels' => $days->map(fn ($date) => $date->format('d/m')),
            'chartData' => $bookingCounts,
            'revenueChartData' => $revenueSeries,
        ]);
    }
}