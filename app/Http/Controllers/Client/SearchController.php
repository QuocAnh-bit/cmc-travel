<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Lấy từ khóa và các bộ lọc từ Request
        $keyword = $request->input('search');
        $nameFilter = $request->input('name');
        $priceRange = $request->input('price_range');
        $sort = $request->input('sort');

        // 2. Query khách sạn kèm theo danh sách phòng (đã sắp xếp giá tăng dần)
        $query = Hotel::with(['rooms' => function ($q) {
            $q->orderBy('price', 'asc');
        }]);

        // 3. Logic Tìm kiếm theo từ khóa (Tên hoặc Địa chỉ)
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        // 4. Logic Lọc thêm theo tên trong kết quả (Sidebar)
        if ($nameFilter) {
            $query->where('name', 'like', "%{$nameFilter}%");
        }

        // 5. Logic Lọc theo khoảng giá
        if ($priceRange) {
            $query->whereHas('rooms', function ($q) use ($priceRange) {
                if ($priceRange == 'under_1m') {
                    $q->where('price', '<', 1000000);
                } elseif ($priceRange == '1m_3m') {
                    $q->whereBetween('price', [1000000, 3000000]);
                } elseif ($priceRange == 'over_3m') {
                    $q->where('price', '>', 3000000);
                }
            });
        }

        // 6. Logic Sắp xếp (Yêu cầu Join với bảng rooms để sắp xếp theo giá khách sạn)
        if ($sort == 'price_asc' || $sort == 'price_desc') {
            $direction = ($sort == 'price_asc') ? 'asc' : 'desc';
            
            // Join tạm thời để lấy giá thấp nhất của mỗi khách sạn làm mốc sắp xếp
            $query->leftJoin('rooms', 'hotels.id', '=', 'rooms.hotel_id')
                ->select('hotels.*')
                ->groupBy('hotels.id')
                ->orderByRaw("MIN(rooms.price) $direction");
        } else {
            $query->latest();
        }

        // 7. Phân trang và giữ lại các tham số trên URL
        $hotels = $query->paginate(12)->withQueryString();

        return view('clients.hotels.search', compact('hotels'));
    }
}