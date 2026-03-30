@extends('layouts.admin')

@section('title', 'Chi tiết phòng')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">

        {{-- HEADER --}}
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">Chi tiết phòng</h5>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit me-1"></i> Sửa
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-sm btn-light">
                    ← Quay lại
                </a>
            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            <div class="row">

                {{-- ẢNH --}}
                <div class="col-md-4 text-center mb-4">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}"
                             class="rounded shadow-sm"
                             style="width: 100%; max-width: 300px; object-fit: cover;">
                    @else
                        <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded"
                             style="height: 200px;">
                            Không có ảnh
                        </div>
                    @endif
                </div>

                {{-- THÔNG TIN --}}
                <div class="col-md-8">

                    <h4 class="fw-bold text-dark mb-3">
                        {{ $room->name }}
                    </h4>

                    <div class="mb-2">
                        <span class="text-muted">Khách sạn:</span>
                        <span class="fw-semibold">{{ $room->hotel_name }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Địa điểm:</span>
                        <span>{{ $room->location }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Giá:</span>
                        <span class="fw-bold text-danger">
                            {{ number_format($room->price) }}đ
                        </span>
                    </div>

                    {{-- TRẠNG THÁI --}}
                    <div class="mb-2">
                        <span class="text-muted">Trạng thái:</span>
                        @if($room->status == 'available')
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-secondary">Booked</span>
                        @endif
                    </div>

                    {{-- HOT --}}
                    <div class="mb-3">
                        <span class="text-muted">Nổi bật:</span>
                        @if($room->is_featured)
                            <span class="badge bg-warning text-dark">Hot</span>
                        @else
                            <span class="text-muted">Không</span>
                        @endif
                    </div>

                    {{-- MÔ TẢ --}}
                    <div class="mb-3">
                        <h6 class="fw-bold">Mô tả</h6>
                        <p class="text-muted">{{ $room->description }}</p>
                    </div>

                    {{-- TIỆN NGHI --}}
                    <div>
                        <h6 class="fw-bold">Tiện nghi</h6>

                        @if($room->amenities)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($room->amenities as $item)
                                    <span class="badge bg-light text-dark border">
                                        {{ ucfirst($item) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Không có tiện nghi</p>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection