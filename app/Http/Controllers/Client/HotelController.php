<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\HotelAvailabilityFilterRequest;
use App\Http\Requests\Client\HotelIndexFilterRequest;
use App\Models\Booking;
use App\Models\Hotel;
use Carbon\Carbon;

class HotelController extends Controller
{
    public function index(HotelIndexFilterRequest $request)
    {
        $filters = $request->validated();
        $query = Hotel::with(['rooms']);

        if (! empty($filters['name'])) {
            $query->where('hotels.name', 'like', '%' . $filters['name'] . '%');
        }

        if (! empty($filters['price_range'])) {
            $query->whereHas('rooms', function ($roomQuery) use ($filters) {
                switch ($filters['price_range']) {
                    case 'under_1m':
                        $roomQuery->where('price', '<', 1000000);
                        break;
                    case '1m_3m':
                        $roomQuery->whereBetween('price', [1000000, 3000000]);
                        break;
                    case 'over_3m':
                        $roomQuery->where('price', '>', 3000000);
                        break;
                }
            });
        }

        if (! empty($filters['sort'])) {
            $query->leftJoin('rooms', 'hotels.id', '=', 'rooms.hotel_id')
                ->select('hotels.*')
                ->groupBy('hotels.id');

            if ($filters['sort'] === 'price_asc') {
                $query->orderByRaw('MIN(rooms.price) ASC');
            }

            if ($filters['sort'] === 'price_desc') {
                $query->orderByRaw('MIN(rooms.price) DESC');
            }
        } else {
            $query->latest();
        }

        $hotels = $query->paginate(9)->appends($request->query());

        return view('clients.hotels.index', compact('hotels'));
    }

    public function show(HotelAvailabilityFilterRequest $request, $id)
    {
        $hotel = Hotel::with(['rooms' => function ($query) {
            $query->orderBy('price');
        }])->findOrFail($id);

        $filters = $request->validated();
        $checkIn = $filters['check_in'] ?? null;
        $checkOut = $filters['check_out'] ?? null;
        $availableRoomIds = [];

        if ($checkIn && $checkOut) {
            $start = Carbon::parse($checkIn)->startOfDay();
            $end = Carbon::parse($checkOut)->startOfDay();

            $bookedRoomIds = Booking::active()
                ->whereIn('room_id', $hotel->rooms->pluck('id'))
                ->where('check_in', '<', $end->toDateString())
                ->where('check_out', '>', $start->toDateString())
                ->pluck('room_id');

            $availableRoomIds = $hotel->rooms
                ->where('status', 'available')
                ->whereNotIn('id', $bookedRoomIds)
                ->pluck('id')
                ->all();
        }

        $hotels = Hotel::orderBy('created_at', 'desc')->take(12)->get();

        return view('clients.hotels.show', compact('hotel', 'hotels', 'checkIn', 'checkOut', 'availableRoomIds'));
    }
}
