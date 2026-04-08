<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Http\Requests\Admin\UpdateRoomRequest;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('hotel')->latest()->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $hotels = Hotel::all();

        return view('admin.rooms.create', compact('hotels'));
    }

    public function store(StoreRoomRequest $request)
    {
        $data = $request->validated();
        $data['amenities'] = $data['amenities'] ?? [];
        $data['status'] = $data['status'] ?? 'available';
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Them phong thanh cong');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $hotels = Hotel::all();

        return view('admin.rooms.edit', compact('room', 'hotels'));
    }

    public function update(UpdateRoomRequest $request, $id)
    {
        $room = Room::findOrFail($id);
        $data = $request->validated();
        $data['amenities'] = $data['amenities'] ?? [];
        $data['status'] = $data['status'] ?? 'available';
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);

        if ($request->hasFile('image')) {
            if ($room->image && ! str_starts_with($room->image, 'http')) {
                Storage::disk('public')->delete($room->image);
            }

            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Cap nhat thanh cong');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);

        return view('admin.rooms.show', compact('room'));
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        if ($room->image && ! str_starts_with($room->image, 'http')) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return back()->with('success', 'Da xoa phong thanh cong');
    }
}
