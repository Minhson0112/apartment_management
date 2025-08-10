<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchOwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cccd' => ['nullable', 'digits_between:6,20'],
            'full_name' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'mobile_number' => ['nullable', 'regex:/^[0-9]{8,15}$/'],
            'email' => ['nullable', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'cccd.digits_between' => 'CCCD phải từ :min đến :max chữ số.',
            'full_name.string' => 'Tên phải là chuỗi ký tự.',
            'full_name.max' => 'Tên không được vượt quá :max ký tự.',
            'date_from.date' => 'Ngày sinh (từ) không hợp lệ.',
            'date_to.date' => 'Ngày sinh (đến) không hợp lệ.',
            'date_to.after_or_equal' => 'Ngày sinh (đến) phải sau hoặc bằng ngày sinh (từ).',
            'mobile_number.regex' => 'Số điện thoại chỉ chứa số và từ 8 đến 15 chữ số.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá :max ký tự.',
        ];
    }
}
