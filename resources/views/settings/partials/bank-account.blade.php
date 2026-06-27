<form method="POST" action="{{ route('settings.bank-account.update') }}">
    @csrf
    @method('PUT')

    <h2>Bank Account</h2>
    <p>This will appear on your invoices so customers know where to pay.</p>

    <div>
        <label for="bank_name">Bank</label>
        <select id="bank_name" name="bank_name">
            <option value="">— Select Bank —</option>
            @foreach (config('lookup.south_african_banks') as $code => $label)
                <option value="{{ $code }}"
                    {{ old('bank_name', $bankAccount?->bank_name) === $code ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="account_holder">Account Holder</label>
        <input type="text" id="account_holder" name="account_holder"
            value="{{ old('account_holder', $bankAccount?->account_holder) }}" />
    </div>

    <div>
        <label for="account_number">Account Number</label>
        <input type="text" id="account_number" name="account_number"
            value="{{ old('account_number', $bankAccount?->account_number) }}" />
    </div>

    <div>
        <label for="branch_code">Branch Code</label>
        <input type="text" id="branch_code" name="branch_code"
            value="{{ old('branch_code', $bankAccount?->branch_code) }}" />
    </div>

    <div>
        <label for="account_type">Account Type</label>
        <select id="account_type" name="account_type">
            <option value="">— Select Type —</option>
            @foreach (config('lookup.account_types') as $code => $label)
                <option value="{{ $code }}"
                    {{ old('account_type', $bankAccount?->account_type) === $code ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit">Save Bank Account</button>

</form>