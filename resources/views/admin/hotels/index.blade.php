@extends('layouts.admin')

@section('title', 'Quản lý Khách Sạn')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Hệ thống Khách Sạn</h3>
            <p class="text-muted">Quản lý danh mục khách sạn và chi nhánh</p>
        </div>
        <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#addHotelModal">
            <i class="fas fa-plus me-2"></i>Thêm Khách Sạn
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Tên Khách Sạn</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th class="text-center">Số phòng</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hotels as $hotel)
                        <tr>
                            <td class="ps-4 text-muted">#{{ $hotel->id }}</td>
                            <td><span class="fw-bold text-dark">{{ $hotel->name }}</span></td>
                            <td><small class="text-secondary">{{ $hotel->address ?? 'Chưa cập nhật' }}</small></td>
                            <td>{{ $hotel->phone ?? '---' }}</td>
                            <td class="text-center">
                                <span class="badge bg-soft-primary text-primary">{{ $hotel->rooms_count }} phòng</span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" onsubmit="return confirm('Lưu ý: Xóa khách sạn sẽ xóa toàn bộ phòng thuộc khách sạn này. Tiếp tục?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Chưa có khách sạn nào được tạo.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addHotelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-hotel me-2"></i>Thêm Khách Sạn Mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.hotels.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Tên khách sạn <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-lg fs-6 @error('name') is-invalid @enderror" 
                               placeholder="Nhập tên khách sạn..." value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" placeholder="Quận, Thành phố..." value="{{ old('address') }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-secondary">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" placeholder="Số hotline..." value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Lưu dữ liệu</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .bg-soft-primary { background-color: #e7f1ff; color: #0d6efd; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1); }
</style>
@endpush

@push('scripts')
<script>
    // Tự động mở modal nếu có lỗi từ server (Validation)
    @if ($errors->any())
        var myModal = new bootstrap.Modal(document.getElementById('addHotelModal'));
        myModal.show();
    @endif
</script>
@endpush