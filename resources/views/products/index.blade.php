<x-layouts.app title="Products">

    <div>
        <h1>Products</h1>
        <a href="{{ route('products.create') }}">Add Product</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Unit</th>
                <th>Taxable</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>R {{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->unit ?? '—' }}</td>
                    <td>{{ $product->is_taxable ? 'Yes' : 'No' }}</td>
                    <td>{{ ucfirst($product->status) }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}">View</a>
                        <a href="{{ route('products.edit', $product->id) }}">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No products yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-layouts.app>