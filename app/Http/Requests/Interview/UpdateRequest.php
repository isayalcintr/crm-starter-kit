<?php

namespace App\Http\Requests\Interview;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:groups,id',
            'type_id' => 'required|exists:groups,id',
            'special_group1_id' => 'nullable|exists:groups,id',
            'special_group2_id' => 'nullable|exists:groups,id',
            'special_group3_id' => 'nullable|exists:groups,id',
            'special_group4_id' => 'nullable|exists:groups,id',
            'special_group5_id' => 'nullable|exists:groups,id',
        ];
    }
}
