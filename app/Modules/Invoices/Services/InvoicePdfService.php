<?php

namespace App\Modules\Invoices\Services;

use App\Models\Invoice;
use App\Models\OrganizationPreference;
use App\Services\BasePdfService;
use Illuminate\Support\Facades\Storage;

class InvoicePdfService extends BasePdfService
{
    public function generate(Invoice $invoice): string
    {
        $invoice->loadMissing([
            'customer',
            'items',
            'organization',
            'organization.bankAccount',
            'createdBy',
            'payments',
        ]);

        $prefs = OrganizationPreference::where('organization_id', $invoice->organization_id)->first();

        $resolvedPrefs = [
            'brand_color'      => $prefs?->brand_color    ?? config('settings.organization_preferences.brand_color'),
            'invoice_footer'   => $prefs?->invoice_footer ?? config('settings.organization_preferences.invoice_footer'),
            'invoice_template' => $prefs?->invoice_template ?? config('settings.organization_preferences.invoice_template', 'default'),
            'pdf_branding'     => config('settings.organization_preferences.pdf_branding', 'Powered by BillBase'),
        ];
        
        $logoBase64 = null;
        if ($invoice->organization->logo_url) {
            $logoPath = storage_path('app/public/' . $invoice->organization->logo_url);
            if (file_exists($logoPath)) {
                $extension   = pathinfo($logoPath, PATHINFO_EXTENSION);
                $mimeType    = 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
                $logoBase64  = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($logoPath));
            }
        }

        return $this->createPdf("pdfs.invoices.{$resolvedPrefs['invoice_template']}", [
            'invoice'     => $invoice,
            'prefs'       => $resolvedPrefs,
            'tax'         => config('settings.tax'),
            'logoBase64'  => $logoBase64,
        ])->output();
    }

    public function generateAndStore(Invoice $invoice): string
    {
        $pdfContent = $this->generate($invoice);
        $path       = "invoices/{$invoice->organization->org_code}/{$invoice->invoice_number}.pdf";

        Storage::disk('public')->put($path, $pdfContent);

        return $path;
    }
}