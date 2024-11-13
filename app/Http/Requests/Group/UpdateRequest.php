<?php

namespace App\Http\Requests\Group;

use App\Enums\Group\SectionEnum;
use App\Enums\Group\TypeEnum;
use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'section' => 'required|integer|in:' . implode(',', array_column(SectionEnum::cases() , 'value')),
            'type' => 'required|integer|in:' . implode(',', array_column(TypeEnum::cases(), 'value')),
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Group::class, 'title')
                    ->where('section', $this->input('section'))
                    ->where('type', $this->input('type'))
                    ->ignore($this->route('group')->id)
            ],
            'order' =>'nullable|integer'
        ];
    }
}
