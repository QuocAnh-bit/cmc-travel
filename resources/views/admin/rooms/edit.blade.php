@extends('layouts.admin')

@section('title', 'C?p nh?t phòng ngh?')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>C?p nh?t thông tin phòng</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Tên phòng</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $room->name) }}" placeholder="Ví d?: Phòng Deluxe Double" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thu?c khách s?n</label>
                        <select name="hotel_id" class="form-select shadow-sm @error('hotel_id') is-invalid @enderror" required>
                            <option value="">-- Ch?n khách s?n --</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}" {{ old('hotel_id', $room->hotel_id) == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                        @error('hotel_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá m?i dêm (VNÐ)</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $room->price) }}" required>
                        @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Gi?m giá (%)</label>
                        <input type="number" name="discount" class="form-control @error('discount') is-invalid @enderror" min="0" max="100" value="{{ old('discount', $room->discount) }}">
                        @error('discount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Mô t? chi ti?t phòng</label>
                        <textarea name="description" id="editor" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Nh?p gi?i thi?u chi ti?t v? phòng, quy d?nh...">{{ old('description', $room->description) }}</textarea>
                        @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Ti?n nghi (Ch?n nhi?u)</label>
                        <div class="d-flex flex-wrap gap-3 p-3 border rounded bg-light @error('amenities') border-danger @enderror">
                            @php 
                                $list_amenities = ['Wifi', 'Ði?u hòa', 'Tivi', 'T? l?nh', 'Ban công', 'B?n t?m', 'An sáng'];
                                $roomAmenities = old('amenities', $room->amenities ?? []);
                            @endphp
                            @foreach($list_amenities as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $item }}" id="check{{ $loop->index }}" {{ in_array($item, $roomAmenities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="check{{ $loop->index }}">{{ $item }}</label>
                            </div>
                            @endforeach
                        </div>
                        @error('amenities') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        @error('amenities.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Hình ?nh phòng</label>
                        <input type="file" name="image" class="form-control mb-2 @error('image') is-invalid @enderror">
                        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        @if($room->image)
                            <div class="mt-2 text-center border p-2 rounded bg-light">
                                <p class="small text-muted mb-1">?nh hi?n t?i:</p>
                                <img src="{{ asset('storage/' . $room->image) }}" style="max-height: 150px;" class="rounded shadow-sm">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">C?u hình khác</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>S?n sàng</option>
                                    <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Ðã d?t</option>
                                </select>
                                @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured', $room->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="isFeatured">Phòng n?i b?t</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-light border px-4">H?y b?</a>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm"><i class="fas fa-save me-1"></i> C?p nh?t ngay</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(error => { console.error(error); });
</script>
@endsection
