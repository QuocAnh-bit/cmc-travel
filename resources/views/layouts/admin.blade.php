<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <h4><i class="fas fa-shield-alt me-2"></i>CMC Travel</h4>
    </div>
    
    <ul class="nav-admin">
        <li>
            <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/users" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Người dùng
            </a>
        </li>
        <li>
            <a href="/admin/rooms" class="{{ request()->is('admin/rooms*') ? 'active' : '' }}">
                <i class="fas fa-hotel"></i> Phòng nghỉ
            </a>
        </li>
        <li>
            <a href="/admin/bookings" class="{{ request()->is('admin/bookings*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> Đơn đặt phòng
            </a>
        </li>
        <li class="mt-4 pt-3 border-top border-secondary border-opacity-25">
            <a href="/" target="_blank">
                <i class="fas fa-external-link-alt"></i> Xem Website
            </a>
        </li>
    </ul>
</div>

<div class="main-wrapper">
    <header class="topbar">
        <button class="btn d-lg-none me-auto" onclick="toggleMenu()">
            <i class="fas fa-bars fs-4"></i>
        </button>

        <div class="user-info d-flex align-items-center">
            <span class="me-3 fw-semibold text-secondary">{{ auth()->user()->name ?? 'Admin User' }}</span>
            <div class="dropdown">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'A' }}&background=4e73df&color=fff" 
                     class="rounded-circle shadow-sm dropdown-toggle" 
                     id="userMenu" data-bs-toggle="dropdown" 
                     style="cursor: pointer; width: 40px;">
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-3">
                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user-edit me-2"></i>Sửa hồ sơ</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger py-2" type="submit">
                                <i class="fas fa-power-off me-2"></i>Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="content-body">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleMenu() {
        document.getElementById('adminSidebar').classList.toggle('show');
    }
</script>

</body>
</html>