<x-layouts.app title="Add Customer">

    <h1>Add Customer</h1>

    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        @include('customers._form')
        <button type="submit">Create Customer</button>
        <a href="{{ route('customers.index') }}">Cancel</a>
    </form>

</x-layouts.app>