<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseFormRequest;

class CheckRoomAvailabilityRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ];
    }

    public function attributes(): array
    {
        return [
            'check_in' => 'ngày nhận phòng',
            'check_out' => 'ngày trả phòng',
        ];
    }
}
