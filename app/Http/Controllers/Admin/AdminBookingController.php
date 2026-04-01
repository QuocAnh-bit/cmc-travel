<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room.hotel'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);

            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                })->orWhereHas('room', function ($roomQuery) use ($keyword) {
                    $roomQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhereHas('hotel', function ($hotelQuery) use ($keyword) {
                            $hotelQuery->where('name', 'like', "%{$keyword}%");
                        });
                });
            });
        }

        if ($request->filled('check_in_from')) {
            $query->whereDate('check_in', '>=', $request->check_in_from);
        }

        if ($request->filled('check_in_to')) {
            $query->whereDate('check_in', '<=', $request->check_in_to);
        }

        $bookings = $query->paginate(12)->appends($request->query());
        $summary = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'summary'));
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'room.hotel'])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm($id)
    {
        $booking = Booking::with('room')->findOrFail($id);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Khong the xac nhan don da huy.');
        }

        if (! $booking->room || ! $booking->room->isAvailableFor(
            $booking->check_in->toDateString(),
            $booking->check_out->toDateString(),
            $booking->id
        )) {
            return back()->with('error', 'Phong da co lich trung. Khong the xac nhan don nay.');
        }

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Da xac nhan don dat phong.');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Don nay da o trang thai huy.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Da huy don dat phong.');
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();

        return back()->with('success', 'Da xoa don dat phong.');
    }

    public function create()
    {
        return redirect()->route('admin.bookings.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.bookings.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.bookings.show', $id);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.bookings.show', $id);
    }
}
