<?php

namespace App\Http\Requests\Apartment;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\ContractExtension\ContractExtensionRepositoryInterface;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class ContractExtensionRequest extends FormRequest
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
            'rent_price' => ['required','integer','min:0'],
            'rent_start_time' => ['required','date'],
            'rent_end_time' => ['required','date','after_or_equal:rent_start_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'rent_price.required' => 'Vui lòng nhập tiền thuê.',
            'rent_end_time.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'rent_start_time.required' => 'Vui lòng nhập ngày bắt đầu.',
            'rent_end_time.required' => 'Vui lòng nhập ngày kết thúc.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            // Nếu rule cơ bản đã lỗi thì bỏ qua check nâng cao
            if ($v->errors()->isNotEmpty()) {
                return;
            }

            $apartmentId = $this->route('id');
            if (!$apartmentId) return;

            $contractExtensionRepo = app(ContractExtensionRepositoryInterface::class);

            // Max end trong bảng contract_extension
            $latestEnd = $contractExtensionRepo->getMaxEndByApartment($apartmentId);
            $minStart = $latestEnd->copy()->addDay()->startOfDay();
            $startInput = $this->input('rent_start_time');
            try {
                $start = Carbon::parse($startInput)->startOfDay();
            } catch (\Throwable $e) {

                return;
            }

            if ($start->lt($minStart)) {
                $v->errors()->add(
                    'rent_start_time',
                    'Ngày bắt đầu phải từ ' . $minStart->format('Y/m/d') . ' trở đi (nối đuôi hợp đồng gần nhất).'
                );
            }
        });
    }
}
