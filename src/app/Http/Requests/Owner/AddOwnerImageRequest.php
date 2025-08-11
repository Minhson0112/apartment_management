<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddOwnerImageRequest extends FormRequest
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
            'images' => ['nullable','array'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:5120'], // 5MB mỗi ảnh
        ];
    }

    public function messages(): array
    {
        return [
            'images.array' => 'Danh sách ảnh không hợp lệ.',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Ảnh chỉ chấp nhận định dạng: jpg, jpeg, png, webp',
            'images.*.max' => 'Kích thước ảnh tối đa là :max KB.', // :max = 5120 => 5MB
        ];
    }
}
