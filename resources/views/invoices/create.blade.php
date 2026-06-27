<x-layouts.app title="New Invoice">

    <h1>New Invoice</h1>

    <form method="POST" action="{{ route('invoices.store') }}">
        @csrf
        @include('invoices._form')
        <button type="submit">Create Invoice</button>
        <a href="{{ route('invoices.index') }}">Cancel</a>
    </form>

</x-layouts.app>