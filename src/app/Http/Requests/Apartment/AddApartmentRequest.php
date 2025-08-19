<?php

namespace App\Http\Requests\Apartment;

use Illuminate\Foundation\Http\FormRequest;

class AddApartmentRequest extends FormRequest
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
            'rent_price' => ['required','integer','min:0'],
            'rent_start_time' => ['required','date'],
            'rent_end_time' => ['required','date','after_or_equal:rent_start_time'],

            'images' => ['nullable','array'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:5120'],
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
            'rent_price.required' => 'Vui lòng nhập tiền thuê.',
            'rent_end_time.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Ảnh chỉ hỗ trợ: jpg, jpeg, png, webp.',
            'images.*.max' => 'Kích thước ảnh tối đa 5MB.',
        ];
    }
}
