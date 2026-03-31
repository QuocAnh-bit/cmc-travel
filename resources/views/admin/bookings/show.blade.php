@extends('layouts.admin')

@section('title', 'Chi tiet booking')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-file-invoice me-2 text-primary"></i>Chi tiet don dat phong</h2>
            <p class="text-muted small mb-0">Kiem tra thong tin khach hang, phong, lich o va xu ly trang thai booking.</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-light border">Quay lai danh sach</a>
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
                            <div class="text-muted small">Ma booking</div>
                            <div class="fs-4 fw-bold">#{{ $booking->id }}</div>
                        </div>
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
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Khach hang</div>
                                <div class="fw-semibold">{{ $booking->user?->name ?? 'Khach da xoa' }}</div>
                                <div class="small text-muted">{{ $booking->user?->email ?? 'Khong co email' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Phong</div>
                                <div class="fw-semibold">{{ $booking->room?->name ?? 'Phong da xoa' }}</div>
                                <div class="small text-muted">{{ $booking->room?->hotel?->name ?? 'Khach san dang cap nhat' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Nhan phong</div>
                                <div class="fw-semibold">{{ $booking->check_in->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Tra phong</div>
                                <div class="fw-semibold">{{ $booking->check_out->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="small text-muted mb-1">Tong tien</div>
                                <div class="fw-semibold text-primary">{{ number_format($booking->total_price) }}d</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="small text-muted mb-2">Ghi chu xu ly</div>
                        <div class="text-muted">
                            Admin co the xac nhan booking neu phong van con trong trong khoang thoi gian da chon. Khi huy booking, client se thay ngay trang thai moi trong lich su dat phong.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Thao tac nhanh</h5>

                    <div class="d-grid gap-2">
                        @if($booking->status !== 'confirmed')
                            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">Xac nhan booking</button>
                            </form>
                        @endif

                        @if($booking->status !== 'cancelled')
                            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning text-dark w-100" onclick="return confirm('Ban chac chan muon huy don nay?')">Huy booking</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Xoa vinh vien don dat phong nay?')">Xoa vinh vien</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
