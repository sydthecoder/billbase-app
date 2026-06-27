<x-layouts.app title="Edit Product">

    <h1>Edit Product</h1>

    <form method="POST" action="{{ route('products.update', $product->id) }}">
        @csrf
        @method('PUT')
        @include('products._form', ['product' => $product])
        <button type="submit">Update Product</button>
        <a href="{{ route('products.show', $product->id) }}">Cancel</a>
    </form>

</x-layouts.app>