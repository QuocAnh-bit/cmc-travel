@extends('layouts.admin')

@section('title', 'Danh sách phòng nghỉ')

@section('content')
<div class="container-fluid px-4 py-4">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="font-weight: bold; margin-bottom: 4px;"><i class="fas fa-bed" style="margin-right: 8px; color: #0d6efd;"></i>Quản lý Phòng nghỉ</h2>
            <p style="color: #6c757d; font-size: 0.875rem; margin: 0;">Danh sách chi tiết các hạng phòng thuộc hệ thống khách sạn</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary" style="padding: 8px 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-decoration: none;">
            <i class="fas fa-plus"></i> Thêm phòng mới
        </a>
    </div>

    <div style="background: #fff; border-radius: 12px; box-shadow: 0 0.125 perished 0.25rem rgba(0, 0, 0, 0.075); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; vertical-align: middle;">
                <thead style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                    <tr>
                        <th style="padding: 15px; text-align: left; color: #8592a3; font-size: 0.75rem; text-transform: uppercase;">Ảnh</th>
                        <th style="padding: 15px; text-align: left; color: #8592a3; font-size: 0.75rem; text-transform: uppercase;">Thông tin phòng</th>
                        <th style="padding: 15px; text-align: left; color: #8592a3; font-size: 0.75rem; text-transform: uppercase;">Khách sạn</th>
                        <th style="padding: 15px; text-align: left; color: #8592a3; font-size: 0.75rem; text-transform: uppercase;">Giá</th>
                        <th style="padding: 15px; text-align: center; color: #8592a3; font-size: 0.75rem; text-transform: uppercase;">Trạng thái</th>
                        <th style="padding: 15px; text-align: right; color: #8592a3; font-size: 0.75rem; text-transform: uppercase; width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr style="border-bottom: 1px solid #f0f2f4;">
                        <td style="padding: 15px;">
                            <img src="{{ Str::startsWith($room->image, ['http://', 'https://']) ? $room->image : asset('storage/' . $room->image) }}" 
                                 style="width: 60px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;"
                                 onerror="this.src='https://via.placeholder.com/150'">
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-weight: bold; color: #333;">{{ $room->name }}</div>
                        </td>
                        <td style="padding: 15px;">
                            <span style="background: #e7f7ff; color: #03c3ec; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                {{ $room->hotel->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td style="padding: 15px; font-weight: bold; color: #696cff;">
                            {{ number_format($room->price) }}đ
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            @if($room->status == 'available')
                                <span style="background: #e8fadf; color: #71dd37; padding: 5px 12px; border-radius: 6px; font-size: 12px;">Sẵn sàng</span>
                            @else
                                <span style="background: #ffe5e5; color: #ff3e1d; padding: 5px 12px; border-radius: 6px; font-size: 12px;">Đã đặt</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" 
                                   style="width: 32px; height: 32px; background: #e7e7ff; color: #696cff; display: flex; align-items: center; justify-content: center; border-radius: 6px; text-decoration: none;">
                                    <i class="fas fa-edit" style="font-size: 12px;"></i>
                                </a>

                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Xóa phòng này?')" 
                                            style="width: 32px; height: 32px; background: #ffe5e5; color: #ff3e1d; display: flex; align-items: center; justify-content: center; border-radius: 6px; border: none; cursor: pointer;">
                                        <i class="fas fa-trash" style="font-size: 12px;"></i>
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
@endsection