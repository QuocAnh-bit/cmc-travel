<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseFormRequest;

class SearchHotelRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'name' => ['nullable', 'string', 'max:100'],
            'price_range' => ['nullable', 'in:under_1m,1m_3m,over_3m'],
            'sort' => ['nullable', 'in:price_asc,price_desc'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'search' => trim((string) $this->input('search')),
            'name' => trim((string) $this->input('name')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'search' => 'từ khóa tìm kiếm',
            'name' => 'tên khách sạn',
            'price_range' => 'khoảng giá',
            'sort' => 'sắp xếp',
        ];
    }
}
