@extends('layouts.admin')

@section('title', 'Quản lý Khách Sạn')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-hotel me-2 text-primary"></i>Hệ thống Khách Sạn</h2>
            <p class="text-muted small mb-0">Quản lý danh mục khách sạn, chi nhánh và số lượng phòng trực thuộc.</p>
        </div>
        <button class="btn btn-dark shadow-sm px-4 rounded-3 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addHotelModal">
            <i class="fas fa-plus me-2"></i> <span class="small fw-bold text-uppercase">Thêm Khách Sạn</span>
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4"><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Thông tin khách sạn</th>
                        <th>Địa chỉ</th>
                        <th>Hotline</th>
                        <th class="text-center">Quy mô</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hotels as $hotel)
                    <tr>
                        <td class="ps-4 fw-bold text-muted">#{{ $hotel->id }}</td>
                        <td>
                            <div class="fw-bold text-dark fs-6">{{ $hotel->name }}</div>
                            <div class="small text-primary fw-medium">Chi nhánh cao cấp</div>
                        </td>
                        <td>
                            <div class="small text-muted text-truncate" style="max-width: 250px;">
                                <i class="fas fa-map-marker-alt me-1 text-danger opacity-50"></i>{{ $hotel->address ?? 'Chưa cập nhật địa chỉ' }}
                            </div>
                        </td>
                        <td><span class="fw-semibold text-dark small">{{ $hotel->phone ?? '---' }}</span></td>
                        <td class="text-center"><span class="badge-room"><i class="fas fa-door-open me-1"></i> {{ $hotel->rooms_count }} phòng</span></td>
                        <td class="pe-4">
                            <div class="action-btn-group">
                                <button class="btn-lux btn-lux-view" data-label="Chỉnh sửa"><i class="fas fa-pen-nib"></i></button>
                                <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" class="m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-lux btn-lux-danger" data-label="Xóa hệ thống" onclick="return confirm('Lưu ý: Xóa khách sạn sẽ xóa toàn bộ phòng thuộc khách sạn này. Tiếp tục?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted small">Không tìm thấy dữ liệu khách sạn.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addHotelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-white pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-plus-circle me-2 text-primary"></i>Khai báo Khách Sạn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.hotels.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Tên thương hiệu <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-lux @error('name') is-invalid @enderror" placeholder="VD: Grand Plaza Hotel" value="{{ old('name') }}" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Địa chỉ chi tiết</label>
                        <textarea name="address" class="form-control form-control-lux @error('address') is-invalid @enderror" rows="2" placeholder="Số nhà, đường, quận, thành phố...">{{ old('address') }}</textarea>
                        @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-muted">Hotline liên hệ</label>
                        <input type="text" name="phone" class="form-control form-control-lux @error('phone') is-invalid @enderror" placeholder="090xxx" value="{{ old('phone') }}">
                        @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light-soft p-4">
                    <button type="button" class="btn btn-light px-4 rounded-3 fw-bold small" data-bs-dismiss="modal">HỦY BỎ</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold small shadow-sm">LƯU DỮ LIỆU</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
:root { --primary-color: #4f46e5; --danger-soft: #fef2f2; --danger-bold: #ef4444; }
.table thead th { background: #f8fafc !important; color: #64748b !important; font-size: 0.7rem !important; font-weight: 800 !important; text-transform: uppercase; letter-spacing: 0.1em; padding: 18px 20px !important; }
.badge-room { padding: 6px 12px; background: #eef2ff; color: #4f46e5; border-radius: 8px; font-size: 0.75rem; font-weight: 700; }
.form-control-lux { border-radius: 10px; border: 1px solid #e2e8f0; padding: 12px 15px; font-size: 0.9rem; transition: all 0.3s; }
.form-control-lux:focus { border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }
.action-btn-group { display: flex; gap: 8px; justify-content: flex-end; }
.btn-lux { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; border: none; background: #f1f5f9; color: #64748b; transition: all 0.3s ease; position: relative; }
.btn-lux:hover { transform: translateY(-2px); box-shadow: 0 5px 10px rgba(0,0,0,0.05); }
.btn-lux-view:hover { background: #eef2ff !important; color: #4f46e5 !important; }
.btn-lux-danger:hover { background: var(--danger-soft) !important; color: var(--danger-bold) !important; }
.btn-lux::after { content: attr(data-label); position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); background: #1e293b; color: #fff; padding: 4px 8px; font-size: 10px; border-radius: 5px; margin-bottom: 8px; opacity: 0; pointer-events: none; transition: 0.2s; white-space: nowrap; }
.btn-lux:hover::after { opacity: 1; bottom: 120%; }
.bg-light-soft { background-color: #f8fafc; }
</style>
@endsection