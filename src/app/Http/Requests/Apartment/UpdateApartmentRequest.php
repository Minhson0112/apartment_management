<?php

namespace App\Http\Requests\Apartment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
            'apartment_name'  => ['required','string','max:255'],
            'type' => ['required','in:1,2,3,4'],
            'area' => ['required','numeric','min:0'],
            'balcony_direction' => ['required','in:1,2,3,4,5,6,7,8'],
            'toilet_count' => ['required','numeric','min:1'],
            'apartment_owner' => ['required','digits_between:6,20','exists:owner,cccd'],
            'appliances_price' => ['nullable','integer','min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'apartment_name.required' => 'Vui lòng nhập tên căn hộ.',
            'type.required' => 'Vui lòng chọn kiểu phòng.',
            'type.in' => 'Kiểu phòng không hợp lệ.',
            'area.required' => 'Vui lòng nhập diện tích.',
            'area.numeric' => 'Diện tích phải là số.',
            'toilet_count.required' => 'Số lượng wc không được trống',
            'toilet_count.numeric' => 'Số lượng wc phải là số',
            'balcony_direction.required' => 'hướng không được trống',
            'apartment_owner.required' => 'Vui lòng nhập CCCD chủ hộ.',
            'apartment_owner.exists' => 'CCCD chủ hộ không tồn tại.',
        ];
    }
}
