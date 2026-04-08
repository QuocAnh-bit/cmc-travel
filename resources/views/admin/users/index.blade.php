@extends('layouts.admin')

@section('title', 'Quan ly nguoi dung')

@section('content')
<div class="container-fluid px-4 py-4">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-0">
            <h5 class="mb-0 fw-bold text-dark">Danh sach nguoi dung</h5>
            
            <a href="{{ route('admin.users.create') }}" class="btn btn-dark px-3 rounded-3 shadow-sm d-flex align-items-center">
                <i class="fas fa-user-plus me-2"></i> 
                <span class="small fw-bold text-uppercase" style="letter-spacing: 1px;">Them nguoi dung</span>
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nguoi dung</th>
                            <th>Email</th>
                            <th>Vai tro</th>
                            <th>Trang thai</th>
                            <th class="text-end pe-4">Thao tac</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td>
                                <span class="badge-lux {{ $user->role == 'admin' ? 'badge-admin' : 'badge-user' }}">
                                    {{ $user->role == 'admin' ? 'Quan tri' : 'Khach hang' }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $user->status == 'active' ? 'confirmed' : 'cancelled' }}">
                                    {{ $user->status == 'active' ? 'Hoat dong' : 'Da khoa' }}
                                </span>
                            </td>
                            <td class="pe-4">
                                <div class="action-btn-group">
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn-lux {{ $user->status == 'active' ? 'btn-lux-cancel' : 'btn-lux-confirm' }}" 
                                                data-label="{{ $user->status == 'active' ? 'Khoa' : 'Mo khoa' }}">
                                            <i class="fas {{ $user->status == 'active' ? 'fa-lock' : 'fa-lock-open' }}"></i>
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-lux btn-lux-view" data-label="Chinh sua">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-lux btn-lux-danger" data-label="Xoa bo" 
                                                onclick="return confirm('Xoa vinh vien nguoi dung nay?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Danh sach nguoi dung trong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0 py-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --lux-primary: #4f46e5;
    --success-soft: #ecfdf5; --success-bold: #10b981;
    --warning-soft: #fffbeb; --warning-bold: #f59e0b;
    --danger-soft: #fef2f2; --danger-bold: #ef4444;
}

.table thead th {
    background: #f8fafc !important;
    color: #64748b !important;
    font-size: 0.7rem !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 16px 20px !important;
}

.avatar-circle {
    width: 35px; height: 35px;
    background: #f1f5f9; color: #475569;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 0.8rem;
    border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.badge-lux {
    padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
}
.badge-admin { background: #e0e7ff; color: #4338ca; }
.badge-user { background: #f1f5f9; color: #475569; }

.status-badge {
    padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;
    display: inline-flex; align-items: center; gap: 6px;
}
.status-confirmed { background: var(--success-soft); color: var(--success-bold); }
.status-cancelled { background: var(--danger-soft); color: var(--danger-bold); }
.status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

.action-btn-group { display: flex; gap: 8px; justify-content: flex-end; }

.btn-lux {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px; border: none;
    background: #f1f5f9; color: #64748b;
    transition: all 0.3s ease;
    text-decoration: none; position: relative;
}

.btn-lux:hover { transform: translateY(-2px); box-shadow: 0 5px 10px rgba(0,0,0,0.05); }
.btn-lux-view:hover { background: #eef2ff !important; color: #4f46e5 !important; }
.btn-lux-confirm:hover { background: #ecfdf5 !important; color: #10b981 !important; }
.btn-lux-cancel:hover { background: #fffbeb !important; color: #f59e0b !important; }
.btn-lux-danger:hover { background: #fef2f2 !important; color: #ef4444 !important; }

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
