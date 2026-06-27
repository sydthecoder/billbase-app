<?php

namespace App\Services\Settings;

use App\Models\OrganizationMailSetting;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class MailSettingsService
{
    private bool $loaded = false;
    private ?OrganizationMailSetting $row = null;

    public function __construct(
        private readonly int $organizationId,
    ) {}

    public function setting(): ?OrganizationMailSetting
    {
        return $this->load();
    }

    public function from(): ?array
    {
        $setting = $this->load();

        if (! $setting) {
            return null;
        }

        return [
            'address' => $setting->from_email,
            'name'    => $setting->from_name,
        ];
    }

    public function build(bool $requireVerified = true): ?Mailer
    {
        $setting = $this->load();

        if (! $setting) {
            return null;
        }

        if ($requireVerified && ! $setting->is_verified) {
            return null;
        }

        try {
            $transport = $this->buildSmtp($setting->config);

            return new Mailer(
                'tenant',
                app('view'),
                $transport,
                app('events'),
            );

        } catch (\Throwable $e) {
            Log::error("MailSettingsService: failed to build mailer for org {$this->organizationId}: " . $e->getMessage());
            return null;
        }
    }

    private function buildSmtp(array $config): EsmtpTransport
    {
        $transport = new EsmtpTransport(
            host: $config['host'],
            port: (int) ($config['port'] ?? 587),
            tls:  ($config['encryption'] ?? 'tls') === 'ssl',
        );

        if (! empty($config['username'])) {
            $transport->setUsername($config['username']);
        }

        if (! empty($config['password'])) {
            $transport->setPassword($config['password']);
        }

        return $transport;
    }

    private function load(): ?OrganizationMailSetting
    {
        if (! $this->loaded) {
            $this->row    = OrganizationMailSetting::where('organization_id', $this->organizationId)->first();
            $this->loaded = true;
        }

        return $this->row;
    }
}