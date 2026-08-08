<x-layouts.app title="Bank Account Settings">
    <div>
        <div class="max-w-4xl">

            <x-ui.breadcrumb :items="[
                ['label' => 'Settings', 'url' => route('settings.general.index')],
                ['label' => 'Bank Account'],
            ]" />

            <form
                method="POST"
                action="{{ route('settings.bank-account.update') }}"
                x-data="{ loading: false }"
                @submit="loading = true"
                class="flex flex-col gap-8"
            >
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Bank Account</h3>
                        <p class="text-[14px] text-[#6b7280]">This will appear on your invoices so customers know where to pay.</p>
                    </div>

                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="bank_name">Bank</label>
                            <div class="relative">
                                <select
                                    id="bank_name"
                                    name="bank_name"
                                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                >
                                    <option value="">— Select Bank —</option>
                                    @foreach (config('lookup.south_african_banks') as $code => $label)
                                        <option value="{{ $code }}"
                                            {{ old('bank_name', $bankAccount?->bank_name) === $code ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="account_holder">Account Holder</label>
                            <input
                                type="text"
                                id="account_holder"
                                name="account_holder"
                                value="{{ old('account_holder', $bankAccount?->account_holder) }}"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="account_number">Account Number</label>
                            <input
                                type="text"
                                id="account_number"
                                name="account_number"
                                value="{{ old('account_number', $bankAccount?->account_number) }}"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="branch_code">Branch Code</label>
                            <input
                                type="text"
                                id="branch_code"
                                name="branch_code"
                                value="{{ old('branch_code', $bankAccount?->branch_code) }}"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="account_type">Account Type</label>
                            <div class="relative">
                                <select
                                    id="account_type"
                                    name="account_type"
                                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                >
                                    <option value="">— Select Type —</option>
                                    @foreach (config('lookup.account_types') as $code => $label)
                                        <option value="{{ $code }}"
                                            {{ old('account_type', $bankAccount?->account_type) === $code ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                            </div>
                        </div>
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