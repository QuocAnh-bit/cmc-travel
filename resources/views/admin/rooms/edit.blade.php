@extends('layouts.admin')

@section('title', 'Cập nhật phòng nghỉ')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Cập nhật thông tin phòng</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Tên phòng --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Tên phòng</label>
                        <input type="text" name="name" class="form-control" value="{{ $room->name }}" placeholder="Ví dụ: Phòng Deluxe Double" required>
                    </div>

                    {{-- Khách sạn --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thuộc Khách sạn (Danh mục)</label>
                        <select name="hotel_id" class="form-select shadow-sm" required>
                            <option value="">-- Chọn khách sạn --</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}" {{ $room->hotel_id == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Giá --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá mỗi đêm (VNĐ)</label>
                        <input type="number" name="price" class="form-control" value="{{ $room->price }}" required>
                    </div>

                    {{-- MÔ TẢ (Trường mới bổ sung) --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Mô tả chi tiết phòng</label>
                        <textarea name="description" id="editor" class="form-control" rows="5" placeholder="Nhập giới thiệu chi tiết về phòng, quy định...">{{ $room->description }}</textarea>
                        <small class="text-muted">Mô tả giúp khách hàng hiểu rõ hơn về không gian và dịch vụ của phòng.</small>
                    </div>

                    {{-- Tiện ích --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Tiện nghi (Chọn nhiều)</label>
                        <div class="d-flex flex-wrap gap-3 p-3 border rounded bg-light">
                            @php 
                                $list_amenities = ['Wifi', 'Điều hòa', 'Tivi', 'Tủ lạnh', 'Ban công', 'Bồn tắm'];
                                $room_amenities = $room->amenities ?? [];
                            @endphp
                            @foreach($list_amenities as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $item }}" 
                                    id="check{{ $loop->index }}" {{ in_array($item, $room_amenities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="check{{ $loop->index }}">{{ $item }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Hình ảnh --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Hình ảnh phòng</label>
                        <input type="file" name="image" class="form-control mb-2">
                        @if($room->image)
                            <div class="mt-2 text-center border p-2 rounded bg-light">
                                <p class="small text-muted mb-1">Ảnh hiện tại:</p>
                                <img src="{{ asset('storage/' . $room->image) }}" style="max-height: 150px;" class="rounded shadow-sm">
                            </div>
                        @endif
                    </div>

                    {{-- Trạng thái & Nổi bật --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Cấu hình khác</label>
                        <div class="row">
                            <div class="col-6">
                                <select name="status" class="form-select">
                                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Sẵn sàng</option>
                                    <option value="booked" {{ $room->status == 'booked' ? 'selected' : '' }}>Đã đặt</option>
                                </select>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ $room->is_featured ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="isFeatured">Phòng nổi bật</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-light border px-4">Hủy bỏ</a>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-save me-1"></i> Cập nhật ngay
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Script để tích hợp bộ soạn thảo văn bản cho đẹp (Tùy chọn) --}}
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(error => { console.error(error); });
</script>
@endsection