@extends('layouts.admin')

@section('title', 'Quản lý đơn đặt phòng')

@section('content')

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-receipt me-2 text-primary"></i>
                    Quản lý đơn đặt phòng
                </h2>
                <p class="text-muted small mb-0">
                    Theo dõi đặt phòng từ khách hàng, lọc nhanh theo trạng thái và xử lý xác nhận hoặc hủy đơn.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4">
                {{ session('error') }}
            </div>
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
                        <div class="text-muted small">Chờ thanh toán</div>
                        <div class="fs-3 fw-bold text-warning">{{ number_format($summary['pending']) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Đã thanh toán thành công</div>
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
                        <label class="form-label fw-semibold small">Tìm kiếm</label>
                        <input type="text" name="keyword" class="form-control @error('keyword') is-invalid @enderror"
                            value="{{ request('keyword') }}" placeholder="Khách hàng, phòng, khách sạn...">
                        @error('keyword')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label fw-semibold small">Trạng thái</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">Tất cả</option>
                            <option value="pending" @selected(request('status') === 'pending')>Chờ xác nhận</option>
                            <option value="confirmed" @selected(request('status') === 'confirmed')>Đã xác nhận</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>Đã hủy</option>
                        </select>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label fw-semibold small">Từ ngày</label>
                        <input type="date" name="check_in_from"
                            class="form-control @error('check_in_from') is-invalid @enderror"
                            value="{{ request('check_in_from') }}">
                        @error('check_in_from')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label fw-semibold small">Đến ngày</label>
                        <input type="date" name="check_in_to"
                            class="form-control @error('check_in_to') is-invalid @enderror"
                            value="{{ request('check_in_to') }}">
                        @error('check_in_to')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-dark w-100 rounded-3">Lọc</button>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-light border w-100 rounded-3">Đặt
                            lại</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
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
                                                <td class="ps-4 fw-bold text-muted">#{{ $booking->id }}</td>

                                                <td>
                                                    <div class="fw-bold text-dark">
                                                        {{ $booking->user?->name ?? 'Khách lẻ' }}
                                                    </div>
                                                    <div class="small text-muted">
                                                        {{ $booking->user?->email }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="fw-semibold text-truncate" style="max-width: 180px;">
                                                        {{ $booking->room?->name }}
                                                    </div>
                                                    <div class="small text-muted text-truncate" style="max-width: 180px;">
                                                        {{ $booking->room?->hotel?->name }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="small fw-bold">
                                                        {{ $booking->check_in->format('d/m/Y') }}
                                                    </div>
                                                    <div class="small text-muted">
                                                        {{ $booking->check_in->diffInDays($booking->check_out) }} đêm
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="price-tag text-primary">
                                                        {{ number_format($booking->total_price) }}đ
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="status-badge status-{{ $booking->status }}">
                                                        {{ match ($booking->status) {
                                'confirmed' => 'Đã thanh toán',
                                'cancelled' => 'Đã hủy',
                                'expired' => 'Hết hạn thanh toán',
                                default => 'Đang chờ thanh toán',
                            } }}
                                                    </span>
                                                </td>

                                                <td class="pe-4">
                                                    <div class="action-btn-group">
                                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn-lux btn-lux-view"
                                                            data-label="Chi tiết">
                                                            <i class="far fa-eye"></i>
                                                        </a>

                                                        @if($booking->status !== 'confirmed')
                                                            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn-lux btn-lux-confirm" data-label="Duyệt đơn">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if($booking->status !== 'cancelled')
                                                            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn-lux btn-lux-cancel" data-label="Hủy đơn"
                                                                    onclick="return confirm('Hủy đơn đặt phòng này?')">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Không tìm thấy đơn đặt phòng nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        :root {
            --success-soft: #ecfdf5;
            --success-bold: #10b981;
            --warning-soft: #fffbeb;
            --warning-bold: #f59e0b;
            --danger-soft: #fef2f2;
            --danger-bold: #ef4444;
        }

        .table thead th {
            background: #f8fafc !important;
            color: #64748b !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 16px 20px !important;
        }

        .table td {
            padding: 16px 20px !important;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
        }

        .status-pending {
            background: var(--warning-soft);
            color: var(--warning-bold);
        }

        .status-confirmed {
            background: var(--success-soft);
            color: var(--success-bold);
        }

        .status-cancelled {
            background: var(--danger-soft);
            color: var(--danger-bold);
        }

        .status-badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .action-btn-group {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-lux {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #f1f5f9;
            color: #64748b;
            border: none;
            transition: 0.3s;
            position: relative;
        }

        .btn-lux:hover {
            transform: translateY(-2px);
        }

        .btn-lux-view:hover {
            background: #eef2ff;
            color: #4f46e5;
        }

        .btn-lux-confirm:hover {
            background: #ecfdf5;
            color: #10b981;
        }

        .btn-lux-cancel:hover {
            background: #fef2f2;
            color: #ef4444;
        }

        .btn-lux::after {
            content: attr(data-label);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1e293b;
            color: #fff;
            padding: 4px 8px;
            font-size: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
            opacity: 0;
            transition: 0.2s;
        }

        .btn-lux:hover::after {
            opacity: 1;
        }

        .price-tag {
            font-weight: 800;
        }
    </style>

@endsection