@extends('layouts.auth')

@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="login-wrapper">

    <div class="login-left">
        <div class="brand-content">
            <h1>CMC Travel</h1>
            <p>Bắt đầu hành trình của bạn ngay hôm nay</p>
        </div>
    </div>

    <div class="login-right">
        <div class="login-box">
            <h3>Tạo tài khoản</h3>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                
                <input type="text" name="name" class="form-control" placeholder="Họ và tên" value="{{ old('name') }}" required>
                
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                
                <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required>

                <button type="submit" class="btn btn-primary mt-2">Đăng ký ngay</button>
            </form>

            <div class="register-link mt-4 text-center">
                <span>Đã có tài khoản?</span>
                <a href="{{ route('login') }}">Đăng nhập</a>
            </div>
        </div>
    </div>

</div>
@endsection