<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends BaseFormRequest
{
    protected array $allowedAmenities = [
        'Wifi',
        'Điều hòa',
        'Tivi',
        'Tủ lạnh',
        'Ban công',
        'Bồn tắm',
        'Ăn sáng',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'hotel_id' => ['required', 'integer', 'exists:hotels,id'],
            'price' => ['required', 'integer', 'min:0'],
            'discount' => ['nullable', 'integer', 'between:0,100'],
            'description' => ['nullable', 'string', 'max:5000'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', Rule::in($this->allowedAmenities)],
            'status' => ['nullable', 'in:available,booked'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'description' => trim(strip_tags((string) $this->input('description'))),
            'status' => $this->input('status', 'available'),
            'is_featured' => $this->boolean('is_featured'),
            'discount' => $this->filled('discount') ? $this->input('discount') : 0,
        ]);
    }

    public function attributes(): array
    {
        return [
            'name' => 'tên phòng',
            'hotel_id' => 'khách sạn',
            'price' => 'giá mỗi đêm',
            'discount' => 'giảm giá',
            'description' => 'mô tả phòng',
            'amenities' => 'tiện nghi',
            'amenities.*' => 'tiện nghi',
            'status' => 'trạng thái phòng',
            'is_featured' => 'cờ nổi bật',
            'image' => 'hình ảnh',
        ];
    }
}
