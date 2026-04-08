<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class BookingIndexRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:pending,confirmed,cancelled'],
            'check_in_from' => ['nullable', 'date'],
            'check_in_to' => ['nullable', 'date', 'after_or_equal:check_in_from'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'keyword' => trim((string) $this->input('keyword')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'keyword' => 'từ khóa',
            'status' => 'trạng thái',
            'check_in_from' => 'từ ngày',
            'check_in_to' => 'đến ngày',
        ];
    }
}
