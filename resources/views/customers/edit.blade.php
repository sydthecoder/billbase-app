<x-layouts.app title="Edit Customer">

    <h1>Edit Customer</h1>

    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')
        @include('customers._form', ['customer' => $customer])
        <button type="submit">Update Customer</button>
        <a href="{{ route('customers.show', $customer->id) }}">Cancel</a>
    </form>

</x-layouts.app>