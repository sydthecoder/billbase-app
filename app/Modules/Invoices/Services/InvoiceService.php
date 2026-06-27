<?php

namespace App\Modules\Invoices\Services;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Quote;
use App\Models\User;
use App\Services\CodeGeneratorService;
use App\Services\CustomerMailService;
use App\Services\WhatsAppService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct(
        protected InvoicePdfService $invoicePdfService,
    ) {}

    public function index(User $user): Collection
    {
        return Invoice::where('organization_id', $user->organization_id)
            ->with(['customer', 'items', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store(User $user, array $data): array
    {
        $customer = Customer::where('organization_id', $user->organization_id)
            ->findOrFail($data['customer_id']);

        if (isset($data['quote_id'])) {
            $quote = Quote::where('organization_id', $user->organization_id)
                ->where('status', 'accepted')
                ->findOrFail($data['quote_id']);
        }

        DB::beginTransaction();

        try {
            $totals = $this->calculateTotals($data['items'], $data);

            $invoice = Invoice::create([
                'organization_id'  => $user->organization_id,
                'customer_id'      => $data['customer_id'],
                'quote_id'         => $data['quote_id'] ?? null,
                'created_by'       => $user->id,
                'invoice_number'   => CodeGeneratorService::invoice($user->organization_id),
                'status'           => 'draft',
                'issue_date'       => $data['issue_date'],
                'due_date'         => $data['due_date'],
                'discount_amount'  => $data['discount_amount'] ?? 0,
                'discount_percent' => $data['discount_percent'] ?? 0,
                'subtotal'         => $totals['subtotal'],
                'tax_total'        => $totals['tax_total'],
                'total'            => $totals['total'],
                'notes'            => $data['notes'] ?? null,
                'footer'           => $data['footer'] ?? config('settings.organization_preferences.invoice_footer'),
                'billing_name'           => $customer->first_name . ' ' . $customer->last_name,
                'billing_company'        => $customer->company_name,
                'billing_vat_number'     => $customer->vat_number,
                'billing_street_address' => $customer->street_address,
                'billing_suburb'         => $customer->suburb,
                'billing_city'           => $customer->city,
                'billing_province'       => $customer->province,
                'billing_postal_code'    => $customer->postal_code,
            ]);

            $this->syncItems($invoice, $data['items']);

            if (isset($quote)) {
                $quote->update([
                    'status'                  => 'converted',
                    'converted_at'            => now(),
                    'converted_to_invoice_id' => $invoice->id,
                ]);
            }

            DB::commit();

            return [
                'status'  => 'success',
                'invoice' => $invoice->load(['customer', 'items', 'payments']),
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'status'  => 'error',
                'message' => 'Failed to create invoice: ' . $e->getMessage(),
            ];
        }
    }

    public function show(User $user, int $id): Invoice
    {
        return Invoice::where('organization_id', $user->organization_id)
            ->with(['customer', 'items', 'items.product', 'payments', 'organization', 'organization.bankAccount'])
            ->findOrFail($id);
    }

    public function update(User $user, int $id, array $data): array
    {
        $invoice = Invoice::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if ($invoice->is_locked) {
            return ['status' => 'error', 'message' => 'Invoice is locked and cannot be edited.'];
        }

        if (in_array($invoice->status, ['paid', 'cancelled'])) {
            return ['status' => 'error', 'message' => 'Invoice cannot be edited in its current status.'];
        }

        DB::beginTransaction();

        try {
            $updateData = collect($data)->except('items')->toArray();

            if (isset($data['items'])) {
                $totals = $this->calculateTotals($data['items'], array_merge(
                    $invoice->toArray(),
                    $data
                ));

                $updateData['subtotal']  = $totals['subtotal'];
                $updateData['tax_total'] = $totals['tax_total'];
                $updateData['total']     = $totals['total'];

                $this->syncItems($invoice, $data['items']);
            }

            $invoice->update($updateData);

            DB::commit();

            return [
                'status'  => 'success',
                'invoice' => $invoice->fresh()->load(['customer', 'items', 'payments']),
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return ['status' => 'error', 'message' => 'Failed to update invoice: ' . $e->getMessage()];
        }
    }

    public function destroy(User $user, int $id): array
    {
        $invoice = Invoice::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if ($invoice->is_locked || $invoice->status === 'paid') {
            return ['status' => 'error', 'message' => 'Paid or locked invoices cannot be deleted.'];
        }

        $invoice->delete();

        return ['status' => 'success'];
    }

    public function send(User $user, int $id): array
    {
        $invoice = Invoice::where('organization_id', $user->organization_id)
            ->with(['customer', 'items', 'payments', 'organization', 'organization.bankAccount'])
            ->findOrFail($id);

        if ($invoice->is_locked && $invoice->status === 'paid') {
            return ['status' => 'error', 'message' => 'Paid invoices cannot be resent.'];
        }

        try {
            $pdf = $this->invoicePdfService->generate($invoice);

            $sent = CustomerMailService::send(
                organization: $invoice->organization,
                to:           $invoice->customer->email,
                name:         $invoice->customer->first_name . ' ' . $invoice->customer->last_name,
                subject:      'Invoice ' . $invoice->invoice_number . ' from ' . $invoice->organization->name,
                view:         'emails.customer.invoice.sent',
                data:         ['invoice' => $invoice, 'organization' => $invoice->organization],
                attachments:  [[
                    'data' => $pdf,
                    'name' => $invoice->invoice_number . '.pdf',
                    'mime' => 'application/pdf',
                ]],
            );

            if (! $sent) {
                return ['status' => 'error', 'message' => 'Failed to send invoice email.'];
            }

            if ($invoice->customer->phone) {
                app(WhatsAppService::class)->sendPdf(
                    phone:     $invoice->customer->phone,
                    message:   'Hi ' . $invoice->customer->first_name . ', please find your invoice ' . $invoice->invoice_number . ' attached. Amount due: R ' . number_format((float) $invoice->amount_due, 2) . '. Due: ' . $invoice->due_date->format('d M Y') . '.',
                    pdfBinary: $pdf,
                    filename:  $invoice->invoice_number . '.pdf',
                );
            }

            $invoice->update([
                'sent_at' => now(),
                'status'  => 'sent',
            ]);

            return ['status' => 'success', 'message' => 'Invoice sent to ' . $invoice->customer->email];

        } catch (\Throwable $e) {
            return ['status' => 'error', 'message' => 'Failed to send invoice: ' . $e->getMessage()];
        }
    }

    /*--------------------------------------------------------------------------
    | Private helpers
    |--------------------------------------------------------------------------*/

    private function syncItems(Invoice $invoice, array $items): void
    {
        $invoice->items()->delete();

        foreach ($items as $index => $item) {
            $lineTotal = $this->calculateLineTotal($item);

            InvoiceItem::create([
                'invoice_id'      => $invoice->id,
                'product_id'      => $item['product_id'] ?? null,
                'description'     => $item['description'],
                'quantity'        => $item['quantity'],
                'unit'            => $item['unit'] ?? null,
                'unit_price'      => $item['unit_price'],
                'is_taxable'      => $item['is_taxable'],
                'tax_rate'        => $item['is_taxable'] ? config('settings.tax.rate') : 0,
                'discount_amount' => $item['discount_amount'] ?? 0,
                'line_total'      => $lineTotal,
                'sort_order'      => $item['sort_order'] ?? $index,
            ]);
        }
    }

    private function calculateLineTotal(array $item): float
    {
        $quantity  = (float) $item['quantity'];
        $unitPrice = (float) $item['unit_price'];
        $discount  = (float) ($item['discount_amount'] ?? 0);

        return round(($quantity * $unitPrice) - $discount, 2);
    }

    private function calculateTotals(array $items, array $data): array
    {
        $subtotal = 0;
        $taxTotal = 0;
        $taxRate  = config('settings.tax.rate');

        foreach ($items as $item) {
            $lineTotal = $this->calculateLineTotal($item);
            $subtotal += $lineTotal;

            if ($item['is_taxable']) {
                $taxTotal += round($lineTotal * ($taxRate / 100), 2);
            }
        }

        $discountAmount  = (float) ($data['discount_amount'] ?? 0);
        $discountPercent = (float) ($data['discount_percent'] ?? 0);

        if ($discountPercent > 0) {
            $discountAmount = round($subtotal * ($discountPercent / 100), 2);
        }

        $total = round(($subtotal + $taxTotal) - $discountAmount, 2);

        return [
            'subtotal'  => round($subtotal, 2),
            'tax_total' => round($taxTotal, 2),
            'total'     => $total,
        ];
    }
}