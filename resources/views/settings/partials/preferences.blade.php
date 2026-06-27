<form method="POST" action="{{ route('settings.preferences.update') }}">
    @csrf
    @method('PUT')

    <h2>Invoice</h2>

    <div>
        <label for="invoice_prefix">Invoice Prefix</label>
        <input type="text" id="invoice_prefix" name="invoice_prefix"
            value="{{ old('invoice_prefix', $preferences?->invoice_prefix ?? 'INV-') }}"
            placeholder="INV-" />
    </div>

    <div>
        <label for="invoice_starting_number">Starting Number</label>
        <input type="number" id="invoice_starting_number" name="invoice_starting_number"
            value="{{ old('invoice_starting_number', $preferences?->invoice_starting_number ?? 1) }}"
            min="1" />
    </div>

    <div>
        <label for="default_payment_terms">Default Payment Terms (days)</label>
        <input type="number" id="default_payment_terms" name="default_payment_terms"
            value="{{ old('default_payment_terms', $preferences?->default_payment_terms ?? 30) }}"
            min="1" />
    </div>

    <div>
        <label for="invoice_footer">Invoice Footer</label>
        <input type="text" id="invoice_footer" name="invoice_footer"
            value="{{ old('invoice_footer', $preferences?->invoice_footer) }}"
            placeholder="e.g. Thank you for your business." />
    </div>

    <div>
        <label for="invoice_notes">Default Invoice Notes</label>
        <textarea id="invoice_notes" name="invoice_notes"
            placeholder="e.g. Payment due within 30 days.">{{ old('invoice_notes', $preferences?->invoice_notes) }}</textarea>
    </div>

    <h2>Quote</h2>

    <div>
        <label for="quote_prefix">Quote Prefix</label>
        <input type="text" id="quote_prefix" name="quote_prefix"
            value="{{ old('quote_prefix', $preferences?->quote_prefix ?? 'QUO-') }}"
            placeholder="QUO-" />
    </div>

    <div>
        <label for="quote_starting_number">Starting Number</label>
        <input type="number" id="quote_starting_number" name="quote_starting_number"
            value="{{ old('quote_starting_number', $preferences?->quote_starting_number ?? 1) }}"
            min="1" />
    </div>

    <h2>Branding</h2>

    <div>
        <label for="brand_color">Brand Color</label>
        <input type="color" id="brand_color" name="brand_color"
            value="{{ old('brand_color', $preferences?->brand_color ?? '#000000') }}" />
        <small>Used as accent color on invoice and quote PDFs.</small>
    </div>

    <button type="submit">Save Preferences</button>

</form>