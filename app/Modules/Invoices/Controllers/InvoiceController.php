<?php

namespace App\Modules\Invoices\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Modules\Invoices\Requests\CreateInvoiceRequest;
use App\Modules\Invoices\Requests\UpdateInvoiceRequest;
use App\Modules\Invoices\Services\InvoicePdfService;
use App\Modules\Invoices\Services\InvoiceService;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService    $invoiceService,
        protected InvoicePdfService $invoicePdfService,
    ) {}

    public function index(): JsonResponse
    {
        return $this->invoiceService->index(auth()->user());
    }

    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        return $this->invoiceService->store(auth()->user(), $request->validated());
    }

    public function show(int $id): JsonResponse
    {
        return $this->invoiceService->show(auth()->user(), $id);
    }

    public function update(UpdateInvoiceRequest $request, int $id): JsonResponse
    {
        return $this->invoiceService->update(auth()->user(), $id, $request->validated());
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->invoiceService->destroy(auth()->user(), $id);
    }

    public function send(int $id): JsonResponse
    {
        return $this->invoiceService->send(auth()->user(), $id);
    }

    public function pdf(int $id): mixed
    {
        $invoice = Invoice::where('organization_id', auth()->user()->organization_id)
            ->findOrFail($id);

        if ($invoice->pdf_path) {
            return redirect($this->invoicePdfService->presignedUrl($invoice->pdf_path));
        }

        $pdf = $this->invoicePdfService->generate($invoice);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $invoice->invoice_number . '.pdf"');
    }

    public function pdfDownload(int $id): mixed
    {
        $invoice = Invoice::where('organization_id', auth()->user()->organization_id)
            ->findOrFail($id);

        if ($invoice->pdf_path) {
            return redirect($this->invoicePdfService->presignedUrl($invoice->pdf_path, true));
        }

        $pdf = $this->invoicePdfService->generate($invoice);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $invoice->invoice_number . '.pdf"');
    }
}