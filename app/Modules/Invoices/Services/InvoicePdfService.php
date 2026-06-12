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
        $invoice->load([
            'customer',
            'items',
            'organization',
            'organization.bankAccount',
            'organization.activeSubscription.plan',
            'createdBy',
            'payments',
        ]);

        $prefs = OrganizationPreference::where('organization_id', $invoice->organization_id)->first();

        $resolvedPrefs = [
            'brand_color'      => $prefs?->brand_color      ?? config('settings.organization_preferences.brand_color'),
            'invoice_footer'   => $prefs?->invoice_footer   ?? config('settings.organization_preferences.invoice_footer'),
            'pdf_branding'   => $prefs?->pdf_branding       ?? config('settings.organization_preferences.pdf_branding'),
            'invoice_template' => $prefs?->invoice_template ?? config('settings.organization_preferences.invoice_template'),
        ];

        return $this->createPdf("pdfs.invoices.{$resolvedPrefs['invoice_template']}", [
            'invoice' => $invoice,
            'prefs'   => $resolvedPrefs,
            'tax'     => config('settings.tax'),
        ])->output();
    }

    public function generateAndStore(Invoice $invoice): string
    {
        $pdfContent = $this->generate($invoice);
        $path       = "invoices/{$invoice->organization->org_code}/{$invoice->invoice_number}.pdf";

        Storage::disk('r2')->put($path, $pdfContent, 'private');

        return $path;
    }

    public function presignedUrl(string $path, bool $download = false): string
    {
        $filename = basename($path);

        return Storage::disk('r2')->temporaryUrl(
            $path,
            now()->addMinutes(10),
            $download ? [
                'ResponseContentDisposition' => "attachment; filename=\"{$filename}\"",
            ] : []
        );
    }
}