@extends('layouts.client')

@section('content')
<main class="main-content">
    
    {{-- 1. HERO SECTION VỚI HIỆU ỨNG GLASSMORPHISM --}}
    {{-- Lưu ý: Class Swiper phải khớp với Script bên dưới --}}
    <section class="hero-v4 swiper" data-aos="fade-down">
        <div class="swiper-wrapper">
            
            @php 
                $banners = [ 
                    [
                        'img' => 'travel1.jpg', 
                        'title' => 'Chạm tới <span class="text-secondary">Ước mơ</span>',
                        'desc' => 'CMC Travel là hệ thống đặt phòng Resort hàng đầu Việt Nam. Chúng tôi cam kết mang lại trải nghiệm nghỉ dưỡng 5 sao với mức giá tối ưu nhất.'
                    ], 
                    [
                        'img' => 'travel2.jpg', 
                        'title' => 'Kỳ nghỉ <span class="text-secondary">Thượng lưu</span>',
                        'desc' => 'Tận hưởng không gian sang trọng và dịch vụ đẳng cấp thế giới tại những hòn đảo thiên đường.'
                    ] 
                ]; 
            @endphp

            @forelse($banners as $banner)
            <div class="swiper-slide position-relative">
                {{-- Ảnh nền --}}
                <div class="parallax-bg" style="background-image: url('{{ asset('storage/banners/' . $banner['img']) }}');"></div>
                
                <div class="container h-100 d-flex align-items-center position-relative" style="z-index: 2;">
                    <div class="row w-100 align-items-center">
                        
                        {{-- Ô NỀN MỜ (Glassmorphism Panel) --}}
                        <div class="col-lg-7">
                            <div class="hero-content-panel" data-aos="fade-right">
                                <h1 class="hero-title text-white">{!! $banner['title'] !!}</h1>
                                <p class="hero-text lh-lg text-white-50">{{ $banner['desc'] }}</p>
                                
                                <div class="mt-4 pt-3 border-top border-secondary opacity-75">
                                    <div class="d-flex gap-3">
                                        <div class="voucher-tag">Mã: <b class="text-secondary">HE900</b> - Giảm 900k</div>
                                        <div class="voucher-tag">Mã: <b class="text-secondary">VINAP</b> - Giảm 20%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Ảnh phụ nổi bật (Sunshine Heritage) --}}
                        <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left">
                            <div class="floating-img-wrapper">
                            </div>
                        </div>

                    </div>
                </div>
                
                {{-- Overlay làm tối nền --}}
                <div class="position-absolute inset-0 bg-dark bg-opacity-25" style="z-index: 1;"></div>
            </div>
            @empty
                <div class="swiper-slide bg-dark d-flex align-items-center justify-content-center text-white h-100">
                    <p>Đang cập nhật banner...</p>
                </div>
            @endforelse
        </div>
        
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
        <div class="swiper-pagination"></div>
    </section>
    {{-- 3. SEARCH BOX NEUMORPHISM ✅ --}}
<div class="container position-relative" style="z-index: 100;">
    <div class="search-wrapper glass-panel mx-auto" style="max-width: 900px;">
        <h5 class="fw-bold mb-3"><i class="fas fa-search me-2 text-primary"></i>Tìm khách sạn giá tốt</h5>
        
        {{-- 1. Thêm action trỏ đến route danh sách khách sạn --}}
       <form action="{{ route('client.search') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-lg-7">
                <label class="small fw-bold text-muted mb-1 text-uppercase">Địa điểm</label>
                <div class="input-group border rounded-3 p-2">
                    <span class="input-group-text bg-transparent border-0"><i class="fas fa-map-marker-alt text-primary"></i></span>
                    
                    {{-- 2. Quan trọng: Thêm name="search" và value để giữ từ khóa sau khi tìm --}}
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control border-0" 
                           placeholder="Thành phố, địa danh, khách sạn...">
                </div>
            </div>
            <div class="col-lg-5">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm">
                    TÌM NGAY
                </button>
            </div>
        </form>
    </div>
