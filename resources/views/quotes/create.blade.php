<x-layouts.app title="New Quote">

    <h1>New Quote</h1>

    <form method="POST" action="{{ route('quotes.store') }}">
        @csrf
        @include('quotes._form')
        <button type="submit">Create Quote</button>
        <a href="{{ route('quotes.index') }}">Cancel</a>
    </form>

</x-layouts.app>