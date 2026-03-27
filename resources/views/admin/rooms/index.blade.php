@extends('layouts.admin')

@section('title', 'Quản lý phòng')

@section('content')
<div class="container-fluid px-4 py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">

        {{-- HEADER --}}
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">Danh sách phòng</h5>

            <a href="{{ route('admin.rooms.create') }}" 
               class="btn btn-primary btn-sm px-3 d-flex align-items-center"
               style="border-radius: 8px;">
                <i class="fas fa-plus me-1"></i> 
                <span>Thêm phòng</span>
            </a>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Phòng</th>
                            <th>Tên</th>
                            <th>Khách sạn</th>
                            <th>Địa điểm</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Hot</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($rooms as $room)
                        <tr>

                            {{-- ID --}}
                            <td>#{{ $room->id }}</td>

                            {{-- TÊN + ẢNH --}}
                            <td>
                                <div class="d-flex align-items-center">

                                    @if($room->image)
                                        <img src="{{ Storage::url($room->image) }}"
                                             class="me-3 rounded"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center me-3"
                                             style="width: 60px; height: 60px;">
                                            N/A
                                        </div>
                                    @endif

                                </div>
                            </td>

                            <td>{{ $room->name }}</td>
                            {{-- KHÁCH SẠN --}}
                            <td>{{ $room->hotel_name }}</td>

                            {{-- ĐỊA ĐIỂM --}}
                            <td>{{ $room->location }}</td>

                            {{-- GIÁ --}}
                            <td class="fw-bold text-danger">
                                {{ number_format($room->price) }}đ
                            </td>

                            {{-- TRẠNG THÁI --}}
                            <td>
                                @if($room->status == 'available')
                                    <span class="badge bg-success-subtle text-success border border-success px-3">
                                        Available
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3">
                                        Unavailable
                                    </span>
                                @endif
                            </td>

                            {{-- HOT --}}
                            <td>
                                @if($room->is_featured)
                                    <span class="badge bg-warning text-dark px-3">Hot</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">

                                    {{-- XEM --}}
                                    <a href="{{ route('admin.rooms.show', $room->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- SỬA --}}
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- XOÁ --}}
                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Xóa phòng này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Không có phòng nào.
                            </td>
                        </tr>
                    @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>
@endsection