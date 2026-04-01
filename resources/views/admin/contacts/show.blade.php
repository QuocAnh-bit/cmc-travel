@extends('layouts.admin')

@section('title', 'Chi tiết liên hệ')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-primary">Nội dung tin nhắn</h5>
                        <span class="badge {{ $contact->status === 'new' ? 'bg-warning text-dark' : 'bg-light text-muted' }} px-3 py-2 rounded-pill">
                            {{ $contact->status === 'new' ? 'Tin nhắn mới' : 'Đã xem' }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h4 class="fw-bold text-dark mb-4">{{ $contact->subject ?? 'Không có tiêu đề' }}</h4>
                    
                    <div class="message-content p-4 rounded-4 bg-light border-start border-primary border-4 mb-4">
                        <p class="mb-0 text-secondary" style="line-height: 1.8; white-space: pre-wrap;">{{ $contact->message }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-reply me-2"></i> Phản hồi qua Email
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4" onclick="return confirm('Xác nhận xóa tin nhắn này?')">
                                <i class="fas fa-trash-alt me-2"></i> Xóa tin nhắn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-muted text-uppercase small mb-4">Thông tin người gửi</h6>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-circle-lg me-3 bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold;">
                            {{ substr($contact->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark fs-5">{{ $contact->name }}</div>
                            <div class="text-muted small">{{ $contact->email }}</div>
                        </div>
                    </div>

                    <div class="list-group list-group-flush small">
                        <div class="list-group-item px-0 py-3 d-flex justify-content-between border-0 border-bottom">
                            <span class="text-muted">Ngày gửi:</span>
                            <span class="fw-semibold text-dark">{{ $contact->created_at->format('H:i - d/m/Y') }}</span>
                        </div>
                        <div class="list-group-item px-0 py-3 d-flex justify-content-between border-0 border-bottom">
                            <span class="text-muted">ID Tin nhắn:</span>
                            <span class="fw-semibold text-dark">#{{ $contact->id }}</span>
                        </div>
                        <div class="list-group-item px-0 py-3 d-flex justify-content-between border-0">
                            <span class="text-muted">Trạng thái hiện tại:</span>
                            <span class="fw-semibold {{ $contact->status === 'new' ? 'text-warning' : 'text-success' }}">
                                {{ $contact->status === 'new' ? 'Chưa xử lý' : 'Đã đọc' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .message-content {
        font-size: 1.05rem;
        background-color: #f8f9fa;
    }
    .card { transition: transform 0.2s; }
</style>
@endsection