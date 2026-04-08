<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class RevenueReportRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'hotel_keyword' => ['nullable', 'string', 'max:100'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'hotel_keyword' => trim((string) $this->input('hotel_keyword')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'start_date' => 'ngày bắt đầu',
            'end_date' => 'ngày kết thúc',
            'hotel_keyword' => 'từ khóa khách sạn',
        ];
    }
}
