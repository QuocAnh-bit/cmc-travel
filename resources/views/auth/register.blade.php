@extends('layouts.auth')

@section('content')
<div class="container mt-5" style="max-width:400px">
    <h3>Đăng ký</h3>

    <form method="POST" action="/register">
        @csrf
        <input name="name" class="form-control mb-2" placeholder="Tên">
        <input name="email" class="form-control mb-2" placeholder="Email">
        <input type="password" name="password" class="form-control mb-2" placeholder="Mật khẩu">
        <button class="btn btn-success w-100">Đăng ký</button>
    </form>
</div>
@endsection