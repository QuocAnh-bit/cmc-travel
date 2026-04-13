<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseFormRequest;

class HotelAvailabilityFilterRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'check_in' => ['nullable', 'required_with:check_out', 'date', 'after_or_equal:today'],
            'check_out' => ['nullable', 'required_with:check_in', 'date', 'after:check_in'],
            'room' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'check_in' => 'ngày nhận phòng',
            'check_out' => 'ngày trả phòng',
            'room' => 'phòng',
        ];
    }
}
