@extends('layouts.client')

@section('title', 'CMC Travel - Hệ thống đặt phòng Resort hàng đầu')

@section('content')
<div class="hero-banner">
    <div class="container text-white">
        <h1 class="fw-bold display-5">Tìm phòng nghỉ dưỡng hoàn hảo</h1>
        <p class="lead">Hơn 500+ Resort và Khách sạn cao cấp đang chờ đón bạn</p>
    </div>
</div>

<div class="container search-container">
    <div class="search-box shadow-lg p-4 bg-white rounded-4 border-0">
        <form action="{{ route('rooms.index') }}" method="GET" class="row g-3">
            <div class="col-lg-5">
                <label class="form-label fw-bold small text-muted"><i class="fas fa-map-marker-alt me-1 text-primary"></i> Bạn muốn nghỉ dưỡng ở đâu?</label>
                <input type="text" name="location" class="form-control form-control-lg" placeholder="Nhập tên resort, thành phố...">
            </div>
            <div class="col-lg-4">
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-bold small text-muted"><i class="fas fa-calendar-alt me-1 text-primary"></i> Nhận phòng</label>
                        <input type="date" name="checkin" class="form-control form-control-lg">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold small text-muted"><i class="fas fa-calendar-check me-1 text-primary"></i> Trả phòng</label>
                        <input type="date" name="checkout" class="form-control form-control-lg">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 d-flex align-items-end">
                <button type="submit" class="btn btn-search-tour w-100 py-3 fs-5 shadow-sm">Tìm phòng nhanh</button>
            </div>
        </form>
    </div>
</div>

<div class="container mt-5 pt-4">
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0">Ưu đãi phòng tốt nhất hôm nay</h3>
            <a href="{{ route('rooms.index') }}" class="text-primary text-decoration-none fw-bold">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        @forelse($featuredRooms as $room)
        <div class="featured-card position-relative rounded-4 overflow-hidden shadow mb-4">
            <img src="{{ asset('storage/' . $room->image) }}" class="w-100 object-fit-cover" style="height: 380px;">
            <div class="overlay-content position-absolute bottom-0 start-0 w-100 p-4 text-white">
                <span class="badge bg-danger px-3 py-2 mb-2"><i class="fas fa-tag me-1"></i> Giảm giá {{ $room->discount }}%</span>
                <h2 class="fw-bold">{{ $room->name }}</h2>
                <div class="d-flex justify-content-between align-items-end">
                    <p class="mb-0 fs-5"><i class="fas fa-map-marker-alt me-1"></i> {{ $room->location }}</p>
                    <div class="text-end">
                        <p class="mb-0 text-white-50"><del>{{ number_format($room->price) }}đ</del></p>
                        <h3 class="text-warning fw-bold mb-0">
                            {{ number_format($room->price * (1 - $room->discount/100)) }}đ 
                            <small class="fs-6 fw-normal">/Đêm</small>
                        </h3>
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-warning fw-bold px-4 mt-2 rounded-pill">Chi tiết phòng</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <p class="text-center text-muted">Đang cập nhật các phòng ưu đãi...</p>
        @endforelse
    </div>

    <div class="mb-5">
        <h3 class="fw-bold mb-4">Gợi ý khách sạn & Resort</h3>
        <div class="row g-4">
            @foreach($allRooms as $room)
            <div class="col-md-3">
                <div class="item-card card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top object-fit-cover" style="height: 180px;" alt="{{ $room->name }}">
                        @if($room->discount > 0)
                            <span class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 m-2 rounded small">-{{ $room->discount }}%</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <small class="text-primary fw-bold text-uppercase">{{ $room->location }}</small>
                        <h6 class="fw-bold text-dark text-truncate-2 mt-1">{{ $room->name }}</h6>
                        <div class="d-flex align-items-center mb-2">
                             <div class="text-warning small me-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                             </div>
                             <small class="text-muted">(45 đánh giá)</small>
                        </div>
                        <div class="price-box mt-3 pt-2 border-top">
                            <span class="text-orange fw-bold fs-5">{{ number_format($room->price * (1 - $room->discount/100)) }}đ</span>
                            <small class="text-muted">/Đêm</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection