<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMC Travel - @yield('title')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-paper-plane me-2"></i>CMC <span>Travel</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ms-auto align-items-center">
    <li class="nav-item dropdown has-megamenu">
    <a class="nav-link dropdown-toggle {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" id="hotelMegaMenu" data-bs-toggle="dropdown">
        KHÁCH SẠN
    </a>
    
    <div class="dropdown-menu megamenu shadow-lg border-0 p-4" aria-labelledby="hotelMegaMenu">
        <div class="row g-4">
            {{-- Chia danh sách hotels thành các nhóm 4 mục cho mỗi cột --}}
            @foreach($hotels->chunk(4) as $chunk)
                <div class="col-md-4 {{ !$loop->last ? 'border-end' : '' }}">
                    <h6 class="fw-bold text-primary mb-3">
                        @if($loop->iteration == 1) <i class="fas fa-star me-2"></i>Nổi bật 
                        @elseif($loop->iteration == 2) <i class="fas fa-hot-cdn me-2"></i>Ưu đãi 
                        @else <i class="fas fa-crown me-2"></i>Cao cấp @endif
                    </h6>
                    <ul class="list-unstyled menu-hotel-list">
                        @foreach($chunk as $hotel)
                            <li>
                                <a href="{{ route('hotels.index', ['hotel_id' => $hotel->id]) }}" title="{{ $hotel->name }}">
                                    {{ $hotel->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        
        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
            <span class="small text-muted italic">Khám phá hệ thống khách sạn của CMC Travel</span>
           <a href="{{ route('hotels.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Xem tất cả</a>
        </div>
    </div>
</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('hotels*') ? 'active' : '' }}" href="{{ route('hotels.index') }}">COMBO GIÁ TỐT</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">VOUCHER</a>
    </li>
    @auth
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">ĐƠN CỦA TÔI</a>
    </li>
    @endauth
    <li class="nav-item btn-contact-nav">
        <a class="nav-link px-4 ms-lg-3" href="#">LIÊN HỆ</a>
    </li>

    {{-- KIỂM TRA ĐĂNG NHẬP ĐỂ GỌI ROUTE --}}
    @guest
        {{-- Nếu chưa đăng nhập: Gọi route login và register --}}
        <li class="nav-item ms-lg-3">
            <a class="nav-link fw-bold text-primary" href="{{ route('login') }}">Đăng nhập</a>
        </li>
        <li class="nav-item">
            <a class="btn btn-primary rounded-pill px-4 ms-lg-2" href="{{ route('register') }}">Đăng ký</a>
        </li>
    @endguest

    @auth
        {{-- Nếu đã đăng nhập: Hiển thị Dropdown cá nhân --}}
        <li class="nav-item dropdown ms-lg-3">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                <div class="avatar-circle me-2">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span>{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                @if(Auth::user()->role == 'admin')
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2"></i>Quản trị</a></li>
                @endif
                <li><a class="dropdown-item" href="{{ route('bookings.index') }}"><i class="fas fa-box me-2"></i>Đơn đặt phòng</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    {{-- Gọi route logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    @endauth
</ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- 8. FOOTER - LUXURY DARK ✅ --}}
<footer class="footer-premium">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <h4 class="text-white fw-bold mb-4">CMC <span class="text-secondary">Travel</span></h4>
                <p class="opacity-50 small mb-4">Hệ thống đặt phòng Resort & Hotel hàng đầu Việt Nam. Mang đến trải nghiệm nghỉ dưỡng 5 sao với giá thành hợp lý nhất.</p>
                <div class="social-links d-flex gap-2">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2">
                <h6 class="footer-title">Về chúng tôi</h6>
                <ul class="list-unstyled opacity-75 small">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Giới thiệu</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Tuyển dụng</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Tin tức</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h6 class="footer-title">Hỗ trợ</h6>
                <ul class="list-unstyled opacity-75 small">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Chính sách bảo mật</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Điều khoản sử dụng</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="footer-title">Liên hệ</h6>
                <ul class="list-unstyled opacity-75 small text-white">
                    <li class="mb-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> Tòa nhà Sun City, 13 Hai Bà Trưng, Hoàn Kiếm, Hà Nội</li>
                    <li class="mb-3"><i class="fas fa-phone-alt me-2 text-secondary"></i> 1800 6645 (Miễn phí)</li>
                    <li class="mb-3"><i class="fas fa-envelope me-2 text-secondary"></i> contact@cmctravel.vn</li>
                </ul>
            </div>
        </div>
        <hr class="my-5 opacity-10">
        <div class="text-center opacity-50 pb-4 small">
            &copy; 2026 CMC Travel. All rights reserved. Designed by Thvnh.
        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
    </script>
</body>
</html>
