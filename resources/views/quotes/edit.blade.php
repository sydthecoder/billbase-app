<x-layouts.app title="Edit Quote">

    <h1>Edit Quote — {{ $quote->quote_number }}</h1>

    <form method="POST" action="{{ route('quotes.update', $quote->id) }}">
        @csrf
        @method('PUT')
        @include('quotes._form', ['quote' => $quote])
        <button type="submit">Update Quote</button>
        <a href="{{ route('quotes.show', $quote->id) }}">Cancel</a>
    </form>

</x-layouts.app>