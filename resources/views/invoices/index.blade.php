<x-layouts.app title="Invoices">

    <div>
        <h1>Invoices</h1>
        <a href="{{ route('invoices.create') }}">New Invoice</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Number</th>
                <th>Customer</th>
                <th>Issue Date</th>
                <th>Due Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}</td>
                    <td>{{ $invoice->issue_date->format('d M Y') }}</td>
                    <td>{{ $invoice->due_date->format('d M Y') }}</td>
                    <td>R {{ number_format($invoice->total, 2) }}</td>
                    <td>{{ ucfirst($invoice->status) }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice->id) }}">View</a>
                        @if (!$invoice->is_locked && !in_array($invoice->status, ['paid', 'cancelled']))
                            <a href="{{ route('invoices.edit', $invoice->id) }}">Edit</a>
                        @endif
                        <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete invoice?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No invoices yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-layouts.app>