<?php

namespace App\Modules\Quotes\Services;

use App\Models\OrganizationPreference;
use App\Models\Quote;
use App\Services\BasePdfService;
use Illuminate\Support\Facades\Storage;

class QuotePdfService extends BasePdfService
{
    public function generate(Quote $quote): string
    {
        $quote->loadMissing([
            'customer',
            'items.product',
            'organization',
            'organization.bankAccount',
            'organization.activeSubscription.plan',
            'createdBy',
        ]);

        $prefs = OrganizationPreference::where('organization_id', $quote->organization_id)->first();

        $resolvedPrefs = [
            'brand_color'    => $prefs?->brand_color    ?? config('settings.organization_preferences.brand_color', '#000000'),
            'invoice_footer' => $prefs?->invoice_footer ?? config('settings.organization_preferences.invoice_footer'),
            'pdf_branding'   => config('settings.organization_preferences.pdf_branding', 'Powered by BillBase'),
            'quote_template' => $prefs?->quote_template ?? config('settings.organization_preferences.quote_template', 'default'),
        ];

        $logoBase64 = null;
        if ($quote->organization->logo_url) {
            $logoPath = storage_path('app/public/' . $quote->organization->logo_url);
            if (file_exists($logoPath)) {
                $extension  = pathinfo($logoPath, PATHINFO_EXTENSION);
                $mimeType   = 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
                $logoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($logoPath));
            }
        }

        return $this->createPdf("pdfs.quotes.{$resolvedPrefs['quote_template']}", [
            'quote'      => $quote,
            'prefs'      => $resolvedPrefs,
            'tax'        => config('settings.tax'),
            'logoBase64' => $logoBase64,
        ])->output();
    }

    public function generateAndStore(Quote $quote): string
    {
        $pdfContent = $this->generate($quote);
        $path       = "quotes/{$quote->organization->org_code}/{$quote->quote_number}.pdf";

        Storage::disk('public')->put($path, $pdfContent);

        return $path;
    }
}