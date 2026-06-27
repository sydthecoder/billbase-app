<?php

namespace App\Modules\Settings\Requests;

use App\Models\OrganizationMailSetting;
use Illuminate\Foundation\Http\FormRequest;

class SaveMailSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $existing = OrganizationMailSetting::where('organization_id', $this->user()->organization_id)->first();

        $passwordRule = $existing ? 'nullable' : 'required';

        return [
            'from_name'         => 'required|max:150',
            'from_email'        => 'required|email',
            'config.host'       => 'required',
            'config.port'       => 'required|integer',
            'config.encryption' => 'required|in:tls,ssl,starttls',
            'config.username'   => 'required',
            'config.password'   => $passwordRule,
        ];
    }
}