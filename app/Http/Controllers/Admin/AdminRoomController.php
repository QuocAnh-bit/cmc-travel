<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'hotel_name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
        ]);

        $data = $request->all();

        // amenities (KHÔNG cần json_encode)
        $data['amenities'] = $request->amenities ?? [];

        // upload ảnh
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
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'hotel_name' => 'required',
            'location' => 'required',
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