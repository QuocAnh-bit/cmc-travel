<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use Carbon\Carbon;
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
            $query->whereHas('rooms', function ($q) use ($request) {
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
        $hotel = Hotel::with(['rooms' => function ($query) {
            $query->orderBy('price');
        }])->findOrFail($id);

        $checkIn = request('check_in');
        $checkOut = request('check_out');
        $availableRoomIds = [];

        if ($checkIn && $checkOut) {


            $start = Carbon::parse($checkIn);
            $end = Carbon::parse($checkOut);

            // 1. check logic ngày
            if ($start->gte($end)) {
                return redirect()->back()->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc');
            }

            // 2. không cho đặt quá khứ
            if ($start->lt(now()->startOfDay())) {
                return redirect()->back()->with('error', 'Không thể đặt ngày trong quá khứ vui lòng thử lại');
            }

            $bookedRoomIds = Booking::active()
                ->whereIn('room_id', $hotel->rooms->pluck('id'))
                ->where('check_in', '<', $end->toDateString())
                ->where('check_out', '>', $start->toDateString())
                ->pluck('room_id');

            $availableRoomIds = $hotel->rooms
                ->whereNotIn('id', $bookedRoomIds)
                ->pluck('id')
                ->all();
        }

        $hotels = Hotel::orderBy('created_at', 'desc')->take(12)->get();

        return view('clients.hotels.show', compact('hotel', 'hotels', 'checkIn', 'checkOut', 'availableRoomIds'));
    }
}
