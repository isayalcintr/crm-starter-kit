<?php

namespace App\Http\Requests\Product;

use App\Enums\Product\TypeEnum;
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
            'code' => 'required|unique:products,id,'.$this->route('product')->id,
            'name' => 'required|string|max:255',
            'unit_id' => 'required|integer|exists:units,id',
            'purchase_vat_rate' => 'required|decimal:5,2',
            'purchase_price' => 'required|decimal:18,6',
            'sell_vat_rate' => 'required|decimal:5,2',
            'sell_price' => 'required|decimal:18,6',
            'quantity' => 'required|decimal:18,6',
            'special_group1' => 'nullable|exists:groups,id',
            'special_group2' => 'nullable|exists:groups,id',
            'special_group3' => 'nullable|exists:groups,id',
            'special_group4' => 'nullable|exists:groups,id',
            'special_group5' => 'nullable|exists:groups,id',
            'type' => 'required|in:' . implode(',', array_column(TypeEnum::cases(), 'value')),
        ];
    }
}
