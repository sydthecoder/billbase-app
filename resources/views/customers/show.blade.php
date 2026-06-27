<x-layouts.app title="Customer">

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div>
        <h1>{{ $customer->first_name }} {{ $customer->last_name }}</h1>
        <a href="{{ route('customers.edit', $customer->id) }}">Edit</a>
        <a href="{{ route('customers.index') }}">Back</a>
    </div>

    <div>
        <p><strong>Code:</strong> {{ $customer->customer_code }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <p><strong>Phone:</strong> {{ $customer->phone ?? '—' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($customer->status) }}</p>
    </div>

    @if ($customer->company_name)
        <div>
            <p><strong>Company:</strong> {{ $customer->company_name }}</p>
            <p><strong>Reg Number:</strong> {{ $customer->company_reg_number ?? '—' }}</p>
            <p><strong>VAT Number:</strong> {{ $customer->vat_number ?? '—' }}</p>
        </div>
    @endif

    <div>
        <p><strong>Address:</strong>
            {{ $customer->street_address ?? '' }}
            {{ $customer->suburb ?? '' }}
            {{ $customer->city ?? '' }}
            {{ $customer->province ?? '' }}
            {{ $customer->postal_code ?? '' }}
        </p>
    </div>

    @if ($customer->notes)
        <div>
            <p><strong>Notes:</strong> {{ $customer->notes }}</p>
        </div>
    @endif

</x-layouts.app>