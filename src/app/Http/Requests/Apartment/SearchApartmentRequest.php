<?php

namespace App\Http\Requests\Apartment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ApartmentType;
use App\Enums\ApartmentStatus;

class SearchApartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các rule cho form tìm kiếm (tất cả đều nullable)
     */
    public function rules(): array
    {
        return [
            'apartment_name' => ['nullable', 'string', 'max:255'],

            'type' => ['nullable', 'array'],
            'type.*' => [Rule::in(array_column(ApartmentType::cases(), 'value'))],

            'area_min' => ['nullable', 'integer', 'min:0'],
            'area_max' => ['nullable', 'integer', 'min:0', 'gte:area_min'],

            'status' => ['nullable', 'array'],
            'status.*' => [Rule::in(array_column(ApartmentStatus::cases(), 'value'))],

            'check_in_from' => ['nullable', 'date'],
            'check_in_to' => ['nullable', 'date', 'after_or_equal:check_in_from'],

            'check_out_from' => ['nullable', 'date'],
            'check_out_to' => ['nullable', 'date', 'after_or_equal:check_out_from'],
        ];
    }

    public function messages(): array
    {
        return [
            'apartment_name.string' => 'Tên căn hộ phải là chuỗi.',
            'apartment_name.max' => 'Tên căn hộ không vượt quá :max ký tự.',

            'type.array' => 'Kiểu phòng không hợp lệ.',
            'type.*.in' => 'Giá trị kiểu phòng không hợp lệ.',

            'area_min.integer' => 'Diện tích (từ) phải là số nguyên.',
            'area_min.min' => 'Diện tích (từ) phải ≥ :min.',
            'area_max.integer' => 'Diện tích (đến) phải là số nguyên.',
            'area_max.min' => 'Diện tích (đến) phải ≥ :min.',
            'area_max.gte' => 'Diện tích (đến) phải ≥ diện tích (từ).',

            'status.array' => 'Trạng thái không hợp lệ.',
            'status.*.in' => 'Giá trị trạng thái không hợp lệ.',

            'check_in_from.date' => 'Ngày nhận (từ) không hợp lệ.',
            'check_in_to.date' => 'Ngày nhận (đến) không hợp lệ.',
            'check_in_to.after_or_equal' => 'Ngày nhận (đến) phải sau hoặc bằng ngày nhận (từ).',

            'check_out_from.date' => 'Ngày trả (từ) không hợp lệ.',
            'check_out_to.date' => 'Ngày trả (đến) không hợp lệ.',
            'check_out_to.after_or_equal' => 'Ngày trả (đến) phải sau hoặc bằng ngày trả (từ).',
        ];
    }
}
