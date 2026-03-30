<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Hiển thị danh sách khách sạn kèm bộ lọc
     */
    public function index(Request $request)
{
    // 1. Khởi tạo query lấy kèm rooms để tránh lỗi N+1 và lấy ảnh/giá
    $query = Hotel::with(['rooms']);

    // 2. Lọc theo tên khách sạn
    if ($request->filled('name')) {
    $query->where('hotels.name', 'like', '%' . $request->name . '%');
}

    // 3. Lọc theo khoảng giá (Lọc dựa trên phòng rẻ nhất của khách sạn)
    if ($request->filled('price_range')) {
        $query->whereHas('rooms', function($q) use ($request) {
            switch ($request->price_range) {
                case 'under_1m':
                    $q->where('price', '<', 1000000);
                    break;
                case '1m_3m':
                    $q->whereBetween('price', [1000000, 3000000]);
                    break;
                case 'over_3m':
                    $q->where('price', '>', 3000000);
                    break;
            }
        });
    }

    // 4. Sắp xếp (Cần join với bảng rooms để biết giá min từng hotel)
    if ($request->filled('sort')) {
        $query->leftJoin('rooms', 'hotels.id', '=', 'rooms.hotel_id')
              ->select('hotels.*')
              ->groupBy('hotels.id');
        
        if ($request->sort == 'price_asc') {
            $query->orderByRaw('MIN(rooms.price) ASC');
        } elseif ($request->sort == 'price_desc') {
            $query->orderByRaw('MIN(rooms.price) DESC');
        }
    } else {
        $query->latest();
    }

    $hotels = $query->paginate(9)->appends($request->query());

    return view('clients.hotels.index', compact('hotels'));
}

    /**
     * Chi tiết khách sạn
     */
    public function show($id)
    {
        $hotel = Hotel::with('hotels')->findOrFail($id);
        return view('clients.hotels.show', compact('hotel'));
    }
}