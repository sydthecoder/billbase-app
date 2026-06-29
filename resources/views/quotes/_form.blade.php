@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p style="color: red;">{{ $error }}</p>
        @endforeach
    </div>
@endif

@php
    $defaultItems = [['product_id'=>'','description'=>'','quantity'=>1,'unit'=>'','unit_price'=>0,'is_taxable'=>true,'discount_amount'=>0]];
    $initialItems = old('items', isset($existingItems) ? $existingItems : $defaultItems);
@endphp

<div x-data="quoteForm({{ $products->toJson() }}, {{ json_encode($initialItems) }})">

    {{-- Customer --}}
    <div>
        <label for="customer_id">Customer *</label>
        <select id="customer_id" name="customer_id" required>
            <option value="">— Select Customer —</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}"
                    {{ old('customer_id', $quote->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->first_name }} {{ $customer->last_name }}
                    @if ($customer->company_name) — {{ $customer->company_name }} @endif
                </option>
            @endforeach
        </select>
    </div>

    {{-- Title --}}
    <div>
        <label for="title">Title</label>
        <input type="text" id="title" name="title"
            value="{{ old('title', $quote->title ?? '') }}"
            placeholder="e.g. Website Development Proposal" />
    </div>

    {{-- Dates --}}
    <div>
        <label for="issue_date">Issue Date *</label>
        <input type="date" id="issue_date" name="issue_date"
            value="{{ old('issue_date', isset($quote) ? $quote->issue_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required />
    </div>

    <div>
        <label for="expires_at">Expiry Date *</label>
        <input type="date" id="expires_at" name="expires_at"
            value="{{ old('expires_at', isset($quote) ? $quote->expires_at->format('Y-m-d') : now()->addDays(30)->format('Y-m-d')) }}"
            required />
    </div>

    {{-- Line Items --}}
    <h3>Line Items</h3>

    <template x-for="(item, index) in items" :key="index">
        <div>
            <div>
                <label>Product</label>
                <select @change="selectProduct(index, $event)">
                    <option value="">— Custom / Manual —</option>
                    <template x-for="product in products" :key="product.id">
                        <option :value="product.id" :selected="item.product_id == product.id">
                            <span x-text="product.name"></span>
                        </option>
                    </template>
                </select>
            </div>

            <div>
                <label>Description *</label>
                <input type="text"
                    :name="`items[${index}][description]`"
                    x-model="item.description" required />
            </div>

            <div>
                <label>Qty *</label>
                <input type="number" step="0.01" min="0.01"
                    :name="`items[${index}][quantity]`"
                    x-model="item.quantity"
                    @input="recalculate()" required />
            </div>

            <div>
                <label>Unit</label>
                <input type="text"
                    :name="`items[${index}][unit]`"
                    x-model="item.unit"
                    placeholder="hr, kg, item" />
            </div>

            <div>
                <label>Unit Price *</label>
                <input type="number" step="0.01" min="0"
                    :name="`items[${index}][unit_price]`"
                    x-model="item.unit_price"
                    @input="recalculate()" required />
            </div>

            <div>
                <label>Taxable</label>
                <select :name="`items[${index}][is_taxable]`"
                    x-model="item.is_taxable"
                    @change="recalculate()">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div>
                <label>Discount (R)</label>
                <input type="number" step="0.01" min="0"
                    :name="`items[${index}][discount_amount]`"
                    x-model="item.discount_amount"
                    @input="recalculate()" />
            </div>

            <input type="hidden" :name="`items[${index}][product_id]`" x-model="item.product_id" />

            <div>
                <span>R <span x-text="lineTotal(item).toFixed(2)"></span></span>
            </div>

            <button type="button" @click="removeItem(index)" x-show="items.length > 1">Remove</button>
        </div>
    </template>

    <button type="button" @click="addItem()">+ Add Line Item</button>

    {{-- Discounts --}}
    <div>
        <label for="discount_percent">Discount %</label>
        <input type="number" id="discount_percent" name="discount_percent" step="0.01" min="0" max="100"
            value="{{ old('discount_percent', $quote->discount_percent ?? 0) }}"
            x-model="discountPercent"
            @input="recalculate()" />
    </div>

    <div>
        <label for="discount_amount">Discount Amount (R)</label>
        <input type="number" id="discount_amount" name="discount_amount" step="0.01" min="0"
            value="{{ old('discount_amount', $quote->discount_amount ?? 0) }}"
            x-model="discountAmount"
            @input="recalculate()" />
    </div>

    {{-- Totals --}}
    <div>
        <p>Subtotal: R <span x-text="subtotal.toFixed(2)"></span></p>
        <p>VAT (15%): R <span x-text="taxTotal.toFixed(2)"></span></p>
        <p>Discount: R <span x-text="totalDiscount.toFixed(2)"></span></p>
        <p><strong>Total: R <span x-text="total.toFixed(2)"></span></strong></p>
    </div>

    {{-- Notes / Footer --}}
    <div>
        <label for="notes">Notes</label>
        <textarea id="notes" name="notes">{{ old('notes', $quote->notes ?? '') }}</textarea>
    </div>

    <div>
        <label for="footer">Footer</label>
        <textarea id="footer" name="footer">{{ old('footer', $quote->footer ?? '') }}</textarea>
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