</div>

    {{-- 2. QUICK STATS --}}
    <div class="container mt-n5 position-relative" style="z-index: 10;">
        <div class="row g-0 shadow-lg rounded-4 overflow-hidden bg-white text-center">
            <div class="col-md-3 p-4 border-end border-light hover-bg-light transition">
                <h2 class="fw-bold text-primary mb-0">15+</h2>
                <small class="text-muted text-uppercase fw-semibold">Năm kinh nghiệm</small>
            </div>
            <div class="col-md-3 p-4 border-end border-light hover-bg-light transition">
                <h2 class="fw-bold text-primary mb-0">1,000+</h2>
                <small class="text-muted text-uppercase fw-semibold">Hotel & Resort</small>
            </div>
            <div class="col-md-3 p-4 border-end border-light hover-bg-light transition">
                <h2 class="fw-bold text-primary mb-0">24/7</h2>
                <small class="text-muted text-uppercase fw-semibold">Hỗ trợ tận tâm</small>
            </div>
            <div class="col-md-3 p-4 hover-bg-light transition">
                <h2 class="fw-bold text-primary mb-0">100%</h2>
                <small class="text-muted text-uppercase fw-semibold">Giá tốt nhất</small>
            </div>
        </div>
    </div>

    {{-- 3. DEAL HOT --}}
    <section class="container py-5 mt-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold text-danger border-start border-4 border-danger ps-3">Deal Hot Hôm Nay</h3>
                <p class="text-muted mb-0">Ưu đãi độc quyền chỉ có tại CMC Travel.</p>
            </div>
            <a href="#" class="btn btn-outline-primary rounded-pill px-4">Xem tất cả <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
        
        <div class="row g-4">
            @foreach($featuredRooms as $room)
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="item-card hover-float h-100 border-0 bg-white shadow-sm rounded-4 overflow-hidden transition">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ \Illuminate\Support\Str::startsWith($room->image, ['http://', 'https://']) ? $room->image : asset('storage/' . $room->image) }}" 
     class="w-100 transition-transform" 
     style="height: 220px; object-fit: cover;"
     onerror="this.src='https://placehold.co/600x400?text=CMC+Travel'">
                        <div class="badge-sale">-{{$room->discount}}%</div>
                    </div>
                    <div class="p-3">
                        <h6 class="fw-bold text-truncate mb-1">{{ $room->name }}</h6>
                        <div class="text-warning small mb-2">
                            @for($i=1; $i<=5; $i++) <i class="fas fa-star"></i> @endfor
                        </div>
                        <p class="small text-muted mb-3"><i class="fas fa-map-marker-alt me-1"></i> {{ $room->hotel->address }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-decoration-line-through text-muted small d-block">{{ number_format($room->price * 1.2) }}đ</small>
                                <span class="fs-5 fw-bold text-danger">{{ number_format($room->price) }}đ</span>
                            </div>
                            <a href="{{ route('hotels.show', ['id' => $room->hotel_id, 'room' => $room->id]) }}#room-{{ $room->id }}"
                               class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                Đặt ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    {{-- 4. ĐIỂM ĐẾN PHỔ BIẾN ✅ --}}
<section class="container py-5">
    <div class="text-center mb-5">
        <h3 class="fw-bold section-title">Điểm Đến Yêu Thích</h3>
        <p class="text-muted">Khám phá vẻ đẹp bất tận của dải đất hình chữ S</p>
    </div>
    
    <div class="row g-4">
        @php
            $destinations = [
                ['name' => 'Đà Nẵng', 'count' => 23, 'img' => 'danang.jpg', 'col' => 'col-md-4'],
                ['name' => 'Phú Quốc', 'count' => 21, 'img' => 'phuquoc.jpg', 'col' => 'col-md-8'],
                ['name' => 'Đà Lạt', 'count' => 18, 'img' => 'dalat.jpg', 'col' => 'col-md-8'],
                ['name' => 'Sapa', 'count' => 30, 'img' => 'sapa.jpg', 'col' => 'col-md-4'],
            ];
        @endphp

        @foreach($destinations as $dest)
        <div class="{{ $dest['col'] }}" data-aos="fade-up">
            <div class="dest-card-premium shadow-sm">
                <img src="{{ asset('storage/destinations/' . $dest['img']) }}" class="w-100 h-100 object-fit-cover" style="min-height: 250px;">
                <div class="overlay-grad">
                    <h4 class="fw-bold mb-0">{{ $dest['name'] }}</h4>
                    <p class="small mb-0 opacity-75">{{ $dest['count'] }} Khách sạn & Resort</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
{{-- 5. LÝ DO CHỌN CHÚNG TÔI ✅ --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="{{ asset('storage/banners/why-choose-us.jpg') }}" class="img-fluid rounded-5 shadow-lg">
            </div>
            <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                <h3 class="fw-bold mb-4 mt-4 mt-lg-0">Tại sao nên đặt phòng tại <span class="text-primary">CMC Travel?</span></h3>
                <div class="d-flex mb-4">
                    <div class="icon-box me-3"><i class="fas fa-shield-alt text-primary fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold">Thông tin minh bạch</h6>
                        <p class="text-muted small">Cam kết thông tin Hotel & Resort trên web luôn Trung thực - Chính xác.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="icon-box me-3"><i class="fas fa-tags text-primary fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold">Giá tốt nhất thị trường</h6>
                        <p class="text-muted small">Luôn có ưu đãi đặc quyền dành cho Nhóm khách, Công ty và Khách lẻ.</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="icon-box me-3"><i class="fas fa-headset text-primary fs-3"></i></div>
                    <div>
                        <h6 class="fw-bold">Hỗ trợ nhanh chóng</h6>
                        <p class="text-muted small">Hoàn, huỷ, thay đổi ngày linh hoạt với đội ngũ chăm sóc 24/7.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- 6. CẢM NHẬN KHÁCH HÀNG ✅ --}}
<section class="py-5 bg-light">
        <div class="container">
            <h3 class="fw-bold text-center mb-5">Khách Hàng Nói Gì Về CMC Travel</h3>
            <div class="row g-4">
                @php
                    $reviews = [
                        ['name' => 'Hà Mạnh Khiêm', 'text' => 'Dịch vụ tuyệt vời, nhân viên hỗ trợ rất nhiệt tình.'],
                        ['name' => 'Đỗ Duy Thịnh', 'text' => 'Tôi đã có một kỳ nghỉ đáng nhớ tại Nha Trang.'],
                        ['name' => 'Dương Quốc Anh', 'text' => 'Giá voucher rất tốt so với thị trường.']
                    ];
                @endphp
                @foreach($reviews as $review)
                <div class="col-md-4">
                    <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="text-warning mb-3">★★★★★</div>
                        <p class="fst-italic text-muted small">"{{ $review['text'] }}"</p>
                        <div class="d-flex align-items-center mt-4">
                            <div class="avatar me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: #f0f2f5; border-radius: 50%; border: 1px solid #ddd;">
                                <i class="fas fa-user text-muted" style="font-size: 20px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold small">{{ $review['name'] }}</h6>
                                <small class="text-primary" style="font-size: 11px;">Khách hàng thân thiết</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
{{-- 7. NEWSLETTER ✅ --}}
<section class="container py-5">
    <div class="bg-primary p-5 rounded-5 text-center text-white position-relative overflow-hidden shadow-lg">
        <div class="position-relative" style="z-index: 2;">
            <h2 class="fw-bold mb-3 text-white">Nhận Ngay Ưu Đãi 30%</h2>
            <p class="mb-4 opacity-75">Để lại email để không bỏ lỡ những voucher hot nhất từ CMC Travel.</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group mb-3 bg-white p-2 rounded-pill">
                        <input type="email" class="form-control border-0 px-4" placeholder="Nhập email của bạn...">
                        <button class="btn btn-secondary rounded-pill px-4 fw-bold">Đăng ký ngay</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Decor Circles --}}
        <div class="position-absolute translate-middle" style="top:0; left:0; width:300px; height:300px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    </div>
</section>
   

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selector đã được sửa từ .hero-slider thành .hero-v4 ✅
        const swiper = new Swiper('.hero-v4', {
            loop: true,
            speed: 1000,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
@endsection
