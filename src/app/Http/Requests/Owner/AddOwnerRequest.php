<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cccd' => ['required','integer', Rule::unique('owner','cccd')],
            'full_name' => ['required','string','max:255'],
            'date_of_birth' => ['required','date'],
            'images' => ['nullable','array'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:5120'], // 5MB mỗi ảnh
        ];
    }

    public function messages(): array
    {
    return [
        'cccd.required' => 'Vui lòng nhập số CCCD.',
        'cccd.integer' => 'Số CCCD phải là số nguyên.',
        'cccd.unique' => 'Số CCCD này đã tồn tại.',

        'full_name.required' => 'Vui lòng nhập họ và tên.',
        'full_name.string' => 'Họ và tên phải là chuỗi ký tự.',
        'full_name.max' => 'Họ và tên không được vượt quá :max ký tự.',

        'date_of_birth.required' => 'Vui lòng chọn ngày sinh.',
        'date_of_birth.date' => 'Ngày sinh không hợp lệ.',

        'images.array' => 'Danh sách ảnh không hợp lệ.',
        'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
        'images.*.mimes' => 'Ảnh chỉ chấp nhận định dạng: jpg, jpeg, png, webp',
        'images.*.max' => 'Kích thước ảnh tối đa là :max KB.', // :max = 5120 => 5MB
    ];
    }
}
