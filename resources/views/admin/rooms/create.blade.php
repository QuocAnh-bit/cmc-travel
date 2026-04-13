@extends('layouts.admin')

@section('title', 'Thêm phòng ngh? m?i')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm" style="border-radius: 15px text-decoration-none;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-plus-circle me-2"></i>Thêm phòng ngh? m?i</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-secondary">Tên phòng ngh? <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg fs-6 @error('name') is-invalid @enderror" placeholder="Ví d?: Phòng Deluxe hu?ng bi?n" value="{{ old('name') }}" required>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary">Ch?n khách s?n <span class="text-danger">*</span></label>
                                <select name="hotel_id" class="form-select @error('hotel_id') is-invalid @enderror" required>
                                    <option value="">-- Ch?n khách s?n s? h?u --</option>
                                    @foreach($hotels as $hotel)
                                        <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                                @error('hotel_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary">Giá m?i dêm (VNÐ) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Ví d?: 750000" value="{{ old('price') }}" required>
                                    <span class="input-group-text">d</span>
                                </div>
                                @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary">Gi?m giá (%)</label>
                                <input type="number" name="discount" class="form-control @error('discount') is-invalid @enderror" min="0" max="100" value="{{ old('discount', 0) }}">
                                @error('discount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Mô t? chi ti?t phòng ngh?</label>
                                <textarea name="description" id="editor_create" class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Gi?i thi?u chi ti?t v? di?n tích, n?i th?t, view phòng...">{{ old('description') }}</textarea>
                                @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Ti?n nghi có s?n</label>
                                <div class="d-flex flex-wrap gap-3 p-3 border rounded-3 bg-light shadow-sm @error('amenities') border-danger @enderror">
                                    @php $amenities_list = ['Wifi', 'Ði?u hòa', 'Tivi', 'T? l?nh', 'Ban công', 'B?n t?m', 'An sáng']; @endphp
                                    @foreach($amenities_list as $item)
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $item }}" id="amenity_{{ $loop->index }}" {{ is_array(old('amenities')) && in_array($item, old('amenities')) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark" for="amenity_{{ $loop->index }}">{{ $item }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('amenities') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                @error('amenities.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">Hình ?nh d?i di?n phòng</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">Tùy ch?n hi?n th?</label>
                                <div class="d-flex gap-4 align-items-center h-75 p-2 border rounded bg-white @error('status') border-danger @enderror">
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="switchFeatured" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="switchFeatured">Phòng n?i b?t</label>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statusAvail" value="available" {{ old('status', 'available') === 'available' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusAvail">S?n sàng</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statusBooked" value="booked" {{ old('status') === 'booked' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusBooked">Ðã d?t</label>
                                    </div>
                                </div>
                                @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-light px-4 border shadow-sm">H?y b?</a>
                            <button type="submit" class="btn btn-primary px-5 shadow"><i class="fas fa-save me-2"></i>Luu phòng ngh?</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor_create'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
    }).catch(error => console.error(error));
</script>
@endsection
