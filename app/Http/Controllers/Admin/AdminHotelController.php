<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHotelRequest;
use App\Models\Hotel;

class AdminHotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with(['rooms' => function ($query) {
            $query->orderBy('price', 'asc');
        }])
            ->withCount('rooms')
            ->latest()
            ->paginate(9);

        return view('admin.hotels.index', compact('hotels'));
    }

    public function store(StoreHotelRequest $request)
    {
        $data = $request->validated();
        $data['address'] = $data['address'] ?: null;
        $data['phone'] = $data['phone'] ?: null;

        Hotel::create($data);

        return redirect()->back()->with('success', 'Da them khach san moi thanh cong!');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->back()->with('success', 'Da xoa khach san va cac phong lien quan.');
    }
}
