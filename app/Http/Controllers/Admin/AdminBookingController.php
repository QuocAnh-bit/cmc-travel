<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // danh sách booking
    public function index()
    {
        $bookings = Booking::all();
        return view('admin.bookings.index', compact('bookings'));
    }

    // xem chi tiết
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // xác nhận booking
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return back()->with('success', 'Đã xác nhận booking');
    }

    // hủy booking
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Đã hủy booking');
    }

    // xóa booking
    public function destroy($id)
    {
        Booking::destroy($id);
        return back()->with('success', 'Đã xóa booking');
    }
}