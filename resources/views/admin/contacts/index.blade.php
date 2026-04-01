@extends('layouts.admin')

@section('title', 'Quản lý liên hệ')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-envelope-open-text me-2 text-primary"></i>Tin nhắn liên hệ</h2>
            <p class="text-muted small mb-0">Quản lý các phản hồi và yêu cầu hỗ trợ từ khách hàng của CMC Travel.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold">Tổng tin nhắn</div>
                    <div class="fs-3 fw-bold text-dark">{{ $summary['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
                <div class="card-body">
                    <div class="text-white-50 small text-uppercase fw-bold">Chưa xử lý</div>
                    <div class="fs-3 fw-bold">{{ $summary['new'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Khách hàng</th>
                        <th>Tiêu đề</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $item)
                        <tr class="{{ $item->status === 'new' ? 'fw-bold' : '' }}">
                            <td class="ps-4">
                                <div class="fw-semibold">{{ $item->name }}</div>
                                <div class="small text-muted">{{ $item->email }}</div>
                            </td>
                            <td><span class="text-truncate d-inline-block" style="max-width: 250px;">{{ $item->subject ?? 'Không có tiêu đề' }}</span></td>
                            <td>{{ $item->created_at->format('H:i - d/m/Y') }}</td>
                            <td>
                                @if($item->status === 'new')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Mới</span>
                                @else
                                    <span class="badge bg-light text-muted px-3 py-2 rounded-pill">Đã đọc</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.contacts.show', $item->id) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                                    <form action="{{ route('admin.contacts.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa tin nhắn này?')">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Hộp thư hiện đang trống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection