<?php

namespace App\Modules\Quotes\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Modules\Quotes\Requests\CreateQuoteRequest;
use App\Modules\Quotes\Requests\UpdateQuoteRequest;
use App\Modules\Quotes\Services\QuotePdfService;
use App\Modules\Quotes\Services\QuoteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuoteController extends Controller
{
    public function __construct(
        protected QuoteService    $quoteService,
        protected QuotePdfService $quotePdfService,
    ) {}

    public function index(): View
    {
        $quotes = $this->quoteService->index(auth()->user());

        return view('quotes.index', compact('quotes'));
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

        return view('quotes.create', compact('customers', 'products'));
    }

    public function store(CreateQuoteRequest $request): RedirectResponse
    {
        $result = $this->quoteService->store(auth()->user(), $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']])->withInput();
        }

        return redirect()->route('quotes.show', $result['quote']->id)
            ->with('success', 'Quote created.');
    }

    public function show(int $id): View
    {
        $quote = $this->quoteService->show(auth()->user(), $id);

        return view('quotes.show', compact('quote'));
    }

    public function edit(int $id): View
    {
        $quote = $this->quoteService->show(auth()->user(), $id);

        $customers = Customer::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->get();

        $products = Product::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $existingItems = $quote->items->map(fn($i) => [
            'product_id'      => $i->product_id,
            'description'     => $i->description,
            'quantity'        => $i->quantity,
            'unit'            => $i->unit,
            'unit_price'      => $i->unit_price,
            'is_taxable'      => $i->is_taxable,
            'discount_amount' => $i->discount_amount,
        ])->toArray();

        return view('quotes.edit', compact('quote', 'customers', 'products', 'existingItems'));
    }

    public function update(UpdateQuoteRequest $request, int $id): RedirectResponse
    {
        $result = $this->quoteService->update(auth()->user(), $id, $request->validated());

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']])->withInput();
        }

        return redirect()->route('quotes.show', $id)->with('success', 'Quote updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $result = $this->quoteService->destroy(auth()->user(), $id);

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']]);
        }

        return redirect()->route('quotes.index')->with('success', 'Quote deleted.');
    }

    public function send(int $id): RedirectResponse
    {
        $result = $this->quoteService->updateStatus(auth()->user(), $id, 'sent');

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']]);
        }

        return back()->with('success', 'Quote sent.');
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:draft,sent,viewed,accepted,declined,expired',
        ]);

        $result = $this->quoteService->updateStatus(auth()->user(), $id, $request->status);

        if ($result['status'] === 'error') {
            return back()->withErrors(['general' => $result['message']]);
        }

        return back()->with('success', 'Quote status updated.');
    }

    public function pdf(int $id): mixed
    {
        $quote = $this->quoteService->show(auth()->user(), $id);
        $pdf   = $this->quotePdfService->generate($quote);

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $quote->quote_number . '.pdf"');
    }
}