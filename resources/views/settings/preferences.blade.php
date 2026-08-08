<x-layouts.app title="Preferences Settings">
    <div>
        <div class="max-w-4xl">

            <x-ui.breadcrumb :items="[
                ['label' => 'Settings', 'url' => route('settings.general.index')],
                ['label' => 'Preferences'],
            ]" />

            <form
                method="POST"
                action="{{ route('settings.preferences.update') }}"
                x-data="{ loading: false }"
                @submit="loading = true"
                class="flex flex-col gap-8"
            >
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Invoice</h3>
                        <p class="text-[14px] text-[#6b7280]">Numbering and default text for invoices you send.</p>
                    </div>

                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="invoice_prefix">Invoice Prefix</label>
                            <input
                                type="text"
                                id="invoice_prefix"
                                name="invoice_prefix"
                                value="{{ old('invoice_prefix', $preferences?->invoice_prefix ?? 'INV-') }}"
                                placeholder="INV-"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="invoice_starting_number">Starting Number</label>
                            <input
                                type="number"
                                id="invoice_starting_number"
                                name="invoice_starting_number"
                                value="{{ old('invoice_starting_number', $preferences?->invoice_starting_number ?? 1) }}"
                                min="1"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="default_payment_terms">Default Payment Terms (days)</label>
                            <input
                                type="number"
                                id="default_payment_terms"
                                name="default_payment_terms"
                                value="{{ old('default_payment_terms', $preferences?->default_payment_terms ?? 30) }}"
                                min="1"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="invoice_footer">Invoice Footer</label>
                            <input
                                type="text"
                                id="invoice_footer"
                                name="invoice_footer"
                                value="{{ old('invoice_footer', $preferences?->invoice_footer) }}"
                                placeholder="e.g. Thank you for your business."
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="invoice_notes">Default Invoice Notes</label>
                            <textarea
                                id="invoice_notes"
                                name="invoice_notes"
                                rows="3"
                                placeholder="e.g. Payment due within 30 days."
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >{{ old('invoice_notes', $preferences?->invoice_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Quote</h3>
                        <p class="text-[14px] text-[#6b7280]">Numbering for quotes you send to clients.</p>
                    </div>

                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="quote_prefix">Quote Prefix</label>
                            <input
                                type="text"
                                id="quote_prefix"
                                name="quote_prefix"
                                value="{{ old('quote_prefix', $preferences?->quote_prefix ?? 'QUO-') }}"
                                placeholder="QUO-"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="quote_starting_number">Starting Number</label>
                            <input
                                type="number"
                                id="quote_starting_number"
                                name="quote_starting_number"
                                value="{{ old('quote_starting_number', $preferences?->quote_starting_number ?? 1) }}"
                                min="1"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Branding</h3>
                        <p class="text-[14px] text-[#6b7280]">Accent color used on invoice and quote PDFs.</p>
                    </div>

                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="flex flex-col gap-2 max-w-xs">
                        <label class="text-[14px] font-medium text-[#030712]" for="brand_color">Brand Color</label>
                        <input
                            type="color"
                            id="brand_color"
                            name="brand_color"
                            value="{{ old('brand_color', $preferences?->brand_color ?? '#000000') }}"
                            class="w-full h-12 bg-white border border-[#d1d5db] rounded-xl px-2 py-1 cursor-pointer focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                        >
                        <span class="text-[14px] text-[#6b7280]">Used as accent color on invoice and quote PDFs.</span>
                    </div>
                </div>

                <div class="fixed bottom-0 right-0 left-65 bg-white shadow-lg px-6 py-4 border border-[#e5e7eb]">
                    <div class="flex justify-end">
                        <button
                            class="w-fit bg-primary-500 text-white font-medium px-4 py-2.5 rounded-xl shadow-md hover:bg-[#4a1fd4] transition-colors"
                            type="submit"
                            :disabled="loading"
                        >
                            <x-ui.button-loader />
                            <span x-text="loading ? 'Saving' : 'Save changes'"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>