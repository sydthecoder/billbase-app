<?php

namespace App\Modules\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('product_categories', 'name')
                    ->where('organization_id', $this->user()->organization_id)
            ],
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('product_categories.messages.name_required'),
            'name.unique' => __('product_categories.messages.name_unique'),
        ];
    }

    public function attributes(): array
    {
        return __('product_categories.attributes');
    }
}