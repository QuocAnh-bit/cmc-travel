@extends('layouts.client')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        {{-- BỘ LỌC BÊN TRÁI ✅ (Giữ nguyên để khách có thể lọc lại sau khi search) --}}
        <div class="col-lg-3">
            <div class="filter-sidebar p-4 bg-white shadow-sm rounded-4 border">
                <h5 class="fw-bold mb-4"><i class="fas fa-filter me-2 text-primary"></i>Bộ lọc</h5>
                
                <form action="{{ route('client.search') }}" method="GET">
                    {{-- Giữ lại các tham số hiện tại để không bị mất khi lọc --}}
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">

                    <div class="mb-4">
                        <label class="small fw-bold mb-2 text-muted text-uppercase">Tìm trong kết quả</label>
                        <input type="text" name="name" class="form-control border-2" placeholder="Tên khách sạn..." value="{{ request('name') }}">
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold mb-2 text-muted text-uppercase">Khoảng giá</label>
                        @foreach(['under_1m' => 'Dưới 1 triệu', '1m_3m' => '1 - 3 triệu', 'over_3m' => 'Trên 3 triệu'] as $value => $label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="price_range" value="{{ $value }}" 
                                       id="{{ $value }}" {{ request('price_range') == $value ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm">Áp dụng</button>
                    
                    @if(request()->anyFilled(['name', 'price_range', 'search']))
                        <a href="{{ route('client.search') }}" class="btn btn-link w-100 text-muted mt-2 small text-decoration-none">Xóa tất cả bộ lọc</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- KẾT QUẢ TÌM KIẾM BÊN PHẢI ✅ --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1">Kết quả tìm kiếm</h4>
                    <p class="text-muted mb-0 small">
                        Tìm thấy <b>{{ $hotels->total() }}</b> khách sạn cho từ khóa: <span class="text-primary fw-bold">"{{ request('search') }}"</span>
                    </p>
                </div>

                {{-- SẮP XẾP --}}
                <div class="dropdown">
                    <button class="btn btn-white border dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                        <i class="fas fa-sort-amount-down me-1 text-primary"></i>
                        {{ request('sort') == 'price_asc' ? 'Giá thấp đến cao' : (request('sort') == 'price_desc' ? 'Giá cao đến thấp' : 'Sắp xếp theo') }}
                    </button>
                    <ul class="dropdown-menu shadow-sm border-0">
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Giá tăng dần</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Giá giảm dần</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ request()->fullUrlWithQuery(['sort' => null]) }}">Mặc định</a></li>
                    </ul>
                </div>
            </div>

            <div class="row g-4">
                @forelse($hotels as $hotel)
                    @php
                        // Lấy phòng có giá thấp nhất của khách sạn này
                        $representativeRoom = $hotel->rooms->sortBy('price')->first();
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <div class="hotel-card-premium bg-white h-100 rounded-4 overflow-hidden border shadow-hover transition">
                            <div class="position-relative overflow-hidden" style="height: 180px;">
                                <img src="{{ \Str::startsWith($representativeRoom->image ?? '', 'http') ? $representativeRoom->image : asset('storage/' . ($representativeRoom->image ?? 'default.jpg')) }}" 
                                     class="w-100 h-100 object-fit-cover transition-scale"
                                     onerror="this.src='https://placehold.co/600x400?text=CMC+Travel'">
                            </div>

                            <div class="p-4">
                                <h5 class="fw-bold text-dark text-truncate mb-2" title="{{ $hotel->name }}">{{ $hotel->name }}</h5>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i> 
                                    {{ $hotel->address ?? 'Địa chỉ đang cập nhật' }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <small class="text-muted d-block">Giá từ</small>
                                        <span class="fw-bold text-danger fs-5">
                                            {{ number_format($representativeRoom->price ?? 0) }}đ
                                        </span>
                                    </div>
                                    <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-primary rounded-pill px-3 fw-bold btn-sm shadow-sm">
                                        Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-search-minus fa-4x text-muted opacity-25"></i>
                        </div>
                        <h5 class="text-muted">Không tìm thấy khách sạn nào phù hợp với yêu cầu của Thịnh.</h5>
                        <p class="small text-muted">Thử thay đổi từ khóa hoặc xóa bộ lọc xem sao nhé!</p>
                        <a href="{{ route('client.search') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 mt-2">Xem tất cả khách sạn</a>
                    </div>
                @endforelse
            </div>

            {{-- Phân trang (Giữ lại các tham số query trên URL) --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $hotels->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection