@extends('layouts.admin')

@section('title', 'Danh sách phòng nghỉ')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-bed me-2 text-primary"></i>Quản lý Phòng nghỉ</h2>
            <p class="text-muted small mb-0">Danh sách chi tiết các hạng phòng thuộc hệ thống khách sạn</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-dark shadow-sm px-4 rounded-3 d-flex align-items-center">
            <i class="fas fa-plus me-2"></i> <span class="small fw-bold text-uppercase">Thêm phòng mới</span>
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Ảnh</th>
                        <th>Thông tin phòng</th>
                        <th>Khách sạn</th>
                        <th>Giá/Đêm</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td class="ps-4">
                            <div class="room-img-container">
                                <img src="{{ Str::startsWith($room->image, ['http://', 'https://']) ? $room->image : asset('storage/' . $room->image) }}" 
                                     alt="{{ $room->name }}"
                                     onerror="this.src='https://via.placeholder.com/150'">
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-6">{{ $room->name }}</div>
                            <div class="small text-muted">ID: #{{ $room->id }}</div>
                        </td>
                        <td>
                            <span class="badge-hotel">
                                <i class="fas fa-building me-1 opacity-50"></i>{{ $room->hotel->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="price-tag text-primary">{{ number_format($room->price) }}đ</span>
                        </td>
                        <td class="text-center">
                            <span class="status-badge status-{{ $room->status == 'available' ? 'confirmed' : 'cancelled' }}">
                                {{ $room->status == 'available' ? 'Sẵn sàng' : 'Đã đặt' }}
                            </span>
                        </td>
                        <td class="pe-4">
                            <div class="action-btn-group">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn-lux btn-lux-view" data-label="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-lux btn-lux-danger" data-label="Xóa phòng" 
                                            onclick="return confirm('Bạn chắc chắn muốn xóa phòng này?')">
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

<style>
/* --- ĐỒNG BỘ LUXURY STYLE --- */
:root {
    --primary-color: #4f46e5;
    --success-soft: #ecfdf5; --success-bold: #10b981;
    --danger-soft: #fef2f2; --danger-bold: #ef4444;
}

/* Header Table */
.table thead th {
    background: #f8fafc !important;
    color: #64748b !important;
    font-size: 0.7rem !important;
    font-weight: 800 !important;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 18px 20px !important;
    border-bottom: 1px solid #edf2f7 !important;
}

/* Room Image */
.room-img-container {
    width: 65px; height: 48px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #fff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}
.room-img-container img {
    width: 100%; height: 100%;
    object-fit: cover;
}

/* Badge Khách sạn */
.badge-hotel {
    padding: 5px 10px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* Giá tiền */
.price-tag { font-family: 'Inter', sans-serif; font-weight: 800; }

/* Trạng thái (Đồng bộ với các trang trước) */
.status-badge {
    padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;
    display: inline-flex; align-items: center; gap: 6px;
}
.status-confirmed { background: var(--success-soft); color: var(--success-bold); }
.status-cancelled { background: var(--danger-soft); color: var(--danger-bold); }
.status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

/* --- ACTION BUTTONS --- */
.action-btn-group { display: flex; gap: 8px; justify-content: flex-end; }
.btn-lux {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px; border: none;
    background: #f1f5f9; color: #64748b;
    transition: all 0.3s ease; position: relative;
}
.btn-lux:hover { transform: translateY(-2px); box-shadow: 0 5px 10px rgba(0,0,0,0.05); }
.btn-lux-view:hover { background: #eef2ff !important; color: #4f46e5 !important; }
.btn-lux-danger:hover { background: var(--danger-soft) !important; color: var(--danger-bold) !important; }

/* Tooltip Labels */
.btn-lux::after {
    content: attr(data-label);
    position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%);
    background: #1e293b; color: #fff; padding: 4px 8px;
    font-size: 10px; border-radius: 5px; margin-bottom: 8px;
    opacity: 0; pointer-events: none; transition: 0.2s; white-space: nowrap;
}
.btn-lux:hover::after { opacity: 1; bottom: 120%; }
</style>
@endsection