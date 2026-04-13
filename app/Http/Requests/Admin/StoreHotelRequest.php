<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class StoreHotelRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:hotels,name'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+()\-\s]+$/'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'address' => trim((string) $this->input('address')),
            'phone' => trim((string) $this->input('phone')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'name' => 'tên khách sạn',
            'address' => 'địa chỉ',
            'phone' => 'số điện thoại',
        ];
    }
}
