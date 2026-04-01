@extends('layouts.client')

@section('content')
<div class="container py-5" style="margin-top: 90px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Lịch sử đặt phòng</h2>
            <p class="text-muted mb-0">Theo dõi trạng thái đơn, thời gian lưu trú và thao tác hủy khi còn hiệu lực.</p>
        </div>
        <a href="{{ route('hotels.index') }}" class="btn btn-outline-primary rounded-pill px-4">Tiếp tục đặt phòng</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Tổng đơn của tôi</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($summary['total']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Chờ xác nhận</div>
                    <div class="fs-3 fw-bold text-warning">{{ number_format($summary['pending']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Đã xác nhận</div>
                    <div class="fs-3 fw-bold text-success">{{ number_format($summary['confirmed']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Đã hủy</div>
                    <div class="fs-3 fw-bold text-danger">{{ number_format($summary['cancelled']) }}</div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4 border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @forelse($bookings as $booking)
                @php
                    $room = $booking->room;
                    $hotel = $room?->hotel;
                    $image = $room?->image;
                    $imageUrl = $image
                        ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset('storage/' . $image))
                        : 'https://placehold.co/640x420?text=CMC+Travel';
                @endphp
                <div class="row g-0 border-bottom">
                    <div class="col-md-3">
                        <img src="{{ $imageUrl }}" alt="{{ $room?->name }}" class="w-100 h-100 object-fit-cover" style="min-height: 220px;">
                    </div>
                    <div class="col-md-9">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                <div>
                                    <div class="text-muted small mb-2">{{ $hotel?->name ?? 'Khách sạn đang cập nhật' }}</div>
                                    <h4 class="fw-bold mb-2">{{ $room?->name ?? 'Phòng không còn tồn tại' }}</h4>
                                    <p class="text-muted mb-3">
                                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $hotel?->address ?? 'Địa chỉ đang cập nhật' }}
                                    </p>
                                </div>
                                <div class="text-end">
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
                                    <div class="fs-5 fw-bold text-primary mt-3">{{ number_format($booking->total_price) }}đ</div>
                                </div>
                            </div>

                            <div class="row row-cols-1 row-cols-md-3 g-3 mt-1">
                                <div class="col">
                                    <div class="bg-light rounded-4 p-3">
                                        <div class="small text-muted mb-1">Nhận phòng</div>
                                        <div class="fw-semibold">{{ $booking->check_in->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="bg-light rounded-4 p-3">
                                        <div class="small text-muted mb-1">Trả phòng</div>
                                        <div class="fw-semibold">{{ $booking->check_out->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="bg-light rounded-4 p-3">
                                        <div class="small text-muted mb-1">Số đêm</div>
                                        <div class="fw-semibold">{{ $booking->check_in->diffInDays($booking->check_out) }} đêm</div>
                                    </div>
                                </div>
                            </div>

                            @if($booking->status !== 'cancelled' && $booking->check_in->isFuture())
                                <div class="mt-4 d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary rounded-pill px-4">
                                        Xem chi tiết
                                    </a>
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4" onclick="return confirm('Bạn chắc chắn muốn hủy đơn đặt phòng này?')">
                                            Hủy đặt phòng
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="mt-4 text-end">
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary rounded-pill px-4">
                                        Xem chi tiết
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-5 text-center">
                    <h5 class="fw-bold mb-2">Bạn chưa có đơn đặt phòng nào</h5>
                    <p class="text-muted mb-4">Bắt đầu bằng việc chọn khách sạn, kiểm tra phòng trống và tạo đơn đặt phòng đầu tiên.</p>
                    <a href="{{ route('hotels.index') }}" class="btn btn-primary rounded-pill px-4">Khám phá khách sạn</a>
                </div>
            @endforelse
        </div>
    </div>

    @if($bookings->hasPages())
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
