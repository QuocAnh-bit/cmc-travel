<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CheckRoomAvailabilityRequest;
use App\Http\Requests\Client\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['room.hotel'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $hotels = Hotel::orderBy('created_at', 'desc')->take(12)->get();
        $summary = [
            'total' => Booking::where('user_id', Auth::id())->count(),
            'pending' => Booking::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'confirmed' => Booking::where('user_id', Auth::id())->where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('user_id', Auth::id())->where('status', 'cancelled')->count(),
        ];

        return view('clients.bookings.index', compact('bookings', 'hotels', 'summary'));
    }

    public function create()
    {
        return redirect()->route('hotels.index');
    }

    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        $room = Room::with('hotel')->findOrFail($validated['room_id']);
        $checkIn = Carbon::parse($validated['check_in'])->startOfDay();
        $checkOut = Carbon::parse($validated['check_out'])->startOfDay();



        if ($room->status !== 'available') {
            return back()
                ->withInput()
                ->withErrors(['room_id' => 'Phòng này hiện không ở trạng thái sẵn sàng để đặt.']);
        }

        if (! $room->isAvailableFor($checkIn->toDateString(), $checkOut->toDateString())) {
            return back()
                ->withInput()
                ->withErrors(['availability' => 'Phòng này đã có lịch đặt trùng trong khoảng thời gian bạn chọn.']);
        }

        $nights = max(1, $checkIn->diffInDays($checkOut));
        $nightlyPrice = max(0, $room->price - (int) (($room->price * ($room->discount ?? 0)) / 100));


        // tạo boonking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'total_price' => $nightlyPrice * $nights,
            "expires_at" => now()->addMinute(5),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Đặt phòng thành công. Đơn của bạn đang chờ xác nhận.');
    }

    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);

        $booking->load(['room.hotel']);

        if ($booking->status === 'pending' && $booking->expires_at < now()) {
            $booking->update([
                'status' => 'expired'
            ]);
        }
        $hotels = Hotel::orderBy('created_at', 'desc')->take(12)->get();

        return view('clients.bookings.show', compact('booking', 'hotels'));
    }

    public function edit(Booking $booking)
    {
        abort(404);
    }

    public function update(Request $request, Booking $booking)
    {
        abort(404);
    }

    public function destroy(Booking $booking)
    {
        return $this->cancel($booking);
    }

    public function availability(CheckRoomAvailabilityRequest $request, Room $room)
    {
        $validated = $request->validated();

        if ($room->status !== 'available') {
            return back()->with('error', 'Phòng này hiện không ở trạng thái sẵn sàng để đặt.');
        }

        $isAvailable = $room->isAvailableFor($validated['check_in'], $validated['check_out']);

        return back()->with(
            $isAvailable ? 'success' : 'error',
            $isAvailable
                ? 'Phòng còn trống trong khoảng thời gian bạn chọn.'
                : 'Phòng đã kín lịch trong khoảng thời gian bạn chọn.'
        );
    }

    public function cancel(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Đơn đặt phòng này đã được hủy trước đó.');
        }

        if ($booking->check_in->isToday() || $booking->check_in->isPast()) {
            return back()->with('error', 'Không thể hủy đơn đã đến ngày nhận phòng hoặc đã quá hạn.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Hủy đặt phòng thành công.');
    }
}
