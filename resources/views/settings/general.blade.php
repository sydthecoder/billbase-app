<x-layouts.app title="General Settings">   
    <div>
        <div class="max-w-4xl">
            
            <x-ui.breadcrumb :items="[
                ['label' => 'Settings', 'url' => route('settings.general.index')],
                ['label' => 'General'],
            ]" />

            <form 
                method="POST" 
                action="{{ route('settings.general.update') }}"
                x-data="{ loading: false }"
                @submit="loading = true"
                class="flex flex-col gap-8"
            >
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Brand Identity</h3>
                        <p class="text-[14px] text-[#6b7280]">Your logo and primary company name.</p>
                    </div>
                    
                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-[#f9fafb] border border-dashed border-[#d1d5db] rounded-xl flex flex-col items-center justify-center text-[#6b7280] hover:bg-[#f2f2ff] hover:border-primary-500 hover:text-primary-500 cursor-pointer transition-colors flex-shrink-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-[4px]"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        </div>

                        <div class="flex flex-col gap-1">
                            <span class="text-[14px] font-medium text-[#030712]">Upload Company Logo</span>
                            <span class="text-[14px] text-[#4b5563]">Maximum 1mb size.</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Company Name</label>
                            <input 
                                type="text" 
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                value="{{ old('name', $organization->name) }}" 
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="reg_number">Registration Number</label>
                            <input 
                                type="text" 
                                id="reg_number"
                                name="reg_number"
                                value="{{ old('reg_number', $organization->reg_number) }}"
                                placeholder="20**/******/**"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Contact Details</h3>
                        <p class="text-[14px] text-[#6b7280]">Where clients should direct their inquiries.</p>
                    </div>
                    
                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Billing Email Address</label>
                            <input 
                                type="email" 
                                value="{{ old('email', $organization->email) }}"
                                placeholder="name@company.co.za"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Phone Number</label>
                            <input 
                                type="tel" 
                                placeholder="015 456 3***"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>
                        
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label class="text-[14px] font-medium text-[#030712]">Company Website</label>
                            <input 
                                type="url" 
                                placeholder="https://company.co.za"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Registered Address</h3>
                        <p class="text-[14px] text-[#6b7280]">The physical location of your business.</p>
                    </div>
                    
                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Street Address</label>
                            <input 
                                type="text" 
                                value="{{ old('street_address', $organization->street_address) }}" 
                                placeholder="123 Business Rd, Suite 100"
                                class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                            >
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]">City</label>
                                <input 
                                    type="text" 
                                    value="{{ old('city', $organization->city) }}"
                                    placeholder="Metropolis"
                                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                >
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]">Postal Code</label>
                                <input 
                                    type="text" 
                                    value="{{ old('postal_code', $organization->postal_code) }}"
                                    placeholder="10001"
                                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-4 text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                >
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]">State / Province</label>
                                <div class="relative"> 
                                    <select 
                                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all" 
                                        id="province" 
                                        name="province" 
                                        aria-label="province select example"
                                    >
                                        <option selected>Province</option>

                                        @foreach (config('lookup.provinces') as $code => $label)
                                            <option value="{{ $code }}" {{ old('province', $organization->province) === $code ? 'selected' : '' }}>
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
                                <label class="text-[14px] font-medium text-[#030712]">Country</label>
                                <div class="relative">
                                    <select class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all">
                                    <option>United States</option>
                                    <option>United Kingdom</option>
                                    <option>Canada</option>
                                    <option selected>South Africa</option>
                                    <option>Australia</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                    </div>
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
                            <x-ui.button-loader  />
                            <span x-text="loading ? 'Saving' : 'Save changes'"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.co.za/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
        <script>
            new Cleave('#reg_number', {
                delimiters: ['/', '/'],
                blocks: [4, 6, 2],
                numericOnly: true,
            });
        </script>
    @endpush 
</x-layouts.app>