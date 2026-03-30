<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class AdminHotelController extends Controller
{
    public function index()
{
    $hotels = Hotel::with(['rooms' => function($q) {
        $q->orderBy('price', 'asc'); // Lấy phòng rẻ nhất lên trước
    }])
    ->withCount('rooms')
    ->latest()
    ->paginate(9); // Phân trang 9 để khớp giao diện 3 cột

    return view('admin.hotels.index', compact('hotels'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:hotels,name|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Vui lòng nhập tên khách sạn.',
            'name.unique' => 'Tên khách sạn này đã tồn tại trong hệ thống.',
        ]);

        Hotel::create($data);

        return redirect()->back()->with('success', 'Đã thêm khách sạn mới thành công!');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->back()->with('success', 'Đã xóa khách sạn và các phòng liên quan.');
    }
}