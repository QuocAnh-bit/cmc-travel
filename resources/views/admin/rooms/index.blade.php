@extends('layouts.admin')

@section('title', 'Danh sách phòng nghỉ')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-bed me-2 text-primary"></i>Quản lý Phòng nghỉ</h2>
            <p class="text-muted small">Danh sách chi tiết các hạng phòng thuộc hệ thống khách sạn</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary shadow-sm px-4">
            <i class="fas fa-plus me-1"></i> Thêm phòng mới
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" style="width: 80px;">Ảnh</th>
                            <th>Thông tin phòng</th>
                            <th>Khách sạn</th>
                            <th>Giá & Giảm giá</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                        <tr>
                            <td class="ps-4">
                                <div class="position-relative">
                                    <img src="{{ $room->image ? asset('storage/'.$room->image) : 'https://via.placeholder.com/150' }}" 
                                         class="rounded shadow-sm border" 
                                         style="width: 70px; height: 50px; object-fit: cover;">
                                    @if($room->is_featured)
                                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-warning text-dark border border-white" style="font-size: 10px;">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="fw-bold text-dark">{{ $room->name }}</div>
                                <div class="text-muted small text-truncate" style="max-width: 200px;">
                                    {!! Str::limit(strip_tags($room->description), 50) !!}
                                </div>
                            </td>

                            <td>
                                <div class="badge bg-soft-info text-info border border-info">
                                    <i class="fas fa-hotel me-1"></i> {{ $room->hotel->name ?? 'N/A' }}
                                </div>
                            </td>

                            <td>
                                <div class="fw-bold text-primary">{{ number_format($room->price) }}đ</div>
                                @if($room->discount > 0)
                                    <small class="text-danger">Giảm: {{ $room->discount }}%</small>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($room->status == 'available')
                                    <span class="badge bg-success-soft text-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Sẵn sàng
                                    </span>
                                @elseif($room->status == 'booked')
                                    <span class="badge bg-danger-soft text-danger px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Đã đặt
                                    </span>
                                @else
                                    <span class="badge bg-warning-soft text-warning px-3 py-2">
                                        <i class="fas fa-tools me-1"></i> Bảo trì
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-outline-primary border-0 shadow-none">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0 shadow-none" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Badge Styles cho chuyên nghiệp */
    .bg-success-soft { background-color: #e8fadf; color: #71dd37; }
    .bg-danger-soft { background-color: #ffe5e5; color: #ff3e1d; }
    .bg-warning-soft { background-color: #fff2d6; color: #ffab00; }
    .bg-soft-info { background-color: #e7f7ff; color: #03c3ec; }
    
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #8592a3;
    }
</style>
@endpush