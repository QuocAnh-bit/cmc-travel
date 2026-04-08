<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\SearchHotelRequest;
use App\Models\Hotel;

class SearchController extends Controller
{
    public function index(SearchHotelRequest $request)
    {
        $filters = $request->validated();
        $keyword = $filters['search'] ?? null;
        $nameFilter = $filters['name'] ?? null;
        $priceRange = $filters['price_range'] ?? null;
        $sort = $filters['sort'] ?? null;

        $query = Hotel::with(['rooms' => function ($roomQuery) {
            $roomQuery->orderBy('price', 'asc');
        }]);

        if (! empty($keyword)) {
            $query->where(function ($hotelQuery) use ($keyword) {
                $hotelQuery->where('name', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        if (! empty($nameFilter)) {
            $query->where('name', 'like', "%{$nameFilter}%");
        }

        if (! empty($priceRange)) {
            $query->whereHas('rooms', function ($roomQuery) use ($priceRange) {
                if ($priceRange === 'under_1m') {
                    $roomQuery->where('price', '<', 1000000);
                } elseif ($priceRange === '1m_3m') {
                    $roomQuery->whereBetween('price', [1000000, 3000000]);
                } elseif ($priceRange === 'over_3m') {
                    $roomQuery->where('price', '>', 3000000);
                }
            });
        }

        if ($sort === 'price_asc' || $sort === 'price_desc') {
            $direction = $sort === 'price_asc' ? 'asc' : 'desc';

            $query->leftJoin('rooms', 'hotels.id', '=', 'rooms.hotel_id')
                ->select('hotels.*')
                ->groupBy('hotels.id')
                ->orderByRaw("MIN(rooms.price) {$direction}");
        } else {
            $query->latest();
        }

        $hotels = $query->paginate(12)->withQueryString();

        return view('clients.hotels.search', compact('hotels'));
    }
}
