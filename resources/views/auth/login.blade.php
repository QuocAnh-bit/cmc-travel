@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-wrapper">

    <div class="login-left">
        <div class="brand-content">
            <h1>CMC Travel</h1>
            <p>Đăng nhập nhanh chóng, Tiện lợi</p>
        </div>
    </div>

    <div class="login-right">
        <div class="login-box">
            <h3>Login</h3>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="email" name="email" class="form-control mb-1 @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" >
                @error('email')
                    <div class="text-danger small mb-3">{{ $message }}</div>
                @enderror

                <input type="password" name="password" class="form-control mb-1 @error('password') is-invalid @enderror" placeholder="Mat khau" >
                @error('password')
                    <div class="text-danger small mb-3">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary mt-2">Đăng nhập</button>
            </form>

            <div class="register-link mt-4 text-center">
                <span>Chưa có tài khoản?</span>
                <a href="{{ route('register') }}">Đăng ký</a>
            </div>
        </div>
    </div>

</div>
@endsection
