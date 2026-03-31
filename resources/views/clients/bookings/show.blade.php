@extends('layouts.client')

@section('title', 'Chi tiết đơn đặt phòng')

@section('content')
@php
    $room = $booking->room;
    $hotel = $room?->hotel;
    $image = $room?->image;
    $imageUrl = $image
        ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset('storage/' . $image))
        : 'https://placehold.co/900x560?text=CMC+Travel';
@endphp

<div class="container py-5" style="margin-top: 90px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Chi tiết đơn đặt phòng</h2>
            <p class="text-muted mb-0">Khách hàng chỉ được xem đơn đặt phòng của chính mình.</p>
        </div>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary rounded-pill px-4">Quay lại đơn của tôi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4 border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{ $imageUrl }}" alt="{{ $room?->name }}" class="w-100 object-fit-cover" style="max-height: 360px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
                        <div>
                            <div class="text-muted small mb-1">Mã đơn #{{ $booking->id }}</div>
                            <h3 class="fw-bold mb-2">{{ $room?->name ?? 'Phòng đang cập nhật' }}</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-hotel me-2 text-primary"></i>{{ $hotel?->name ?? 'Khách sạn đang cập nhật' }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $hotel?->address ?? 'Địa chỉ đang cập nhật' }}
                            </p>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 {{
                            $booking->status === 'confirmed' ? 'bg-success' :
                            ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark')
                        }}">
                            {{ match($booking->status) {
                                'confirmed' => 'Đã xác nhận',
                                'cancelled' => 'Đã hủy',
                                default => 'Chờ xác nhận',
                            } }}
                        </span>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3">
                                <div class="small text-muted mb-1">Nhận phòng</div>
                                <div class="fw-semibold">{{ $booking->check_in->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3">
                                <div class="small text-muted mb-1">Trả phòng</div>
                                <div class="fw-semibold">{{ $booking->check_out->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3">
                                <div class="small text-muted mb-1">Số đêm</div>
                                <div class="fw-semibold">{{ $booking->check_in->diffInDays($booking->check_out) }} đêm</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Thông tin đơn đặt phòng</h4>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted">Tổng tiền</span>
                        <span class="fw-bold text-primary">{{ number_format($booking->total_price) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted">Trạng thái hiện tại</span>
                        <span class="fw-semibold">
                            {{ match($booking->status) {
                                'confirmed' => 'Đã xác nhận',
                                'cancelled' => 'Đã hủy',
                                default => 'Chờ xác nhận',
                            } }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Ngày tạo đơn</span>
                        <span class="fw-semibold">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    @if($booking->status !== 'cancelled' && $booking->check_in->isFuture())
                        <div class="mt-4">
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill" onclick="return confirm('Bạn chắc chắn muốn hủy đơn đặt phòng này?')">
                                    Hủy đơn đặt phòng
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
