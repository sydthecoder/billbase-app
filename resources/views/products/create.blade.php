<x-layouts.app title="Add Product">

    <h1>Add Product</h1>

    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        @include('products._form')
        <button type="submit">Create Product</button>
        <a href="{{ route('products.index') }}">Cancel</a>
    </form>

</x-layouts.app>