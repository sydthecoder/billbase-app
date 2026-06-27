<?php

namespace App\Services;

use App\Models\Organization;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class CustomerMailService
{
    public static function send(
        Organization $organization,
        string       $to,
        string       $name,
        string       $subject,
        string       $view,
        array        $data        = [],
        array        $attachments = [],
    ): bool {
        try {
            $settings = SettingsService::for($organization->id);
            $setting  = $settings->mail()->setting();

            $html = view($view, array_merge($data, [
                'organization' => $organization,
                'subject'      => $subject,
            ]))->render();

            if (! $setting) {
                /*--------------------------------------------------------------
                | No mail settings at all — use system mailer silently
                |--------------------------------------------------------------*/
                return MailService::sendWithAttachment(
                    to:          $to,
                    name:        $name,
                    subject:     $subject,
                    view:        $view,
                    data:        array_merge($data, ['organization' => $organization]),
                    attachments: $attachments,
                );
            }

            if (! $setting->is_verified) {
                /*--------------------------------------------------------------
                | Settings exist but not verified — block and log, don't fallback
                |--------------------------------------------------------------*/
                Log::warning("CustomerMailService: org [{$organization->id}] has unverified mail settings, email blocked.", [
                    'to'      => $to,
                    'subject' => $subject,
                ]);

                return false;
            }

            /*------------------------------------------------------------------
            | Verified SMTP — use their mailer, let it fail loudly if broken
            |------------------------------------------------------------------*/
            $mailer = $settings->mail()->build(requireVerified: true);
            $from   = $settings->mail()->from();

            $email = (new Email())
                ->from(new Address($from['address'], $from['name']))
                ->to(new Address($to, $name))
                ->subject($subject)
                ->html($html);

            foreach ($attachments as $attachment) {
                $email->attach(
                    $attachment['data'],
                    $attachment['name'],
                    $attachment['mime'],
                );
            }

            $mailer->getSymfonyTransport()->send($email);

            Log::info("CustomerMailService: sent [{$subject}] to [{$to}] for org [{$organization->id}]");

            return true;

        } catch (\Throwable $e) {
            Log::error("CustomerMailService: failed to send [{$subject}] to [{$to}]", [
                'organization_id' => $organization->id,
                'error'           => $e->getMessage(),
            ]);

            return false;
        }
    }
}