<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = [
            [
                'id' => 1,
                'name' => 'Phòng VIP',
                'price' => 500000
            ],
            [
                'id' => 2,
                'name' => 'Phòng thường',
                'price' => 300000
            ],
            [
                'id' => 3,
                'name' => 'Phòng đơn',
                'price' => 200000
            ]
        ];

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }

    public function checkAvailable(Request $request)
    {
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        $rooms = \App\Models\Room::whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
            $q->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q2) use ($checkIn, $checkOut) {
                        $q2->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                    });
            });
        })->get();

        return response()->json($rooms);
    }
}
