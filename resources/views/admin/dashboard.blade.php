@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Tổng quan hệ thống</h3>
            <p class="text-muted mb-0">Theo dõi nhanh doanh thu và các chỉ số vận hành quan trọng.</p>
        </div>
        <span class="text-muted">{{ date('d/m/Y') }}</span>
    </div>

    <div class="row g-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #4e73df !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 0.8rem;">Người dùng</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($totalUsers) }}</div>
                        </div>
                        <div class="bg-primary-subtle p-3 rounded-circle">
                            <i class="fas fa-users text-primary fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #198754 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.8rem;">Doanh thu hôm nay</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($revenueToday) }}đ</div>
                        </div>
                        <div class="bg-success-subtle p-3 rounded-circle">
                            <i class="fas fa-coins text-success fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #0dcaf0 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.8rem;">Doanh thu tháng này</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($revenueThisMonth) }}đ</div>
                        </div>
                        <div class="bg-info-subtle p-3 rounded-circle">
                            <i class="fas fa-chart-column text-info fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #f6c23e !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.8rem;">Tổng doanh thu confirmed</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($confirmedRevenue) }}đ</div>
                        </div>
                        <div class="bg-warning-subtle p-3 rounded-circle">
                            <i class="fas fa-wallet text-warning fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #6f42c1 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 0.8rem; color: #6f42c1;">Tổng số phòng</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($totalRooms) }}</div>
                        </div>
                        <div class="p-3 rounded-circle" style="background-color: rgba(111, 66, 193, 0.12);">
                            <i class="fas fa-door-open fa-lg" style="color: #6f42c1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #fd7e14 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 0.8rem; color: #fd7e14;">Doanh thu chờ xác nhận</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($pendingRevenue) }}đ</div>
                        </div>
                        <div class="p-3 rounded-circle" style="background-color: rgba(253, 126, 20, 0.12);">
                            <i class="fas fa-hourglass-half fa-lg" style="color: #fd7e14;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #20c997 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 0.8rem; color: #20c997;">Đơn đặt phòng</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($totalBookings) }}</div>
                        </div>
                        <div class="p-3 rounded-circle" style="background-color: rgba(32, 201, 151, 0.12);">
                            <i class="fas fa-calendar-check fa-lg" style="color: #20c997;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 0.8rem; color: #b58105;">Đơn đã xác nhận</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($confirmedBookings) }}</div>
                        </div>
                        <div class="p-3 rounded-circle" style="background-color: rgba(255, 193, 7, 0.14);">
                            <i class="fas fa-check-circle fa-lg" style="color: #b58105;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">Biểu đồ doanh thu 7 ngày gần nhất</h5>
                        <p class="text-muted small mb-0">Chỉ tính các đơn đặt phòng đã xác nhận.</p>
                    </div>
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-sm btn-outline-success">Xem báo cáo chi tiết</a>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="min-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 15px;">
                <h5 class="fw-bold mb-3">Thao tác nhanh</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-success text-start"><i class="fas fa-sack-dollar me-2"></i>Báo cáo doanh thu</a>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-info text-start"><i class="fas fa-list me-2"></i>Xem đơn đặt</a>
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-primary text-start"><i class="fas fa-door-open me-2"></i>Quản lý phòng</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary text-start"><i class="fas fa-users me-2"></i>Quản lý người dùng</a>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">Xu hướng đơn đặt phòng</h5>
                </div>
                <div class="card-body">
                    <canvas id="bookingsChart" style="min-height: 220px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($revenueChartData) !!},
                borderRadius: 8,
                backgroundColor: 'rgba(25, 135, 84, 0.75)',
                hoverBackgroundColor: 'rgba(25, 135, 84, 0.9)'
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

    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Số đơn đặt phòng',
                data: {!! json_encode($chartData) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                fill: true,
                tension: 0.3,
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: '#4e73df'
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
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endsection
