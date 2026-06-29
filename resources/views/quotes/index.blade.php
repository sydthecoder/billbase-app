<x-layouts.app title="Quotes">

    <div>
        <h1>Quotes</h1>
        <a href="{{ route('quotes.create') }}">New Quote</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Number</th>
                <th>Title</th>
                <th>Customer</th>
                <th>Issue Date</th>
                <th>Expires</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quotes as $quote)
                <tr>
                    <td>{{ $quote->quote_number }}</td>
                    <td>{{ $quote->title ?? '—' }}</td>
                    <td>{{ $quote->customer->first_name }} {{ $quote->customer->last_name }}</td>
                    <td>{{ $quote->issue_date->format('d M Y') }}</td>
                    <td>{{ $quote->expires_at->format('d M Y') }}</td>
                    <td>R {{ number_format($quote->total, 2) }}</td>
                    <td>{{ ucfirst($quote->status) }}</td>
                    <td>
                        <a href="{{ route('quotes.show', $quote->id) }}">View</a>
                        @if (!$quote->isLocked())
                            <a href="{{ route('quotes.edit', $quote->id) }}">Edit</a>
                        @endif
                        <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete quote?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No quotes yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-layouts.app>