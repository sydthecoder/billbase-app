<?php

namespace App\Services\Settings;

use App\Models\OrganizationPreference;

class PreferencesService
{
    private bool $loaded = false;
    private ?OrganizationPreference $row = null;
    private array $defaults;

    public function __construct(
        private readonly int $organizationId,
    ) {
        $this->defaults = config('settings.organization_preferences', []);
    }

    public function get(string $key, mixed $fallback = null): mixed
    {
        $prefs   = $this->load();
        $dbValue = $prefs?->$key ?? null;

        return $dbValue ?? $this->defaults[$key] ?? $fallback;
    }

    public function all(): array
    {
        $prefs = $this->load();

        return [
            'invoice_prefix'          => $prefs?->invoice_prefix          ?? $this->defaults['invoice_prefix']          ?? 'INV',
            'invoice_starting_number' => $prefs?->invoice_starting_number ?? $this->defaults['invoice_starting_number'] ?? 1,
            'default_payment_terms'   => $prefs?->default_payment_terms   ?? $this->defaults['default_payment_terms']   ?? 30,
            'invoice_footer'          => $prefs?->invoice_footer           ?? $this->defaults['invoice_footer']          ?? null,
            'invoice_notes'           => $prefs?->invoice_notes            ?? $this->defaults['invoice_notes']           ?? null,
            'invoice_template'        => $prefs?->invoice_template         ?? $this->defaults['invoice_template']        ?? 'default',
            'quote_prefix'            => $prefs?->quote_prefix             ?? $this->defaults['quote_prefix']            ?? 'QUO',
            'quote_starting_number'   => $prefs?->quote_starting_number    ?? $this->defaults['quote_starting_number']   ?? 1,
            'customer_code_prefix'    => $prefs?->customer_code_prefix     ?? $this->defaults['customer_code_prefix']    ?? 'CUS',
            'brand_color'             => $prefs?->brand_color              ?? $this->defaults['brand_color']             ?? '#000000',
        ];
    }

    public function tax(string $key, mixed $fallback = null): mixed
    {
        return config("settings.tax.{$key}", $fallback);
    }

    private function load(): ?OrganizationPreference
    {
        if (! $this->loaded) {
            $this->row    = OrganizationPreference::where('organization_id', $this->organizationId)->first();
            $this->loaded = true;
        }

        return $this->row;
    }
}