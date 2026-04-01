@extends('layouts.admin')

@section('title', 'Quản lý đơn đặt phòng')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-receipt me-2 text-primary"></i>Quản lý đơn đặt phòng</h2>
            <p class="text-muted small mb-0">Theo dõi đặt phòng từ khách hàng, lọc nhanh theo trạng thái và xử lý xác nhận hoặc hủy đơn.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Tổng số đơn đặt</div>
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
                    <div class="text-muted small">Đã hủy đơn</div>
                    <div class="fs-3 fw-bold text-danger">{{ number_format($summary['cancelled']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-3">
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">Tìm theo khách hàng, phòng, khách sạn</label>
                    <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="Ví dụ: email, tên phòng, tên khách sạn...">
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" @selected(request('status') === 'pending')>Chờ xác nhận</option>
                        <option value="confirmed" @selected(request('status') === 'confirmed')>Đã xác nhận</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Đã hủy</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Nhận phòng từ ngày</label>
                    <input type="date" name="check_in_from" class="form-control" value="{{ request('check_in_from') }}">
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Đến ngày</label>
                    <input type="date" name="check_in_to" class="form-control" value="{{ request('check_in_to') }}">
                </div>
                <div class="col-lg-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-light border w-100">Đặt lại</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Phòng / Khách sạn</th>
                        <th>Lịch ở</th>
                        <th>Thành tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $booking->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $booking->user?->name ?? 'Khách đã xóa' }}</div>
                                <div class="small text-muted">{{ $booking->user?->email ?? 'Không có email' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-truncate" style="max-width: 200px;">{{ $booking->room?->name ?? 'Phòng đã xóa' }}</div>
                                <div class="small text-muted">{{ $booking->room?->hotel?->name ?? 'Khách sạn đang cập nhật' }}</div>
                            </td>
                            <td>
                                <div>{{ $booking->check_in->format('d/m/Y') }} - {{ $booking->check_out->format('d/m/Y') }}</div>
                                <div class="small text-muted">{{ $booking->check_in->diffInDays($booking->check_out) }} đêm</div>
                            </td>
                            <td class="fw-bold text-primary">{{ number_format($booking->total_price) }}đ</td>
                            <td>
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
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary px-3">Xem chi tiết</a>

                                    @if($booking->status !== 'confirmed')
                                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Xác nhận</button>
                                        </form>
                                    @endif

                                    @if($booking->status !== 'cancelled')
                                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-dark" onclick="return confirm('Bạn chắc chắn muốn hủy đơn đặt phòng này?')">Hủy đơn</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cảnh báo: Hành động này sẽ xóa vĩnh viễn đơn đặt phòng khỏi hệ thống!')">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Không tìm thấy đơn đặt phòng nào phù hợp với bộ lọc hiện tại.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection