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
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stats-icon bg-light-blue me-3">
                        <i class="fas fa-inbox text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Tổng tin nhắn</div>
                        <div class="fs-3 fw-bold text-dark">{{ $summary['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stats-icon bg-white-20 me-3">
                        <i class="fas fa-bell text-white"></i>
                    </div>
                    <div>
                        <div class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Chưa xử lý</div>
                        <div class="fs-3 fw-bold">{{ $summary['new'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Khách hàng</th>
                        <th>Tiêu đề</th>
                        <th>Ngày gửi</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $item)
                        <tr class="{{ $item->status === 'new' ? 'row-new' : '' }}">
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->name }}</div>
                                <div class="small text-muted fw-normal">{{ $item->email }}</div>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block text-dark fw-medium" style="max-width: 280px;">
                                    {{ $item->subject ?? 'Không có tiêu đề' }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-muted fw-bold">{{ $item->created_at->format('H:i') }}</div>
                                <div class="small text-muted opacity-75">{{ $item->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="status-badge status-{{ $item->status === 'new' ? 'pending' : 'read' }}">
                                    {{ $item->status === 'new' ? 'Tin mới' : 'Đã đọc' }}
                                </span>
                            </td>
                            <td class="pe-4">
                                <div class="action-btn-group">
                                    <a href="{{ route('admin.contacts.show', $item->id) }}" 
                                       class="btn-lux btn-lux-view" data-label="Xem nội dung">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form action="{{ route('admin.contacts.destroy', $item->id) }}" method="POST" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-lux btn-lux-danger" data-label="Xóa bỏ" 
                                                onclick="return confirm('Xóa vĩnh viễn tin nhắn này?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-comment-slash fs-1 text-muted opacity-25 mb-3"></i>
                                    <p class="text-muted small">Hộp thư hiện đang trống.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* --- ĐỒNG BỘ LUXURY SYSTEM --- */
:root {
    --primary-color: #4f46e5;
    --success-soft: #ecfdf5; --success-bold: #10b981;
    --warning-soft: #fffbeb; --warning-bold: #f59e0b;
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
}

/* Highlight tin nhắn mới */
.row-new { background-color: rgba(79, 70, 229, 0.02); }

/* Stats Icon */
.stats-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
}
.bg-light-blue { background: #eef2ff; }
.bg-white-20 { background: rgba(255,255,255,0.2); }

/* Status Badges */
.status-badge {
    padding: 6px 14px; border-radius: 8px; font-size: 0.7rem; font-weight: 800;
    display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase;
}
.status-pending { background: var(--warning-soft); color: var(--warning-bold); }
.status-read { background: #f1f5f9; color: #64748b; }
.status-badge::before { content: ''; width: 4px; height: 4px; border-radius: 50%; background: currentColor; }

/* --- ACTION BUTTONS (ĐỒNG BỘ) --- */
.action-btn-group { display: flex; gap: 8px; justify-content: flex-end; }
.btn-lux {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px; border: none;
    background: #f1f5f9; color: #64748b;
    transition: all 0.3s ease; position: relative;
    text-decoration: none;
}
.btn-lux:hover { transform: translateY(-2px); box-shadow: 0 5px 10px rgba(0,0,0,0.05); }
.btn-lux-view:hover { background: #eef2ff !important; color: #4f46e5 !important; }
.btn-lux-danger:hover { background: var(--danger-soft) !important; color: var(--danger-bold) !important; }

/* Tooltip */
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