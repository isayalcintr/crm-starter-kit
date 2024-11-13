<?php

namespace App\Http\Requests\Task;

use App\Enums\Task\PriorityEnum;
use App\Enums\Task\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'incumbent_by' => 'required|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'special_group1_id' => 'nullable|exists:groups,id',
            'special_group2_id' => 'nullable|exists:groups,id',
            'special_group3_id' => 'nullable|exists:groups,id',
            'special_group4_id' => 'nullable|exists:groups,id',
            'special_group5_id' => 'nullable|exists:groups,id',
            'priority' => 'required|integer|in:' . implode(',', array_column(PriorityEnum::cases(), 'value')),
            'status' => 'required|integer|in:' . implode(',', array_column(StatusEnum::cases(), 'value')),
        ];
    }
}
