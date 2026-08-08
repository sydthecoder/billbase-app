@if ($errors->any())
    <div class="mb-6 flex flex-col gap-1 bg-[#fef2f2] border border-[#fecaca] text-[#b91c1c] rounded-xl px-4 py-3 text-[14px]">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@php
    $defaultItems = [['product_id'=>'','description'=>'','quantity'=>1,'unit'=>'','unit_price'=>0,'is_taxable'=>true,'discount_amount'=>0]];
    $initialItems = old('items', isset($existingItems) ? $existingItems : $defaultItems);
@endphp

<div
    x-data="quoteForm({{ $products->toJson() }}, {{ json_encode($initialItems) }})"
    class="flex flex-col gap-8"
>

    {{-- Customer, Title & Dates --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
        <div>
            <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Quote Details</h3>
            <p class="text-[14px] text-[#6b7280]">Who this quote is for, and how long it's valid.</p>
        </div>

        <div class="w-full h-px bg-[#e5e7eb]"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="customer_id">Customer <span class="text-[#dc2626]">*</span></label>
                <div class="relative">
                    <select
                        id="customer_id"
                        name="customer_id"
                        required
                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                        <option value="">— Select Customer —</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id', $quote->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->first_name }} {{ $customer->last_name }}
                                @if ($customer->company_name) — {{ $customer->company_name }} @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="title">Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $quote->title ?? '') }}"
                    placeholder="e.g. Website Development Proposal"
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="issue_date">Issue Date <span class="text-[#dc2626]">*</span></label>
                <input
                    type="date"
                    id="issue_date"
                    name="issue_date"
                    value="{{ old('issue_date', isset($quote) ? $quote->issue_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                    required
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="expires_at">Expiry Date <span class="text-[#dc2626]">*</span></label>
                <input
                    type="date"
                    id="expires_at"
                    name="expires_at"
                    value="{{ old('expires_at', isset($quote) ? $quote->expires_at->format('Y-m-d') : now()->addDays(30)->format('Y-m-d')) }}"
                    required
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >
            </div>
        </div>
    </div>

    {{-- Line Items --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
        <div>
            <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Line Items</h3>
            <p class="text-[14px] text-[#6b7280]">Pick a product to autofill, or enter details manually.</p>
        </div>

        <div class="w-full h-px bg-[#e5e7eb]"></div>

        <div class="hidden lg:grid grid-cols-12 gap-3 px-1 text-[12px] font-semibold uppercase tracking-wide text-[#6b7280]">
            <div class="col-span-3">Product</div>
            <div class="col-span-3">Description</div>
            <div class="col-span-1">Qty</div>
            <div class="col-span-1">Unit</div>
            <div class="col-span-1">Price</div>
            <div class="col-span-1">Tax</div>
            <div class="col-span-1">Discount</div>
            <div class="col-span-1 text-right">Total</div>
        </div>

        <template x-for="(item, index) in items" :key="index">
            <div class="border border-[#e5e7eb] rounded-xl p-4 lg:p-3 flex flex-col lg:grid lg:grid-cols-12 gap-3 lg:items-center">

                <div class="lg:col-span-3 flex flex-col gap-1">
                    <label class="text-[12px] font-medium text-[#6b7280] lg:hidden">Product</label>
                    <div class="relative">
                        <select
                            @change="selectProduct(index, $event)"
                            class="w-full bg-white border border-[#d1d5db] rounded-lg px-3 py-2 text-[14px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                        >
                            <option value="">— Custom / Manual —</option>
                            <template x-for="product in products" :key="product.id">
                                <option :value="product.id" :selected="item.product_id == product.id" x-text="product.name"></option>
                            </template>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 flex flex-col gap-1">
                    <label class="text-[12px] font-medium text-[#6b7280] lg:hidden">Description <span class="text-[#dc2626]">*</span></label>
                    <input
                        type="text"
                        :name="`items[${index}][description]`"
                        x-model="item.description"
                        required
                        class="w-full bg-white border border-[#d1d5db] rounded-lg px-3 py-2 text-[14px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                </div>

                <div class="lg:col-span-1 flex flex-col gap-1">
                    <label class="text-[12px] font-medium text-[#6b7280] lg:hidden">Qty <span class="text-[#dc2626]">*</span></label>
                    <input
                        type="number" step="0.01" min="0.01"
                        :name="`items[${index}][quantity]`"
                        x-model="item.quantity"
                        @input="recalculate()"
                        required
                        class="w-full bg-white border border-[#d1d5db] rounded-lg px-3 py-2 text-[14px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                </div>

                <div class="lg:col-span-1 flex flex-col gap-1">
                    <label class="text-[12px] font-medium text-[#6b7280] lg:hidden">Unit</label>
                    <input
                        type="text"
                        :name="`items[${index}][unit]`"
                        x-model="item.unit"
                        placeholder="hr, kg"
                        class="w-full bg-white border border-[#d1d5db] rounded-lg px-3 py-2 text-[14px] text-[#030712] placeholder-[#9ca3af] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                </div>

                <div class="lg:col-span-1 flex flex-col gap-1">
                    <label class="text-[12px] font-medium text-[#6b7280] lg:hidden">Unit Price <span class="text-[#dc2626]">*</span></label>
                    <input
                        type="number" step="0.01" min="0"
                        :name="`items[${index}][unit_price]`"
                        x-model="item.unit_price"
                        @input="recalculate()"
                        required
                        class="w-full bg-white border border-[#d1d5db] rounded-lg px-3 py-2 text-[14px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                </div>

                <div class="lg:col-span-1 flex flex-col gap-1">
                    <label class="text-[12px] font-medium text-[#6b7280] lg:hidden">Taxable</label>
                    <div class="relative">
                        <select
                            :name="`items[${index}][is_taxable]`"
                            x-model="item.is_taxable"
                            @change="recalculate()"
                            class="w-full bg-white border border-[#d1d5db] rounded-lg px-3 py-2 text-[14px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                        >
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 flex flex-col gap-1">
                    <label class="text-[12px] font-medium text-[#6b7280] lg:hidden">Discount (R)</label>
                    <input
                        type="number" step="0.01" min="0"
                        :name="`items[${index}][discount_amount]`"
                        x-model="item.discount_amount"
                        @input="recalculate()"
                        class="w-full bg-white border border-[#d1d5db] rounded-lg px-3 py-2 text-[14px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                </div>

                <input type="hidden" :name="`items[${index}][product_id]`" x-model="item.product_id" />

                <div class="lg:col-span-1 flex items-center justify-between lg:justify-end gap-3 pt-1 lg:pt-0">
                    <span class="text-[14px] font-semibold text-[#030712] lg:hidden">Line total</span>
                    <span class="text-[14px] font-semibold text-[#030712]">R <span x-text="lineTotal(item).toFixed(2)"></span></span>
                    <button
                        type="button"
                        @click="removeItem(index)"
                        x-show="items.length > 1"
                        class="text-[#9ca3af] hover:text-[#dc2626] transition-colors"
                        title="Remove line"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                    </button>
                </div>
            </div>
        </template>

        <button
            type="button"
            @click="addItem()"
            class="w-fit flex items-center gap-2 text-[14px] font-medium text-primary-500 hover:text-[#4a1fd4] transition-colors"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add line item
        </button>
    </div>

    {{-- Totals --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
        <div>
            <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Discount & Totals</h3>
            <p class="text-[14px] text-[#6b7280]">Apply an overall discount and review the final amount.</p>
        </div>

        <div class="w-full h-px bg-[#e5e7eb]"></div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="grid grid-cols-2 gap-6 content-start">
                <div class="flex flex-col gap-2">
                    <label class="text-[14px] font-medium text-[#030712]" for="discount_percent">Discount %</label>
                    <input
                        type="number" id="discount_percent" name="discount_percent" step="0.01" min="0" max="100"
                        value="{{ old('discount_percent', $quote->discount_percent ?? 0) }}"
                        x-model="discountPercent"
                        @input="recalculate()"
                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[14px] font-medium text-[#030712]" for="discount_amount">Discount Amount (R)</label>
                    <input
                        type="number" id="discount_amount" name="discount_amount" step="0.01" min="0"
                        value="{{ old('discount_amount', $quote->discount_amount ?? 0) }}"
                        x-model="discountAmount"
                        @input="recalculate()"
                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                    >
                </div>
            </div>

            <div class="bg-[#f9fafb] rounded-xl p-5 flex flex-col gap-2 lg:max-w-sm lg:ml-auto lg:w-full">
                <div class="flex justify-between text-[14px] text-[#4b5563]">
                    <span>Subtotal</span>
                    <span>R <span x-text="subtotal.toFixed(2)"></span></span>
                </div>
                <div class="flex justify-between text-[14px] text-[#4b5563]">
                    <span>VAT (15%)</span>
                    <span>R <span x-text="taxTotal.toFixed(2)"></span></span>
                </div>
                <div class="flex justify-between text-[14px] text-[#4b5563]">
                    <span>Discount</span>
                    <span>- R <span x-text="totalDiscount.toFixed(2)"></span></span>
                </div>
                <div class="w-full h-px bg-[#e5e7eb] my-1"></div>
                <div class="flex justify-between text-[18px] font-bold text-[#030712]">
                    <span>Total</span>
                    <span>R <span x-text="total.toFixed(2)"></span></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Notes / Footer --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
        <div>
            <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Notes & Footer</h3>
            <p class="text-[14px] text-[#6b7280]">Extra text shown on the quote PDF.</p>
        </div>

        <div class="w-full h-px bg-[#e5e7eb]"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="notes">Notes</label>
                <textarea
                    id="notes" name="notes" rows="3"
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >{{ old('notes', $quote->notes ?? '') }}</textarea>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-[14px] font-medium text-[#030712]" for="footer">Footer</label>
                <textarea
                    id="footer" name="footer" rows="3"
                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                >{{ old('footer', $quote->footer ?? '') }}</textarea>
            </div>
        </div>
    </div>

    @if (isset($quoteId) && $quoteId)
        <input type="hidden" name="quote_id" value="{{ $quoteId }}" />
    @endif

</div>

@push('scripts')
<script>
function quoteForm(products, initialItems) {
    return {
        products:        products,
        items:           initialItems,
        discountPercent: {{ old('discount_percent', $quote->discount_percent ?? 0) }},
        discountAmount:  {{ old('discount_amount', $quote->discount_amount ?? 0) }},
        subtotal:        0,
        taxTotal:        0,
        totalDiscount:   0,
        total:           0,
        taxRate:         0.15,

        init() {
            this.recalculate();
        },

        addItem() {
            this.items.push({
                product_id: '', description: '', quantity: 1,
                unit: '', unit_price: 0, is_taxable: true, discount_amount: 0,
            });
        },

        removeItem(index) {
            this.items.splice(index, 1);
            this.recalculate();
        },

        selectProduct(index, event) {
            const productId = parseInt(event.target.value);
            const product   = this.products.find(p => p.id === productId);

            if (product) {
                this.items[index].product_id      = product.id;
                this.items[index].description     = product.description || product.name;
                this.items[index].unit_price      = parseFloat(product.price);
                this.items[index].unit            = product.unit || '';
                this.items[index].is_taxable      = product.is_taxable ? '1' : '0';
                this.items[index].discount_amount = 0;
            } else {
                this.items[index].product_id = '';
            }

            this.recalculate();
        },

        lineTotal(item) {
            const qty      = parseFloat(item.quantity)        || 0;
            const price    = parseFloat(item.unit_price)      || 0;
            const discount = parseFloat(item.discount_amount) || 0;
            return Math.max(0, (qty * price) - discount);
        },

        recalculate() {
            let subtotal = 0;
            let taxTotal = 0;

            this.items.forEach(item => {
                const line    = this.lineTotal(item);
                subtotal     += line;
                const taxable = item.is_taxable == '1' || item.is_taxable === true;
                if (taxable) {
                    taxTotal += Math.round(line * this.taxRate * 100) / 100;
                }
            });

            let discount = 0;
            if (parseFloat(this.discountPercent) > 0) {
                discount = Math.round(subtotal * (parseFloat(this.discountPercent) / 100) * 100) / 100;
            } else {
                discount = parseFloat(this.discountAmount) || 0;
            }

            this.subtotal      = subtotal;
            this.taxTotal      = taxTotal;
            this.totalDiscount = discount;
            this.total         = Math.max(0, (subtotal + taxTotal) - discount);
        },
    }
}
</script>
@endpush