@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Them nguoi dung moi</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ho va ten</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhap ho ten..." value="{{ old('name') }}" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Mat khau</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" required>
                        <small class="text-muted">Mat khau can it nhat 8 ky tu, gom chu va so.</small>
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Xac nhan mat khau</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" minlength="8" required>
                        @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vai tro</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>Khach hang</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quan tri vien</option>
                        </select>
                        @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Huy</a>
                    <button type="submit" class="btn btn-primary px-4">Luu thong tin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
