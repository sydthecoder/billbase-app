<?php

namespace App\Modules\Quotes\Services;

use App\Models\OrganizationPreference;
use App\Models\Quote;
use App\Services\BasePdfService;
use Illuminate\Support\Facades\Storage;

class QuotePdfService extends BasePdfService
{
    /**
     * Generate PDF as string — used for streaming/preview.
     */
    public function generate(Quote $quote): string
    {
        $quote->load([
            'customer',
            'items.product',
            'organization',
            'organization.bankAccount',
            'organization.activeSubscription.plan',
            'createdBy',
        ]);

        $prefs = OrganizationPreference::where('organization_id', $quote->organization_id)->first();

        $resolvedPrefs = [
            'brand_color'    => $prefs?->brand_color    ?? config('settings.organization_preferences.brand_color'),
            'invoice_footer' => $prefs?->invoice_footer ?? config('settings.organization_preferences.invoice_footer'),
            'pdf_branding'   => $prefs?->pdf_branding       ?? config('settings.organization_preferences.pdf_branding'),
            'quote_template' => $prefs?->quote_template ?? config('settings.organization_preferences.quote_template'),
        ];

        return $this->createPdf("pdfs.quotes.{$resolvedPrefs['quote_template']}", [
            'quote' => $quote,
            'prefs' => $resolvedPrefs,
            'tax'   => config('settings.tax'),
        ])->output();
    }

    /**
     * Generate PDF and store to R2 — called on status change to sent.
     */
    public function generateAndStore(Quote $quote): string
    {
        $pdfContent = $this->generate($quote);

        $path = "quotes/{$quote->organization->org_code}/{$quote->quote_number}.pdf";

        Storage::disk('r2')->put($path, $pdfContent, 'private');

        return $path;
    }

    /**
     * Generate a presigned URL for an existing R2 PDF.
     */
    public function presignedUrl(string $path): string
    {
        return Storage::disk('r2')->temporaryUrl($path, now()->addMinutes(10));
    }
}