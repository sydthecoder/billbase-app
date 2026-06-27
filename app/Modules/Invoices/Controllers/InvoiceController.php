<?php

namespace App\Modules\Invoices\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Modules\Invoices\Requests\CreateInvoiceRequest;
use App\Modules\Invoices\Requests\UpdateInvoiceRequest;
use App\Modules\Invoices\Services\InvoicePdfService;
use App\Modules\Invoices\Services\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService    $invoiceService,
        protected InvoicePdfService $invoicePdfService,
    ) {}

    public function index(): View
    {
        $invoices = $this->invoiceService->index(auth()->user());

        return view('invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $customers = Customer::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();

        $products = Product::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('invoices.create', compact('customers', 'products'));
    }

    public function store(CreateInvoiceRequest $request): RedirectResponse
    {
        $result = $this->invoiceService->store(auth()->user(), $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']])->withInput();
        }

        return redirect()->route('invoices.show', $result['invoice']->id)
            ->with('success', 'Invoice created.');
    }

    public function show(int $id): View
    {
        $invoice = $this->invoiceService->show(auth()->user(), $id);

        return view('invoices.show', compact('invoice'));
    }

    public function edit(int $id): View
    {
        $invoice = $this->invoiceService->show(auth()->user(), $id);

        $customers = Customer::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();

        $products = Product::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $existingItems = $invoice->items->map(fn($i) => [
            'product_id'      => $i->product_id,
            'description'     => $i->description,
            'quantity'        => $i->quantity,
            'unit'            => $i->unit,
            'unit_price'      => $i->unit_price,
            'is_taxable'      => $i->is_taxable,
            'discount_amount' => $i->discount_amount,
        ])->toArray();

        return view('invoices.edit', compact('invoice', 'customers', 'products', 'existingItems'));
    }

    public function update(UpdateInvoiceRequest $request, int $id): RedirectResponse
    {
        $result = $this->invoiceService->update(auth()->user(), $id, $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']])->withInput();
        }

        return redirect()->route('invoices.show', $id)->with('success', 'Invoice updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $result = $this->invoiceService->destroy(auth()->user(), $id);

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted.');
    }

    public function send(int $id): RedirectResponse
    {
        $result = $this->invoiceService->send(auth()->user(), $id);

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }

    public function pdf(int $id): mixed
    {
        $invoice = $this->invoiceService->show(auth()->user(), $id);
        $pdf     = $this->invoicePdfService->generate($invoice);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $invoice->invoice_number . '.pdf"');
    }
}