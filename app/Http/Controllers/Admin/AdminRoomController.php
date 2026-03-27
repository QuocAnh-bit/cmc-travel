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
            'price' => 'required|numeric',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Thêm phòng thành công');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        Room::destroy($id);
        return back()->with('success', 'Xóa thành công');
    }
}