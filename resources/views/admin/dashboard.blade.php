@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Tổng quan hệ thống</h3>
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
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #1cc88a !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.8rem;">Tổng số phòng</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($totalRooms) }}</div>
                        </div>
                        <div class="bg-success-subtle p-3 rounded-circle">
                            <i class="fas fa-door-open text-success fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 5px solid #36b9cc !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.8rem;">Đơn đặt phòng</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($totalBookings) }}</div>
                        </div>
                        <div class="bg-info-subtle p-3 rounded-circle">
                            <i class="fas fa-calendar-alt text-info fa-lg"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.8rem;">Đã xác nhận</div>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ number_format($confirmedBookings) }}</div>
                        </div>
                        <div class="bg-warning-subtle p-3 rounded-circle">
                            <i class="fas fa-check-circle text-warning fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mt-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-dark">Thống kê đơn đặt phòng (7 ngày qua)</h5>
            </div>
            <div class="card-body">
                <canvas id="bookingsChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 15px; height: 100%;">
            <h5 class="fw-bold mb-3">Thao tác nhanh</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary text-start"><i class="fas fa-users me-2"></i>Quản lý User</a>
                <a href="#" class="btn btn-outline-success text-start"><i class="fas fa-plus me-2"></i>Thêm phòng mới</a>
                <a href="#" class="btn btn-outline-info text-start"><i class="fas fa-list me-2"></i>Xem đơn đặt</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(ctx, {
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
</div>
@endsection