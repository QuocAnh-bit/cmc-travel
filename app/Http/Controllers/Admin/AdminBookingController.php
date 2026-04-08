<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingIndexRequest;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    public function index(BookingIndexRequest $request)
    {
        $filters = $request->validated();
        $query = Booking::with(['user', 'room.hotel'])->latest();

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['keyword'])) {
            $keyword = $filters['keyword'];

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

        if (! empty($filters['check_in_from'])) {
            $query->whereDate('check_in', '>=', $filters['check_in_from']);
        }

        if (! empty($filters['check_in_to'])) {
            $query->whereDate('check_in', '<=', $filters['check_in_to']);
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

        if ($booking->status === 'confirmed') {
            return back()->with('error', 'Don dat phong nay da duoc xac nhan truoc do.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Khong the xac nhan don da huy.');
        }

        if (! $booking->room || $booking->room->status !== 'available') {
            return back()->with('error', 'Phong khong con o trang thai san sang de xac nhan.');
        }

        if (! $booking->room->isAvailableFor(
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

    public function store()
    {
        return redirect()->route('admin.bookings.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.bookings.show', $id);
    }

    public function update($id)
    {
        return redirect()->route('admin.bookings.show', $id);
    }
}
