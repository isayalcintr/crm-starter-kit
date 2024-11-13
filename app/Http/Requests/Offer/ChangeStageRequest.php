<?php

namespace App\Http\Requests\Offer;

use App\Enums\Offer\StageEnum;
use App\Enums\Offer\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStageRequest extends FormRequest
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
        $offer = $this->route('offer');

        if ($offer->getAttribute('status') != StatusEnum::PROCESSING->value) {
            return [
                'stage' => function ($attribute, $value, $fail) {
                    $fail('Teklif aşama değişimi için uygun değil.');
                },
            ];
        }
        return match ((int)$offer->getAttribute('stage')) {
            StageEnum::OFFER->value => [
                'stage' => 'required|int|in:' . StageEnum::APPROVAL->value,
            ],
            StageEnum::APPROVAL->value => [
                'stage' => 'required|int|in:' . implode(',', [StageEnum::CUSTOMER_APPROVAL->value, StageEnum::OFFER->value]),
            ],
            StageEnum::CUSTOMER_APPROVAL->value => [
                'stage' => 'required|int|in:' . implode(',', [StageEnum::ORDER->value, StageEnum::OFFER->value]),
            ],
            default => [
                'stage' => 'required|int',
            ],
        };
    }

    public function messages(): array
    {
        return [
            'asama.required' => 'Aşama alanı zorunludur.',
            'asama.int' => 'Aşama alanı geçerli bir tamsayı olmalıdır.',
            'asama.in' => 'Geçersiz aşama değeri. Bu aşamada sadece izin verilen değerlere geçiş yapabilirsiniz.',
        ];
    }
}
