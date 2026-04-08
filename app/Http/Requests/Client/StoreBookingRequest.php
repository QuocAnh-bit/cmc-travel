<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseFormRequest;

class StoreBookingRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ];
    }

    public function attributes(): array
    {
        return [
            'room_id' => 'phòng',
            'check_in' => 'ngày nhận phòng',
            'check_out' => 'ngày trả phòng',
        ];
    }
}
