<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsAppService — Sends WhatsApp messages and PDFs via the BillBase microservice.
 *
 * The microservice runs locally on 127.0.0.1:8080 and is never exposed to the internet.
 * All requests are authenticated via a shared secret key.
 *
 * Usage:
 *   app(WhatsAppService::class)->sendMessage('27791562004', 'Your invoice is ready.');
 *   app(WhatsAppService::class)->sendPdf('27791562004', 'See attached.', $pdfBinary, 'INV-001.pdf');
 */
class WhatsAppService
{
    private string $url;
    private string $secret;

    public function __construct()
    {
        $this->url    = config('services.whatsapp.url');
        $this->secret = config('services.whatsapp.secret');
    }

    /**
     * Send a plain text WhatsApp message.
     */
    public function sendMessage(string $phone, string $message): bool
    {
        return $this->dispatch([
            'phone'   => $this->formatPhone($phone),
            'message' => $message,
        ]);
    }

    /**
     * Send a PDF document via WhatsApp.
     *
     * @param string $pdfBinary  Raw PDF binary string (from dompdf ->output())
     * @param string $filename   Filename shown in WhatsApp e.g. 'INV-0001.pdf'
     */
    public function sendPdf(
        string $phone,
        string $message,
        string $pdfBinary,
        string $filename,
    ): bool {
        return $this->dispatch([
            'phone'       => $this->formatPhone($phone),
            'message'     => $message,
            'file_base64' => base64_encode($pdfBinary),
            'filename'    => $filename,
        ]);
    }

    /**
     * Format SA phone number to international format.
     * Strips +, spaces, dashes. Converts leading 0 to 27.
     */
    public function formatPhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '0')) {
            $digits = '27' . substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Dispatch a request to the WhatsApp microservice.
     */
    private function dispatch(array $payload): bool
    {
        try {
            $response = Http::timeout(15)
                ->post("{$this->url}/api/v1/send", array_merge(
                    ['secret_key' => $this->secret],
                    $payload
                ));

            if ($response->successful() && $response->json('success') === true) {
                Log::info('WhatsAppService: message dispatched', [
                    'phone' => $payload['phone'] ?? null,
                ]);
                return true;
            }

            Log::error('WhatsAppService: microservice rejected request', [
                'status'   => $response->status(),
                'response' => $response->json(),
            ]);

            return false;

        } catch (\Throwable $e) {
            Log::error('WhatsAppService: dispatch failed', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}