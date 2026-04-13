<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'required_with' => ':attribute là bắt buộc khi đã nhập :values.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'email' => ':attribute phải là địa chỉ email hợp lệ.',
            'max.string' => ':attribute không được vượt quá :max ký tự.',
            'max.numeric' => ':attribute không được lớn hơn :max.',
            'max.file' => ':attribute không được lớn hơn :max KB.',
            'min.string' => ':attribute phải có ít nhất :min ký tự.',
            'min.numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
            'min.file' => ':attribute phải có dung lượng ít nhất :min KB.',
            'integer' => ':attribute phải là số nguyên.',
            'numeric' => ':attribute phải là số.',
            'array' => ':attribute không đúng định dạng danh sách.',
            'date' => ':attribute không phải ngày hợp lệ.',
            'after' => ':attribute phải sau :date.',
            'after_or_equal' => ':attribute phải từ :date trở đi.',
            'before' => ':attribute phải trước :date.',
            'before_or_equal' => ':attribute phải trước hoặc bằng :date.',
            'in' => ':attribute không hợp lệ.',
            'exists' => ':attribute không tồn tại trong hệ thống.',
            'unique' => ':attribute đã tồn tại.',
            'confirmed' => ':attribute xác nhận không khớp.',
            'boolean' => ':attribute không hợp lệ.',
            'image' => ':attribute phải là tệp hình ảnh.',
            'mimes' => ':attribute phải có định dạng: :values.',
            'between.numeric' => ':attribute phải trong khoảng từ :min đến :max.',
            'regex' => ':attribute không đúng định dạng.',
            'password.min' => ':attribute phải có ít nhất :min ký tự.',
            'password.letters' => ':attribute phải chứa ít nhất một chữ cái.',
            'password.mixed' => ':attribute phải chứa cả chữ hoa và chữ thường.',
            'password.numbers' => ':attribute phải chứa ít nhất một chữ số.',
            'password.symbols' => ':attribute phải chứa ít nhất một ký tự đặc biệt.',
            'password.uncompromised' => ':attribute không an toàn, vui lòng chọn mật khẩu khác.',
        ];
    }
}
