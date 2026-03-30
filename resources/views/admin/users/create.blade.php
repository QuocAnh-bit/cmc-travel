@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Thêm người dùng mới</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Họ và tên</label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên..." required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vai trò</label>
                        <select name="role" class="form-select">
                            <option value="user">Khách hàng</option>
                            <option value="admin">Quản trị viên</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Hủy</a>
                    <button type="submit" class="btn btn-primary px-4">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection