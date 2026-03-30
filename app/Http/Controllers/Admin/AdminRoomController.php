<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function index()
    {
        // Sử dụng with('hotel') để tối ưu query (Eager Loading)
        $rooms = Room::with('hotel')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        // 2. Lấy danh sách khách sạn để truyền vào Select Box
        $hotels = Hotel::all();
        return view('admin.rooms.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'hotel_id' => 'required|exists:hotels,id', // 3. Validate id khách sạn phải tồn tại
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['amenities'] = $request->amenities ?? [];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Thêm phòng thành công');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        // 4. Lấy danh sách khách sạn để sửa
        $hotels = Hotel::all();
        return view('admin.rooms.edit', compact('room', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'hotel_id' => 'required|exists:hotels,id', // Thay đổi ở đây
            'price' => 'required|numeric',
        ]);

        $room = Room::findOrFail($id);
        $data = $request->all();
        $data['amenities'] = $request->amenities ?? [];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.show', compact('room'));
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return back()->with('success', 'Đã xóa (soft delete)');
    }
}