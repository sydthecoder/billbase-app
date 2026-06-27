<?php

namespace App\Services\Settings;

/**
 * Entry point to access an organization's settings.
 * Call SettingsService::for($orgId) then chain the concern you need.
 */
class SettingsService
{
    private ?MailSettingsService        $mail        = null;
    private ?BankSettingsService        $bank        = null;
    private ?PreferencesService         $preferences = null;

    public function __construct(
        private readonly int $organizationId,
    ) {}

    public static function for(int $organizationId): static
    {
        return new static($organizationId);
    }

    public function mail(): MailSettingsService
    {
        return $this->mail ??= new MailSettingsService($this->organizationId);
    }

    public function bank(): BankSettingsService
    {
        return $this->bank ??= new BankSettingsService($this->organizationId);
    }

    public function preferences(): PreferencesService
    {
        return $this->preferences ??= new PreferencesService($this->organizationId);
    }
}