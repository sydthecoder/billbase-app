<?php

namespace App\Modules\Settings\Services;

use App\Models\OrganizationMailSetting;
use App\Models\User;
use App\Services\Settings\SettingsService;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailService
{
    public function get(User $user): ?OrganizationMailSetting
    {
        return SettingsService::for($user->organization_id)->mail()->setting();
    }

    public function save(User $user, array $data): OrganizationMailSetting
    {
        $existing = OrganizationMailSetting::where('organization_id', $user->organization_id)->first();
        $config   = $data['config'];

        /*----------------------------------------------------------------------
        | Preserve password — don't overwrite with blank or placeholder
        |----------------------------------------------------------------------*/
        $password = $config['password'] ?? null;

        if (($password === null || $password === '' || $password === '••••••••') && $existing) {
            $config['password'] = $existing->config['password'] ?? '';
        }

        return OrganizationMailSetting::updateOrCreate(
            ['organization_id' => $user->organization_id],
            [
                'driver'      => 'smtp',
                'from_name'   => $data['from_name'],
                'from_email'  => $data['from_email'],
                'config'      => $config,
                'is_verified' => false,
            ]
        );
    }

    public function test(User $user, string $recipient): array
    {
        $settings = SettingsService::for($user->organization_id);
        $setting  = $settings->mail()->setting();

        if (! $setting) {
            return [
                'status'  => 'error',
                'message' => 'No mail settings configured yet.',
            ];
        }

        try {
            $mailer = $settings->mail()->build(requireVerified: false);
            $from   = $settings->mail()->from();

            if (! $mailer) {
                return [
                    'status'  => 'error',
                    'message' => 'Could not build mailer. Check your SMTP configuration.',
                ];
            }

            $email = (new Email())
                ->from(new Address($from['address'], $from['name']))
                ->to($recipient)
                ->subject('BillBase — Mail Settings Test')
                ->text('This is a test email from BillBase. Your mail settings are working correctly.');

            $mailer->getSymfonyTransport()->send($email);

            $setting->update(['is_verified' => true]);

            return [
                'status'  => 'success',
                'message' => 'Test email sent. Mail settings verified.',
            ];

        } catch (\Throwable $e) {
            $setting->update(['is_verified' => false]);

            return [
                'status'  => 'error',
                'message' => 'Failed to send test email: ' . $e->getMessage(),
            ];
        }
    }
}