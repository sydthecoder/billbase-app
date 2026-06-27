<x-layouts.app title="Edit Invoice">

    <h1>Edit Invoice — {{ $invoice->invoice_number }}</h1>

    <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
        @csrf
        @method('PUT')
        @include('invoices._form', ['invoice' => $invoice])
        <button type="submit">Update Invoice</button>
        <a href="{{ route('invoices.show', $invoice->id) }}">Cancel</a>
    </form>

</x-layouts.app>