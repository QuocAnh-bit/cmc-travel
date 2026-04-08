@extends('layouts.auth')

@section('title', 'Dang ky tai khoan')

@section('content')
<div class="login-wrapper">

    <div class="login-left">
        <div class="brand-content">
            <h1>CMC Travel</h1>
            <p>Bắt đầu hành trình của bạn ngày hôm nay</p>
        </div>
    </div>

    <div class="login-right">
        <div class="login-box">
            <h3>Tạo tài khoản</h3>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ho va ten" value="{{ old('name') }}" >
                @error('name')
                    <div class="text-danger small mt-1 mb-2">{{ $message }}</div>
                @enderror
                
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" >
                @error('email')
                    <div class="text-danger small mt-1 mb-2">{{ $message }}</div>
                @enderror
                
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mat khau" >
                @error('password')
                    <div class="text-danger small mt-1 mb-2">{{ $message }}</div>
                @enderror
                
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Xac nhan mat khau" >
                @error('password_confirmation')
                    <div class="text-danger small mt-1 mb-2">{{ $message }}</div>
                @enderror

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
