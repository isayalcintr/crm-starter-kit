<?php

namespace App\Http\Requests\Customer;

use App\Enums\Group\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:customers,code,' . $this->route('customer')->id,
            'title' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'address1' => 'nullable|string|max:500',
            'address2' => 'nullable|string|max:500',
            'tax_number' => 'nullable|string|max:50',
            'tax_office' => 'nullable|string|max:255',
            'special_group1_id' => 'nullable|exists:groups,id',
            'special_group2_id' => 'nullable|exists:groups,id',
            'special_group3_id' => 'nullable|exists:groups,id',
            'special_group4_id' => 'nullable|exists:groups,id',
            'special_group5_id' => 'nullable|exists:groups,id',
            'type' => 'required|integer|in:' . implode(',', array_column(\App\Enums\Customer\TypeEnum::cases(), 'value')),
        ];
    }
}
