@extends('layouts.admin')

@section('title', 'Báo cáo doanh thu')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-sack-dollar me-2 text-success"></i>Báo cáo doanh thu</h2>
            <p class="text-muted mb-0">Theo dõi doanh thu từ các đơn đặt phòng đã xác nhận theo khoảng thời gian bạn chọn.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light border">Quay lại dashboard</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.revenue') }}" method="GET" class="row g-3">
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $filters['start_date'] }}">
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $filters['end_date'] }}">
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">Từ khóa khách sạn</label>
                    <input type="text" name="hotel_keyword" class="form-control" value="{{ $filters['hotel_keyword'] }}" placeholder="Ví dụ: Đà Nẵng, Riverside, Ocean...">
                </div>
                <div class="col-lg-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-success px-4 text-nowrap flex-shrink-0">Xem</button>
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-light border text-nowrap w-100">Đặt lại</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Tổng doanh thu</div>
                    <div class="fs-3 fw-bold text-success">{{ number_format($summary['revenue']) }}đ</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Số đơn xác nhận</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($summary['bookings']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Giá trị trung bình / đơn</div>
                    <div class="fs-3 fw-bold text-primary">{{ number_format($summary['averageBookingValue']) }}đ</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Ngày doanh thu cao nhất</div>
                    <div class="fs-3 fw-bold text-warning">{{ number_format($summary['bestDayRevenue']) }}đ</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">Biểu đồ doanh thu theo ngày</h5>
                    <p class="text-muted small mb-0">Dữ liệu chỉ lấy các booking đã xác nhận trong khoảng lọc hiện tại.</p>
                </div>
                <div class="card-body px-4 pb-4">
                    @if(count($dailyRevenueData) > 0)
                        <canvas id="dailyRevenueChart" style="min-height: 340px;"></canvas>
                    @else
                        <div class="rounded-4 border bg-light text-center py-5 text-muted">
                            Chưa có dữ liệu doanh thu trong khoảng thời gian này.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">Top khách sạn doanh thu cao</h5>
                    <p class="text-muted small mb-0">Top 5 khách sạn theo tổng doanh thu đã xác nhận.</p>
                </div>
                <div class="card-body px-4 pb-4">
                    @forelse($hotelRevenue as $item)
                        <div class="d-flex justify-content-between align-items-start py-3 border-bottom">
                            <div class="me-3">
                                <div class="fw-semibold">{{ $item['hotel'] }}</div>
                                <div class="small text-muted">{{ number_format($item['bookings']) }} đơn xác nhận</div>
                            </div>
                            <div class="fw-bold text-success text-nowrap">{{ number_format($item['total']) }}đ</div>
                        </div>
                    @empty
                        <div class="rounded-4 border bg-light text-center py-5 text-muted">
                            Chưa có khách sạn nào phát sinh doanh thu.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-1">Danh sách booking tạo doanh thu</h5>
            <p class="text-muted small mb-0">Dùng bảng này để đối chiếu từng đơn đã được ghi nhận vào doanh thu.</p>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Khách sạn / Phòng</th>
                        <th>Ngày tạo đơn</th>
                        <th>Lịch ở</th>
                        <th class="text-end pe-4">Doanh thu</th>
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
                                <div class="fw-semibold">{{ $booking->room?->hotel?->name ?? 'Khách sạn không xác định' }}</div>
                                <div class="small text-muted">{{ $booking->room?->name ?? 'Phòng không xác định' }}</div>
                            </td>
                            <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div>{{ $booking->check_in->format('d/m/Y') }} - {{ $booking->check_out->format('d/m/Y') }}</div>
                                <div class="small text-muted">{{ $booking->check_in->diffInDays($booking->check_out) }} đêm</div>
                            </td>
                            <td class="text-end pe-4 fw-bold text-success">{{ number_format($booking->total_price) }}đ</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Không có booking xác nhận nào phù hợp với bộ lọc hiện tại.</td>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dailyRevenueData = {!! json_encode($dailyRevenueData) !!};

    if (dailyRevenueData.length > 0) {
        const dailyRevenueCtx = document.getElementById('dailyRevenueChart').getContext('2d');
        new Chart(dailyRevenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyRevenueLabels) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: dailyRevenueData,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.12)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#198754'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection