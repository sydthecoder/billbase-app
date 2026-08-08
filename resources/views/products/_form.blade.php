@if ($errors->any())
    <div class="mb-6 flex flex-col gap-1 bg-[#fef2f2] border border-[#fecaca] text-[#b91c1c] rounded-xl px-4 py-3 text-[14px]">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="flex flex-col gap-8">

    {{-- Details --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
        <div>
            <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Product Details</h3>
            <p class="text-[14px] text-[#6b7280]">What this product or service is, and what it costs.</p>
        </div>

        <div class="w-full h-px bg-[#e5e7eb]"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2 md:col-span-2">
                <label class="text-[14px] font-medium text-[#030712]" for="name">Name <span class="text-[#dc2626]">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $product->name ?? '') }}"
                    required
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >
            </div>

            <div class="flex flex-col gap-2 md:col-span-2">
                <label class="text-[14px] font-medium text-[#030712]" for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="price">Price <span class="text-[#dc2626]">*</span></label>
                <input
                    type="number"
                    id="price"
                    name="price"
                    step="0.01"
                    min="0"
                    value="{{ old('price', $product->price ?? '') }}"
                    required
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="unit">Unit</label>
                <input
                    type="text"
                    id="unit"
                    name="unit"
                    value="{{ old('unit', $product->unit ?? '') }}"
                    placeholder="e.g. hr, kg, item"
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="sku">SKU</label>
                <input
                    type="text"
                    id="sku"
                    name="sku"
                    value="{{ old('sku', $product->sku ?? '') }}"
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >
            </div>
        </div>
    </div>

    {{-- Tax & Status --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
        <div>
            <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Tax & Status</h3>
            <p class="text-[14px] text-[#6b7280]">Whether VAT applies, and if this product is available to add to invoices and quotes.</p>
        </div>

        <div class="w-full h-px bg-[#e5e7eb]"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="is_taxable">Taxable</label>
                <div class="relative">
                    <select
                        id="is_taxable"
                        name="is_taxable"
                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                        <option value="1" {{ old('is_taxable', $product->is_taxable ?? true) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('is_taxable', $product->is_taxable ?? true) ? 'selected' : '' }}>No</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="status">Status</label>
                <div class="relative">
                    <select
                        id="status"
                        name="status"
                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                        <option value="active"   {{ old('status', $product->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>