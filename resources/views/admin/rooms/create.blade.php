@extends('layouts.admin')

@section('title', 'Thêm phòng')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">

        {{-- HEADER --}}
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Thêm phòng mới</h5>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- TÊN PHÒNG --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên phòng</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    {{-- KHÁCH SẠN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Khách sạn</label>
                        <input type="text" name="hotel_name" class="form-control">
                    </div>

                    {{-- ĐỊA ĐIỂM --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Địa điểm</label>
                        <input type="text" name="location" class="form-control">
                    </div>

                    {{-- GIÁ --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" name="price" class="form-control">
                    </div>

                    {{-- GIẢM GIÁ --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Giảm giá</label>
                        <input type="number" name="discount" class="form-control">
                    </div>

                    {{-- MÔ TẢ --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    {{-- TIỆN ÍCH --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Tiện ích</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="amenities[]" value="wifi">
                            <label class="form-check-label">Wifi</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="amenities[]" value="pool">
                            <label class="form-check-label">Hồ bơi</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="amenities[]" value="breakfast">
                            <label class="form-check-label">Ăn sáng</label>
                        </div>
                    </div>

                    {{-- ẢNH --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ảnh</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    {{-- TRẠNG THÁI --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                        </select>
                    </div>

                    {{-- NỔI BẬT --}}
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1">
                            <label class="form-check-label">Nổi bật</label>
                        </div>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-light">
                        Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Thêm phòng
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection