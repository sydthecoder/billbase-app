@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    </div>
@endif

<div>
    <label for="name">Name <span>*</span></label>
    <input type="text" id="name" name="name"
        value="{{ old('name', $product->name ?? '') }}" required />
</div>

<div>
    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div>
    <label for="price">Price <span>*</span></label>
    <input type="number" id="price" name="price" step="0.01" min="0"
        value="{{ old('price', $product->price ?? '') }}" required />
</div>

<div>
    <label for="unit">Unit</label>
    <input type="text" id="unit" name="unit"
        value="{{ old('unit', $product->unit ?? '') }}"
        placeholder="e.g. hr, kg, item" />
</div>

<div>
    <label for="sku">SKU</label>
    <input type="text" id="sku" name="sku"
        value="{{ old('sku', $product->sku ?? '') }}" />
</div>

<div>
    <label for="is_taxable">Taxable</label>
    <select id="is_taxable" name="is_taxable">
        <option value="1" {{ old('is_taxable', $product->is_taxable ?? true) ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ !old('is_taxable', $product->is_taxable ?? true) ? 'selected' : '' }}>No</option>
    </select>
</div>

<div>
    <label for="status">Status</label>
    <select id="status" name="status">
        <option value="active"   {{ old('status', $product->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status', $product->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
</div>