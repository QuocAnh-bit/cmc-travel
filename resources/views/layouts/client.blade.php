<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMC Travel - @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
</head>
<body>

<div class="topbar-client d-none d-lg-block">
    <div class="container d-flex justify-content-between">
        <div>
            <i class="fas fa-phone-alt me-1"></i> Hotline: <span class="fw-bold">1900 1870</span> (7h30 - 21h)
        </div>
        <div>
            @auth
                <span class="me-3"><i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-link btn-sm text-white p-0 text-decoration-none">Đăng xuất</button>
                </form>
            @else
                <a href="/login" class="text-white text-decoration-none me-3"><i class="fas fa-user me-1"></i> Tài khoản</a>
            @endauth
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="/">
            <span class="text-info">CMC</span> Travel
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#clientNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="clientNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom active" href="/hotels">Khách sạn</a>
                </li>
                
                
            </ul>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="bg-white border-top pt-5 pb-3 mt-5 shadow-sm">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-dark">Về CMC Travel</h6>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Về chúng tôi</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">CMC Blog</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Tuyển dụng</a></li>
                </ul>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="text-info fs-5"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-danger fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-info fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-danger fs-5"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-primary fs-5"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-dark">Thông tin cần biết</h6>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Điều kiện & Điều khoản</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Quy chế hoạt động</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Câu hỏi thường gặp</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Chính sách bảo mật</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-dark">Chứng nhận</h6>
                <div class="mb-3">
                    <img src="data:image/png;base64,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" width="120" alt="Đã đăng ký bộ công thương" class="me-2 opacity-75">
                </div>
                <h6 class="fw-bold mb-2 text-dark small">Thành viên của</h6>
                <div class="fw-bold text-primary fs-4">CMC Group</div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-dark">Bạn cần trợ giúp?</h6>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-phone-alt text-orange fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold text-orange fs-5">1900 1870</div>
                        <small class="text-muted">7h30 — 21h</small>
                    </div>
                </div>
                <div class="mt-4">
                    <h6 class="fw-bold mb-2 text-dark small">Tải ứng dụng ngay</h6>
                    <div class="d-flex gap-2 align-items-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=CMCTravel" alt="QR Code" class="border p-1 rounded">
                        <div class="d-grid gap-1">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" width="90" alt="App Store">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" width="90" alt="Google Play">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4 text-muted opacity-25">

        <div class="row small text-muted">
            <div class="col-md-8">
                <p class="mb-1 fw-bold text-dark">Dự án CMC Travel - Hệ thống đặt phòng Resort chuyên nghiệp</p>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-1"></i> <strong>HCM:</strong> Tòa nhà Innovation, Công viên phần mềm Quang Trung, Quận 12, TP.HCM</p>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-1"></i> <strong>HN:</strong> Tòa nhà FPT Polytechnic, Trịnh Văn Bô, Nam Từ Liêm, Hà Nội</p>
            </div>
            <div class="col-md-4 text-md-end">
                <p class="mb-0">&copy; 2026 CMC Travel Team. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>