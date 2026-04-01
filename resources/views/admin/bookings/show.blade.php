@extends('layouts.admin')

@section('title', 'Chi tiết đặt phòng')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-file-invoice me-2 text-primary"></i>Chi tiết đơn đặt phòng</h2>
            <p class="text-muted small mb-0">Kiểm tra thông tin khách hàng, phòng, lịch ở và xử lý trạng thái đơn hàng.</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-light border">Quay lại danh sách</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                        <div>
                            <div class="text-muted small">Mã đơn hàng</div>
                            <div class="fs-4 fw-bold">#{{ $booking->id }}</div>
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

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Khách hàng</div>
                                <div class="fw-semibold">{{ $booking->user?->name ?? 'Khách đã xóa' }}</div>
                                <div class="small text-muted">{{ $booking->user?->email ?? 'Không có email' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Thông tin phòng</div>
                                <div class="fw-semibold">{{ $booking->room?->name ?? 'Phòng đã xóa' }}</div>
                                <div class="small text-muted">{{ $booking->room?->hotel?->name ?? 'Khách sạn đang cập nhật' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Ngày nhận phòng</div>
                                <div class="fw-semibold">{{ $booking->check_in->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Ngày trả phòng</div>
                                <div class="fw-semibold">{{ $booking->check_out->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Tổng chi phí</div>
                                <div class="fw-semibold text-primary">{{ number_format($booking->total_price) }}đ</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="small text-muted mb-2">Ghi chú quản trị</div>
                        <div class="text-muted small">
                            Quản trị viên có thể xác nhận đơn đặt phòng nếu phòng vẫn còn trống trong khoảng thời gian khách đã chọn. Khi hủy đơn, hệ thống sẽ tự động cập nhật trạng thái mới và thông báo tới khách hàng trong mục lịch sử đặt phòng.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Thao tác nhanh</h5>

                    <div class="d-grid gap-2">
                        @if($booking->status !== 'confirmed')
                            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 py-2">Xác nhận đơn hàng</button>
                            </form>
                        @endif

                        @if($booking->status !== 'cancelled')
                            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning text-dark w-100 py-2" onclick="return confirm('Bạn chắc chắn muốn hủy đơn đặt phòng này?')">Hủy đơn hàng</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 py-2" onclick="return confirm('Cảnh báo: Hành động này sẽ xóa vĩnh viễn đơn đặt phòng khỏi hệ thống!')">Xóa vĩnh viễn</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection