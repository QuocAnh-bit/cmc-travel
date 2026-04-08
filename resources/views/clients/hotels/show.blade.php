@extends('layouts.client')

@section('title', $hotel->name)

@section('content')
<div class="container py-5" style="margin-top: 90px;">
    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
                    <div>
                        <div class="text-muted small mb-2">Chi ti?t khách s?n</div>
                        <h1 class="fw-bold mb-2">{{ $hotel->name }}</h1>
                        <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $hotel->address }}</p>
                    </div>
                    <div class="text-end">
                        <div class="small text-muted">Liên h?</div>
                        <div class="fw-semibold">{{ $hotel->phone ?: 'Ðang c?p nh?t' }}</div>
                    </div>
                </div>

                <form action="{{ route('hotels.show', $hotel->id) }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Ngày nh?n phòng</label>
                        <input type="date" name="check_in" class="form-control @error('check_in') is-invalid @enderror" min="{{ now()->toDateString() }}" value="{{ old('check_in', $checkIn) }}">
                        @error('check_in') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Ngày tr? phòng</label>
                        <input type="date" name="check_out" class="form-control @error('check_out') is-invalid @enderror" min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out', $checkOut) }}">
                        @error('check_out') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Ki?m tra</button>
                    </div>
                </form>

                @if($checkIn && $checkOut && !$errors->has('check_in') && !$errors->has('check_out'))
                    <div class="alert alert-info border-0 rounded-4 mt-4 mb-0">
                        K?t qu? ki?m tra t? <strong>{{ \Carbon\Carbon::parse($checkIn)->format('d/m/Y') }}</strong>
                        d?n <strong>{{ \Carbon\Carbon::parse($checkOut)->format('d/m/Y') }}</strong>:
                        còn <strong>{{ count($availableRoomIds) }}</strong> phòng phù h?p.
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
                <span class="text-muted">{{ $hotel->rooms->count() }} lo?i phòng</span>
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
                                            <p class="text-muted mb-3">{{ $room->description ?: 'Phòng dang du?c c?p nh?t mô t? chi ti?t.' }}</p>
                                        </div>
                                        @if($available !== null)
                                            <span class="badge rounded-pill px-3 py-2 {{ $available ? 'bg-success' : 'bg-danger' }}">{{ $available ? 'Còn phòng' : 'H?t phòng' }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        @forelse($room->amenities ?? [] as $amenity)
                                            <span class="badge text-bg-light border me-2 mb-2 px-3 py-2">{{ $amenity }}</span>
                                        @empty
                                            <span class="text-muted small">Ti?n nghi dang c?p nh?t</span>
                                        @endforelse
                                    </div>

                                    <div class="d-flex justify-content-between align-items-end gap-3 flex-wrap">
                                        <div>
                                            @if(($room->discount ?? 0) > 0)
                                                <div class="small text-muted text-decoration-line-through">{{ number_format($room->price) }}d / dêm</div>
                                            @endif
                                            <div class="fs-4 fw-bold text-primary">{{ number_format($finalPrice) }}d <span class="fs-6 text-muted fw-normal">/ dêm</span></div>
                                        </div>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <form action="{{ route('rooms.availability', $room) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="check_in" value="{{ old('check_in', $checkIn) }}">
                                                <input type="hidden" name="check_out" value="{{ old('check_out', $checkOut) }}">
                                                <button type="submit" class="btn btn-outline-primary rounded-pill px-4" @disabled(! $checkIn || ! $checkOut)>Ki?m tra phòng tr?ng</button>
                                            </form>

                                            @auth
                                                <form action="{{ route('bookings.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                                    <input type="hidden" name="check_in" value="{{ old('check_in', $checkIn) }}">
                                                    <input type="hidden" name="check_out" value="{{ old('check_out', $checkOut) }}">
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4" @disabled(! $checkIn || ! $checkOut || $available === false)>Ð?t phòng</button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">Ðang nh?p d? d?t</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-secondary rounded-4 border-0 shadow-sm">Khách s?n này hi?n chua có phòng d? d?t.</div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Quy trình d?t phòng</h4>
                <div class="d-grid gap-3">
                    <div class="bg-light rounded-4 p-3"><div class="fw-semibold mb-1">1. Ki?m tra phòng tr?ng</div><div class="small text-muted">Ch?n ngày nh?n và tr? phòng d? l?c ngay các phòng còn tr?ng.</div></div>
                    <div class="bg-light rounded-4 p-3"><div class="fw-semibold mb-1">2. Ð?t phòng</div><div class="small text-muted">Ðang nh?p, ch?n phòng phù h?p và g?i don d?t phòng.</div></div>
                    <div class="bg-light rounded-4 p-3"><div class="fw-semibold mb-1">3. Theo dõi và h?y don</div><div class="small text-muted">Vào m?c Ðon c?a tôi d? xem l?ch s? d?t phòng và h?y don tru?c ngày check-in.</div></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
