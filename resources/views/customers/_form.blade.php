@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- Company --}}
<div>
    <label for="company_name">Company Name</label>
    <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $customer->company_name ?? '') }}" />
</div>

<div>
    <label for="company_reg_number">Company Reg Number</label>
    <input type="text" id="company_reg_number" name="company_reg_number" value="{{ old('company_reg_number', $customer->company_reg_number ?? '') }}" />
</div>

<div>
    <label for="vat_number">VAT Number</label>
    <input type="text" id="vat_number" name="vat_number" value="{{ old('vat_number', $customer->vat_number ?? '') }}" />
</div>

{{-- Personal --}}
<div>
    <label for="first_name">First Name <span>*</span></label>
    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $customer->first_name ?? '') }}" required />
</div>

<div>
    <label for="last_name">Last Name <span>*</span></label>
    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $customer->last_name ?? '') }}" required />
</div>

<div>
    <label for="email">Email <span>*</span></label>
    <input type="email" id="email" name="email" value="{{ old('email', $customer->email ?? '') }}" required />
</div>

<div>
    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" />
</div>

{{-- Address --}}
<div>
    <label for="street_address">Street Address</label>
    <input type="text" id="street_address" name="street_address" value="{{ old('street_address', $customer->street_address ?? '') }}" />
</div>

<div>
    <label for="suburb">Suburb</label>
    <input type="text" id="suburb" name="suburb" value="{{ old('suburb', $customer->suburb ?? '') }}" />
</div>

<div>
    <label for="city">City</label>
    <input type="text" id="city" name="city" value="{{ old('city', $customer->city ?? '') }}" />
</div>

<div>
    <label for="province">Province</label>
    <select id="province" name="province">
        <option value="">— Select Province —</option>
        @foreach (config('lookup.provinces') as $code => $label)
            <option value="{{ $code }}" {{ old('province', $customer->province ?? '') === $code ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label for="postal_code">Postal Code</label>
    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $customer->postal_code ?? '') }}" />
</div>

{{-- Notes --}}
<div>
    <label for="notes">Notes</label>
    <textarea id="notes" name="notes">{{ old('notes', $customer->notes ?? '') }}</textarea>
</div>

{{-- Status --}}
<div>
    <label for="status">Status</label>
    <select id="status" name="status">
        <option value="active"   {{ old('status', $customer->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status', $customer->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
</div>