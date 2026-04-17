@extends('layouts.client')

@section('title', $hotel->name)

@section('content')
<div class="container py-5" style="margin-top: 90px;">
    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
                    <div>
                        <div class="text-muted small mb-2">Chi tiết khách sạn</div>
                        <h1 class="fw-bold mb-2">{{ $hotel->name }}</h1>
                        <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $hotel->address }}</p>
                    </div>
                    <div class="text-end">
                        <div class="small text-muted">Liên hệ</div>
                        <div class="fw-semibold">{{ $hotel->phone ?: 'Đang cập nhật' }}</div>
                    </div>
                </div>

                <form action="{{ route('hotels.show', $hotel->id) }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Ngày nhận phòng</label>
                        <input type="date" name="check_in" class="form-control @error('check_in') is-invalid @enderror" min="{{ now()->toDateString() }}" value="{{ old('check_in', $checkIn) }}">
                        @error('check_in') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Ngày trả phòng</label>
                        <input type="date" name="check_out" class="form-control @error('check_out') is-invalid @enderror" min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out', $checkOut) }}">
                        @error('check_out') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Kiểm tra</button>
                    </div>
                </form>

                @if($checkIn && $checkOut && !$errors->has('check_in') && !$errors->has('check_out') && empty(session('error')))
                    <div class="alert alert-info border-0 rounded-4 mt-4 mb-0">
                        Kết quả kiểm tra từ <strong>{{ \Carbon\Carbon::parse($checkIn)->format('d/m/Y') }}</strong>
                        đến <strong>{{ \Carbon\Carbon::parse($checkOut)->format('d/m/Y') }}</strong>:
                        còn <strong>{{ count($availableRoomIds) }}</strong> phòng phù hợp.
                    </div>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success rounded-4 border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger rounded-4 border-0 shadow-sm">{{ session('error') }}</div>
            @endif

            @error('availability')
                <div class="alert alert-danger rounded-4 border-0 shadow-sm">{{ $message }}</div>
            @enderror

            @error('room_id')
                <div class="alert alert-danger rounded-4 border-0 shadow-sm">{{ $message }}</div>
            @enderror

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold mb-0">Danh sách phòng</h3>
                <span class="text-muted">{{ $hotel->rooms->count() }} loại phòng</span>
            </div>

            <div class="d-grid gap-4">
                @forelse($hotel->rooms as $room)
                    @php
                        $imageUrl = $room->image
                            ? (\Illuminate\Support\Str::startsWith($room->image, ['http://', 'https://']) ? $room->image : asset('storage/' . $room->image))
                            : 'https://placehold.co/800x520?text=CMC+Travel';
                        $available = $checkIn && $checkOut ? in_array($room->id, $availableRoomIds, true) : null;
                        $finalPrice = max(0, $room->price - (int) (($room->price * ($room->discount ?? 0)) / 100));
                    @endphp
                    <div id="room-{{ $room->id }}" class="card border-0 shadow-sm rounded-4 overflow-hidden {{ request('room') == $room->id ? 'border border-primary' : '' }}">
                        <div class="row g-0">
                            <div class="col-md-4"><img src="{{ $imageUrl }}" alt="{{ $room->name }}" class="w-100 h-100 object-fit-cover" style="min-height: 240px;"></div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                        <div>
                                            <h4 class="fw-bold mb-2">{{ $room->name }}</h4>
                                            <p class="text-muted mb-3">{{ $room->description ?: 'Phòng đang được cập nhật mô tả chi tiết.' }}</p>
                                        </div>
                                        @if($available !== null)
                                            <span class="badge rounded-pill px-3 py-2 {{ $available ? 'bg-success' : 'bg-danger' }}">{{ $available ? 'Còn phòng' : 'Hết phòng' }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        @forelse($room->amenities ?? [] as $amenity)
                                            <span class="badge text-bg-light border me-2 mb-2 px-3 py-2">{{ $amenity }}</span>
                                        @empty
                                            <span class="text-muted small">Tiện nghi đang cập nhật</span>
                                        @endforelse
                                    </div>

                                    <div class="d-flex justify-content-between align-items-end gap-3 flex-wrap">
                                        <div>
                                            @if(($room->discount ?? 0) > 0)
                                                <div class="small text-muted text-decoration-line-through">{{ number_format($room->price) }}đ / đêm</div>
                                            @endif
                                            <div class="fs-4 fw-bold text-primary">{{ number_format($finalPrice) }}đ <span class="fs-6 text-muted fw-normal">/ đêm</span></div>
                                        </div>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <form action="{{ route('rooms.availability', $room) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="check_in" value="{{ old('check_in', $checkIn) }}">
                                                <input type="hidden" name="check_out" value="{{ old('check_out', $checkOut) }}">
                                                <button type="submit" class="btn btn-outline-primary rounded-pill px-4" @disabled(! $checkIn || ! $checkOut)>Kiểm tra phòng trống</button>
                                            </form>

                                            @auth
                                                <form action="{{ route('bookings.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                    <input type="hidden" name="check_in" value="{{ old('check_in', $checkIn) }}">
                                                    <input type="hidden" name="check_out" value="{{ old('check_out', $checkOut) }}">
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4" @disabled(! $checkIn || ! $checkOut || $available === false)>Đặt phòng</button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">Đăng nhập để đặt</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-secondary rounded-4 border-0 shadow-sm">Khách sạn này hiện chưa có phòng để đặt.</div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Quy trình đặt phòng</h4>
                <div class="d-grid gap-3">
                    <div class="bg-light rounded-4 p-3"><div class="fw-semibold mb-1">1. Kiểm tra phòng trống</div><div class="small text-muted">Chọn ngày nhận và trả phòng để lọc các phòng còn trống.</div></div>
                    <div class="bg-light rounded-4 p-3"><div class="fw-semibold mb-1">2. Đặt phòng</div><div class="small text-muted">Đăng nhập, chọn phòng phù hợp và gửi đơn đặt phòng.</div></div>
                    <div class="bg-light rounded-4 p-3"><div class="fw-semibold mb-1">3. Theo dõi và hủy đơn</div><div class="small text-muted">Vào mục Đơn của tôi để xem lịch sử và hủy trước ngày check-in.</div></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection