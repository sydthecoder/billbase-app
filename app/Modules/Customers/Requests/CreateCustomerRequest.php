<?php

namespace App\Modules\Customers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name'       => 'nullable|string|max:150',
            'company_reg_number' => 'nullable|string|max:100',
            'vat_number'         => 'nullable|string|max:100',
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'email'              => [
                'required',
                'email',
                'max:150',
                Rule::unique('customers', 'email')
                    ->where('organization_id', $this->user()->organization_id)
            ],
            'phone'              => 'nullable|string|max:50',
            'street_address'     => 'nullable|string|max:255',
            'suburb'             => 'nullable|string|max:100',
            'city'               => 'nullable|string|max:100',
            'province'           => 'nullable|in:' . implode(',', array_keys(config('lookup.provinces'))),
            'postal_code'        => 'nullable|string|max:10',
            'notes'              => 'nullable|string',
            'status'             => 'sometimes|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('customers.messages.first_name_required'),
            'last_name.required'  => __('customers.messages.last_name_required'),
            'email.required'      => __('customers.messages.email_required'),
            'email.email'         => __('customers.messages.email_email'),
            'email.unique'        => __('customers.messages.email_unique'),
            'province.in'         => __('customers.messages.province_in'),
            'status.in'           => __('customers.messages.status_in'),
        ];
    }

    public function attributes(): array
    {
        return __('customers.attributes');
    }
}