<x-layouts.app title="Invoice {{ $invoice->invoice_number }}">

    <div>
        <h1>{{ $invoice->invoice_number }}</h1>
        <span>{{ ucfirst($invoice->status) }}</span>

        <div>
            @if (!$invoice->is_locked && !in_array($invoice->status, ['paid', 'cancelled']))
                <a href="{{ route('invoices.edit', $invoice->id) }}">Edit</a>
            @endif

            <a href="{{ route('invoices.pdf', $invoice->id) }}" target="_blank">View PDF</a>

            @if (!in_array($invoice->status, ['paid', 'cancelled']))
                <form method="POST" action="{{ route('invoices.send', $invoice->id) }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Send invoice to {{ $invoice->customer->email }}?')">
                        Send Invoice
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete invoice?')">Delete</button>
            </form>
        </div>
    </div>

    {{-- Customer --}}
    <div>
        <h2>Bill To</h2>
        <p>{{ $invoice->billing_name }}</p>
        @if ($invoice->billing_company) <p>{{ $invoice->billing_company }}</p> @endif
        @if ($invoice->billing_vat_number) <p>VAT: {{ $invoice->billing_vat_number }}</p> @endif
        <p>
            {{ $invoice->billing_street_address }}
            {{ $invoice->billing_suburb }}
            {{ $invoice->billing_city }}
            {{ $invoice->billing_province }}
            {{ $invoice->billing_postal_code }}
        </p>
    </div>

    {{-- Dates --}}
    <div>
        <p><strong>Issue Date:</strong> {{ $invoice->issue_date->format('d M Y') }}</p>
        <p><strong>Due Date:</strong> {{ $invoice->due_date->format('d M Y') }}</p>
        @if ($invoice->sent_at)
            <p><strong>Sent:</strong> {{ $invoice->sent_at->format('d M Y H:i') }}</p>
        @endif
    </div>

    {{-- Line Items --}}
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Tax</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit ?? '—' }}</td>
                    <td>R {{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->is_taxable ? $item->tax_rate . '%' : 'No' }}</td>
                    <td>R {{ number_format($item->discount_amount, 2) }}</td>
                    <td>R {{ number_format($item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    <div>
        <p>Subtotal: R {{ number_format($invoice->subtotal, 2) }}</p>
        <p>VAT: R {{ number_format($invoice->tax_total, 2) }}</p>
        @if ($invoice->discount_amount > 0)
            <p>Discount: R {{ number_format($invoice->discount_amount, 2) }}</p>
        @endif
        <p><strong>Total: R {{ number_format($invoice->total, 2) }}</strong></p>
        <p>Amount Paid: R {{ number_format($invoice->amount_paid, 2) }}</p>
        <p><strong>Amount Due: R {{ number_format($invoice->amount_due, 2) }}</strong></p>
    </div>

    {{-- Notes --}}
    @if ($invoice->notes)
        <div>
            <h3>Notes</h3>
            <p>{{ $invoice->notes }}</p>
        </div>
    @endif

    @if ($invoice->footer)
        <div>
            <p>{{ $invoice->footer }}</p>
        </div>
    @endif

</x-layouts.app>