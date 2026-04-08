<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RevenueReportRequest;
use App\Models\Booking;
use Carbon\Carbon;

class RevenueReportController extends Controller
{
    public function index(RevenueReportRequest $request)
    {
        $validated = $request->validated();
        $startDate = $validated['start_date'] ?? now()->startOfMonth()->toDateString();
        $endDate = $validated['end_date'] ?? now()->toDateString();
        $hotelKeyword = $validated['hotel_keyword'] ?? '';

        $bookingsQuery = Booking::with(['user', 'room.hotel'])
            ->where('status', 'confirmed')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest();

        if ($hotelKeyword !== '') {
            $bookingsQuery->whereHas('room.hotel', function ($hotelQuery) use ($hotelKeyword) {
                $hotelQuery->where('name', 'like', "%{$hotelKeyword}%");
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
            ->groupBy(fn ($booking) => $booking->room?->hotel?->name ?? 'Khach san khong xac dinh')
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
                'hotel_keyword' => $hotelKeyword,
            ],
        ]);
    }
}
