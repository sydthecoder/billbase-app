<?php

namespace App\Modules\Quotes\Services;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\User;
use App\Services\CodeGeneratorService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class QuoteService
{
    public function __construct(
        protected QuotePdfService $quotePdfService,
    ) {}

    public function index(User $user): Collection
    {
        return Quote::where('organization_id', $user->organization_id)
            ->with(['customer', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store(User $user, array $data): array
    {
        DB::beginTransaction();

        try {
            $totals = $this->calculateTotals($data['items'], $data);

            $quote = Quote::create([
                'organization_id'  => $user->organization_id,
                'customer_id'      => $data['customer_id'],
                'created_by'       => $user->id,
                'quote_number'     => CodeGeneratorService::quote($user->organization_id),
                'title'            => $data['title'] ?? null,
                'status'           => 'draft',
                'issue_date'       => $data['issue_date'],
                'expires_at'       => $data['expires_at'],
                'discount_amount'  => $data['discount_amount'] ?? 0,
                'discount_percent' => $data['discount_percent'] ?? 0,
                'subtotal'         => $totals['subtotal'],
                'tax_total'        => $totals['tax_total'],
                'total'            => $totals['total'],
                'notes'            => $data['notes'] ?? null,
                'footer'           => $data['footer'] ?? config('settings.organization_preferences.invoice_footer'),
            ]);

            $this->syncItems($quote, $data['items']);

            DB::commit();

            return [
                'status' => 'success',
                'quote'  => $quote->load(['customer', 'createdBy', 'items']),
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'status'  => 'error',
                'message' => 'Failed to create quote: ' . $e->getMessage(),
            ];
        }
    }

    public function show(User $user, int $id): Quote
    {
        return Quote::where('organization_id', $user->organization_id)
            ->with(['customer', 'createdBy', 'items', 'items.product', 'organization', 'organization.bankAccount'])
            ->findOrFail($id);
    }

    public function update(User $user, int $id, array $data): array
    {
        $quote = Quote::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if ($quote->isLocked()) {
            return ['status' => 'error', 'message' => 'This quote is locked and cannot be edited.'];
        }

        DB::beginTransaction();

        try {
            $updateData = collect($data)->except('items')->toArray();

            if (isset($data['items'])) {
                $totals = $this->calculateTotals($data['items'], array_merge(
                    $quote->toArray(),
                    $data
                ));

                $updateData['subtotal']  = $totals['subtotal'];
                $updateData['tax_total'] = $totals['tax_total'];
                $updateData['total']     = $totals['total'];

                $this->syncItems($quote, $data['items']);
            }

            $quote->update($updateData);

            DB::commit();

            return [
                'status' => 'success',
                'quote'  => $quote->fresh()->load(['customer', 'createdBy', 'items']),
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return ['status' => 'error', 'message' => 'Failed to update quote: ' . $e->getMessage()];
        }
    }

    public function destroy(User $user, int $id): array
    {
        $quote = Quote::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if ($quote->isLocked()) {
            return ['status' => 'error', 'message' => 'This quote is locked and cannot be deleted.'];
        }

        $quote->delete();

        return ['status' => 'success'];
    }

    public function updateStatus(User $user, int $id, string $status): array
    {
        $quote = Quote::where('organization_id', $user->organization_id)
            ->findOrFail($id);

        if ($quote->isLocked()) {
            return ['status' => 'error', 'message' => 'This quote is locked and its status cannot be changed.'];
        }

        $timestamps = [];

        if ($status === 'sent') {
            $timestamps['sent_at'] = now();

            if (! $quote->pdf_path) {
                try {
                    $path = $this->quotePdfService->generateAndStore($quote);
                    $timestamps['pdf_path']         = $path;
                    $timestamps['pdf_generated_at'] = now();
                } catch (\Throwable $e) {
                    return ['status' => 'error', 'message' => 'Failed to generate PDF: ' . $e->getMessage()];
                }
            }
        }

        $quote->update(array_merge(['status' => $status], $timestamps));

        return ['status' => 'success'];
    }

    /*--------------------------------------------------------------------------
    | Private helpers
    |--------------------------------------------------------------------------*/

    private function syncItems(Quote $quote, array $items): void
    {
        $quote->items()->delete();

        foreach ($items as $index => $item) {
            $lineTotal = $this->calculateLineTotal($item);

            QuoteItem::create([
                'quote_id'        => $quote->id,
                'product_id'      => $item['product_id'] ?? null,
                'description'     => $item['description'],
                'quantity'        => $item['quantity'],
                'unit'            => $item['unit'] ?? null,
                'unit_price'      => $item['unit_price'],
                'is_taxable'      => $item['is_taxable'] ?? true,
                'tax_rate'        => ($item['is_taxable'] ?? true) ? config('settings.tax.rate') : 0,
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
            $lineTotal  = $this->calculateLineTotal($item);
            $subtotal  += $lineTotal;
            $isTaxable  = $item['is_taxable'] ?? true;

            if ($isTaxable) {
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