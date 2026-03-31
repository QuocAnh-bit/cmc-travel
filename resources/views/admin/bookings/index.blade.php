@extends('layouts.admin')

@section('title', 'Quan ly don dat phong')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-receipt me-2 text-primary"></i>Quan ly don dat phong</h2>
            <p class="text-muted small mb-0">Theo doi booking tu client, loc nhanh theo trang thai va xu ly xac nhan hoac huy don.</p>
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
                    <div class="text-muted small">Tong so booking</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($summary['total']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Cho xac nhan</div>
                    <div class="fs-3 fw-bold text-warning">{{ number_format($summary['pending']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Da xac nhan</div>
                    <div class="fs-3 fw-bold text-success">{{ number_format($summary['confirmed']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small">Da huy</div>
                    <div class="fs-3 fw-bold text-danger">{{ number_format($summary['cancelled']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-3">
                <div class="col-lg-4">
                    <label class="form-label fw-semibold">Tim theo khach hang, phong, khach san</label>
                    <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="Vi du: test@example.com, Deluxe, CMC">
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Trang thai</label>
                    <select name="status" class="form-select">
                        <option value="">Tat ca</option>
                        <option value="pending" @selected(request('status') === 'pending')>Cho xac nhan</option>
                        <option value="confirmed" @selected(request('status') === 'confirmed')>Da xac nhan</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Da huy</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Check-in tu ngay</label>
                    <input type="date" name="check_in_from" class="form-control" value="{{ request('check_in_from') }}">
                </div>
                <div class="col-lg-2">
                    <label class="form-label fw-semibold">Check-in den ngay</label>
                    <input type="date" name="check_in_to" class="form-control" value="{{ request('check_in_to') }}">
                </div>
                <div class="col-lg-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">Loc</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-light border w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Ma</th>
                        <th>Khach hang</th>
                        <th>Phong / Khach san</th>
                        <th>Lich o</th>
                        <th>Thanh tien</th>
                        <th>Trang thai</th>
                        <th class="text-end pe-4">Thao tac</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $booking->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $booking->user?->name ?? 'Khach da xoa' }}</div>
                                <div class="small text-muted">{{ $booking->user?->email ?? 'Khong co email' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $booking->room?->name ?? 'Phong da xoa' }}</div>
                                <div class="small text-muted">{{ $booking->room?->hotel?->name ?? 'Khach san dang cap nhat' }}</div>
                            </td>
                            <td>
                                <div>{{ $booking->check_in->format('d/m/Y') }} - {{ $booking->check_out->format('d/m/Y') }}</div>
                                <div class="small text-muted">{{ $booking->check_in->diffInDays($booking->check_out) }} dem</div>
                            </td>
                            <td class="fw-bold text-primary">{{ number_format($booking->total_price) }}d</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 {{
                                    $booking->status === 'confirmed' ? 'bg-success' :
                                    ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark')
                                }}">
                                    {{ match($booking->status) {
                                        'confirmed' => 'Da xac nhan',
                                        'cancelled' => 'Da huy',
                                        default => 'Cho xac nhan',
                                    } }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2 flex-wrap justify-content-end">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">Xem</a>

                                    @if($booking->status !== 'confirmed')
                                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Xac nhan</button>
                                        </form>
                                    @endif

                                    @if($booking->status !== 'cancelled')
                                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-dark" onclick="return confirm('Ban chac chan muon huy don nay?')">Huy</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xoa vinh vien don dat phong nay?')">Xoa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Chua co booking nao phu hop bo loc hien tai.</td>
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
