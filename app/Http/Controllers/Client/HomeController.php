<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
    // 1. Lấy các phòng "Nổi bật" (is_featured) để hiện ở Banner lớn
    $featuredRooms = Room::where('status', 'available')
                         ->where('is_featured', 1)
                         ->take(5)
                         ->get();
    $hotels = Hotel::orderBy('created_at', 'desc')->take(12)->get();
    // 2. Lấy danh sách phòng mới nhất hoặc theo địa điểm (Vũng Tàu)
    $allRooms = Room::where('status', 'available')
                    ->orderBy('created_at', 'desc')
                    ->take(8)
                    ->get();
    
    return view('clients.home', compact('featuredRooms', 'allRooms','hotels'));
}
}