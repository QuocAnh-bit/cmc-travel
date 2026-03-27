@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid px-4 py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-bold text-primary">Danh sách người dùng</h5>
    
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm px-3 d-flex align-items-center" style="border-radius: 8px;">
        <i class="fas fa-user-plus me-1"></i> 
        <span>Thêm người dùng</span>
    </a>
</div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">ID</th>
                            <th class="py-3">Người dùng</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Vai trò</th>
                            <th class="py-3">Trạng thái</th>
                            <th class="py-3 text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px; font-weight: 600;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-info-subtle text-info border border-info px-3">Quản trị viên</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3">Khách hàng</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success-subtle text-success border border-success px-3 text-uppercase" style="font-size: 0.75rem;">Hoạt động</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-3 text-uppercase" style="font-size: 0.75rem;">Đã khóa</span>
                                @endif
                            </td>
                            <td class="text-end">
                               <div class="d-flex justify-content-end gap-2">
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $user->status == 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}" style="min-width: 90px;">
                                            <i class="fas {{ $user->status == 'active' ? 'fa-lock' : 'fa-lock-open' }} me-1"></i>
                                            {{ $user->status == 'active' ? 'Khóa' : 'Mở' }}
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                        <i class="fas fa-edit me-1"></i> Sửa
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center" onclick="return confirm('Xóa vĩnh viễn người dùng này?')">
                                            <i class="fas fa-trash-alt me-1"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Không có người dùng nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection