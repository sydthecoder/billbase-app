<x-layouts.app title="Customers">

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    @endif

    <div>
        <h1>Customers</h1>
        <a href="{{ route('customers.create') }}">Add Customer</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>{{ $customer->customer_code }}</td>
                    <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '—' }}</td>
                    <td>{{ ucfirst($customer->status) }}</td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}">View</a>
                        <a href="{{ route('customers.edit', $customer->id) }}">Edit</a>
                        <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this customer?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No customers yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-layouts.app>