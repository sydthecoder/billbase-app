<x-layouts.app title="Product">

    <div>
        <h1>{{ $product->name }}</h1>
        <a href="{{ route('products.edit', $product->id) }}">Edit</a>
        <a href="{{ route('products.index') }}">Back</a>
    </div>

    <p><strong>Price:</strong> R {{ number_format($product->price, 2) }}</p>
    <p><strong>Unit:</strong> {{ $product->unit ?? '—' }}</p>
    <p><strong>SKU:</strong> {{ $product->sku ?? '—' }}</p>
    <p><strong>Taxable:</strong> {{ $product->is_taxable ? 'Yes' : 'No' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>

    @if ($product->description)
        <p><strong>Description:</strong> {{ $product->description }}</p>
    @endif

</x-layouts.app>