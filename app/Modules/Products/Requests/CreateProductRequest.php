<?php

namespace App\Modules\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_category_id' => 'nullable|integer|exists:product_categories,id',
            'name'                => 'required|string|max:150',
            'description'         => 'nullable|string',
            'price'               => 'required|numeric|min:0',
            'unit'                => 'nullable|string|max:50',
            'is_taxable'          => 'sometimes|boolean',
            'sku'                 => 'nullable|string|max:100',
            'status'              => 'sometimes|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('products.messages.name_required'),
            'price.required' => __('products.messages.price_required'),
            'price.numeric' => __('products.messages.price_numeric'),
            'price.min' => __('products.messages.price_min'),
            'product_category_id.exists' => __('products.messages.category_exists'),
            'sku.unique' => __('products.messages.sku_unique'),
        ];
    }

    public function attributes(): array
    {
        return __('products.attributes');
    }
}