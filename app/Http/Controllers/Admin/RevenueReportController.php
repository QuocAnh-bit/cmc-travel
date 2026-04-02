<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevenueReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $bookingsQuery = Booking::with(['user', 'room.hotel'])
            ->where('status', 'confirmed')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest();

        if ($request->filled('hotel_keyword')) {
            $keyword = trim($request->hotel_keyword);

            $bookingsQuery->whereHas('room.hotel', function ($hotelQuery) use ($keyword) {
                $hotelQuery->where('name', 'like', "%{$keyword}%");
            });
        }

        $reportBookings = (clone $bookingsQuery)->get();
        $bookings = (clone $bookingsQuery)->paginate(12)->appends($request->query());

        $dailyRevenue = $reportBookings
            ->groupBy(fn ($booking) => $booking->created_at->format('Y-m-d'))
            ->sortKeys()
            ->map(fn ($items, $date) => [
                'label' => Carbon::parse($date)->format('d/m'),
                'total' => (int) $items->sum('total_price'),
            ])
            ->values();

        $hotelRevenue = $reportBookings
            ->groupBy(fn ($booking) => $booking->room?->hotel?->name ?? 'Khách sạn không xác định')
            ->map(fn ($items, $hotel) => [
                'hotel' => $hotel,
                'total' => (int) $items->sum('total_price'),
                'bookings' => $items->count(),
            ])
            ->sortByDesc('total')
            ->take(5)
            ->values();

        $summary = [
            'revenue' => (int) $reportBookings->sum('total_price'),
            'bookings' => $reportBookings->count(),
            'averageBookingValue' => $reportBookings->count() > 0
                ? (int) round($reportBookings->avg('total_price'))
                : 0,
            'bestDayRevenue' => (int) $dailyRevenue->max('total'),
        ];

        return view('admin.reports.revenue', [
            'bookings' => $bookings,
            'summary' => $summary,
            'dailyRevenueLabels' => $dailyRevenue->pluck('label'),
            'dailyRevenueData' => $dailyRevenue->pluck('total'),
            'hotelRevenue' => $hotelRevenue,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'hotel_keyword' => $request->input('hotel_keyword', ''),
            ],
        ]);
    }
}