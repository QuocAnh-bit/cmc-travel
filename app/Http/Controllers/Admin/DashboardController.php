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
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalRooms' => Room::count(),
            'totalBookings' => Booking::count(),
            'confirmedBookings' => Booking::where('status','confirmed')->count(),
        ]);
    }
}