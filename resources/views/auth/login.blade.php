@extends('layouts.auth')

@section('content')
<div class="container mt-5" style="max-width:400px">
    <h3>Đăng nhập</h3>

    @session('error')
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endsession

    <form method="POST" action="/login">
        @csrf
        <input name="email" class="form-control mb-2" placeholder="Email">
        <input type="password" name="password" class="form-control mb-2" placeholder="Mật khẩu">
        <button class="btn btn-primary w-100">Đăng nhập</button>
    </form>
</div>
@endsection