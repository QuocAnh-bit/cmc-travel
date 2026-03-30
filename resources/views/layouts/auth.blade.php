<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <style>
        /* Đảm bảo html và body full 100% màn hình */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100% !important;
            overflow: hidden; /* Ngăn hiện thanh cuộn */
        }

        /* Đặt HÌNH NỀN FULL TOÀN BỘ MÀN HÌNH */
        body {
            background-image: url("{{ asset('images/bg.jpg') }}"); /* Đảm bảo đường dẫn này đúng */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            
        }

        /* Lớp phủ tối đè lên hình nền (tùy chọn) */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Độ tối 40% */
            z-index: 1; /* Nằm dưới nội dung, trên hình nền */
        }

        /* Đảm bảo nội dung luôn nằm trên lớp phủ tối */
        .login-wrapper {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>

    @yield('content')

</body>
</html>