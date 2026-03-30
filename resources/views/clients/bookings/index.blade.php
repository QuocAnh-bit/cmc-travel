@extends('layouts.client')

@section('content')
<div class="container py-4">

    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            🏨 Danh sách đặt phòng
        </h2>

        <a href="#" class="btn btn-success">
            + Đặt phòng mới
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Khách hàng</th>
                        <th>Phòng</th>
                        <th>Ngày nhận</th>
                        <th>Ngày trả</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Demo dữ liệu --}}
                    <tr>
                        <td>1</td>
                        <td>Nguyễn Văn A</td>
                        <td>Phòng VIP</td>
                        <td>01/04/2026</td>
                        <td>05/04/2026</td>
                        <td>
                            <span class="badge bg-success">Đã xác nhận</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary">Xem</a>
                            <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger">Hủy</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Trần Thị B</td>
                        <td>Phòng Deluxe</td>
                        <td>02/04/2026</td>
                        <td>06/04/2026</td>
                        <td>
                            <span class="badge bg-warning text-dark">Chờ xử lý</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary">Xem</a>
                            <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger">Hủy</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection