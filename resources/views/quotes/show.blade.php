<x-layouts.app title="Quote {{ $quote->quote_number }}">

    <div>
        <h1>{{ $quote->quote_number }}</h1>
        @if ($quote->title) <p>{{ $quote->title }}</p> @endif
        <span>{{ ucfirst($quote->status) }}</span>

        <div>
            @if (!$quote->isLocked())
                <a href="{{ route('quotes.edit', $quote->id) }}">Edit</a>
            @endif

            <a href="{{ route('quotes.pdf', $quote->id) }}" target="_blank">View PDF</a>

            @if (!$quote->isLocked())
                <form method="POST" action="{{ route('quotes.send', $quote->id) }}">
                    @csrf
                    <button type="submit">Send Quote</button>
                </form>
            @endif

            {{-- Status update --}}
            @if (!$quote->isLocked())
                <form method="POST" action="{{ route('quotes.status', $quote->id) }}">
                    @csrf
                    <select name="status" onchange="this.form.submit()">
                        @foreach (['draft', 'sent', 'viewed', 'accepted', 'declined', 'expired'] as $s)
                            <option value="{{ $s }}" {{ $quote->status === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            @if (!$quote->isLocked())
                <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete quote?')">Delete</button>
                </form>
            @endif

            {{-- Convert to invoice --}}
            @if ($quote->status === 'accepted')
                <a href="{{ route('invoices.create', ['quote_id' => $quote->id]) }}">Convert to Invoice</a>
            @endif
        </div>
    </div>

    {{-- Customer --}}
    <div>
        <h2>Customer</h2>
        <p>{{ $quote->customer->first_name }} {{ $quote->customer->last_name }}</p>
        @if ($quote->customer->company_name)
            <p>{{ $quote->customer->company_name }}</p>
        @endif
        <p>{{ $quote->customer->email }}</p>
    </div>

    {{-- Dates --}}
    <div>
        <p><strong>Issue Date:</strong> {{ $quote->issue_date->format('d M Y') }}</p>
        <p><strong>Expires:</strong> {{ $quote->expires_at->format('d M Y') }}</p>
        @if ($quote->sent_at)
            <p><strong>Sent:</strong> {{ $quote->sent_at->format('d M Y H:i') }}</p>
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
            @foreach ($quote->items as $item)
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
        <p>Subtotal: R {{ number_format($quote->subtotal, 2) }}</p>
        <p>VAT: R {{ number_format($quote->tax_total, 2) }}</p>
        @if ($quote->discount_amount > 0)
            <p>Discount: R {{ number_format($quote->discount_amount, 2) }}</p>
        @endif
        <p><strong>Total: R {{ number_format($quote->total, 2) }}</strong></p>
    </div>

    @if ($quote->notes)
        <div>
            <h3>Notes</h3>
            <p>{{ $quote->notes }}</p>
        </div>
    @endif

    @if ($quote->footer)
        <p>{{ $quote->footer }}</p>
    @endif

</x-layouts.app>