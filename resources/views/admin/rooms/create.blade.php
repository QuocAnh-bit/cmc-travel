@extends('layouts.admin')

@section('title', 'Thêm phòng nghỉ mới')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm" style="border-radius: 15px text-decoration-none;">
                {{-- Card Header --}}
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Thêm phòng nghỉ mới
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            {{-- Tên phòng --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-secondary">Tên phòng nghỉ <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg fs-6 @error('name') is-invalid @enderror" 
                                       placeholder="Ví dụ: Phòng Deluxe hướng biển" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Chọn Khách sạn & Giá --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary">Chọn Khách sạn (Danh mục) <span class="text-danger">*</span></label>
                                <select name="hotel_id" class="form-select @error('hotel_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn khách sạn sở hữu --</option>
                                    @foreach($hotels as $hotel)
                                        <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                            {{ $hotel->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('hotel_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary">Giá mỗi đêm (VNĐ) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                           placeholder="Ví dụ: 750000" value="{{ old('price') }}" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- MÔ TẢ CHI TIẾT (Bổ sung mới) --}}
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Mô tả chi tiết phòng nghỉ</label>
                                <textarea name="description" id="editor_create" class="form-control" rows="6" 
                                          placeholder="Giới thiệu chi tiết về diện tích, nội thất, view phòng...">{{ old('description') }}</textarea>
                                <div class="form-text mt-2 text-muted">
                                    <i class="fas fa-info-circle me-1"></i> Một mô tả chi tiết sẽ giúp khách hàng dễ dàng đưa ra quyết định đặt phòng hơn.
                                </div>
                            </div>

                            {{-- Tiện nghi --}}
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Tiện nghi có sẵn</label>
                                <div class="d-flex flex-wrap gap-3 p-3 border rounded-3 bg-light shadow-sm">
                                    @php 
                                        $amenities_list = ['Wifi', 'Điều hòa', 'Tivi', 'Tủ lạnh', 'Ban công', 'Bồn tắm', 'Ăn sáng'];
                                    @endphp
                                    @foreach($amenities_list as $item)
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" 
                                               value="{{ $item }}" id="amenity_{{ $loop->index }}"
                                               {{ is_array(old('amenities')) && in_array($item, old('amenities')) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark" for="amenity_{{ $loop->index }}">
                                            {{ $item }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Hình ảnh --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">Hình ảnh đại diện phòng</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Trạng thái & Nổi bật --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">Tùy chọn hiển thị</label>
                                <div class="d-flex gap-4 align-items-center h-75 p-2 border rounded bg-white">
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="switchFeatured" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="switchFeatured">Phòng nổi bật</label>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statusAvail" value="available" checked>
                                        <label class="form-check-label" for="statusAvail">Sẵn sàng</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Buttons --}}
                        <hr class="my-4 opacity-25">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-light px-4 border shadow-sm">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary px-5 shadow">
                                <i class="fas fa-save me-2"></i>Lưu phòng nghỉ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Script để tích hợp bộ soạn thảo CKEditor 5 --}}
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor_create'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection